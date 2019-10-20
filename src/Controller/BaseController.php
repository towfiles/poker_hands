<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 7/26/19
 * Time: 9:39 PM
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BaseController
 * @package App\Controller
 */
class BaseController extends AbstractController
{

    /**
     * @var integer HTTP status code - 200 (OK) by default
     */
    protected $statusCode = 200;


    /**
     * @var array the default values are set for the headers
     */
    private $headers =  [
        'Content-Type'  => 'application/json',
        'Access-Control-Allow-Origin' => '*'

    ];


    /**
     * Gets the value of statusCode.
     *
     * @return integer
     */
    public function getStatusCode() :int
    {
        return $this->statusCode;
    }


    /**
     * Sets the value of statusCode.
     *
     * @param integer $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode(int $statusCode) :self
    {
        $this->statusCode = $statusCode;

        return $this;
    }



    /**
     * Returns a JSON response
     *
     * @param object $data
     * @param array $headers
     *
     * @return JsonResponse
     */
    public function result($data, $headers = []) :JsonResponse
    {

        $this->setHeaders($headers);

        return new JsonResponse($data,
            $this->getStatusCode(),
            $this->getHeaders());
    }


    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $errors
     *
     * @param array $headers
     * @return JsonResponse
     */
    public function resultWithErrors($errors, $headers = []) :JsonResponse
    {
        $data = [
            'errors' => $errors,
        ];
        $this->setHeaders($headers);

        return new JsonResponse($data,
            $this->getStatusCode(),
            $this->getHeaders()
        );
    }

    /**
     * Returns a 401 Unauthorized http response
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function resultWithUnauthorized($message = 'Not authorized!') :JsonResponse
    {
        return $this->setStatusCode(401)->resultWithErrors($message);
    }



    public function resultValidationError($message = 'Validation errors') :JsonResponse
    {
        return $this->setStatusCode(422)->resultWithErrors($message);
    }


    public function resultServerError($message = 'Server Error Occured') :JsonResponse
    {
        return $this->setStatusCode(500)->resultWithErrors($message);
    }

    // respond with server error



    public function resultNotFound($message = 'Not found!') :JsonResponse
    {
        return $this->setStatusCode(404)->resultWithErrors($message);
    }



    public function respondCreated($data = []) :JsonResponse
    {
        return $this->setStatusCode(201)->result($data);
    }


    /**
 * @return array
 */
public function getHeaders(): array
{
    return $this->headers;
}


/**
 * merges the headers to be set with the default headers
 * @param array $headers
 */
public function setHeaders(array $headers) :void
{
    $this->headers = array_merge($this->headers, $headers);
}


}