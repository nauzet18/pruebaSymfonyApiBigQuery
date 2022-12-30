<?php
namespace App\Models;

class Params
{
    public function __construct(private ?array $data = [])
    {

    }

    public function all()
    {
        return $this->data;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function get(string $key, mixed $default = null)
    {
        if ( isset($this->data[$key]) && !empty($this->data[$key]) )
            return $this->data[$key];

        return $default;
    }
}
