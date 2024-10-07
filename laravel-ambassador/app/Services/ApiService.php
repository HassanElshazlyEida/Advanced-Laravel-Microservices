<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class ApiService
{
    protected string $url;


    public function request($method,$path,$data = []) {
        $response = \Http::acceptJson()->withHeaders(
        [
            'Authorization' => 'Bearer '.request()->cookie('jwt')
        ]
        )->$method($this->url.$path,$data);

        if($response->ok()) {
            return $response->json();
        }
        throw new \Exception($response->body());
    }

    public function post($path,$data) {
        return $this->request('post',$path,$data);
    }
    public function get($path) {
        return $this->request('get',$path);
    }
    public function put($path,$data) {
        return $this->request('put',$path,$data);
    }
    public function delete($path) {
        return $this->request('delete',$path);
    }
}
