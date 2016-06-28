<?php

namespace Lchski;

use Lchski\Contracts\Controller;
use Slim\Container;
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

abstract class BaseController implements Controller
{
    /**
     * Our Slim Request object.
     *
     * @var Request $request
     */
    protected $request;

    /**
     * Our Slim Response object.
     *
     * @var Response $response
     */
    protected $response;

    /**
     * The arguments to our Slim route.
     *
     * @var array $args
     */
    protected $args;

    /**
     * Slim Dependency Injection Container.
     *
     * @var Container $c
     */
    protected $c;

    /**
     * Set the DI Container.
     *
     * @param Container $c
     */
    public function __construct(Container $c)
    {
        $this->c = $c;
    }

    /**
     * Set our controller instance variables.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        /**
         * Set our controllers parameters to the route's.
         */
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        /**
         * Call the controller method corresponding to the route name.
         */
        return call_user_func([$this, $request->getAttribute('route')->getName()]);
    }

    /**
     * Convert data to JSON and set as response, with caching header.
     *
     * @param $data mixed
     *
     * @return Response
     */
    public function buildResponse($data)
    {
        $builtResponse = $this->response
            ->withHeader('Content-Type', 'application/json');

        // If the data comes directly from a Guzzle, we just process it directly.
        if ( isset($data['directResponse']) ) {
            $builtResponse = $builtResponse
                ->write(
                    json_encode(
                        xmlToArray(
                            simplexml_load_string(
                                $data['directResponse']->getBody()
                            )
                        ),
                        JSON_PRETTY_PRINT
                    )
                );
        // If we’ve already processed the data on our end, we don't need extra XML processing.
        } else {
            // Construct response based on provided data.
            $builtResponse = $builtResponse
                ->write(
                    json_encode($data, JSON_PRETTY_PRINT)
                );
        }

        // Return the response with an ETag added, for caching.
        return $this->c->cache->withEtag($builtResponse, sha1($builtResponse->getBody()));
    }
}
