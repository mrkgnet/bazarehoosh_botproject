<?php
//--------------------------------------------------------------
require_once "telegram.php";
require_once "config.php";
require_once "jdf.php";
require_once "user/user-function-bot.php";
require_once "admin/admin-function-bot.php";
//------------------------------------------------------------------

$raw_update = file_get_contents("php://input");
file_put_contents('result.txt', $raw_update);
$update = json_decode($raw_update, true);
$data = json_decode($raw_update);

$telegram = new telegram();

// مقداردهی اولیه متغیرها برای جلوگیری از خطای Undefined
$user_id = null;
$chat_id = null;
$message_id = null;
$user_name = null;
$last_name = null;
$first_name = null;
$text_message = null;
$audio = null;
$caption = null;
$fileid_photo = null;
$callback_id = null;
$text_callback = null;
$callback_data = null;

if (isset($data->message)) {
    $user_id = $data->message->from->id ?? null;
    $chat_id = $data->message->chat->id ?? null;
    $message_id = $data->message->message_id ?? null;
    $user_name = isset($data->message->from->username) ? '@' . $data->message->from->username : '';
    $last_name = $data->message->from->last_name ?? '';
    $first_name = $data->message->from->first_name ?? '';
    $text_message = $data->message->text ?? null;
    $audio = $data->message->audio->file_id ?? null;
    $caption = $data->message->caption ?? null;

    // دریافت باکیفیت‌ترین عکس ارسالی در صورت وجود
    if (isset($data->message->photo) && is_array($data->message->photo)) {
        $last_photo = end($data->message->photo);
        $fileid_photo = $last_photo->file_id ?? null;
    }
} elseif (isset($data->callback_query)) {
    $callback_id = $data->callback_query->id ?? null;
    $user_id = $data->callback_query->from->id ?? null;
    $chat_id = $data->callback_query->message->chat->id ?? null;
    $message_id = $data->callback_query->message->message_id ?? null;
    $user_name = $data->callback_query->from->username ?? '';
    $first_name = $data->callback_query->from->first_name ?? '';
    $text_callback = $data->callback_query->data ?? null;
    $callback_data = $data->callback_query->data ?? null;
}

//_____________________________________________________________________

$time_stamp = time();
$time_persion = jdate('Y/n/j-H:i:s');

