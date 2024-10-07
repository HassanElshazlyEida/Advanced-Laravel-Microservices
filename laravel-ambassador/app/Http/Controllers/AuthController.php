<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {

        
    }
    public function register(RegisterRequest $request)
    {
        $data =$request->only('first_name', 'last_name', 'email', 'password')
        + [
            'is_admin' => $request->path() === 'api/admin/register' ? 1 : 0
        ];
        $user = $this->userService->post('/register',$data);
        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {

        $scope = $request->path() == 'api/admin/login' ? 'admin' : 'ambassador';

        $response = $this->userService->post('/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'scope' => $scope
        ]);
        if(!($response['jwt'] ?? null)){
            return $response;
        }

        $cookie = cookie('jwt', $response['jwt'] ?? '', 60 * 24); // 1 day

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function user()
    {
        return $this->userService->get('/user');
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $user->update([
            'password' => \Hash::make($request->input('password'))
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }
}
