<?php

namespace App\Services;

class UserService extends ApiService
{
    public function __construct()
    {
        $this->url = 'http://host.docker.internal:8001/api'; # User Service URL
    }
}
