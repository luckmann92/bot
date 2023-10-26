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
