<?php

namespace Websanova\Larablog\Parser\Type;

use Websanova\Larablog\Parser\Type;
use Illuminate\Support\Facades\File;
use Websanova\Larablog\Parser\Field\Docs;

class Doc extends Type
{
    private $sub_folder = null;

    public function handle()
    {
        if ( ! $this->folderExists()) {
            throw new Exception('Folder "' . $this->getFullPath() . '" does not exist');
        }

        $path = $this->getFullPath();

        $dirs = File::directories($path);

        foreach ($dirs as $dir) {
            $this->sub_folder = str_replace($path . '/', '', $dir);
        }



        parent::handle();
    }

    public function getFullPath()
    {
        return config('larablog.' . $this->getPlural() . '.src') . $this->getSubPath();
    }

    public function getSubPath()
    {
         return !empty($this->sub_folder) ? '/' . $this->sub_folder : '';
    }

    public function cleanup()
    {
        (new Docs)->cleanup();
    }
}