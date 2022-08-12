<?php

namespace App\Console\Commands;

use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;
use Aws\Sqs\SqsClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class sqsconsume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sqs:consume-people-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $credentials = new Credentials(env("AWS_ACCESS_KEY_ID"), env("AWS_SECRET_ACCESS_KEY"));
        $client = new SqsClient([
            "region" => env("AWS_REGION"),
            "credentials" => $credentials,
            "version" => "2012-11-05"
        ]);

        try {
          $this->info("Iniciado processamento");
          while(true) {
              $result = $client->receiveMessage(array(
                  'AttributeNames' => ['SentTimestamp'],
                  'MaxNumberOfMessages' => 1,
                  'MessageAttributeNames' => ['All'],
                  'QueueUrl' => env("AWS_SQS_QUEUE"),
                  'WaitTimeSeconds' => 0,
              ));
              if (!empty($result->get('Messages'))) {
                   var_dump($result->get("Messages")[0]["Body"]);
                   $body = json_decode($result->get("Messages")[0]['Body'], true);
                   var_dump($body);
                   DB::insert("INSERT INTO pessoas(NOME,IDADE, SEXO)VALUES(?,?,?)",[
                       $body['nome'],
                       $body['idade'],
                       $body['sexo']
                   ]);

                    $client->deleteMessage([
                        'QueueUrl' => env("AWS_SQS_QUEUE"), // REQUIRED
                        'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle']
                    ]);
              }
          }
        }catch (AwsException $exception) {
            $this->error($exception->getMessage());
            return 0;
        }
    }
}
