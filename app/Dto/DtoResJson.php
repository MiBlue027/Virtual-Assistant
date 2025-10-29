<?php

namespace App\Dto;

class DtoResJson implements \JsonSerializable
{
    private bool $success;
    private string $message;
    private mixed $data;

    public function __construct(bool $success = true, string $message = '', mixed $data = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }
    public function jsonSerialize(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data
        ];
    }

    public function ToJson(): void
    {
        echo json_encode($this);
    }

    public function GetMessage(): string
    {
        return $this->message;
    }
}