<?php

namespace App\Http\Controllers;


use Services\UserService;

class AmbassadorController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {

        
    }
    public function index()
    {
        $users = $this->userService->get('/users');
        return collect($users)->filter(fn ($user) => $user['is_admin'] == 0)->values();
    }
}
