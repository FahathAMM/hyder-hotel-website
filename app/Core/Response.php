<?php

namespace App\Core;

class Response
{
    public static function json($message, $data = [], $status = true)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $message,
            'record'  => $data,
            'status'  => $status
        ]);
        exit;
    }
}
