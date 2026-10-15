<?php
// require_once ("../config.php");
//require_once "../telegram.php";
class Admin
{
    public function __construct()
    {
    }

    public static function display_menu($user_id)
    {
        $telegram = new telegram();
        $msgSendMessage = "<b>شما با سطح مدیریت وارد شدید </b>:" . "\n";
        $keyboardHome = [
            [['text' => "⏮| ارسال پروکسی"] ,['text' => "تمدید اکانت"]],
            [['text' => "🔍| جست و جوی کاربر"], ['text' => "🚀| ارسال کانفیگ"]],
            [['text' => "📝| ویرایش اکانت"], ['text' => "✏️| تعریف اکانت"]],
            [['text' => "📈| گزارشات"], ['text' => "❌| حذف اطلاعات کاربر"]],
            [['text' => "👨‍🏫| مشاهده آموزش ها"], ['text' => "💰| تعرفه قیمت ها"]],
            [['text' => "🔴|" . "غیرفعالسازی درگاه پرداخت کاربر"], ['text' => "🟢|" . "فعالسازی درگاه پرداخت کاربر"]],
            [['text' => "〽️| کاربرن در حال منقضی"], ['text' => "➕| اضافه شارژ کیف پول کاربر"]],
            [['text' => "🔉| ارسال پیام به همه کاربران"], ['text' => "📣| ارسال پیام به کانال"]],
            [['text' => "🟢|" . "فعالسازی ربات"], ['text' => "✍️| ارسال پیام به یوزر خاص"]],
            [['text' => "🔙| بازگشت"], ['text' => "🔴|" . "غیرفعالسازی ربات"]],
        ];
        $telegram->sendMessage2($user_id, $msgSendMessage, $keyboardHome);
    }

    //-----------------------------------------------------
 

    //-----------------------------------------------------
   

    //-----------------------------------------------------
    public static function tarife_account_ssh($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //----------------------
        $sqlUpdate = "UPDATE tbl_user SET step_user='tarife_account_ssh' , role='admin' WHERE user_id='$user_id'";
        $stmtUpdate = $telegram->db->prepare($sqlUpdate);
        $stmtUpdate->execute();
        //----------------------
        //----------------------
        $sql = "INSERT INTO tbl_admin (	col_username_ssh, col_password_ssh,col_time_ssh,col_recive_data_ssh,	col_step,col_unic_id) VALUES ('','','','0','tarife_account_ssh_admin','') ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //----------------------
        $txtSendUserName = "⬅️| نام کاربری یوزر را وارد کنید" . "\n";
        $telegram->forceReply($user_id, $txtSendUserName);

    }


   

    //-----------------------------------------------
    public static function ersalPayameKhoshamdid_admin($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //----------------------
        $sql = "UPDATE tbl_user SET step_user='ErsalePayameKhosamdid_Admin' , role='admin' WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //----------------------
        $txtSendMsg = "لطفا متن خود را برای ارسال به کاربر ارسال کنید" . "\n";
    }

    //-----------------------------------------------
    public static function display_active_peyment($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //----------------------
        $sql = "UPDATE tbl_user SET step_user='Active_Peyment' , role='admin' WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //----------------------
        $txtAcc = "لطفا یوزایدی یا نام تلگرامی کاربر را ارسال کنید";
        $telegram->sendMessage($user_id, $txtAcc);
    }

