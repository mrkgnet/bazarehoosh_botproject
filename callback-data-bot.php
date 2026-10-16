<?php

require_once "telegram.php";
//require_once "config.php";
//require_once "userFunctions.php";
//require_once "addminFunctions.php";
// require_once "jdf.php";
// require_once "endTimeAccoutnUsers_Cronjob.php";

require_once "user/user-function-bot.php";


//--------------callback-date


$update = file_get_contents("php://input");
file_put_contents('result.txt', $update);
$update = json_decode($update, true);
$data = json_decode(file_get_contents("php://input"));
$telegram = new telegram();


if (array_key_exists('message', $data)) {
    $user_id = $data->message->from->id;
    $chat_id = $data->message->chat->id;
    $message_id = $data->message->message_id;
    $user_name = '@' . $data->message->from->username;
    $last_name = $data->message->from->last_name;
    $first_name = $data->message->from->first_name;
    $text_message = $data->message->text;
    $audio = $data->message->audio->file_id;
    $caption = $data->message->caption;

} elseif (array_key_exists('callback_query', $data)) {
    $callback_id = $data->callback_query->id;
    $user_id = $data->callback_query->from->id;
    $chat_id = $data->callback_query->message->chat->id;
    $message_id = $data->callback_query->message->message_id;
    $user_name = $data->callback_query->from->username;
    $first_name = $data->callback_query->from->first_name;
    $text_callback = $data->callback_query->data;
    $callback_data = $data->callback_query->data;

}

// $time_persion = jdate("Y/n/j-H:i:s ");
$time_stamp = time();


switch ($callback_data) {   
   
    case 'ConfirmSendProxyToChanel':
        {

            Admin::ConfirmSendProxyToChanel($user_id);
        }
        break;

}