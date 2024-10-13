<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\User;
use Services\UserService;
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
        $data =$request->only('first_name', 'last_name', 'email', 'password')+ [ 'is_admin' =>  0];
        $user = $this->userService->post('/register',$data);
        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {

        $response = $this->userService->post('/login', [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'scope' =>'ambassador'
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
        $user = $this->userService->get('/user');

        $orders = Order::where('user_id', $user['id'])->get();

        $user['revenue'] = $orders->sum(fn(Order $order) => $order->total);

        return $user;
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');

        $this->userService->post('/logout', []);
        
        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $this->userService->put('/users/info', 
            $request->only('first_name', 'last_name', 'email')
        );

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $this->userService->put('/users/password', [
            'password' => $request->input('password')
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }
}
