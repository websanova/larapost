<?php

namespace Websanova\Larablog\Parser;

use Exception;
use Websanova\Larablog\Models\Post;
use Illuminate\Support\Facades\File;
use Websanova\Larablog\Parser\Parser;

class Type
{
    protected $path = null;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle()
    {
        if ( ! $path = $this->folderExists()) {
            throw new Exception('Folder "' . $this->getFullPath() . '" does not exist');
        }

        $files = File::files($path);

        $identifiers = [];

        foreach ($files as $file) {
            $fields = Parser::parse($file);

            if ( ! isset($fields['identifier'])) {
                $fields['identifier'] = explode('.', basename($file))[0];
            }

            $data = Parser::process($fields);

            $post = Post::where('identifier', $data['identifier'])->first();

            if ($post) {
                $post = $this->update($post, $data);
            }
            else {
                $post = $this->create($data);
            }

            array_push($identifiers, $post->identifier);

            Parser::handle($fields, $post);
        }

        $this->delete($identifiers);
    }

    public function create($data)
    {
        $data['type'] = $this->type;

        $post = Post::create($data);
        echo 'New ' . ucfirst($this->type) . ': ' . $data['identifier'] . "\n";

        return $post;
    }

    public function update($post, $data)
    {
        $post->fill($data);
        $post->status = 'active';
        $post->type = $this->type;

        if ($post->isDirty()) {
            $post->save();
            echo 'Update ' . ucfirst($this->type) . ': ' . $data['identifier'] . "\n";
        }

        return $post;
    }

    public function delete($identifiers)
    {
        $posts = Post::whereNotIn('identifier', $identifiers)
            ->where('type', $this->type)
            ->where('status', '<>', 'deleted')
            ->get();
            
        Post::whereIn('id', $posts->lists('id')->toArray())->update([
            'status' => 'deleted'
        ]);

        foreach ($posts as $p) {
            echo 'Removed ' . ucfirst($this->type) . ': ' . $p->identifier . "\n";
        }
    }

    public function getFullPath()
    {
        return $this->path . '/' . $this->folder;
    }

    public function folderExists()
    {
        $path = $this->getFullPath();

        if ( ! file_exists($path)) {
            return false;
        }

        return $path;
    }
}