<?php

namespace Websanova\Larablog\Parser;

use Exception;
use Carbon\Carbon;
use Websanova\Larablog\Models\Post;
use Illuminate\Support\Facades\File;
use Websanova\Larablog\Parser\Parser;
use Websanova\Larablog\Parser\Field\Tags;
use Websanova\Larablog\Parser\Field\Series;

class Type
{
    protected $new_count = 0;

    protected $update_count = 0;

    protected function getSingular()
    {
        $class = explode('\\', strtolower(get_class($this)));

        return end($class);
    }

    protected function getPlural()
    {
        if (isset($this->type)) {
            return strtolower($this->type);
        }

        return $this->getSingular() . 's';
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

            $post = Post::query()
                ->where('identifier', $data['identifier'])
                ->first();

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

        $this->cleanup();

        echo 'New ' . $this->getPlural() . ': ' . $this->new_count . "\n";

        echo 'Updated ' . $this->getPlural() . ': ' . $this->new_count . "\n";
    }

    public function create($data)
    {
        $data['type'] = $this->getSingular();

        $post = Post::create($data);
        
        echo 'New ' . ucfirst($this->getSingular()) . ': ' . $data['identifier'] . "\n";

        $this->new_count++;

        return $post;
    }

    public function update($post, $data)
    {
        $post->fill($data);
        $post->deleted_at = null;
        $post->type = $this->getSingular();

        if ($post->isDirty()) {
            $post->save();

            $this->update_count++;
            
            echo 'Update ' . ucfirst($this->getSingular()) . ': ' . $data['identifier'] . "\n";
        }

        return $post;
    }

    public function delete($identifiers)
    {
        $posts = Post::query()
            ->whereNotIn('identifier', $identifiers)
            ->where('type', $this->getSingular())
            ->whereNull('deleted_at')
            ->get();

        Post::query()
            ->whereIn('id', $posts->pluck('id')->toArray())
            ->update([
                'deleted_at' => Carbon::now()
            ]);

        foreach ($posts as $p) {
            echo 'Removed ' . ucfirst($this->getSingular()) . ': ' . $p->identifier . "\n";
        }
    }

    public function getFullPath()
    {
        return config('larablog.' . $this->getPlural() . '.src');
    }

    public function folderExists()
    {
        $path = $this->getFullPath();

        if ( ! file_exists($path)) {
            return false;
        }

        return $path;
    }

    public function cleanup()
    {
        (new Tags)->cleanup();
        
        (new Series)->cleanup();
    }
}