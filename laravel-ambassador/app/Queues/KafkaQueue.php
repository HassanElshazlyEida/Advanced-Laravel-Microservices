<?php

namespace App\Queues;

use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Queue\Queue;

class KafkaQueue extends Queue implements QueueContract
{
  
    public function __construct(
        protected $consumer,
        protected $producer
    )
    {

    }
 
	public function size($queue = null)
	{
		
	}

	public function push($job, $data = '', $queue = null)
	{
        $topic= $this->producer->newTopic('default');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'hello from laravel');
        $this->producer->flush(10000);
	}

	public function pushRaw($payload, $queue = null, array $options = [])
	{
	
	}

	public function later($delay, $job, $data = '', $queue = null)
	{
		
	}

	public function pop($queue = null)
	{

        $this->consumer->subscribe(['default']);

        $message = $this->consumer->consume(120*1000);

        switch ($message->err) {
            case RD_KAFKA_RESP_ERR_NO_ERROR:
                var_dump($message);
                break;
            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                var_dump('No more messages; will wait for more');
                break;
            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                var_dump('Timed out');
                break;
            default:
                var_dump($message->errstr(), $message->err);
                break;
        }

	}
}
