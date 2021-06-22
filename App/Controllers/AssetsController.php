<?php namespace App\Controllers;

use App\Core\Abstracts\AbstractController;

class AssetsController extends AbstractController
{
    public function assets()
    {
        return $this->getView('404');
    }

    public function app()
    {
        return $this->getStorage('../storage/assets/app.js', 'application/javascript');
    }

    public function sw()
    {
        return $this->getStorage('../storage/assets/sw.js', 'application/javascript');
    }

    public function utils()
    {
        return $this->getStorage('../storage/assets/utils.js', 'application/javascript');
    }

    public function manifest()
    {
        return $this->getStorage('../storage/assets/manifest.json');
    }

    public function js()
    {
        $dir = scandir('../storage/assets');
        unset($dir[0]);
        unset($dir[1]);
        if(!in_array($this->getPath(), $dir))
            return $this->getView('404');

        $path = '../storage/assets/'.$this->getPath().'/app.js';

        if(!@file_exists($path))
            return $this->getView('404');

        return $this->getStorage($path, 'application/javascript');
    }

    public function css()
    {
        $dir = scandir('../storage/assets');
        unset($dir[0]);
        unset($dir[1]);
        if(!in_array($this->getPath(), $dir))
            return $this->getView('404');

        $path = '../storage/assets/'.$this->getPath().'/app.css';
    
        if(!@file_exists($path))
            return $this->getView('404');

        return $this->getStorage($path, 'text/css');
    }

    public function imagenes()
    {
        $dir = scandir('../storage/imagenes');
        unset($dir[0]);
        unset($dir[1]);
        if(!in_array($this->getPath(), $dir))
            return $this->getView('404');

        $path = '../storage/imagenes/'.$this->getPath();

        if(!@file_exists($path))
            return $this->getView('404');

        return $this->getStorage($path);
    }
}