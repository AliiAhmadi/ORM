<?php

namespace Orm\Helpers;

use Orm\Exceptions\ConfigFileNotFoundException;

class Config
{
    public static function getFileContents(string $fileName): array
    {
        $filePath = realpath(__DIR__ . "/../configs/" . $fileName . ".php");

        if (!$filePath) {
            throw new ConfigFileNotFoundException();
        }

        $fileContents = require $filePath;

        return $fileContents;
    }

    public static function get(string $fileName, string $key = null): array|null
    {
        $fileContents = self::getFileContents($fileName);

        if (is_null($key)) {
            return $fileContents;
        }

        return $fileContents[$key] ?? null;
    }
}
