<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
            'user_id'=>$this->order['user_id'],
            'code'=>$this->order['code'],
            'total'=>$this->order['ambassador_revenue'],

        ]);
    }
}
