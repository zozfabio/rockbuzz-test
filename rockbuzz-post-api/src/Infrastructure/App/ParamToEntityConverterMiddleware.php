<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/27/19
 * Time: 10:06 PM
 */

namespace RockBuzz\Post\Infrastructure\App;

use Monolog\Logger;
use RockBuzz\Post\Domain\Repository;
use Slim\Http\Request;
use Slim\Http\Response;

class ParamToEntityConverterMiddleware {

    private $param;

    private $repository;

    public function __construct(string $param, Repository $repository) {
        $this->param      = $param;
        $this->repository = $repository;
    }

    public function __invoke(Request $request, Response $response, callable $next): Response {
        global $container;
        $params = $request->getParams();
        if (isset($params[$this->param])) {
            $entityId = $params[$this->param];
            if (is_array($entityId)) {
                $request = $request->withParsedBody(array_replace($params, [
                    $this->param => array_map([$this->repository, "findOne"], $entityId)
                ]));
            } else {
                $request = $request->withParsedBody(array_replace($params, [
                    $this->param => $this->repository->findOne($entityId)
                ]));
            }
        }
        return $next($request, $response);
    }
}