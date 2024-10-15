<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OrderCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public array $order
    )
    {
        //
    }
    public function handle()
    {
        Order::create([
            'id'=>$this->order['id'],
            'transaction_id'=>$this->order['transaction_id'],
            'first_name'=>$this->order['first_name'],
            'last_name'=>$this->order['last_name'],
            'email'=>$this->order['email'],
            'address'=>$this->order['address'],
            'city'=>$this->order['city'],
            'country'=>$this->order['country'],
            'zip'=>$this->order['zip'],
            'ambassador_email'=>$this->order['ambassador_email'],
            'user_id'=>$this->order['user_id'],
            'code'=>$this->order['code'],
            'total'=>$this->order['ambassador_revenue'],

        ]);

        OrderItem::insert($this->order['order_items']);
    }
}
