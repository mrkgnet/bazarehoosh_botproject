<?php

require_once "telegram.php";
//require_once "config.php";
//require_once "userFunctions.php";
//require_once "addminFunctions.php";
require_once "jdf.php";
// require_once "endTimeAccoutnUsers_Cronjob.php";
require_once "check-data-user-in-db-bot.php";
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

$time_persion = jdate("Y/n/j-H:i:s ");
$time_stamp = time();


switch ($callback_data) {
    case 'Enseraf_OtherAccount':
        {
            //-----------------------------------
            $sqlUpdate = "UPDATE tbl_user SET step_user='Enseraf_OtherAccount' WHERE user_id='$user_id'";
            $stmtUpdate = $telegram->db->prepare($sqlUpdate);
            $stmtUpdate->execute();
            //-----------------------------------
            $telegram->editMessageText($user_id, $message_id, 'انصراف شما تایید شد مجدد به پنل کاربری ✅| خود بازگشتید');
            Display_user_account_information($user_id, $chat_id, $message_id, $callback_id);
        }
        break;
    case 'Confirm_OtherAccount':
        {
            //-----------------------------------
            $sqlUpdate = "UPDATE tbl_user SET step_user='Confirm_OtherAccount' ,already_login='0' WHERE user_id='$user_id'";
            $stmtUpdate = $telegram->db->prepare($sqlUpdate);
            $stmtUpdate->execute();
            //-----------------------------------
            User::voroudbe_panel_karbari($chat_id, $user_id);
//        $user = new User();
//        $user->test($user_id);
        }
        break;
    case 'Delete_Ssh_Account':
        {
            $sqlUpdate = "UPDATE tbl_user SET step_user='Delete_Ssh_Account' , role = 'admin' WHERE user_id='$user_id'";
            $stmtUpdate = $telegram->db->prepare($sqlUpdate);
            $stmtUpdate->execute();
            //-----------------------------------
            $sqldelete = "DELETE  FROM tbl_admin WHERE col_recive_data_ssh = '0'";
            $stmtDelete = $telegram->db->prepare($sqldelete);
            $stmtDelete->execute();
            //-----------------------------------
            $telegram->editMessageText($user_id, $message_id, "عملیات با موفقیت کنسل شد");

        }
        break;
    case 'Accept_Ssh_Account':
        {
            $unicIdmd5 = md5(rand(0, 99999));
            $sql = "UPDATE tbl_user SET step_user='Accept_Ssh_Account' , role = 'admin' WHERE user_id='$user_id'";
            $stmt = $telegram->db->prepare($sql);
            $stmt->execute();
            //-----------------------------------
            $sql = "UPDATE tbl_admin SET col_recive_data_ssh='1', col_unic_id='$unicIdmd5' ";
            $stmt = $telegram->db->prepare($sql);
            $stmt->execute();
            //-----------------------------------
            $txtAccept = "عملیات با موفقیت انجام شد ✅✅✅";
            $telegram->editMessageText($user_id, $message_id, $txtAccept);

        }
        break;
    //--------------------------------
    case 'ersalePayameKhosamdi':
        {
            Admin::ersalPayameKhoshamdid_admin($user_id);
        }
        break;
    //-------------------------------
    case 'nextItemSearch':
        {
            $nextItem = 0;
            $nextItem = $nextItem + 5;
            Admin::search_user($user_id, $nextItem);
        }
        break;
    case "Ersale_PayameEtmamHajm":
        {
            Admin::ersalePayameEtmameHajm($user_id);
        }
        break;
    case 'byV2rayAccount':
        {
            User::byV2rayAccount($user_id, $message_id);
        }
        break;
    case'time_delkhah':
        {
            User::time_delkhah($user_id);
        }
        break;
    case'panele_kharidar':
        {
            User::ComingToBot($chat_id, $user_id, $message_id);
        }
        break;
    case 'FirstComingToBot':
        {
            User::Index($user_id, $message_id);
        }
        break;
    case 'sendMsgWelcomeUser':
        {

            Admin::sendMessageWelcome($user_id);
        }
        break;
    case'Confirm_SendMsg_Welcome':
        {
            Admin::ConfirmSendMessgeWelecomeToUser($user_id, $message_id);
        }
        break;
    case 'ConfirmSendMsgToChanel':
        {
            Admin::confirmSendMsgToChanel($user_id, $message_id);
        }
        break;
    case 'Cancel_SendMsg':
        {
            Admin::canselSendMessageToChanel($user_id, $message_id);
        }
        break;
    case 'ConfirmSendMsgToAllUser':
        {
            Admin::confirmSendMsgToAllUser($user_id, $message_id);
        }
        break;
    case 'sendConfigToChanel':
        {
            Admin::sendConfigToChanel($user_id, $message_id);
        }
        break;
    case 'ConfrimSendConfig':
        {
            Admin::confirmSendConfigToChanel($user_id, $message_id);

        }
        break;
    case 'SendMessageToUser':
        {
            Admin::sendMessageFromAdminToUser($user_id);
        }
        break;
    case 'ConfirmSendMsgToUserUnic':
        {
            Admin::getUserIdUserToSendMsgToUnicUser($user_id);
        }
        break;
    case 'ConfirmSendProxyToChanel':
        {

            Admin::ConfirmSendProxyToChanel($user_id);
        }
        break;

}


