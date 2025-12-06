<?php

namespace App\Http\Controller\API;

class BaseController
{
    protected function json($data, $status = 200)
    {
        http_response_code($status);
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }

    protected function input()
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    protected function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $required = in_array('required', $rule);
            $type     = $rule['type'] ?? null;

            if ($required && !isset($data[$field])) {
                $errors[$field][] = "Field '$field' required";
                continue;
            }

            if (!isset($data[$field])) continue;

            $value = $data[$field];

            if ($type === 'string' && !is_string($value)) {
                $errors[$field][] = "Field '$field' must be string";
            }

            if ($type === 'int' && !is_int($value)) {
                $errors[$field][] = "Field '$field' must be integer";
            }

            if ($type === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field][] = "Field '$field' must be a valid email";
            }
        }

        if (!empty($errors)) {
            $this->json([
                "success" => false,
                "errors" => $errors
            ], 422);
        }

        return $data;
    }
}