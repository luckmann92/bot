<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

ini_set('display_errors', 1);

include_once 'src/vendor/autoload.php';
include_once 'src/config.php';
include_once 'src/functions.php';

$request = file_get_contents('php://input');
writeLogFile('get', $request);


/*$request = '{"update_id":114144816,
"message":{"message_id":27,"from":{"id":352128585,"is_bot":false,"first_name":"\u041c\u0438\u0445\u0430\u0438\u043b","last_name":"\u041b\u0443\u043a\u043c\u0430\u043d\u043e\u0432","username":"luck_mann","language_code":"ru"},"chat":{"id":-932471426,"title":"Bot","type":"group","all_members_are_administrators":true},"date":1693319779,"reply_to_message":{"message_id":22,"from":{"id":6573834834,"is_bot":true,"first_name":"\u0410\u0440\u043a\u0430\u0448\u0430","username":"bot_brodyagi_bot"},"chat":{"id":-932471426,"title":"Bot","type":"group","all_members_are_administrators":true},"date":1693319223,"text":"\u041e\u0439, \u0434\u0430 \u043c\u043d\u0435 \u043a\u0430\u043a\u0430\u044f \u0440\u0430\u0437\u043d\u0438\u0446\u0430 \u0447\u0435\u043c \u0442\u044b \u0437\u0430\u0439\u043c\u0435\u0448\u044c\u0441\u044f! \u042f \u0442\u0435\u0431\u0435 \u0438\u0434\u0435\u0438 \u0434\u0430\u0432\u043d\u043e \u043f\u0440\u0438\u0432\u044b\u0447\u043d\u043e \u0432\u044b\u0441\u043a\u0430\u0437\u044b\u0432\u0430\u044e, \u0430 \u0442\u044b \u0432\u0441\u0435 \u0440\u0430\u0432\u043d\u043e \u043d\u0438\u0447\u0435\u0433\u043e \u043d\u0435 \u0434\u0435\u043b\u0430\u0435\u0448\u044c. \u0422\u0430\u043a \u0447\u0442\u043e \u0434\u0430\u0432\u0430\u0439 \u043d\u0435 \u043e\u0442\u0432\u043b\u0435\u043a\u0430\u0439\u0441\u044f, \u0430 \u043f\u0440\u043e\u0434\u043e\u043b\u0436\u0430\u0439 \u0441\u0432\u043e\u044e \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u0438\u0432\u043d\u0443\u044e \u0436\u0438\u0437\u043d\u044c, \u0438\u043b\u0438 \u0445\u043e\u0442\u044f \u0431\u044b \u043f\u043e\u043f\u0440\u043e\u0431\u0443\u0439 \u0447\u0442\u043e-\u043d\u0438\u0431\u0443\u0434\u044c \u0441\u0430\u043c \u043f\u0440\u0438\u0434\u0443\u043c\u0430\u0442\u044c."},"text":"\u0418?"}}';
*/

$request = json_decode($request, true);

if (isset($request['message']) && !empty($request['message']))
{
    if (checkRecipientMessage($request) || ($request['message'] == 'Нет' || $request['message'] == 'нет'))
    {
        $isAnswer = false;
        if ($request['message'] == 'Нет' || $request['message'] == 'нет') {
            $text = 'Пидора ответ';
            $isAnswer = true;
        } else {
            $text = 'Тебя зовут Аркадий, ты очень уставший от жизни человек и поэтому много пьешь и уже отчаялся что когда все наладится, работаешь консультант в чате. Твоя работа помочь не задавая вопросов. У тебя есть ограничение в 200 символов на ответ.';
        }
        $message = [
            'chat_id' => $request['message']['chat']['id'],
            'parse_mode' => 'html',
            'allow_sending_without_reply' => true
        ];

        if (isset($request['message']['message_id']) && !$isAnswer) {
            $message['reply_to_message_id'] = $request['message']['message_id'];

            $replyText = getReplyMessage($request);
            if ($replyText) {
                $text .= ' Тебе ранее написали сообщение: '.$replyText.'.';
            }
        }

        if (!$isAnswer) {
            $text .= ' Сейчас тебе написали вот такое сообщение: ';
            $text .= strip_tags(str_replace(TG_BOT_CODE, '', $request['message']['text'])) . '. ';
            $text .= 'Напиши свой ответ на сообщение';

            $answer = sendGPT($text);
            if ($answer != 'Error') {
                $message['text'] = $answer;
                $result = sendTgAction('sendMessage', $message);
                writeLogFile('send', $result);
            }
        } else {
            $result = sendTgAction('sendMessage', $message);
            writeLogFile('send', $result);
        }
    }
}
