<?php namespace App\Controllers;

use App\Core\Abstracts\AbstractController;

class HomeController extends AbstractController
{
    public function home()
    {
        dd($this->getPath());
        $data = [
            '_data' => [
                'usuario' => $this->getProfile(),
                'ms' => [
                    [
                        'name' => 'Agenda',
                        'icon' => 'test',
                        'info' => [
                            [
                                'name' => 'Total de citas',
                                'reference' => 'Ultimo periodo',
                                'value' => 10
                            ],
                            [
                                'name' => 'Total de citas',
                                'reference' => 'Del dia de hoy',
                                'value' => 10
                            ]
                        ]
                    ]
                ],
                'general' => [
                    [
                        'name' => 'Estadisticas',
                        'icon' => 'test',
                        'info' => [
                            [
                                'name' => 'Total de citas',
                                'reference' => 'Ultimo periodo',
                                'value' => 10
                            ],
                            [
                                'name' => 'Total de citas',
                                'reference' => 'Del dia de hoy',
                                'value' => 10
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        return $this->getView('home', $data);
    }

    public function configuracion()
    {
        return $this->getView('home/configuracion');
    }

    public function perfil()
    {
        return $this->getView('home/perfil');
    }

    public function crearUsuario()
    {
        return $this->getView('home/crearUsuario');
    }
}
