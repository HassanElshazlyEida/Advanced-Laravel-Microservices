<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class ApiService
{
    protected string $url;

    public function post($path,$data) {
        return \Http::post($this->url.$path,$data);
    }
}
