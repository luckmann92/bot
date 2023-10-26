<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

namespace App\Services\Telegram;

use App\Facades\OpenAI;
use App\Services\GoogleBardService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use AdityaDees\LaravelBard\LaravelBard;

class IndexService
{
    public function get(Request $request)
    {
       // return OpenAI::ask('erfwere');
       $bard = (new LaravelBard())->get_answer('Сколько будет 2+2?');
       // $bard = new GoogleBardService();
        //$result = $bard->get_answer('Сколько будет 2+2?');
        dd($bard);
        return [
            Telegram::bot()->getMe(),
            Telegram::getWebhookInfo()
        ];
    }
}
