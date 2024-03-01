<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use PDO;
use Psr\Container\ContainerInterface;

class PgHelper extends \Codeception\Module
{
    public function fixSequence(string $tableName, string $tableField): void
    {
        /** @var PDO $dbh */
        $dbh = $this->getModule('Db')->dbh;

        if ($dbh->getAttribute(PDO::ATTR_DRIVER_NAME) === 'pgsql') {
            $dbh->query('SELECT SETVAL((SELECT PG_GET_SERIAL_SEQUENCE(\'"' . $tableName . '"\', \'' . $tableField . '\')), (SELECT (MAX("' . $tableField . '") + 1) FROM "' . $tableName . '"), FALSE)');
        }
    }
}
