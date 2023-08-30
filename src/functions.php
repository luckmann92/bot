<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

use Symfony\Component\VarDumper\VarDumper;

function sendGPT($text = '', $chatId = false)
{
    if (!$chatId) {
        $chatId = rand(9999, 1000000);
    }

    $message = [];
    $message["role"] = "user";
    $message["content"] = strip_tags($text);
    $messages[] = $message;

    $data["model"] = "gpt-3.5-turbo";
    $data["messages"] = $messages;
    $data["max_tokens"] = 150;

// Настройка cURL-сессии
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, GPT_HOST);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . GPT_TOKEN,
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

// Выполнение запроса и получение ответа
    $response = curl_exec($ch);
    if(curl_errno($ch)){
        echo 'Request Error:' . curl_error($ch);
    }
    curl_close($ch);

// Декодирование ответа JSON и вывод результата
    $result = json_decode($response, true);

    return isset($result['choices'][0]['message']['content']) ? $result['choices'][0]['message']['content'] : 'Error';
}

function getReplyMessage($request) {
    if (isset($request['message']['reply_to_message'])) {
        $replyMessage = $request['message']['reply_to_message'];

        if ($replyMessage['from']['username'] == 'bot_brodyagi_bot') {
            return $replyMessage['text'];
        }
    }
    return false;
}

function checkRecipientMessage($request = '')
{
    if (strlen(getReplyMessage($request)) > 0) {
        return true;
    }

    $text = $request['message']['text'] ?: '';
    if (strpos($text, TG_BOT_CODE) !== false) {
        return true;
    }
    $names = ['бот', 'ботик', 'аркаша', 'аркаш', 'Аркаш', 'аркадий', 'Аркаша', 'Аркадий'];
    $symbols = ['!', ')', '.', ',', ' ', ''];

    foreach ($names as $name) {
        foreach ($symbols as $symbol) {
            if (strpos(strtolower($text), $name.$symbol) !== false) {
                return true;
            }
        }
    }
    foreach ($names as $name) {
        if (strpos(strtolower($text), $name) !== false) {
            return true;
        }
    }
    return false;
}

function sendTgAction($action = '', $data = [])
{
    $data['parse_mode'] = 'html';
    $request = !empty($data) ? http_build_query($data) : '';

    $ch = curl_init(TG_HOST. TG_TOKEN ."/{$action}?" . $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $resultQuery = curl_exec($ch);
    curl_close($ch);

    return $resultQuery;
}

function writeLogFile($type, $string){
    $now = date("Y-m-d H:i:s");
    $log_file_name = $_SERVER['DOCUMENT_ROOT']."/logs/message__".date('d-m-Y').".log";

    $result = is_array($string) ? json_encode($string, JSON_UNESCAPED_UNICODE) : $string;

    file_put_contents($log_file_name,  $now.' ['.$type.']: '.$string."\r\n", FILE_APPEND);
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        if (!in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && !headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }

        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        exit(1);
    }
}
