<?php

require_once "telegram.php";
require_once "config.php";
require_once "jdf.php";

require_once "user/user-function-bot.php";
require_once "admin/admin-function-bot.php";

// دریافت پیام تلگرام
$raw_update = file_get_contents("php://input");

file_put_contents("result.txt", $raw_update);

$update = json_decode($raw_update, true);
$data = json_decode($raw_update);

$telegram = new telegram();

// اطلاعات اولیه
$user_id = null;
$chat_id = null;
$message_id = null;
$user_name = '';
$first_name = '';
$last_name = '';
$text_message = null;
$fileid_photo = null;
$audio = null;
$caption = null;
$callback_id = null;
$text_callback = null;
$callback_data = null;

// پیام معمولی
if (isset($data->message)) {

    $user_id = $data->message->from->id ?? null;
    $chat_id = $data->message->chat->id ?? null;
    $message_id = $data->message->message_id ?? null;

    $first_name = $data->message->from->first_name ?? '';
    $last_name = $data->message->from->last_name ?? '';

    $user_name = isset($data->message->from->username)
        ? '@' . $data->message->from->username
        : '';

    $text_message = $data->message->text ?? null;
    $audio = $data->message->audio->file_id ?? null;
    $caption = $data->message->caption ?? null;

    if (isset($data->message->photo)) {
        $photos = $data->message->photo;
        $last_photo = end($photos);
        $fileid_photo = $last_photo->file_id ?? null;
    }

}

// دکمه شیشه‌ای
elseif (isset($data->callback_query)) {

    $callback_id = $data->callback_query->id ?? null;

    $user_id = $data->callback_query->from->id ?? null;
    $chat_id = $data->callback_query->message->chat->id ?? null;
    $message_id = $data->callback_query->message->message_id ?? null;

    $first_name = $data->callback_query->from->first_name ?? '';
    $user_name = $data->callback_query->from->username ?? '';

    $text_callback = $data->callback_query->data ?? null;
    $callback_data = $text_callback;
}

// اطلاعات زمان
$time_stamp = time();


// تشخیص کاربر و ادمین
if ($user_id != null) {

    if ($user_id == adminChatIDMain) {

        require "admin/admin-handler.php";

    } else {

        require "user/user-handler.php";
    }
}

// مدیریت دکمه‌های شیشه‌ای
require_once "callback-data-bot.php";