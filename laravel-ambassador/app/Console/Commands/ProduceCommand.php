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
        $array = $order->toArray();

        $array['ambassador_revenue'] = $order->ambassador_revenue;

        OrderCompleted::dispatch($array)->onQueue('email_topic');
    }
}
