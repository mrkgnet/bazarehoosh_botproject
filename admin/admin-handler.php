<?php

// ثبت نقش ادمین
$sql = "UPDATE tbl_user SET role='admin' WHERE user_id=:user_id";

$stmt = $telegram->db->prepare($sql);
$stmt->execute([':user_id' => $user_id]);

// دستورات ادمین
if ($text_message != null) {

    switch ($text_message) {

        case '/start':
        case '🏘| خانه':

            Admin::display_menu($user_id);

            break;

        case '🔍| جست و جوی کاربر':

            Admin::search_user($user_id);

            break;

        case '🔉| ارسال پیام به همه کاربران':

            Admin::sendMessageToAllUser($user_id);

            break;

        // سایر دستورات ادمین

        default:

            // مراحل ادمین

            break;
    }
}

// مدیریت عکس ادمین
if ($fileid_photo != null) {

    // کدهای ارسال عکس ادمین
    // در همین بخش قرار می‌گیرند
}