if ($callback_data == 'try_again') {
    $msg = "<b> لطفاً مطابق با فرمت زیر مجدد نام کاربری و پسورد خودرا ارسال کنید</b>:
<pre>
<code>username:password</code>
For Example=>  ali:1234  ✅
</pre>
    ⚠️ حتما از جدا کنند <b> : </b> برای جدا کردن نام کاربری و پسورد استفاده کنید.";
    $telegram->excCurl(apiUrl . 'editMessageText', [
        'chat_id' => $chat_id,
        'text' => $msg,
        'message_id' => $message_id,
        'parse_mode' => "HTML"
    ]);

} elseif ($callback_data == "notification_callback") {
    $telegram->db->query("update info set step='enable-notif' where user_id=" .
        $user_id);
    EnableNotif($chat_id, $message_id);
} elseif ($callback_data == "joinMeAtChannel") {
    $telegram->answerCallbackQuery($callback_id, "عضویت شما تایید شد| ✅");
    User::Index($chat_id, $user_id, $message_id);
} elseif ($callback_data == "refresh_from_database") {
    $msg = "اطلاعات حساب کاربری شما با موفقیت بروزرسانی شد...🟢🟢";
    $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
        'callback_query_id' => $callback_id,
        'text' => $msg,
        'text' => $msg,
        'show_alert' => 'false'
    ]);
    //  Refresh_Data($user_id, $chat_id, $message_id);
    Display_user_account_information($user_id, $chat_id, $message_id, $callback_id);
} elseif ($callback_data == "send_advertising_to_allusers") {
    $telegram->db->query("update users set step = 'taeede_ersale_payame_tabligi'");

    // $telegram->sendMessage($chat_id,"tablichati");
    taeede_ersale_payame_tabligi($chat_id, $message_id, $callback_id);
} elseif ($callback_data == "confirm_disablebot") {
    // $telegram->sendMessage($chat_id,"*****");
    $telegram->db->query("update users set step = 'confirm_disablebot'");

    disableBot($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "confirm_enablebot") {
    // $telegram->sendMessage($chat_ienablebotd,"*****");
    enableBot($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "disablebot") {
    $telegram->db->query("update users set step = 'confirm_disablebot'");

    showMsgDisablebot($chat_id, $message_id);
} elseif ($callback_data == "enablebot") {

    showMsgEnablebot($chat_id, $message_id);
} elseif ($callback_data == "joinMeAtChannel") {
    ozviatEjbari(channelID_1, $chat_id, $user_id, $message_id, $callback_id);
} elseif ($callback_data == "confirmUserDay") {
    //  $telegram->sendMessage($chat_id,'oooooooo');
    $telegram->db->query("update users set step = 'confirmUserDay'");
    confirmUserDay($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "byNewAccount") {
    $telegram->db->query("update info set step = 'byNewAccount'");
    byNewAccount($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "new1month") {
    $telegram->db->query("update info set step = 'new1month'");
    // $telegram->sendMessage($chat_id,'1 month');
    new1month($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "new2month") {
    $telegram->db->query("update info set step = 'new2month'");
    new2month($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "new3month") {
    $telegram->db->query("update info set step = 'new3month'");
    new3month($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "new4month") {
    $telegram->db->query("update info set step = 'new4month'");
    new4month($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "edit_send_text_advertising") {
    $telegram->db->query("update users set step = 'edit_payame_tablighati_users'");
    DisplyConfirmTablighati($chat_id, $message_id);
} elseif ($callback_data == "GetLastUpdateServer") {
    //
//        SendPayameTablighatiToAllUsers();

    $telegram->db->query("update info set step = 'bedast_avardan_list_serverha' where user_id=" . $user_id);

    GetLastUpdateServer($user_id, $chat_id, $message_id);


} elseif ($callback_data == "panele_kharidar") {
//    $telegram = new telegram();
//
//
//    /******************************************************/
//    $telegram->db->query("update users set login_tbl_users='0' ,step= 'user_pannel'");
//    $telegram->db->query("update info set login_tbl_info='1'  , step = 'user_pannel'");
//    $rows1 = $telegram->db->query("select * from info where  user_id=" . $user_id)->fetch();
//    $telegram->db->query("UPDATE info SET StepTable='karbar_kharidar' , step = 'pannele_shoroo'  , backtomain='true' , login_tbl_info='1'  WHERE user_id=" . $user_id);
//    /******************************************************/


//    ComingToBot($chat_id, $user_id, $message_id);
} //--------------------
elseif ($callback_data == "FirstComingToBot") {
//    //----------------query
//    $sqlUpdete = "UPDATE tbl_user SET  step_user='FirstComingBot'  WHERE user_id='$user_id'";
//    $stmtUpdte = $telegram->db->prepare($sqlUpdete);
//    $stmtUpdte->execute();
//    //----------------query
//    $telegram->answerCallbackQuery($callback_id, ' به ربات گروه ابزار وی پی ان خوش آمدید|✔️');
//    User::Index($chat_id, $user_id, $message_id);

} //-------------------------------------------------------------
elseif ($callback_data == "update_bot") {
    $telegram->db->query("update info set step='beruz_resani_robat' where user_id=" . $user_id);
    Update_Bot($chat_id, $user_id, $message_id);
} elseif ($callback_data == "ConfirmToFetchData") {

    $telegram->db->query("update users set step = 'confirm_payam_be_userekhas'" . $user_id);

    $telegram->db->query("update info set step = 'confirm_payam_be_userekhas'" . $user_id);


    ConfirmToFetchData($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);
} elseif ($callback_data == "Account_Definition") {

    $telegram->db->query("update users set step='create_account'");

    Account_Definition($chat_id, $message_id);
} elseif ($callback_data == "InsertUserProfielToDbUsers") {
    $telegram->db->query("update users set step='sabte_etelaat_dar_db'");
    InsertUserProfielToDbUsers($chat_id, $message_id, $callback_id);

} elseif ($callback_data == "ExitAll") {

    ExitFromStart($chat_id, $callback_id, $message_id);
} elseif ($callback_data == "EditTextUserProfile") {

    $telegram->db->query("update users set step='virayeshe_etelaate_user_dar_db'");
    Account_Definition($chat_id, $message_id);
} elseif ($callback_data == "enableAccount") {

    $telegram->db->query("UPDATE info SET step='enableAccout' WHERE user_id=" . $user_id);
    enableAccount($user_id, $chat_id, $message_id, $callback_id);
} elseif ($callback_data == "v2ray_service_learning") {

    $telegram->db->query("UPDATE info SET step='v2ray_service_learning' WHERE user_id=" . $user_id);
//            enableAccount($user_id,$chat_id, $message_id,$callback_id);
    ComingToBot_SendMsg_v2ray($chat_id, $message_id);
} elseif ($callback_data == "Account_Renewal") {

    $telegram->db->query("update users set step ='virayesh_account'");


    Account_RenewalTBLUsers($chat_id, $message_id);
} elseif ($callback_data == "ِDeleteUserProfile") {
    //   $telegram->db->query("update users set step ='delete_user_account'");

    ِDeleteUserProfile($chat_id, $message_id);
} elseif ($callback_data == "send_video_iphone") {
    $telegram->db->query("update info set step ='ersale_video_iphone'where  user_id=" . $user_id);
    SendVideoIphone($chat_id, $message_id);
} elseif ($callback_data == "send_video_android") {
    $telegram->db->query("update info set step ='ersale_video_android'where  user_id=" . $user_id);
    SendVideoَAndroid($chat_id);
} elseif ($callback_data == "send_video_windows") {
    $telegram->db->query("update info set step ='ersale_video_windows'where  user_id=" . $user_id);
    SendVideoَWindows($chat_id);
} elseif ($callback_data == "send_video_android_v2ray") {
    $telegram->db->query("update info set step ='ersale_video_android_v2ray'where  user_id=" . $user_id);
    SendVideoَAndroid_v2ray($chat_id);
} elseif ($callback_data == "send1_video_iphone_v2ray") {

    $telegram->db->query("update info set step ='ersale_video_Iphone_v2ray'where  user_id=" . $user_id);
    SendVideoIphone_v2ray($chat_id);
} elseif ($callback_data == "send_video_windows_v2ray") {
    $telegram->db->query("update info set step ='ersale_video_windows_v2ray'where  user_id=" . $user_id);
    SendVideoَWindows_v2ray($chat_id, $message_id);
} elseif ($callback_data == "Extend_Time") {
//        ِDeleteUserProfile();
} elseif ($callback_data == "backStepInsertUser") {
//        Account_Definition();
    AdminPannelUi($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);

} elseif ($callback_data == "restart_the_bot") {


    $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
        'callback_query_id' => $callback_id,
        'text' => 'بروزرسانی ربات با موفقیت انجام شد🟢',
        'show_alert=' => 'true'
    ]);


    Authentication_Users($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);
} elseif ($callback_data == "Time_Extension") {
    //    $query = "update users set step='tamdid_tarikh'";
    //   $result = mysqli_query($db, $query);

    $telegram->db->query("update users set step='tamdid_tarikh'");

    Time_Extention($chat_id, $message_id);

} elseif ($callback_data == "ExitPannel") {

    $msg1 = "\n" . '<b>' . "⛔️ با خروج از حساب کاربری تمامی اطلاعات شما به صورت کامل از پایگاه داده حذف خواهد شد" . '</b>' . "\n";
    $keyboard = [
        [['text' => 'انصرف| بازگشت 🔙', 'callback_data' => 'index'], ['text' => 'تایید خروج | ✅', 'callback_data' => 'ConfirmExit']]
    ];
    $telegram->editMessageText($chat_id, $message_id, $msg1, $keyboard);

    $telegram->db->query("update info set step='exitpannel' where user_id=" . $user_id);


} elseif ($callback_data == "ConfirmExit") {
    //    $query = "delete from info  where user_id=" . $user_id;
    // $result = mysqli_query($db, $query);

    $telegram->db->query("delete from info  where user_id=" . $user_id);
    ExitPannel($chat_id, $message_id, $callback_id);

    //  ComeBackToBot($chat_id, $message_id);
} //-----------------------------------
elseif ($callback_data == "login_account") {
    User::Display_user_account_information($user_id, $chat_id, $message_id, $callback_id);
} //------------------------------------

elseif ($callback_data == "login_account") {
//    $telegram->excCurl(apiUrl . 'sendMessage', [
//        'chat_id' => $chat_id,
//        'text' => 'login_account'
//    ]);
//
//
//    $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
//        'callback_query_id' => $callback_id,
//        'text' => 'ورود شما به حساب کاربری با موفقیت تایید شد(تایید نهایی)| ✅ ',
//        'show_alert=' => 'true'
//    ]);
//
//    Display_user_account_information($user_id, $chat_id, $message_id);
} //--------------------------------
elseif ($callback_data == "come_back_to_fetch_data") {
    Display_user_account_information($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);
} elseif ($callback_data == "hamkaranFroush") {

    $msg = 'در حال پیاده سازی این قسمت هستیم.' . "\n" . "\n" . "به زودی در آپدیت های بعدی..|🔋";

    $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
        'callback_query_id' => $callback_id,
        'text' => $msg,
        'show_alert' => true
    ]);
}
//
//
elseif ($callback_data == "go_to_pannel_user") {
    $telegram->db->query("update info set step = 'vorud_be_pannele_karbari' where user_id=" . $user_id);
    CommingBackToPannel($chat_id, $user_id, $message_id);
}
//
//
elseif ($callback_data == 'moshahedeh_amoozehsha') {
    $telegram->db->query("update info set step='moshahedeh_amoozehsha' where user_id=" . $user_id);
    choice_service_learning($chat_id, $message_id);
} elseif ($callback_data == 'ssh_service_learning') {
    $telegram->db->query("update info set step='ssh_service_learning' where user_id=" . $user_id);
    ComingToBot_SendMsg($chat_id, $message_id);
} elseif ($callback_data == "send_message_to_unic_user") {
    $telegram->db->query("update users set step = 'ersal_payam_be_userekhas'");
    GetUserNameUnic($chat_id, $message_id);
} elseif ($callback_data == "confirmSendToChannel") {
    $telegram->db->query("UPDATE info SET step = 'confirmSendToChannel' WHERE user_id=" . $user_id);

    $telegram->db->query("update users set step = 'confirmSendToChannel'");
    confirmSendToChannel($callback_id);
} elseif ($callback_data == 'EnableNotification' || $callback_data == 'join_channel') {
    Mandatory_membership($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id, $callback_id);
} elseif ($callback_data == 'pricing') {
    $telegram->db->query("update info set step = 'choice_service' where user_id=" . $user_id);
    choice_service($chat_id, $message_id);
} elseif ($callback_data == 'ssh_service') {
    $telegram->db->query("update info set step = 'tarefe_gheimat_ssh' where user_id=" . $user_id);
    Pricing($chat_id, $message_id);
} elseif ($callback_data == 'v2ray_service') {
    $telegram->db->query("update info set step = 'tarefe_gheimat_v2ray' where user_id=" . $user_id);
    v2ray_pricing($chat_id, $message_id);
} elseif ($callback_data == 'home') {
    $telegram->db->query("update info set step = 'home' where user_id=" . $user_id);
    home($chat_id, $message_id);
} elseif ($callback_data == 'homeLearning') {
    $telegram->db->query("update info set step = 'home' where user_id=" . $user_id);
    homeLearning($chat_id, $message_id);
} elseif ($callback_data == '1mahe') {
    $telegram->db->query("update info set step = 'pricing_1mahe' where user_id=" . $user_id);
    Pricing_1mahe($chat_id, $message_id, $callback_id);
} elseif ($callback_data == '2mahe') {
    $telegram->db->query("update info set step = 'pricing_2mahe' where user_id=" . $user_id);
    Pricing_2mahe($chat_id, $message_id, $callback_id);
} elseif ($callback_data == '3mahe') {
    $telegram->db->query("update info set step = 'pricing_3mahe' where user_id=" . $user_id);
    Pricing_3mahe($chat_id, $message_id, $callback_id);
} elseif ($callback_data == 'editData') {


    $rows_fetch = $telegram->db->query("select * from info where user_id=" . $user_id)->fetch();

    if (($rows_fetch['username'] != null) && (($rows_fetch['password'] != null))) {
        $txt_answerCallBack = " ⚠️این گزینه به منظور ورود به حساب کاربری دیگر شما است" . "\n" . "---------------------------------------------------------" . "\n" . "برای تغییر پسورد خود به آیدی ادمین پیام دهید تا پسورد شما را تغییر دهد";

        // file_get_contents($api_url . 'answerCallbackQuery?' . 'callback_query_id=' . $callback_id . '&text=' . $txt_answerCallBack . '&parse_mode=' . 'HTML' . '&show_alert=' . 'true');
        $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
            'callback_query_id' => $callback_id,
            'text' => $txt_answerCallBack,
            'show_alert=' => 'true'
        ]);

        $telegram->db->query("UPDATE info SET step='EditDataInDB' WHERE user_id=" . $user_id);


        EditDataInDB($chat_id, $message_id);
    } else {
//            file_get_contents($api_url.'sendMessage?'.'chat_id='.$chat_id.'&text='.'sllele');
//            EditDataInDB();

        //$query = "update users set step= 'khata_dar_uservapassword' where user_id=" . $user_id;
        //   $result = mysqli_query($db, $query);
        $telegram->db->query("update users set step= 'khata_dar_uservapassword' where user_id=" . $user_id);

        Error_Entering_User_Information($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);

    }


} elseif ($callback_data == 'EnableAlert') {
    // $query = "update info set step='enable-notif-ok', send_notification = 'true' where user_id=" . $user_id;
    $telegram->db->query("update info set step='enable-notif-ok', send_notification = 'true' where user_id=" . $user_id);

    //  mysqli_query($db, $query);
    ConfirmEnableAlert($chat_id, $message_id, $callback_id);
} elseif ($callback_data == 'sendMessageToChannel') {
    $telegram->db->query("update info set step='sendMessageToChannel' where user_id=" . $user_id);
    $telegram->db->query("update users set step='sendMessageToChannel' ");
    sendMessageToChannel($chat_id);
} elseif ($callback_data == 'sendTextOnly') {
    $telegram->db->query("update info set step='sendTextOnly' where user_id=" . $user_id);
    $telegram->db->query("update users set step='sendTextOnly' ");
    sendTextOnly($chat_id, $message_id);
} elseif ($callback_data == 'DisableAlert') {

    //$query = "update info set step='enable-notif-false', send_notification = 'false' where user_id=" . $user_id;

    //    mysqli_query($db, $query);

    $telegram->db->query("update info set step='enable-notif-false', send_notification = 'false' where user_id=" . $user_id);

    ConfirmDisableAlert($chat_id, $message_id, $callback_id);

} elseif ($callback_data == 'edit_again_info') {
    WelcomToBot($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);
}

//    elseif ($callback_data == 'send_message_valume_users') {
//        $telegram->db->query("update users set step= 'etmam_hajm'");
//        Display_Volume_Message($chat_id, $message_id);
//    }

elseif ($callback_data == 'comfirm_to_send_volume') {
    $telegram->db->query("update users set step='taede_ersale_payam'");
    Send_Message_Valume_Users($chat_id, $callback_id);
} elseif ($callback_data == 'send_advertising_message') {
    $telegram->db->query("update users  set step ='payame_tablighati'");
    DisplyConfirmTablighati($chat_id, $message_id);
} elseif ($callback_data == 'index') {
    $rows = $telegram->db->query("select * from info where user_id=" . $user_id)->fetch();
    if ($rows['login_tbl_info'] == '1') {
        switch ($rows['step']) {
            case 'moshahedeh_amoozehsha':
                {
                    //file_get_contents($api_url.'sendMessage?'.'chat_id='.$chat_id.'&text='.'wedde23eeele');
                    $telegram->db->query("update info set step = 'pannele_shoroo' where  user_id=" . $user_id);

                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'ersale_video_iphone':
                {
                    $telegram->db->query("update info set step = 'moshahedeh_amoozehsha' where  user_id=" . $user_id);
                    ComingToBot_SendMsg($chat_id, $message_id);
                }
                break;
            case 'ersale_video_android':
                {
                    $telegram->db->query("update info set step = 'moshahedeh_amoozehsha' where  user_id=" . $user_id);
//                file_get_contents($api_url.'sendMessage?'.'chat_id='.$chat_id.'&text='.'wedde23eeele');
                    ComingToBot_SendMsg($chat_id, $message_id);
                }
                break;
            case 'ersale_video_windows':
                {
                    $telegram->db->query("update info set step = 'moshahedeh_amoozehsha' where  user_id=" . $user_id);
//                file_get_contents($api_url.'sendMessage?'.'chat_id='.$chat_id.'&text='.'wedde23eeele');
                    ComingToBot_SendMsg($chat_id, $message_id);
                }
                break;
            case 'pannele_shoroo':
                {
//                file_get_contents($api_url.'sendMessage?'.'chat_id='.$chat_id.'&text='.'wedde23eeele');
                    $telegram->db->query("update info set startbot = 'true', go_to_bot='false' where user_id=" . $user_id);
                    User::Index($chat_id, $user_id, $message_id);
                }
                break;
            case 'pricing_1mahe':
                {
//                        $query = "update info set step='tarefe_gheimat_ssh_ssh' where user_id=" . $user_id;
//                        $result = mysqli_query($db, $query);
                    $telegram->db->query("update info set step='tarefe_gheimat_ssh_ssh' where user_id=" . $user_id);


                    Pricing($chat_id, $message_id);
                }
                break;
            case 'pricing_2mahe':
                {
                    $telegram->db->query("update info set step='tarefe_gheimat_ssh_ssh' where user_id=" . $user_id);
                    Pricing($chat_id, $message_id);
                }
                break;
            case 'pricing_3mahe':
                {
                    //   $query = "update info set step='tarefe_gheimat_ssh_ssh' where user_id=" . $user_id;
                    //   $result = mysqli_query($db, $query);
                    $telegram->db->query("update info set step='tarefe_gheimat_ssh' where user_id=" . $user_id);


                    Pricing($chat_id, $message_id);
                }
                break;
            case 'pannele_kharidar':
                {
                    // $query = "update info set step='pannele_shoroo' where user_id=" . $user_id;
                    //  $result = mysqli_query($db, $query);
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);

                    User::Index($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);
                }
                break;
            case 'tarefe_gheimat_ssh':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);

                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'vorud_be_pannele_karbari':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);

                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'InsertDataTodb':
            {
                $telegram->db->query("update info set step='vorud_be_pannele_karbari' where user_id=" . $user_id);
                WelcomToBot($chat_id, $message_id);
            }
            case 'fetch_data_from_db':
                {

                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);

                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'khataye_etelaat_vorudi':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'enable-notif':
                {

                    $telegram->db->query("update info set step='fetch_data_from_db' where user_id=" . $user_id);
                    Display_user_account_information($user_id, $chat_id, $message_id);
                }
                break;
            case 'enable-notif-ok':
                {

                    $telegram->db->query("update info set step='enable-notif' where user_id=" . $user_id);
                    EnableNotif($chat_id, $message_id);
                }
                break;
            case 'enable-notif-false':
                {

                    $telegram->db->query("update info set step='enable-notif' where user_id=" . $user_id);
                    EnableNotif($chat_id, $message_id);
                }
                break;
            case 'EditDataInDB':
                {

                    $telegram->db->query("update info set step='fetch_data_from_db' where user_id=" . $user_id);
//                            EnableNotif($chat_id, $message_id);
                    Display_user_account_information($user_id, $chat_id, $message_id);
                }
                break;
            case 'bedast_avardan_list_serverha':
                {

                    $telegram->db->query("update info set step='fetch_data_from_db' where user_id=" . $user_id);
//                            EnableNotif($chat_id, $message_id);
                    Display_user_account_information($user_id, $chat_id, $message_id);
                }
                break;
            case 'beruz_resani_robat':
                {

                    $telegram->db->query("update info set step='fetch_data_from_db' where user_id=" . $user_id);
//                            EnableNotif($chat_id, $message_id);
                    Display_user_account_information($user_id, $chat_id, $message_id);
                }
                break;
            case 'exitpannel':
                {
                    $telegram->db->query("update info set step='fetch_data_from_db' where user_id=" . $user_id);
//                            EnableNotif($chat_id, $message_id);
                    Display_user_account_information($user_id, $chat_id, $message_id);
                }
                break;
            case 'new1month':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'new2month':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'new3month':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }

                break;
            case 'new4month':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'byNewAccount':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;
            case 'ssh_service_learning':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;


            case 'choice_service':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;

            case 'tarefe_gheimat_v2ray':
                {
                    $telegram->db->query("update info set step='pannele_shoroo' where user_id=" . $user_id);
                    ComingToBot($chat_id, $message_id);
                }
                break;


            default:
            {
                ComingToBot($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id);
            }


        }

    } else {

//----------------------------------------------------------------------------------------------------
        $rows = $telegram->db->query("select * from users")->fetch();
        if ($rows['login_tbl_users'] == 1) {

            switch ($rows['step']) {
                case 'create_account':
                    {
                        $rows = $telegram->db->query("update users  set step ='adminpannel'");
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;


                case 'vorude_dade_be_DBusers':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;

                case 'tamdid_tarikh':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;

                case 'confirmUserDay':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;
                case 'delete_users_account':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;


                case 'falsazi_bot':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;
                case 'sabte_etelaat_dar_db':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi($chat_id, $message_id);
                    }
                    break;
                case 'virayeshe_etelaate_user_dar_db':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi($chat_id, $message_id);
                    }
                    break;
                case 'virayesh_account':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;
                case 'tamdid_tarikh':
                    {

                        $telegram->db->query("update users  set step ='virayesh_account'");
                        //     Account_Definition($chat_id, $message_id);
                        Account_RenewalTBLUsers($chat_id, $message_id);
                    }
                    break;
                case 'delete_users':
                    {

                        $telegram->db->query("update users  set step ='virayesh_account'");
                        //     Account_Definition($chat_id, $message_id);
                        Account_RenewalTBLUsers($chat_id, $message_id);
                    }
                    break;
                case 'delete_users':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi($chat_id, $message_id);
                    }
                    break;
                case 'payame_tablighati':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi_EditMsgText($chat_id, $message_id);
                    }
                    break;
                case 'adminpannel':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        User::Index($chat_id, $user_id, $message_id);
                    }
                    break;
                case 'ersal_payam_be_userekhas':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi($chat_id, $message_id);
                    }
                    break;


                case 'disableBot':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi($chat_id, $message_id);
                    }
                    break;
                case 'confirm_disablebot':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi($chat_id, $message_id);
                    }
                    break;


                case 'etmam_hajm':
                    {

                        $telegram->db->query("update users  set step ='adminpannel'");
                        //     Account_Definition($chat_id, $message_id);
                        AdminPannelUi($chat_id, $message_id);
                    }
                    break;

            }


        }


    }


    // Index();
} elseif ($callback_data == 'backtohome') {

    ComingToBot($chat_id, $message_id);
}

