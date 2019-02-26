<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/23/19
 * Time: 7:10 PM
 */

namespace RockBuzz\Post\View;

use RockBuzz\Post\Domain\Arguments\Argument;
use Slim\Http\Request;

trait ControllerHasArguments {

    /**
     * @var ControllerArgument[]
     */
    private $arguments;

    /**
     * @return ControllerArgument[]
     */
    public abstract function getArguments();

    /**
     * @param Request $request
     * @return Argument[]
     */
    private function getArgumentsFromRequest(Request $request): array {
        $this->arguments = $this->arguments ?: $this->getArguments();

        $arguments = [];

        foreach ($this->arguments as $argument) {
            if ($value = $request->getParam($argument->getName())) {
                $arguments[] = $argument->newArgumentInstance($value);
            }
        }

        return $arguments;
    }
}