<?php

namespace App\Services;

class UserService extends ApiService
{
    public function __construct()
    {
        $this->url = env('USER_MS_API'); # User Service URL
    }
}
