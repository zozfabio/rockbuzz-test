<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/27/19
 * Time: 7:53 PM
 */

namespace RockBuzz\Post\Infrastructure\App;

use Exception;
use RockBuzz\Post\Domain\InvalidValueException;
use RockBuzz\Post\Domain\NotFoundRepositoryException;
use Slim\Http\Request;
use Slim\Http\Response;

class ErrorHandler {

    public function __invoke(Request $request, Response $response, Exception $ex): Response {
        if ($ex instanceof NotFoundRepositoryException) {
            return $response
                ->withStatus(404, "Resource Not Found")
                ->withJson([
                    "message" => $ex->getMessage(),
                ]);
        } elseif ($ex instanceof InvalidValueException) {
            return $response
                ->withStatus(400, "Invalid Request")
                ->withJson([
                    "message" => $ex->getMessage(),
                ]);
        }
        return $response
            ->withStatus(500, "Unexpected Error")
            ->withJson([
                "message" => $ex->getMessage(),
            ]);
    }
}