    //-----------------------------------------------
    public static function active_payment_user($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //----------------------
        $sql = "UPDATE tbl_user SET step_user='Active_Peyment_User' , role='admin' WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //----------------------
        $sql = "SELECT * FROM tbl_user WHERE user_id='$text_message'   ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        while ($search = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result .= "\n" . 'ID:' . $search['id'] . "\n" . 'userid: ' . '<code>' . $search['user_id'] . '</code>' . "\n" . 'first_name: ' . $search['first_name'] . "\n" . 'username: ' . $search['username_telegram'] . "\n" . 'username_panel: ' . $search['username_panel'] . "\n" . 'password_panel: ' . $search['password_panel'] . "\n" . 'active_peyment: ' . $search['active_peyment'] . "\n" . 'unicCodeInfo: ' . $search['uniccode_tosendinfo'] . "\n" . "---------------" . "\n";
        }
        $keyboard = [
            [['text' => 'تایید', 'callback_data' => 'nextItemSearch'], ['text' => 'انصراف', 'callback_data' => 'prevItemSearch']]
        ];
        $telegram->sendMessage($user_id, $result, $keyboard);


    }

    //-----------------------------------------------
    public static function search_user($user_id, $nsxtItem = 0)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //----------------------
        $sql = "UPDATE tbl_user SET step_user='Search_User' , role='admin' WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //----------------------
        $TxTSearch = '<b>' . "لطفا کد اختاصی کاربر را ارسال کنید" . '</b>' . "\n" . '.';
        $telegram->sendMessage($user_id, $TxTSearch);

    }

    //--------------------------------
    public static function sendMessageToUser($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //----------------------
        //----------------------
        $sql = "UPDATE tbl_user SET step_user='SendMessageToUser' , role='admin' WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //----------------------
        $msg = '<b>' . " یوزر نیم کاربر را وارد کنید " . '</b>';
        $telegram->sendMessage($user_id, $msg);
    }

    //-----------------------------------------------
    public static function getMessageAdminToSendUser($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------

        $sql = "UPDATE tbl_user SET step_user='GetMessageAdminToSendUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $txtrecived = "اطلاعات شما با موفقیت دریافت شد برای شروع مجدد روی گزینه استارت زیر کلیک کنید" . "\n" . "\n" . "/start" . "\n";
        $telegram->sendMessage($user_id, $txtrecived);
    }

    public static function ersalePayameEtmameHajm($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ErsalePayame_EtmameHajm', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $messageToUser = "لطفا یوزر ایدی شخص را وارد کنید ";
        $telegram->forceReply($user_id, $messageToUser);
    }

    public static function sendMessageToAllUser($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sqlDele = "DELETE FROM tbl_message WHERE recived_data ='0'";
        $stmtDele = $telegram->db->prepare($sqlDele);
        $stmtDele->execute();
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='SendMessage_AllUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $textMessage = '<b>' . " متن پیام خود را [برای ارسال به کاربران] ارسال کنید" . '</b>' . "\n";
        $telegram->sendMessage($user_id, $textMessage);
    }

    public static function send_message_to_all_user_step_1($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Text_To_All_User', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "INSERT INTO tbl_message (fileid , text,recived_data) VALUES ('','$text_message',0) ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = '<b>' . "لطفا فایل عکسی خود را [برای ارسال به کاربران] ارسال کنید" . "\n" . "درصورت نداشتن متن لطفا عدد 0 را وارد کنید " . "\n" . '.' . '</b>';
        $telegram->sendMessage($user_id, $textRe);
    }

//    --------------------------------------

    public static function send_message_to_all_user_step_2($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_WithOutMedia_AllUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "UPDATE  tbl_message SET fileid='0'  ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = "اطلاعات شما باموفقیت دریافت شد" . "\n" . '.';
        $telegram->sendMessage($user_id, $textRe);
        //-------------------------
        $sql = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $resFe = $stmt->fetch(PDO::FETCH_ASSOC);
        $message = $resFe['text'];
        $keyboard = [
            [['text' => 'تایید ارسال', 'callback_data' => 'ConfirmSendMsgToAllUser']]
        ];
        $telegram->sendMessage($user_id, $message, $keyboard);
    }

    /* تابع ارسال پیام به کانال */
    public static function sendMessageToChanel($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='SendMessage_ToChanel', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sqlDele = "DELETE FROM tbl_message WHERE recived_data ='0'";
        $stmtDele = $telegram->db->prepare($sqlDele);
        $stmtDele->execute();
        //------------------------
        $textMessage = '<b>' . " متن پیام خود را ارسال کنید" . "\n" . '.' . '</b>';
        $telegram->sendMessage($user_id, $textMessage);
    }

    public static function send_message_to_channel_step_1($user_id, $text_message)
    {

        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Text', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "INSERT INTO tbl_message (fileid , text,recived_data) VALUES ('','$text_message',0) ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = '<b>' . "لطفا فایل عکسی خود را ارسال کنید" . "\n" . "درصورت نداشتن عکس لطفا عدد 0 را وارد کنید " . "\n" . '.' . '</b>';
        $telegram->sendMessage($user_id, $textRe);
    }

    public static function send_message_to_channel_step_2($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_WithOutMedia', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "UPDATE  tbl_message SET fileid='0'  ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = "اطلاعات شما باموفقیت دریافت شد" . "\n" . '.';
        $telegram->sendMessage($user_id, $textRe);
        //-------------------------
        $sql = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $resFe = $stmt->fetch(PDO::FETCH_ASSOC);
        $message = $resFe['text'];
        $keyboard = [
            [['text' => 'تایید ارسال', 'callback_data' => 'ConfirmSendMsgToChanel']]
        ];
        $telegram->sendMessage($user_id, $message, $keyboard);
    }

