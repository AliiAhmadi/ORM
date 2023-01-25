<?php

namespace Orm\Helpers;

use GuzzleHttp\Client;
use Orm\Helpers\Config;

class HttpClient extends Client
{
    public function __construct()
    {
        $config = Config::get("uri", "base_uri");

        parent::__construct($config);
    }
}
