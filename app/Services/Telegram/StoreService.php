<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

namespace App\Services\Telegram;

use App\Facades\OpenAI;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class StoreService
{
    public function store(Request $request)
    {
        $updates = Telegram::getWebhookUpdate();


        foreach ($updates as $event) {
            //OpenAI::ask($event->message)


            /**
             * @author Lukmanov Mikhail <lukmanof92@gmail.com>
             */

          /*  define("NO_KEEP_STATISTIC", true);
            define("NOT_CHECK_PERMISSIONS", true);
            define('STOP_STATISTICS', true);
            require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

            $result = [];
            $json = file_get_contents(__DIR__ . '/result.json');

            $data = $json ? json_decode($json, true) : [];

            foreach ($data['messages'] as $message) {
                $from = $message['from'];
                if (isset($message['text_entities']) && is_array($message['text_entities'])) {
                    foreach ($message['text_entities'] as $entity) {
                        if ($entity['type'] == 'hashtag') {
                            foreach ($message['text_entities'] as $text_entity) {
                                if ($text_entity['type'] == 'plain') {

                                    $value = preg_replace("/[^0-9]/", '', $text_entity['text']);

                                    $result[trim($entity['text'])][$from][] = $value;
                                }
                            }
                        }
                    }
                }
            }

            foreach ($result as $type => $persons) {
                foreach ($persons as $name => $values) {
                    $value = 0;
                    foreach ($values as $vl) {
                        $value += $vl;
                    }
                    $result['sum'][$type][$name] = $value;
                }
            }


            dd($result);*/

        }


    }

    public function set(Request $request)
    {
        $params = [
            'url' => env('TELEGRAM_WEBHOOK_URL')
        ];
        return Telegram::bot()->setWebhook($params);

    }

    public function unset(Request $request)
    {
        return Telegram::bot()->removeWebhook();
    }

    public function handle(Request $request)
    {
        Log::info('telegram', $request->toArray());

        $updates = Telegram::getWebhookUpdate();
    }
}
