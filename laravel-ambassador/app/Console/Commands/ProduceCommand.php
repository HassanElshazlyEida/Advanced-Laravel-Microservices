<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Jobs\OrderCompleted;
use Illuminate\Console\Command;

class ProduceCommand extends Command
{

    protected $signature = 'produce';

    public function handle()
    {
        $order = Order::first();
        
        OrderCompleted::dispatch($order->toArray());
    }
}