// بخش مربوط به کاربران عادی
if ($user_id != null && $user_id != adminChatIDMain) {

    $sql = "UPDATE tbl_user SET role='user' WHERE user_id=:user_id";
    $stmt = $telegram->db->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);
    $telegram->sendMessage($user_id, "👋| سلام $first_name 😊");

    $user = new User($user_id, $chat_id, $first_name, $last_name, $user_name, $time_stamp, $time_persion);

    if ($text_message != null) {
        switch ($text_message) {
            case '/start':
            case '🏘| خانه':
                User::home($user_id, $chat_id, $first_name, $last_name, $user_name, $message_id);
                break;

            case '💰| تعرفه قیمت ها':
                User::tarefe_gheymatha($user_id, $chat_id);
                break;



            case '👨‍🏫| مشاهده آموزش ها':
                User::moshahede_amoozesha($chat_id);
                break;

            case '💣| آموزش سرویس v2ray':
                User::amoozesh_service_v2ray($chat_id);
                break;

            case 'آموزش سرویس v2ray|اندروید|📱':
                User::amoozesh_service_v2ray_android($chat_id);
                break;

            case 'آموزش سرویس v2ray|آیفون|📲':
                User::amoozesh_service_v2ray_iphone($chat_id);
                break;

            case '🔑| ورود به پنل کاربری':
                User::voroudbe_panel_karbari($chat_id, $user_id);
                break;

            case '🔄| بروزرسانی اطلاعات':
                $message_update = "🔄| اطلاعات شما با موفقیت بروزرسانی شد 🟢" . "\n" .
                    '⏰| تاریخ و زمان بروزرسانی: ' . jdate("Y/n/j ساعت H:i:s ") . "\n" . '.';
                $telegram->sendMessage($user_id, $message_update);
                User::Display_user_account_information($user_id, $chat_id, $message_id, $callback_id);
                break;


            case '👨🏻‍💻| ارتباط با ادمین':
            case 'ارتباط با ادمین|👨🏻‍💻':
                User::sendMessageToAdmin($user_id);
                break;

            default:
                $sql = "SELECT * FROM tbl_user WHERE user_id = :user_id";
                $stmt = $telegram->db->prepare($sql);
                $stmt->execute([':user_id' => $user_id]);
                $result_panel = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result_panel) {
                    switch ($result_panel['step_user']) {
                        case 'display_traffic':
                            User::display_traffic_api($user_id, $text_message);
                            break;

                        case 'Time_Delkhah':
                            if ($result_panel['role'] == 'user') {
                                $telegram->sendChatAction($user_id, 'typing');

                                $sql = "UPDATE tbl_user SET step_user='Send_Day_V2ray', role='user', day_v2ray=:day WHERE user_id=:user_id";
                                $stmt = $telegram->db->prepare($sql);
                                $stmt->execute([':day' => $text_message, ':user_id' => $user_id]);

                                $txtMsg = "لطفا حجم را به صورت [عددی] وارد کنید " . "\n" . "به عنوان مثال: 45" . "\n" . ".";
                                $telegram->forceReply($user_id, $txtMsg);
                            }
                            break;

                        case 'Send_Day_V2ray':
                            if ($result_panel['role'] == 'user') {
                                $telegram->sendChatAction($user_id, 'typing');

                                $sql = "UPDATE tbl_user SET step_user='Send_Hajm_V2ray', role='user', hajm_v2ray=:hajm WHERE user_id=:user_id";
                                $stmt = $telegram->db->prepare($sql);
                                $stmt->execute([':hajm' => $text_message, ':user_id' => $user_id]);

                                $sqlFetch = "SELECT * FROM tbl_user WHERE user_id = :user_id";
                                $stmtFetch = $telegram->db->prepare($sqlFetch);
                                $stmtFetch->execute([':user_id' => $user_id]);
                                $resFetch = $stmtFetch->fetch(PDO::FETCH_ASSOC);

                                $dayV2ray = $resFetch['day_v2ray'];
                                $hajm_v2ray = (int)$resFetch['hajm_v2ray'];
                                $endFactor = $hajm_v2ray * 2000;

                                $txtFetch = "📝 فاکتور پرداختی شما به شرح زیر است:" . "\n" .
                                    "◀ سرویس ویتوری" . "\n" .
                                    "◀ زمان اشتراک شما : " . $dayV2ray . "\n" .
                                    "◀ حجم اشتراک شما: " . $hajm_v2ray . "\n" .
                                    "◀ مبلغ نهایی پرداخت : " . $endFactor . " تومان" . "\n" . ".";

                                $keyboardFactor = [
                                    [['text' => 'پرداخت فاکتور: ' . $endFactor . ' تومان', 'url' => 'https://t.me/abzarvpn_admin1']]
                                ];
                                $telegram->sendMessage($user_id, $txtFetch, $keyboardFactor);
                            }
                            break;

                        case 'Send_Hajm_V2ray':
                            if ($result_panel['role'] == 'user') {
                                $telegram->sendChatAction($user_id, 'typing');
                                $sql = "UPDATE tbl_user SET step_user='show_factor_v2ray', role='user' WHERE user_id=:user_id";
                                $stmt = $telegram->db->prepare($sql);
                                $stmt->execute([':user_id' => $user_id]);
                            }
                            break;
                    }
                }
                break;
        }
    }
}
//----------------------------------------
// بخش ورود ادمین
elseif ($user_id == adminChatIDMain) {
    $time_persion = jdate('H:i:s-Y/n/j', time());
    $telegram->sendMessage($user_id, $time_persion);

    $sql = "UPDATE tbl_user SET role='admin' WHERE user_id=:user_id";
    $stmt = $telegram->db->prepare($sql);
    $stmt->execute([':user_id' => $user_id]);

    if ($text_message != null) {
        switch ($text_message) {
            case '/start':
            case '🏘| خانه':
                Admin::display_menu($user_id);
                break;
                        
            case "🟢|فعالسازی درگاه پرداخت کاربر":
                Admin::display_active_peyment($user_id);
                break;

            case '🔍| جست و جوی کاربر':
                Admin::search_user($user_id);
                break;

            case "✍️| ارسال پیام به یوزر خاص":
                Admin::sendMessageFromAdminToUser($user_id);
                break;

            case '🔉| ارسال پیام به همه کاربران':
                Admin::sendMessageToAllUser($user_id);
                break;

            case "📣| ارسال پیام به کانال":
                Admin::sendMessageToChanel($user_id);
                break;
          
            default:
                $sql = "SELECT * FROM tbl_user WHERE user_id=:user_id";
                $stmt = $telegram->db->prepare($sql);
                $stmt->execute([':user_id' => $user_id]);
                $result_panel = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result_panel) {
                    switch ($result_panel['step_user']) {
                        case 'Active_Peyment':
                            if ($result_panel['role'] == 'admin') {
                                Admin::active_payment_user($user_id, $text_message);
                            }
                            break;

                        case "SendMessageFromAdminToUser":
                            if ($result_panel['role'] == 'admin') {
                                Admin::messageToUnicUser($user_id, $text_message);
                            }
                            break;

                        case 'Recived_Text_Admin_To_User':
                            if ($result_panel['role'] == 'admin' && $text_message == '0') {
                                Admin::recivedTextFromAdminToSendUser($user_id, $text_message);
                            }
                            break;

                        case 'ConfirmSendMessge_ToUnicUser':
                            if ($result_panel['role'] == 'admin') {
                                Admin::confirmSendTextToUnicUser($user_id, $text_message);
                            }
                            break;

                        case "Send_Proxy":
                            if ($result_panel['role'] == 'admin') {
                                Admin::getProxyToSendChanel($user_id, $text_message);
                            }
                            break;

                        case 'ConfirmSendMessge_WelecomeToUser':
                            if ($result_panel['role'] == 'admin') {
                                Admin::ConfirmSendMessge_WelecomeToUser($text_message, $user_id);
                            }
                            break;

                        case "SendMessage_ToChanel":
                            if ($result_panel['role'] == 'admin') {
                                Admin::send_message_to_channel_step_1($user_id, $text_message);
                            }
                            break;

                        case 'Recived_Text':
                            if ($result_panel['role'] == 'admin') {
                                Admin::send_message_to_channel_step_2($user_id, $text_message);
                            }
                            break;

                        case 'SendMessage_AllUser':
                            if ($result_panel['role'] == 'admin') {
                                Admin::send_message_to_all_user_step_1($user_id, $text_message);
                            }
                            break;

                        case 'Recived_Text_To_All_User':
                            if ($result_panel['role'] == 'admin') {
                                Admin::send_message_to_all_user_step_2($user_id, $text_message);
                            }
                            break;

                        case 'SendConfigToChanel_ByAdmin':
                            if ($result_panel['role'] == 'admin') {
                                Admin::send_config_free_to_chanel($user_id, $text_message);
                            }
                            break;
                    }
                }
                break;
        }
    }

    if ($fileid_photo != null) {
        $sql = "SELECT * FROM tbl_user WHERE user_id=:user_id";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res) {
            switch ($res['step_user']) {
                case 'Recived_Text':
                    if ($res['role'] == 'admin') {
                        Admin::recived_photo_admin($user_id, $fileid_photo);
                    }
                    break;

                case 'Recived_Text_To_All_User':
                    if ($res['role'] == 'admin') {
                        Admin::recived_photo_to_send_all_user($user_id, $fileid_photo);
                    }
                    break;

                case 'Recived_Text_Admin_To_User':
                    if ($res['role'] == 'admin') {
                        Admin::recived_media_from_admin_to_send_user($user_id, $fileid_photo);
                    }
                    break;
            }
        }
    }
}

require_once("callback-data-bot.php");