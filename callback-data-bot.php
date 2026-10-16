<?php

// ========================================
// فایل‌های مورد نیاز
// ========================================

require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/jdf.php';
require_once __DIR__ . '/check-data-user-in-db-bot.php';
require_once __DIR__ . '/user/user-function-bot.php';

// ========================================
// دریافت اطلاعات تلگرام
// ========================================

$raw_update = file_get_contents('php://input');

file_put_contents(__DIR__ . '/result.txt', $raw_update);

$update = json_decode($raw_update, true);
$data = json_decode($raw_update);

$telegram = new telegram();

// ========================================
// مقدار اولیه متغیرها
// ========================================

$user_id = null;
$chat_id = null;
$message_id = null;

$user_name = '';
$first_name = '';
$last_name = '';

$text_message = null;
$audio = null;
$caption = null;

$callback_id = null;
$text_callback = null;
$callback_data = null;

// ========================================
// دریافت پیام معمولی
// ========================================

if (isset($data->message)) {

    $message = $data->message;

    $user_id = $message->from->id ?? null;
    $chat_id = $message->chat->id ?? null;
    $message_id = $message->message_id ?? null;

    $first_name = $message->from->first_name ?? '';
    $last_name = $message->from->last_name ?? '';

    $username = $message->from->username ?? '';
    $user_name = $username !== '' ? '@' . $username : '';

    $text_message = $message->text ?? null;
    $audio = $message->audio->file_id ?? null;
    $caption = $message->caption ?? null;

}

// ========================================
// دریافت کلیک دکمه شیشه‌ای
// ========================================

elseif (isset($data->callback_query)) {

    $callback = $data->callback_query;

    $callback_id = $callback->id ?? null;

    $user_id = $callback->from->id ?? null;
    $chat_id = $callback->message->chat->id ?? null;
    $message_id = $callback->message->message_id ?? null;

    $first_name = $callback->from->first_name ?? '';
    $last_name = $callback->from->last_name ?? '';
    $user_name = $callback->from->username ?? '';

    $text_callback = $callback->data ?? null;
    $callback_data = $callback->data ?? null;
}

$time_stamp = time();

// ========================================
// اگر callback وجود ندارد، ادامه نده
// ========================================

if ($callback_data === null || $user_id === null) {
    return;
}

// ========================================
// مدیریت دکمه‌های شیشه‌ای
// ========================================

switch ($callback_data) {

    // ------------------------------------
    // ورود به ربات
    // ------------------------------------

    case 'FirstComingToBot':

        User::Index($user_id, $message_id);

        break;


   
   
}