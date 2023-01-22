<?php

namespace Orm\Contracts;

interface DatabaseConnectionInterface
{
    public function connect();
    public function getConnection();
}
