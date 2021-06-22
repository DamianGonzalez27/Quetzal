<?php namespace App\Core\Bridges;

class FilesBridge
{

    private $files;

    public function __construct($files)
    {
        $this->files = $files;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getFile($fileName)
    {
        return $this->files[$fileName];
    }
}