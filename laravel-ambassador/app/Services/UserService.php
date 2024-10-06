<?php

namespace App\Services;

class UserService extends ApiService
{
    public function __construct()
    {
        $this->url = 'http://users_ms:8000/api'; # User Service URL
    }
}
