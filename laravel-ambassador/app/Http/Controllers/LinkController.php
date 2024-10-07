<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Services\UserService;
use App\Http\Resources\LinkResource;

class LinkController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {

        
    }
    
    public function index($id)
    {
        $links = Link::with('orders')->where('user_id', $id)->get();

        return LinkResource::collection($links);
    }

    public function store(Request $request)
    {
        $user = $this->userService->get('/user');

        $link = Link::create([
            'user_id' => $user->id,
            'code' => Str::random(6)
        ]);

        foreach ($request->input('products') as $product_id) {
            LinkProduct::create([
                'link_id' => $link->id,
                'product_id' => $product_id
            ]);
        }

        return $link;
    }


}
