<?php namespace App\Core;

use App\Core\Response;
use League\Plates\Engine;
use League\Plates\Extension\URI;
use App\Core\Validators\AuthValidator;
use App\Core\Factory\FactoryModelViews;
use App\Core\Validators\RoutesValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as StorageResponse;

/**
 * Clase de manipulacion de rutas de acceso a informacion y views
 * 
 */
class Routes
{
    private Engine $templates;

    private Response $response;

    private $routes;
    
    public function __construct(Request $request, $routes)
    {
        $this->request = $request;

        $this->routes = $routes;

        $this->templates = new Engine('../views');

        $this->templates->loadExtension(new URI($_SERVER['SERVER_NAME']));

        $this->response = new Response;
    }

    public function execute()
    {
        $validator = $this->validateRequest();
        
        if(isset($validator['error']))
            return $this->makeErrorResponse($validator['error'], $validator['view']);

        if(isset($validator['view']))
            return $this->makeSuccessResponse($validator['view'], $validator['data']);

        if(isset($validator['storage']))
            return $this->makeStorageResponse($validator['fileName'], $validator['mine-type']);
        
    }

    private function validateRequest()
    {
        $arrayPath = explode("/", $this->request->getPathInfo());

        $realPath = $arrayPath[1];

        if($arrayPath[1] == "")
            $arrayPath[1] = '/';

        if(!RoutesValidator::validateMaxArrayPath($arrayPath))
            return $this->makeError('404', '404');

        if(!RoutesValidator::validateRoute($this->routes, $arrayPath[1]))
            return $this->makeError('404', '404');

        if(RoutesValidator::validatePublicRoute($this->routes[$arrayPath[1]]['access']))
            return $this->publicRoutesProces($arrayPath, $realPath);
        else
            return $this->privateRoutesProcess($arrayPath, $realPath);
    }

    private function publicRoutesProces($arrayPath, $realPath = null)
    {
        if(RoutesValidator::validateIssetSubroutePath($arrayPath))
            return $this->subroutesProcess($arrayPath[1], $arrayPath[2]);      
        
        if($realPath == "" || $realPath == '')
            $realPath = "/";

        if(!RoutesValidator::validatePublicStrict($this->request, $this->routes[$realPath]['access']))
            return $this->makeError('redirect', 'home');
        
        if(!RoutesValidator::validateRoute($this->routes, $realPath))
            return $this->makeError('404', '404');

        return $this->getFactoryResponse(
            $this->routes[$realPath]['controller'],
            $this->routes[$realPath]['function']
        );
    }

    private function getFactoryResponse($controller, $function)
    {
        $factory = new FactoryModelViews($this->request);

        return $factory->getFactory(
            $controller,
            $function
        );
    }

    private function privateRoutesProcess($arrayPath, $realPath)
    {   
        if(!AuthValidator::validateAuth($this->request))
            return $this->makeError('redirect', '/');

        if(RoutesValidator::validateIssetSubroutePath($arrayPath))
            return $this->subroutesProcess($arrayPath[1], $arrayPath[2]);

        if($this->routes[$arrayPath[1]]['permissions'] == 'no')
            return $this->publicRoutesProces($arrayPath, $realPath);

        if(!AuthValidator::validatePermission($this->request, $this->routes[$realPath]['permissions']))
            return $this->makeError('redirect', '/');

        return $this->publicRoutesProces($arrayPath, $realPath);
    }

    private function subroutesProcess($route, $subRoute)
    {
        if(!RoutesValidator::validateRoute($this->routes[$route]['sub-routes'], $subRoute))
            return $this->makeError('404', '404');
              
        if(!AuthValidator::validatePermission($this->request, $this->routes[$route]['sub-routes'][$subRoute]['permissions']))
            return $this->makeError('redirect', '/'.$route);

        return $this->getFactoryResponse(
            $this->routes[$route]['controller'],
            $this->routes[$route]['sub-routes'][$subRoute]['function']
        );
    }

    private function makeError($error, $view)
    {
        return [
            'error' => $error,
            'view' => $view
        ];
    }

    private function makeSuccessResponse($view, $data = null)
    {
        return $this->response->getHtmlResponse(
            $this->templates->render($view, ['data' => $data])
        );
    }

    private function makeErrorResponse($typeError, $view)
    {
        if($typeError == '404')
            return $this->make404Response();

        if($typeError == 'redirect')
            return $this->redirectresponse($view);
    }

    private function make404Response()
    {
        $this->response->setStatus(404);

        return $this->response->getHtmlResponse($this->templates->render('404'));
    }

    private function redirectresponse($view)
    {   
        return $this->response->getRedirectResponse($view);
    }

    private function makeStorageResponse($filename, $mineType)
    {   
        return $this->response->getStorageResponse($filename, $mineType);
    }
}