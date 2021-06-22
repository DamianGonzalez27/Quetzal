<?php namespace App\Controllers;

use App\Core\Abstracts\AbstractController;

class StorageController extends AbstractController
{
    public function storage()
    {
        dd('test');
    }

    public function images()
    {
        return $this->getStorage('test', 'aqui');
    }
}