<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsumeCommand extends Command
{

    protected $signature = 'consume';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // not defined because it installed on docker not on local
        $conf = new \RdKafka\Conf();

        $conf->set('bootstrap.servers',env('KAFKA_BOOTSTRAP_SERVERS'));
        $conf->set('security.protocol',env('KAFKA_SECURITY_PROTOCOL'));
        $conf->set('sasl.mechanisms',env('KAFKA_SASL_MECHANISMS'));
        $conf->set('sasl.username',env('KAFKA_SASL_USERNAME'));
        $conf->set('sasl.password',env('KAFKA_SASL_PASSWORD'));
        $conf->set('group.id', env('KAFKA_GROUP_ID'));
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new \RdKafka\KafkaConsumer($conf);

        while(true){
            // topic name is default
            $consumer->subscribe(['default']);

            $message = $consumer->consume(120*1000);

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $message = json_decode($message->payload);
                    var_dump($message);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    $this->warn('No more messages; will wait for more');
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    $this->warn('Timed out');
                    break;
                default:
                    $this->error($message->errstr(), $message->err);
                    break;
            }
        }

    }
}


