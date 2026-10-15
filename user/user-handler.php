<?php

// ثبت نقش کاربر
$sql = "UPDATE tbl_user SET role='user' WHERE user_id=:user_id";

$stmt = $telegram->db->prepare($sql);
$stmt->execute([':user_id' => $user_id]);

// ساخت کاربر
$user = new User(
    $user_id,
    $chat_id,
    $first_name,
    $last_name,
    $user_name,
    $time_stamp,
    $time_persion
);

// دستورات کاربر
if ($text_message != null) {

    switch ($text_message) {

        case '/start':
        case '🏘| خانه':

            User::home(
                $user_id,
                $chat_id,
                $first_name,
                $last_name,
                $user_name,
                $message_id
            );

            break;

        case '💰| تعرفه قیمت ها':

            User::tarefe_gheymatha($user_id, $chat_id);

            break;

        // سایر دستورات فعلی کاربر اینجا قرار می‌گیرند

        default:

            // مراحل کاربر مثل خرید و ثبت سفارش
            // در همین قسمت باقی می‌مانند

            break;
    }
}