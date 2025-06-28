<?php


if (!function_exists('pluck')) {
    function pluck($array,  $valueKey, $keyKey = null): array
    {
        $results = [];

        foreach ($array as $item) {
            $value = is_array($item) ? $item[$valueKey] ?? null : $item->$valueKey ?? null;

            if ($keyKey !== null) {
                $key = is_array($item) ? $item[$keyKey] ?? null : $item->$keyKey ?? null;
                if ($key !== null) {
                    $results[$key] = $value;
                }
            } else {
                $results[] = $value;
            }
        }

        return $results;
    }
}


if (!function_exists('dd')) {
    function dd(...$vars)
    {
        echo '<pre style="background:#f6f8fa;padding:10px;border-radius:5px;">';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
        die;
    }
}

if (!function_exists('dl')) {
    function dl($vars)
    {
        echo "<pre>" . json_encode($vars, JSON_PRETTY_PRINT) . "</pre>";
        die;
    }
}

if (!function_exists('loadEnv')) {

    function loadEnv($filePath)
    {
        if (!file_exists($filePath)) return;

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // Skip comments
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}
