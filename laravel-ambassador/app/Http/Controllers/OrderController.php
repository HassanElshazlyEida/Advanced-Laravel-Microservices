<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Jobs\OrderCompleted;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Services\UserService;
use App\Events\OrderCompletedEvent;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {

        
    }
    
    public function index()
    {
        return OrderResource::collection(Order::with('orderItems')->get());
    }

}
