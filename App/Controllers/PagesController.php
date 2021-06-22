<?php namespace App\Controllers;

use App\Core\Abstracts\AbstractController;

class PagesController extends AbstractController
{
    public function home()
    {
        return $this->getView('home');
    }

    public function blog()
    {
        $entradas = [
            'entradas' => [ 
                [
                    'id' => 0,
                    'nombre' => 'Entrada 1',
                    'descripcion' => 'Esto es una entrada',
                    'fecha_publicacion' => date("Y-M-D"),
                    'imagen' => 'pruebas.jpg',
                    'autor' => 'Perla Absalon'
                ]
                ],
            'categorias' => [
                [
                    'id' => 0,
                    'nombre' => 'PHP'
                ]
            ]
        ];
        return $this->getView('blog', $entradas);
    }

    public function error()
    {
        return $this->getView('404');
    }

    public function offline()
    {
        return $this->getView('offline');
    }

    public function entrada()
    {
        return $this->getView('entrada');
    }

    public function privacidad()
    {
        return $this->getView('privacidad');
    }
}