//    ---------------------------------------------------------
    public static function recived_photo_admin($user_id ,$fileid_photo)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Media', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        //------------------------
        $sql = "UPDATE  tbl_message SET fileid='$fileid_photo' ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = "اطلاعات شما باموفقیت دریافت شد" . "\n" . '.';
        $telegram->sendMessage($user_id, $textRe);

        //----------------------------
        $sqlfetch = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmtfetch = $telegram->db->prepare($sqlfetch);
        $stmtfetch->execute();
        $resFe = $stmtfetch->fetch(PDO::FETCH_ASSOC);
        $keyboard = [
            [['text' => 'تایید ارسال ✅✅', 'callback_data' => 'ConfirmSendMsgToChanel']], [['text' => 'انصراف ❌❌', 'callback_data' => 'Cancel_SendMsg']]
        ];
        $telegram->sendPhoto($user_id, $resFe['fileid'], $resFe['text'], $keyboard);
    }

    //----------------------
    public static function recived_photo_to_send_all_user($user_id ,$fileid_photo)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Media_To_Send_User', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "UPDATE  tbl_message SET fileid='$fileid_photo' ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = "اطلاعات شما باموفقیت دریافت شد" . "\n" . '.';
        $telegram->sendMessage($user_id, $textRe);

        //----------------------------
        $sqlfetch = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmtfetch = $telegram->db->prepare($sqlfetch);
        $stmtfetch->execute();
        $resFe = $stmtfetch->fetch(PDO::FETCH_ASSOC);
        $keyboard = [
            [['text' => 'تایید ارسال ✅✅', 'callback_data' => 'ConfirmSendMsgToAllUser']], [['text' => 'انصراف ❌❌', 'callback_data' => 'Cancel_SendMsg']]
        ];
        $telegram->sendPhoto($user_id, $resFe['fileid'], $resFe['text'], $keyboard);
    }
    //----------------------------------
    public static function recived_media_from_admin_to_send_user($user_id ,$fileid_photo)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Media_FromAdmin_To_Send_User', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "UPDATE  tbl_message SET fileid='$fileid_photo' ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = "اطلاعات شما باموفقیت دریافت شد" . "\n" . '.';
        $telegram->sendMessage($user_id, $textRe);

        //----------------------------
        $sqlfetch = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmtfetch = $telegram->db->prepare($sqlfetch);
        $stmtfetch->execute();
        $resFe = $stmtfetch->fetch(PDO::FETCH_ASSOC);
        $keyboard = [
            [['text' => 'تایید ارسال ✅✅', 'callback_data' => 'ConfirmSendMsgToUserUnic']]
        ];
        $telegram->sendPhoto($user_id, $resFe['fileid'], $resFe['text'], $keyboard);
    }
    public static function sendMessageWelcome($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');

        //------------------------
        $sql = "UPDATE tbl_user SET step_user='SendMessage_Welcome', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $keyboard = [
            [['text' => 'تایید ارسال', 'callback_data' => 'Confirm_SendMsg_Welcome']]
        ];
        $msg = "متن شما برای کاربر به شرح زیر است آیا قصد ارسال آن را دارید" . "\n" . "➖➖➖➖➖" . "\n" .
            "50 درصد تخفیف ویژه خرید برای شما فقط به مدت 24 ساعت(برای خرید با ادمین در ارتباط باشید)" . "\n";
        $telegram->sendMessage($user_id, $msg, $keyboard);
    }

    public static function ConfirmSendMessgeWelecomeToUser($user_id, $message_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ConfirmSendMessge_WelecomeToUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $text = '<b>' . " یوز آیدی شخص را ارسال کنید " . '</b>' . "\n" . '.';
        $telegram->editMessageText($user_id, $message_id, $text);
    }

    public static function ConfirmSendMessge_WelecomeToUser($text_message, $user_id)
    {
        $telegram = new telegram();
        $sql = "SELECT * FROM tbl_user WHERE user_id='$text_message'";
        $stmtFe = $telegram->db->prepare($sql);
        $stmtFe->execute();
        $resultFe = $stmtFe->fetch(PDO::FETCH_ASSOC);
        $keyboard = [
            [['text' => 'ارتباط با ادمین| 👨🏻‍💻‍', 'url' => 'https://t.me/abzarvpn_admin1']],
            [['text' => 'کانال ما|📱', 'url' => 'https://t.me/abzarvpn']]
        ];
        $textFe = '<b>' . 'سلام' . " " . $resultFe['first_name'] . " " . "عزیز" . '</b>' . "\n" . ''
            . "50 درصد تخفیف ویژه خرید برای شما فقط به مدت 24 ساعت(برای خرید با ادمین در ارتباط باشید)" . "\n" . '➖➖➖➖➖
 🆔 @abzarvpn
➖➖➖➖➖' . "\n" . '.';
        $telegram->sendMessage($resultFe['user_id'], $textFe, $keyboard);
        $telegram->sendMessage($user_id, "پیام با موفقیت ارسال شد ✅✅✅✅");
    }

    public static function confirmSendMsgToChanel($user_id, $message_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ConfirmSendMessge_ToChanel', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();

        $sqlfetch1 = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmtfetch1 = $telegram->db->prepare($sqlfetch1);
        $stmtfetch1->execute();
        $resFe = $stmtfetch1->fetch(PDO::FETCH_ASSOC);

        $time_persion = jdate('Y/n/j-H:i:s', time());
        if ($resFe['fileid'] == '0') {
            $keyboard = [
                [['text' => 'خرید و دریافت کد تخفیف|📲 ', 'url' => 'https://t.me/abzarvpnbot']], [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
            ];
            $txtSend = $resFe['text'] . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $resFe['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . '.';

            $telegram->sendMessage('-1001947887061', $txtSend, $keyboard);
        } else {

            $keyboard = [
                [['text' => 'خرید و دریافت کد تخفیف|📲 ', 'url' => 'https://t.me/abzarvpnbot']], [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
            ];
            $txtSend = $resFe['text'] . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $resFe['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . '.';


            $telegram->sendPhoto('-1001947887061', $resFe['fileid'], $txtSend, $keyboard);
        }

        //---------------------------
        $sql = "UPDATE  tbl_message SET recived_data ='1' ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $telegram->sendMessage($user_id, 'پیام شما با موفقیت در کانال ارسال شد ✅✅');
        //----------------------------

    }

    //-----------------------------------------
    public static function canselSendMessageToChanel($user_id, $message_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='CancelSendMessage_ToChanel', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "DELETE FROM tbl_message WHERE recived_data='0'";
        $stmtde = $telegram->db->prepare($sql);
        $stmtde->execute();
        $telegram->deleteMessage($user_id, $message_id);
        $telegram->sendMessage($user_id, "پیام با موفقیت حذف شد ❌❌");
    }

    //------------------------------------------
    public static function confirmSendMsgToAllUser($user_id, $message_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ConfirmSendMessge_ToAllUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sqlfetch1 = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmtfetch1 = $telegram->db->prepare($sqlfetch1);
        $stmtfetch1->execute();
        $resFe = $stmtfetch1->fetch(PDO::FETCH_ASSOC);
        //------------------------
        $sqlMsg = "SELECT * FROM tbl_user ";
        $stmtMsg = $telegram->db->prepare($sqlMsg);
        $stmtMsg->execute();
        $result = $stmtMsg->fetchAll(PDO::FETCH_ASSOC);
        //-------------------------
        $time_persion = jdate('Y/n/j-H:i:s', time());
        if ($resFe['fileid'] == '0') {
            foreach ($result as $item) {
                $keyboard = [
                    [['text' => 'لینک کانال|📱', 'url' => 'https://t.me/abzarvpn']], [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
                ];
                $txtSend = $resFe['text'] . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $resFe['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . '.';

                $telegram->sendMessage($item['user_id'], $txtSend, $keyboard);
            }
        } else {

            foreach ($result as $item) {
                $keyboard = [
                    [['text' => 'خرید و دریافت کد تخفیف|📲 ', 'url' => 'https://t.me/abzarvpnbot']], [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
                ];
                $txtSend = $resFe['text'] . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $resFe['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . '.';
                $telegram->sendPhoto($item['user_id'], $resFe['fileid'], $txtSend, $keyboard);
            }
        }
        //---------------------------
        $sql = "UPDATE  tbl_message SET recived_data ='1' ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $telegram->sendMessage($user_id, 'پیام شما با موفقیت در کانال ارسال شد ✅✅');
        //----------------------------

    }



    public static function send_config_free_to_chanel($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Config_From_Admin', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "INSERT INTO tbl_config (config_code ,  active_send) values ('$text_message','0')";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();

        //-------------------------
        $sql = "SELECT * FROM tbl_config WHERE active_send='0' ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $resFe = $stmt->fetch(PDO::FETCH_ASSOC);
        $message = $resFe['config_code'];
        $keyboard = [
            [['text' => 'تایید ارسال ✅✅', 'callback_data' => 'ConfrimSendConfig']]
        ];
        $telegram->sendMessage($user_id, $message, $keyboard);
    }

    public static function sendConfigToChanel($user_id, $message_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');

        //------------------------
        $sql = "UPDATE tbl_user SET step_user='SendConfigToChanel_ByAdmin', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $text = 'کانفیگ خود را ارسال کنید.' . "\n" . '.';
        $telegram->forceReply($user_id, $text);
    }

    //-----------------------------
    public static function confirmSendConfigToChanel($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');

        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ConfirmSend_ConfigToChanel', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "SELECT * FROM tbl_config WHERE active_send='0'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //------------------------
        $time_persion = jdate('Y/n/j-H:i:s', time());
        $text = "#کانفیگ_رایگان" . " " . "#همراه_اول #ایرانسل #وای_فای" . "\n" . "کانفیگ را تاچ کنید تا کپی بشه " . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . $result['config_code'] . '</code>' . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $result['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . "\n" . '➖➖➖
👨‍💻 Admin : @abzarvpn_admin1 ‌
💠 robat:@abzarvpnbot
🤝chanell:@abzarvpn' . "\n" . '.';
        $keboard = [
            [['text' => 'دانلود نرم افزار ویتوباکس ⏬', 'url' => 'https://t.me/abzarvpn/226']],
            [['text' => 'ربات جهت خرید', 'url' => 'https://t.me/abzarvpnbot']],
            [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]

        ];
        $telegram->sendMessage(channelIDAbazrvpn, $text, $keboard);
        //------------------------
        $sql = "UPDATE tbl_config SET active_send='1'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $telegram->sendMessage($user_id, "پیام با موفقیت ارسال شد ✅✅✅");
    }

    //-----------------------------
    public static function sendMessageFromAdminToUser($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sqlDele = "DELETE FROM tbl_message WHERE recived_data ='0'";
        $stmtDele = $telegram->db->prepare($sqlDele);
        $stmtDele->execute();
        //------------------------
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='SendMessageFromAdminToUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $textMessage = '<b>' . " متن پیام خود را [برای ارسال به کاربر خاص] ارسال کنید" . "\n" . '.' . '</b>';
        $telegram->sendMessage($user_id, $textMessage);

    }

    //-----------------------------
    public static function getUserIdUserToSendMsgToUnicUser($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ConfirmSendMessge_ToUnicUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $telegram->sendMessage($user_id, "یوزرآیدی کاربری که قصد ارسال پیام به آن را دارید وارد کنید");

    }

    //-----------------------------
    public static function confirmSendMsgToUnicUser($user_id, $message_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ConfirmSendMessge_ToUnicUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();

        $sqlfetch1 = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmtfetch1 = $telegram->db->prepare($sqlfetch1);
        $stmtfetch1->execute();
        $resFe = $stmtfetch1->fetch(PDO::FETCH_ASSOC);
        $time_persion = jdate('Y/n/j-H:i:s', time());
        if ($resFe['fileid'] == '0') {
            $keyboard = [
                [['text' => 'خرید و دریافت کد تخفیف|📲 ', 'url' => 'https://t.me/abzarvpnbot']], [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
            ];
            $txtSend = $resFe['text'] . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $resFe['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . '.';

            $telegram->sendMessage('-1001947887061', $txtSend, $keyboard);
        } else {

            $keyboard = [
                [['text' => 'خرید و دریافت کد تخفیف|📲 ', 'url' => 'https://t.me/abzarvpnbot']], [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
            ];
            $txtSend = $resFe['text'] . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $resFe['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . '.';


            $telegram->sendPhoto('-1001947887061', $resFe['fileid'], $txtSend, $keyboard);
        }

        //---------------------------
        $sql = "UPDATE  tbl_message SET recived_data ='1' ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $telegram->sendMessage($user_id, 'پیام شما با موفقیت در کانال ارسال شد ✅✅');
        //----------------------------

    }

    //-----------------------------
    public static function messageToUnicUser($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Text_Admin_To_User', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "INSERT INTO tbl_message (fileid , text,recived_data) VALUES ('','$text_message',0) ";
        $stmtRe = $telegram->db->prepare($sql);
        $stmtRe->execute();
        $textRe = '<b>' . "لطفا فایل عکسی خود را [برای ارسال به یوزر خاص] ارسال کنید" . "\n" . "درصورت نداشتن عکس لطفا عدد 0 را وارد کنید " . "\n" . '.' . '</b>';
        $telegram->sendMessage($user_id, $textRe);
    }

    //-----------------------------
    public static function recivedTextFromAdminToSendUser($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Recived_Data', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sqlfetch = "SELECT * FROM tbl_message WHERE recived_data='0' ";
        $stmtfetch = $telegram->db->prepare($sqlfetch);
        $stmtfetch->execute();
        $resFe = $stmtfetch->fetch(PDO::FETCH_ASSOC);
        $keyboard = [
            [['text' => 'تایید ارسال ✅✅', 'callback_data' => 'ConfirmSendMsgToUserUnic']]
        ];
        $telegram->sendMessage($user_id, $resFe['text'], $keyboard);
    }

    //-----------------------------
    public static function confirmSendTextToUnicUser($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ConfirmSendText_ToUnicUser', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql = "UPDATE tbl_message SET userid_user='$text_message' WHERE  recived_data ='0' ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sqlfetch = "SELECT * FROM tbl_message WHERE recived_data ='0'";
        $stmtfetch = $telegram->db->prepare($sqlfetch);
        $stmtfetch->execute();
        $resFe = $stmtfetch->fetch(PDO::FETCH_ASSOC);
        $time_persion = jdate('Y/n/j-H:i:s', time());
        $keyboard = [
            [['text' => 'لینک کانال|📱', 'url' => 'https://t.me/abzarvpn']], [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']]
        ];
        $txtSend = $resFe['text'] . "\n" . "\n" . "➖➖➖➖➖➖" . "\n" . '<code>' . '📌|#کد_پیام: ' . $resFe['id'] . "\n" . "⌚️|#تاریخ_زمان: " . $time_persion . '</code>' . "\n" . '.';
        $telegram->sendMessage($resFe['userid_user'], $txtSend, $keyboard);
        //------------------------
        $sql = "UPDATE tbl_message SET recived_data ='1' ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $telegram->sendMessage($user_id, 'پیام شما با موفقیت برای [کاربر] ارسال شد ✅✅✅');
    }

    public static function sendProxy1($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');

        //------------------------
        $sqlDelete = "DELETE FROM tbl_proxy WHERE is_send='0'";
        $stmt = $telegram->db->prepare($sqlDelete);
        if (!($stmt->execute())) {
            $telegram->sendMessage($user_id, 'خطا در حذف اطلاعات از پایگاه داده ❌❌ ');
        }

        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Send_Proxy', role='admin'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $keyboard = [
            [['text' => '🖍 ارسال به کانال', 'callback_data' => 'sendProxyToChanel'], ['text' => '🖌 ارسال به ربات', 'callback_data' => 'sendProxyToBot']]
        ];
        $text = "◀️ یک گزینه را انتخاب کنید" . " " . "\n" . '.';
        $telegram->sendMessage($user_id, $text, $keyboard);
    }

    //-----------------------------------------------------
    public static function sendProxy($user_id)
    {
//        $telegram = new telegram();
//        $telegram->sendChatAction($user_id, 'typing');
//        //------------------------
//        $sqlDelete = "DELETE FROM tbl_proxy WHERE is_send='0'";
//        $stmt = $telegram->db->prepare($sqlDelete);
//        if ( !($stmt->execute())) {
//            $telegram->sendMessage($user_id, 'خطا در حذف اطلاعات از پایگاه داده ❌❌ ');
//        }
//
//        //------------------------
//        $sql = "UPDATE tbl_user SET step_user='Send_Proxy', role='admin'  WHERE user_id='$user_id'";
//        $stmt = $telegram->db->prepare($sql);
//        $stmt->execute();
//        //------------------------
//        $text = "پروکسی خود را براگذاری کنید ... ⏫⏫⏫" . " " . "\n" . '.';
//        $telegram->sendMessage($user_id, $text);
    }

    public static function getProxyToSendChanel($user_id, $text_message)
    {
//        $telegram = new telegram();
//        $telegram->sendChatAction($user_id, 'typing');
//        //------------------------
//        $sql = "UPDATE tbl_user SET step_user='GetProxyToSendChanel', role='admin'  WHERE user_id='$user_id'";
//        $stmt = $telegram->db->prepare($sql);
//        $stmt->execute();
//        //------------------------
//        $sql = "INSERT INTO tbl_proxy ( text_proxy,is_send) values ('$text_message', '0')";
//        $stmt = $telegram->db->prepare($sql);
//
//        if ($stmt->execute()) {
//            $text = "پراکسی شما با موفقیت دریافت شد|✅✅" . " " . "\n" . '.';
//            $telegram->sendMessage($user_id, $text);
//            //----------------------
//            $sql = "SELECT * FROM tbl_proxy WHERE is_send='0'";
//            $stmt = $telegram->db->prepare($sql);
//            $stmt->execute();
//            if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
//                $keyboard = [
//                    [['text' => '🖍 تایید ارسال به کانال', 'callback_data' => 'ConfirmSendProxyToChanel']] ,
//                    [['text' => '🖌 تایید ارسال به ربات', 'callback_data' => 'ConfirmSendProxyToBot']]
//                ];
//                $telegram->sendMessage($user_id, $result['text_proxy'],$keyboard);
//            } else {
//                $telegram->sendMessage($user_id, 'اطلاعاتی از پایگاه داده دریافت نشد ❌');
//
//            }
//
//        } else {
//            $telegram->sendMessage($user_id, 'خطا در دریافت اطلاعات ❌');
//
//        }
    }

    //------------------------
    public static function ConfirmSendProxyToChanel($user_id)
    {
//        $telegram = new telegram();
//        $telegram->sendChatAction($user_id, 'typing');
//
//        $sql = "SELECT * FROM tbl_proxy WHERE is_send='0'";
//        $stmt = $telegram->db->prepare($sql);
//        $stmt->execute();
//        if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            //------------------------
//            $sql = "UPDATE tbl_proxy SET is_send='1'";
//            $stmt = $telegram->db->prepare($sql);
//            $stmt->execute();
//            //------------------------
//            $textProxy = $result['text_proxy'];
//            $textMsg = '◀️ سلام دوستان عزیز روزتون شاد، هر روز کلی پراکسی تلگرام جدید با سرعت فوق العاده بالا توی کانال زیر قرار میدیم. عضو باشید و همیشه و  بودن مشکل متصل باشید.
//ID_Chanel:@proxeto
//ID_Chanel:@proxeto
//ID_Chanel:@proxeto
//ID_Chanel:@proxeto'."\n";
//            $textAttach = "#همراه_اول #ایرانسل #رایتل  #پراکسی_تلگرام #پراکسی_رایگان "."\n"
//              ."\n". "⬇️جهت اتصال روی لینک کلیک کنید⬇️"."\n". $result['text_proxy']."\n".'➖➖➖➖➖➖➖➖➖'."\n".
//                "◀️ جدید ترین پراکسی های کانال رو چک کن همیشه متصل باش"."\n"."ID_Chanel:@proxeto"."\n".'.';
//            $keyboard = [
//                [['text' => 'Connect | اتصال ', 'url' => "$textProxy"]],
//                [['text' => 'کانال پروکسیتو|proxeto', 'url' => "https://t.me/proxeto"]]
//            ];
//            $telegram->sendMessage('-1002471429576',$textAttach,$keyboard);
////            $telegram->sendMessage('449057527',$textMsg.$textAttach,$keyboard);
//            $telegram->sendMessage($user_id,'پیام شما با موفقیت ارسال شد✅');
//
//
//        } else {
//            $telegram->sendMessage($user_id, 'اطلاعاتی از پایگاه داده دریافت نشد ❌');
//
//        }

    }


}


?>