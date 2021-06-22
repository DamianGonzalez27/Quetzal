<?php namespace App\Core;

use App\Core\Client;
use App\Core\Tokenizer;
use App\Core\Validators\AuthValidator;
use App\Core\Validators\FilesValidator;
use App\Core\Validators\FiltersValidator;
use App\Core\Validators\ParamsValidator;
use App\Core\Validators\RoutesValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Clase Genesis
 * 
 * Esta clase tiene la unica responsabilidad de separar el tipo de peticion que se recibe por medio de HTTP
 * hace uso de la clase Routes
 * 
 * @see App\Core\Routes
 * 
 */
class Genesis
{
    private Request $request;

    private Tokenizer $tokenizer;

    private $apiParams; 

    private $services;

    private $method;

    private $data;

    private $filters;

    public $files;

    public $auth;

    public function __construct(Request $request, Tokenizer $tokenizer, $apiParams, $services)
    {
        $this->request = $request;  

        $this->method = ($request->request->get('_method') == "" || $request->request->get('_method') == '') ? null : $request->request->get('_method');

        $this->data = ($request->request->get('_data') == "" || $request->request->get('_data') == '') ? null : json_decode($request->request->get('_data'), true);

        $this->filters = ($request->request->get('_filters') == "" || $request->request->get('_filters') == '') ? null : json_decode($request->request->get('_filters'), true);

        $this->files = $request->files;

        $this->tokenizer = $tokenizer;

        $this->apiParams = $apiParams;

        $this->services = $services;

        $this->auth = $request->cookies->get('_auth');
    }

    public function execute()
    {
        $validador = $this->validateRequest();

        if(is_object($validador))
            return $validador;

        if(isset($validador['error']))
            return $this->makeErrorResponse($validador['error'], $validador['code']);
    }

    private function validateRequest()
    {
        $arrayPath = explode("/", $this->request->getPathInfo());

        if(!RoutesValidator::validateIssetPath($arrayPath[1]))
            return $this->makeError('Endpoint ot Found', 404);

        if(!RoutesValidator::validateEnpoint($arrayPath))
            return $this->makeError('Invalid endpoint', 404);

        if(!RoutesValidator::validateRoute($this->apiParams, $arrayPath[1]))
            return $this->makeError('Endpoint ot Found', 404);
        
        if(!RoutesValidator::validateRoute($this->apiParams[$arrayPath[1]]['methods'], $this->method))
            return $this->makeError('Method ot Found', 404);

        if($this->apiParams[$arrayPath[1]]['methods'][$this->method]['access'] == 'private') 
            return $this->makeResponsePrivate($this->apiParams[$arrayPath[1]]['class'], $this->apiParams[$arrayPath[1]]['methods'][$this->method]);

        else if($this->apiParams[$arrayPath[1]]['methods'][$this->method]['access'] == 'public-strict') 
            return $this->makeResponsePublicStrict($this->apiParams[$arrayPath[1]]['class'], $this->apiParams[$arrayPath[1]]['methods'][$this->method]);    

        return $this->makeResponsePublic($this->apiParams[$arrayPath[1]]['class'], $this->apiParams[$arrayPath[1]]['methods'][$this->method]);
    }

    private function makeResponsePrivate($class, $options)
    {           
        if(!AuthValidator::validateAuth($this->request))
            return $this->makeError([
                'access' => [
                    'name' => 'Bad Access',
                    'descripion' => 'Permisos no encontrados'
                ]
            ], 400);

        if($options['permissions'] == 'no')
            return $this->makeResponsePublic($class, $options);

        if(!AuthValidator::validatePermission($this->request, $options['permissions']))
            return $this->makeError([
                'access' => [
                    'name' => 'Bad Access',
                    'descripion' => 'Permisos incorrectos'
                ]
            ], 400);

        return $this->makeResponsePublic($class, $options);
    }

    private function makeResponsePublicStrict($class, $options)
    {
        if(AuthValidator::validatePublicStrict($this->request))
            return $this->makeError([
                'access' => [
                    'name' => 'Public Access',
                    'descripion' => 'Ruta de acceso estrictamente publico'
                ]
            ], 400);
        
        return $this->makeResponsePublic($class, $options);
    }

    private function makeResponsePublic($class, $options)
    {
        if(isset($options['params']))
            $paramsValidator = ParamsValidator::validateParams($options['params'], $this->data);

        if(isset($options['files']))
            $filesValidator = FilesValidator::validateFiles($options['files'], $this->files);

        if(isset($options['filters']))
            $filtersValidator = FiltersValidator::validateFilters($options['filters'], $this->filters);

        $errors = [];
        
        if(!empty($paramsValidator))
            $errors['_data'] = $paramsValidator;

        if(!empty($filesValidator))
            $errors['_files'] = $filesValidator;

        if(!empty($filtersValidator))
            $errors['_filters'] = $filtersValidator;

        if(isset($errors['_data']) || isset($errors['_files']) || isset($errors['_filters']))
            return $this->makeError($errors, 200);

        $client = new Client(
            $class,
            $options['function'],
            $this->data,
            $this->files,
            $this->filters,
            $this->services,
            $this->auth
        );
        
        return $client->execute();
    }

    private function makeError($error, $code)
    {
        return [
            'error' => $error,
            'code' => $code
        ];
    }

    private function makeErrorResponse($content, $code)
    {
        return new JsonResponse(['_errors' => $content], $code);
    }
}