<?php namespace App\Core;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as GeneralResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Validador de rutas de acceso al sistema
 * 
 * @see https://symfony.com/doc/current/components/http_foundation.html
 */
class Response
{

    /**
     * Estatus de la respuesta
     */
    private $status = 200;

    /**
     * Headers iniciales de la respuesta
     */
    private $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method',
        'Allow' => 'GET, POST',
        'Hamilton-And-Lovelace' => 'Aplicacion Hami'
    ];

    /**
     * @var int Status del response
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param array Arreglo del tipo [name][value]
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    /**
     * @param array Arreglo para retornar al cliente
     * 
     * @return class Retorna una instancia de la clase JsonResponse
     */
    public function getJsonResponse($content)
    {
        return new JsonResponse($content, $this->status, $this->headers);
    }

    /**
     * @param template Template
     */
    public function getHtmlResponse($content)
    {
        return new GeneralResponse($content, $this->status, $this->headers);
    }

    /**
     * @param string Ruta de redireccion
     */
    public function getRedirectResponse($route)
    {
        return new RedirectResponse($route);
    }

    public function getStorageResponse($filename, $mineType)
    {
        $response = new GeneralResponse();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', (!is_null($mineType)) ? $mineType : mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '";');
        $response->headers->set('Content-length', filesize($filename));

        $response->sendHeaders();

        $response->setContent(file_get_contents($filename));

        return $response;
    }
}