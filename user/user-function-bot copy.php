<?php
require_once "telegram.php";
require_once "config.php";
//require_once "userFunctions.php";
//require_once "addminFunctions.php";
require_once "jdf.php";
// require_once "endTimeAccoutnUsers_Cronjob.php";
//require_once "check-data-user-in-db-bot.php";
class User
{

public function __construct($user_id, $chat_id, $first_name, $last_name, $user_name, $time_stamp)
    {
        $telegram = new telegram();
        $telegram->sendMessage($chat_id, "سلام $first_name $user_name عزیز، خوش آمدید.");
        $telegram->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $first_name  = $first_name ?? '';
        $last_name   = $last_name ?? '';
        $user_name   = $user_name ?? '';
        $time_stamp  = $time_stamp ?? time();

        try {
            // ۱. بررسی وجود کاربر در دیتابیس
            $stmt = $telegram->db->prepare("SELECT id FROM tbl_user WHERE user_id = :user_id LIMIT 1");
            $stmt->execute([':user_id' => $user_id]);
            $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userExists) {
                // ۲. ثبت کاربر جدید با ستون‌های جدید و تمیز دیتابیس
                $sqlInsert = "INSERT INTO tbl_user 
                    (user_id, chat_id, first_name, last_name, username_telegram, time_stamp, step_user, role, active_peyment) 
                    VALUES 
                    (:user_id, :chat_id, :first_name, :last_name, :user_name, :time_stamp, 'StartBot', 'user', 1)";
                
                $stmtInsert = $telegram->db->prepare($sqlInsert);
                $stmtInsert->execute([
                    ':user_id'     => $user_id,
                    ':chat_id'     => $chat_id,
                    ':first_name'  => $first_name,
                    ':last_name'   => $last_name,
                    ':user_name'   => $user_name,
                    ':time_stamp'  => $time_stamp
                ]);
            } else {
                // ۳. آپدیت اطلاعات پروفایل کاربر قدیمی
                $sqlUpdate = "UPDATE tbl_user SET 
                    chat_id = :chat_id,
                    first_name = :first_name, 
                    last_name = :last_name, 
                    username_telegram = :user_name 
                    WHERE user_id = :user_id";
                    
                $stmtUpdate = $telegram->db->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ':chat_id'    => $chat_id,
                    ':first_name' => $first_name,
                    ':last_name'  => $last_name,
                    ':user_name'  => $user_name,
                    ':user_id'    => $user_id
                ]);
            }
        } catch (PDOException $e) {
            $telegram->sendMessage($chat_id, "❌ خطای SQL:\n" . $e->getMessage());
        }
    }

    public static function home($user_id, $chat_id, $first_name, $last_name, $user_name, $message_id)
    {
        $telegram = new telegram();

        $stmt = $telegram->db->prepare("SELECT register_user FROM tbl_user WHERE user_id = :user_id LIMIT 1");
        $stmt->execute([':user_id' => $user_id]);
        $result_chkuserp = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result_chkuserp && $result_chkuserp['register_user'] == 1) {
            // آپدیت استپ کاربر به استارت
            $stmtUpdate = $telegram->db->prepare("UPDATE tbl_user SET step_user = 'StartBot', role = 'user' WHERE user_id = :user_id");
            $stmtUpdate->execute([':user_id' => $user_id]);

            $telegram->replyKeyboardRemove($user_id, 'ربات مجدد استارت شد');

            // اصلاح باگ: متد Index فقط ۲ پارامتر می‌گیرد
            User::Index($user_id, $message_id);
        } else {
            User::DisplayStart($user_id, $chat_id, $first_name, $last_name, $user_name);
        }
    }




    public static function voroudbe_panel_karbari($chat_id, $user_id)
    {
        $telegram = new telegram();

        $telegram->sendChatAction($chat_id, 'typing');
        //----------------------
        $sqlUpdate = "UPDATE tbl_user SET step_user='Login_Panel' WHERE user_id='$user_id'";
        $stmtUpdate = $telegram->db->prepare($sqlUpdate);
        $stmtUpdate->execute();
        //------------------------
        //----------------------
        $sql1 = "SELECT * FROM tbl_user WHERE user_id='$user_id'";
        $stmt1 = $telegram->db->prepare($sql1);
        $stmt1->execute();
        $result_alog = $stmt1->fetch(PDO::FETCH_ASSOC);
        //------------------------
        if ($result_alog['already_login'] == '1') {

            $msg = "📢 شما قبلاً ثبت نام کردید برای ورود به پنل کاربری خود گزینه زیر را انتخاب کنید|⬅️ ";
            $keyboardLogin = [
                [['text' => 'ورود مجدد به پنل کاربری|🔐', 'callback_data' => 'login_account']],

            ];
            $telegram->sendMessage($user_id, $msg, $keyboardLogin);
        } else {
            //----------------------
            $sql2 = "UPDATE tbl_user SET step_user='Send_UserName' WHERE user_id='$user_id'";
            $stmt2 = $telegram->db->prepare($sql2);
            $stmt2->execute();
            //------------------------
            $msg = "برای ورود به پنل کاربری لازم است با استفاده از یوزر نیم و پسوردی که ادمین به شما داده لاگین کنید ";
            $keyboard = [
                //                [['text' => "بازگشت به مرحله قبل|🔙"]],
                [['text' => '🏘| خانه']]
            ];
            $telegram->sendMessage2($chat_id, $msg, $keyboard);
            $msgSendUsername = "لطفا نام کاربری(یوزر) خود را وارد کنید";
            $telegram->forceReply($user_id, $msgSendUsername);
        }
    }



















    public static function sendMessageToAdmin($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='SendMessage_ToAdmin', role='user'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $msgtoadmin = "از طریق دکمه زیر می توانید به ادمین پیام دهید";
        $keyboard = [
            [
                ['text' => '👨🏻‍💻| ارتباط با ادمین', 'url' => 'https://t.me/abzarvpn_admin1']
            ]
        ];
        $telegram->sendMessage($user_id, $msgtoadmin, $keyboard);
    }



    public static function ComingToBot($chat_id, $user_id, $message_id)
    {
        $telegram = new telegram();
        //------------------------------------
        $sqlUpdate = "UPDATE tbl_user SET step_user='karbar_kharidar' WHERE user_id='$user_id' ";
        $stmtUpdate = $telegram->db->prepare($sqlUpdate);
        $stmtUpdate->execute();
        //------------------------------------
        $msgSendMessage = "<b>یکی از گزینه های زیر را انتخاب کنید </b>:" . "\n" . "<b> 1- ورود به پنل کاربری :</b>" .
            " پس از خرید اکانت و دریافت یوزرنیم و پسورد با انتخاب این گزینه می توانید وارد پنل کاربری خودتان شوید. پنل کاربری شامل( مشاهده حجم، زمان، مشخصات اکانت، تمدید، ورود به حساب دیگر و.. ) می باشد " . "\n" . "\n" . "<b>2-مشاهده آموزش ها:</b>" . " با انتخاب این گزینه آموزش نصب و فعالسازی سرویس ها به شما نشان داده خواهد شد." . "\n" . "\n" . "<b>3-تعرفه قیمت ها:</b>" . "تعرفه قیمت های سرویس ها را میتوانید با انتخاب این گزینه مشاهده کنید" . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘)در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
        $keyboardHome = [
            //            [['text' => "🔑| ورود به پنل کاربری"], ['text' => "🔑| ارسال کد اختصاصی [جهت اطلاع رسانی اتمام حجم و زمان]"]],
            [['text' => 'اطلاع از ترافیک مصرفی']],
            [['text' => "👨🏻‍💻| ارتباط با ادمین"], ['text' => "💰| تعرفه قیمت ها"]],
            [['text' => "👨‍🏫| مشاهده آموزش ها"], ['text' => "💎| خرید تلگرام پرمیوم"]],
            [
                //            ['text' => "🔙| بازگشت به مرحله قبل"],
                ['text' => "🏘| خانه"]
            ],
        ];
        $telegram->sendMessage2($chat_id, $msgSendMessage, $keyboardHome);
    }

    public static function Index($user_id, $message_id)
    {
        $telegram = new telegram();
        //------------------------
        $sql = "SELECT * FROM tbl_user";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $numOfUserInDb = $stmt->rowCount();
        $numOfUserInDb = $numOfUserInDb + 1000;
        //        $numberOfUser = '<b>' . '💎 تعداد کاربران فعال ربات:' . '</b>' . '<u>' . $numOfUserInDb . '</u>' . " کاربر " . "\n";
        //----------------------------
        $sqlSelect = "SELECT *  FROM tbl_user WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sqlSelect);
        $stmt->execute();
        $result_start = $stmt->fetch(PDO::FETCH_ASSOC);
        $numberOfUserBot = $stmt->rowCount();

        if ($result_start['message_coming'] === '0') {
            $txtStartBotUses = "<u>" . "📣 گزارش ورود کاربر جدید به ربات" . '</u>' . "\n" . "◀️ کاربر " . $result_start['first_name'] . " ربات را استارت کرد " . "\n" . "⏱ ساعت و زمان ورد به ربات:" . jdate("Y/n/j-H:i:s ") . "\n" . '<b>' . "📌 مشخصات کاربر" . '</b>' . "\n" . "🔹 نام کاربر: " . $result_start['first_name'] . "\n" . "🔹 نام خانوادگی: " . $result_start['last_name'] . "\n" . "🔹 یوزر آیدی : " . '<code>' . $result_start['user_id'] . '</code>' . "\n" . "🔹آیدی کاربر: " . '<code>' . $result_start['id'] . '</code>' . "\n" . "🔹 یوزر نیم تلگرام: " . $result_start['username_telegram'] . "\n" . ".";
            $keyboard =
                [
                    [['text' => 'مسدود کردن کاربر', 'callback_data' => 'masdudkardn_karbar'], ['text' => 'ارسال پیام خوش آمدید', 'callback_data' => 'sendMsgWelcomeUser']]
                ];
            $telegram->sendMessage(adminChatIDMain, $txtStartBotUses, $keyboard);
            //------------------------
            $sqlUpdate = "UPDATE tbl_user SET message_coming='1' WHERE user_id='$user_id' ";
            $stmtUpdate = $telegram->db->prepare($sqlUpdate);
            $stmtUpdate->execute();
            //------------------------

        }
        if (($result_start['step_user'] === 'FirstStartBot') and ($result_start['register_user'] === '0')) {
            $msg = "✏️ لطفا یکی از گزینه های زیر را انتخاب کنید" . "\n"
                . "⚠️ در هر مرحله از ربات با استفاده از گزینه منو در سمت چپ پایین می توانید ربات را مجدد استارت کنید " . "\n" . "\n" . '<code>' . "version:1.1.0" . '</code>';
            $keyboard = [
                [['text' => 'پنل خریداران|👤', 'callback_data' => 'panele_kharidar']],
                [['text' => 'پنل همکاران فروش|👥', 'callback_data' => 'hamkaranFroush']],
                [['text' => 'ارتباط با ادمین|👨🏻‍💻‍', 'url' => 'https://t.me/abzarvpn_admin1']]
            ];
            $telegram->editMessageText($user_id, $message_id, $msg, $keyboard);
            //------------------------
            $sqlUpdate = "UPDATE tbl_user SET register_user='1' WHERE user_id='$user_id' ";
            $stmtUpdate = $telegram->db->prepare($sqlUpdate);
            $stmtUpdate->execute();
            //------------------------
        } else {


            $msg = "✏️ لطفا یکی از گزینه های زیر را انتخاب کنید" . "\n"
                . "⚠️ در هر مرحله از ربات با استفاده از گزینه منو در سمت چپ پایین می توانید ربات را مجدد استارت کنید " . "\n" . "\n" . '<code>' . "version:1.1.0" . '</code>';

            $keyboard = [
                [['text' => 'پنل خریداران|👤', 'callback_data' => 'panele_kharidar']],
                [['text' => 'پنل همکاران فروش|👥', 'callback_data' => 'hamkaranFroush']],
                [['text' => 'ارتباط با ادمین|👨🏻‍💻‍', 'url' => 'https://t.me/abzarvpn_admin1']]
            ];
            $telegram->sendMessage($user_id, $msg, $keyboard);
        }
        //----------------------------

    }

    public static function DisplayStart($user_id, $chat_id, $first_name, $last_name, $user_name)
    {
        $telegram = new telegram();
        $time_stamp = time();
        $time_persion = jdate('Y/n/j-H:i:s');

        //-----------------------------
        $sql = "SELECT * FROM tbl_user";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $numOfUserInDb = $stmt->rowCount();
        //------------------------------
        $numOfUserInDb = $numOfUserInDb + 1000;
        //        $numberOfUser = '<b>' . '💎 تعداد کاربران فعال ربات:' . '</b>' . '<u>' . $numOfUserInDb . '</u>' . " کاربر " . "\n";
        $msg = '<b>' . "🏆 به ربات ابزار وی پی ان خوش آمدید این ربات متعلق به کانال ابزار وی پی ان [abzarvpn@] می باشد" . '</b>' . "\n" . '<b>' . "🤔 اما چرا ابزار وی پی ان " . '</b>' . "\n" .
            "🧑‍💻 نظارت مداوم بر ترافیک شبکه و بار سخت‌افزار" . "\n" .
            "🧑‍💻  استفاده از سریع‌ترین پروتکل‌ها و تعریف کاربران جدید روی server جدید در صورت لزوم." .

            "\n" . "✅ بازگشت بی‌چون‌ و چرای هزینه در صورت عدم رضایت." . "\n" . "📣 پشتیبانی فنی مداوم، به‌روزرسانی دستورالعمل‌ها و معرفی روش‌های جایگزین برای دور زدن فیلترینگ و مسدودی‌ها" . "\n" . "\n" . '.';
        $keyboard = [
            [['text' => 'ورود به ربات |📲', 'callback_data' => 'FirstComingToBot']]
        ];
        $telegram->sendMessage($chat_id, $msg, $keyboard);

        //---------------------------


    }
}