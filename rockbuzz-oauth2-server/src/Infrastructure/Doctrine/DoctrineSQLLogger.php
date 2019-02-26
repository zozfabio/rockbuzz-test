<?php
/**
 * Created by PhpStorm.
 * User: zozfabio
 * Date: 2/17/19
 * Time: 10:16 AM
 */

namespace RockBuzz\OAuth2\Server\Infrastructure\Doctrine;

use Doctrine\DBAL\Logging\SQLLogger;
use Monolog\Logger;

class DoctrineSQLLogger implements SQLLogger {

    private $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    /**
     * Logs a SQL statement somewhere.
     *
     * @param string $sql The SQL to be executed.
     * @param mixed[]|null $params The SQL parameters.
     * @param int[]|string[]|null $types The SQL parameter types.
     *
     * @return void
     */
    public function startQuery($sql, ?array $params = null, ?array $types = null) {
        $this->logger->debug("SQL: [$sql] params: [".print_r($params, true)."]");
    }

    /**
     * Marks the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery() {
    }
}