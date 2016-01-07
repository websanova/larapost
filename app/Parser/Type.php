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

        $slugs = [];

        foreach ($files as $file) {
            $fields = Parser::parse($file);

            if ( ! isset($fields['identifier'])) {
                $fields['identifier'] = explode('.', basename($file))[0];
            }

            $data = Parser::process($fields);

            $post = Post::where('slug', $data['slug'])->first();

            if ($post) {
                $post->fill($data);
                $post->status = 'active';
                $post->type = $this->type;

                if ($post->isDirty()) {
                    $post->save();
                    echo 'Update ' . ucfirst($this->type) . ': ' . $data['slug'] . "\n";
                }
            }
            else {
                $post = Post::create($data);
                echo 'New ' . ucfirst($this->type) . ': ' . $data['slug'] . "\n";
            }

            array_push($slugs, $post->slug);

            Parser::handle($fields, $post);
        }

        // Update to deleted status.
        Post::whereNotIn('slug', $slugs)
            ->where('type', $this->type)
            ->update([
                'status' => 'deleted'
            ]);
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