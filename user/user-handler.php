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
                User::Index(
                    $user_id,
                    $message_id
                );
            }

            break;

        // ====================================
        // منوی اصلی
        // ====================================

        case '🏘| خانه':

            User::Index(
                $user_id,
                $message_id
            );

            break;

        case '🎧 پشتیبانی و ثبت تیکت':

            User::sendMessageToAdmin(
                $user_id,
               
            );

            break;


        default:

            // مراحل خرید و ثبت سفارش
            // در آینده اینجا قرار می‌گیرند

            break;
    }
}