<?php
//--------------------------------------------------------------
require_once "telegram.php";
require_once "config.php";
require_once "jdf.php";
require_once "user/user-function-bot.php";
require_once "admin/admin-function-bot.php";
//------------------------------------------------------------------
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
    $fileid_photo = $data->message->photo[2]->file_id;
} //_____________________________________________________________________

elseif (array_key_exists('callback_query', $data)) {
    $callback_id = $data->callback_query->id;
    $user_id = $data->callback_query->from->id;
    $chat_id = $data->callback_query->message->chat->id;
    $message_id = $data->callback_query->message->message_id;
    $user_name = $data->callback_query->from->username;
    $first_name = $data->callback_query->from->first_name;
    $text_callback = $data->callback_query->data;
    $callback_data = $data->callback_query->data;
}
//_____________________________________________________________________

$time_stamp = time();
$time_persion = jdate('Y/n/j-H:i:s');
//user
if ($user_id != adminChatIDMain) {
    $sql = "UPDATE tbl_user SET role='user' WHERE id='$user_id'";
    $stmt = $telegram->db->query($sql);
    $stmt->execute();
    $user = new User($user_id, $chat_id, $first_name, $last_name, $user_name, $time_stamp, $time_persion);
    if ($text_message != null) {
        switch ($text_message) {
            case '/start':
            case '🏘| خانه': {
                    User::home($user_id, $chat_id, $first_name, $last_name, $user_name, $message_id);
                }
                break;

            default: {
                    User::home($user_id, $chat_id, $first_name, $last_name, $user_name, $message_id);
                }
        }
    }
}
//----------------------------------------

//admin login  in system
elseif ($user_id == adminChatIDMain) {
    $time_persion = jdate('H:i:s-Y/n/j', time());
    $telegram->sendMessage($user_id, $time_persion);
    $sql = "UPDATE tbl_user SET role='admin' WHERE id='$user_id'";
    $stmt = $telegram->db->query($sql);
    $stmt->execute();
    //    Admin::display_menu($user_id);
    if ($text_message != null) {
        switch ($text_message) {
            case '/start':
            case '🏘| خانه': {
                    Admin::display_menu($user_id);
                }
                break;


            case '🔉| ارسال پیام به همه کاربران': {
                    Admin::sendMessageToAllUser($user_id);
                }
                break;
            //------------------------
            case "📣| ارسال پیام به کانال": {

                    Admin::sendMessageToChanel($user_id);
                }
                break;
            //------------------------

            //-----------------------
            default: {
                    $sql = "SELECT * FROM tbl_user WHERE user_id='$user_id'";
                    $stmt = $telegram->db->prepare($sql);
                    $stmt->execute();
                    $result_panel = $stmt->fetch(PDO::FETCH_ASSOC);

                    switch ($result_panel['step_user']) {



                        case "SendMessage_ToChanel": {
                                if ($result_panel['role'] == 'admin') {
                                    Admin::send_message_to_channel_step_1($user_id, $text_message);
                                }
                            }
                            break;

                        case 'SendMessage_AllUser': {
                                if ($result_panel['role'] == 'admin') {
                                    Admin::send_message_to_all_user_step_1($user_id, $text_message);
                                }
                            }
                            break;
                        //-------------------------
                        case 'Recived_Text_To_All_User': {
                                if ($result_panel['role'] == 'admin') {
                                    Admin::send_message_to_all_user_step_2($user_id, $text_message);
                                }
                            }
                            break;
                            //--------------------------


                    }
                }
        }
    }
    //    ------------------
    if ($fileid_photo != null) {

        $sql = "SELECT * FROM tbl_user WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        switch ($res['step_user']) {
            case 'Recived_Text': {
                    if ($res['role'] == 'admin') {
                        Admin::recived_photo_admin($user_id, $fileid_photo);
                    }
                }
                break;
            case 'Recived_Text_To_All_User': {
                    if ($res['role'] == 'admin') {
                        Admin::recived_photo_to_send_all_user($user_id, $fileid_photo);
                    }
                }
                break;
            case 'Recived_Text_Admin_To_User': {
                    if ($res['role'] == 'admin') {
                        Admin::recived_media_from_admin_to_send_user($user_id, $fileid_photo);
                    }
                }
                break;
        }
    }
} 
require_once("callback-data-bot.php");