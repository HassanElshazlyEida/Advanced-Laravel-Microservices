<?php

namespace App\Jobs;

use Illuminate\Mail\Message;
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
        var_dump('Sending email ...');
        $order = $this->order;
        \Mail::send('admin', ['order' => $order], function (Message $message) {
            $message->subject('An Order has been completed');
            $message->to('admin@admin.com');
        });

        \Mail::send('ambassador', ['order' => $order], function (Message $message) use ($order) {
            $message->subject('An Order has been completed');
            $message->to($order['ambassador_email'] ?? '');
        });

        var_dump( 'Order completed');
    }
}
