<?php namespace App\Services;

use App\Core\Abstracts\AbstractServices;

class Mail extends AbstractServices
{
    public function printHola()
    {
        return [
            'data' => 'test'
        ];
    }
}