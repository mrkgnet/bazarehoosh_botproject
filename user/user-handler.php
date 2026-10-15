<?php

// ====================================
// ثبت یا بروزرسانی اطلاعات کاربر
// ====================================

// ساخت کاربر
// اگر کاربر جدید باشد، داخل دیتابیس ثبت می‌شود
$user = new User(
    $user_id,
    $chat_id,
    $first_name,
    $last_name,
    $user_name,
    $time_stamp,
    $time_persion
);



// ====================================
// مدیریت دستورات کاربر
// ====================================

if ($text_message != null) {

    switch ($text_message) {

        // ====================================
        // دستور استارت
        // ====================================


case '/start':

    // دریافت وضعیت خوشامدگویی
    $sql = "SELECT welcome_shown FROM tbl_user
            WHERE user_id = :user_id";

    $stmt = $telegram->db->prepare($sql);

    $stmt->execute([
        ':user_id' => $user_id
    ]);

    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user_data && $user_data['welcome_shown'] == 0) {

        // نمایش پیام خوشامدگویی
        // ثبت وضعیت داخل همین تابع انجام می‌شود
        User::DisplayStart(
            $user_id,
            $chat_id,
            $first_name,
            $last_name,
            $user_name
        );

    } else {

        // نمایش منوی اصلی برای کاربران قدیمی
        User::home(
            $user_id,
            $chat_id,
            $first_name,
            $last_name,
            $user_name,
            $message_id
        );
    }

    break;

       



        // ====================================
        // منوی اصلی
        // ====================================

        case '🏘| خانه':

            User::home(
                $user_id,
                $chat_id,
                $message_id
            );

            break;


        // ====================================
        // تعرفه قیمت‌ها
        // ====================================

        case '💰| تعرفه قیمت ها':

            User::tarefe_gheymatha(
                $user_id,
                $chat_id
            );

            break;


        // ====================================
        // سایر دستورات کاربر
        // ====================================

        // دستورات جدید را اینجا اضافه کن


        // ====================================
        // مراحل کاربر
        // ====================================

        default:

            // مراحل خرید و ثبت سفارش
            // در آینده اینجا قرار می‌گیرند

            break;
    }
}