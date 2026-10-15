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


public function __construct(
    $user_id,
    $chat_id,
    $first_name,
    $last_name,
    $user_name,
    $time_stamp,
    $time_persion
) {
    $telegram = new telegram();

    try {

        // فعال کردن نمایش خطاهای دیتابیس
        $telegram->db->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        // بررسی وجود کاربر
        $sql = "SELECT id FROM tbl_user WHERE user_id = :user_id LIMIT 1";

        $stmt = $telegram->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $user_id
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // اگر کاربر وجود نداشت
        if (!$user) {

            $sql_insert = "INSERT INTO tbl_user (
                user_id,
                chat_id,
                first_name,
                last_name,
                username_telegram,
                time_stamp,
                step_user,
                role,
                active_peyment
            ) VALUES (
                :user_id,
                :chat_id,
                :first_name,
                :last_name,
                :username_telegram,
                :time_stamp,
                :step_user,
                :role,
                :active_peyment
            )";

            $stmt_insert = $telegram->db->prepare($sql_insert);

            $stmt_insert->execute([
                ':user_id' => $user_id,
                ':chat_id' => $chat_id,
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':username_telegram' => $user_name,
                ':time_stamp' => $time_stamp,
                ':step_user' => 'StartBot',
                ':role' => 'user',
                ':active_peyment' => 1
            ]);

        } else {

            // بروزرسانی اطلاعات کاربر موجود
            $sql_update = "UPDATE tbl_user SET
                chat_id = :chat_id,
                first_name = :first_name,
                last_name = :last_name,
                username_telegram = :username_telegram
                WHERE user_id = :user_id";

            $stmt_update = $telegram->db->prepare($sql_update);

            $stmt_update->execute([
                ':chat_id' => $chat_id,
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':username_telegram' => $user_name,
                ':user_id' => $user_id
            ]);
        }

    } catch (PDOException $e) {

        // ذخیره خطا در لاگ سرور
        error_log(
            "Telegram Bot Database Error: " . $e->getMessage()
        );
    }
}


    public static function home($user_id, $chat_id, $first_name, $last_name, $user_name, $message_id)
    {
        $telegram = new telegram();
        $sqlCHK = "SELECT * FROM tbl_user WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sqlCHK);
        $stmt->execute();
        $result_chkuserp = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result_chkuserp['register_user'] == 1) {
            //--------------------query
            $sqlUpdate = "UPDATE tbl_user SET step_user='StartBot' , role = 'user' WHERE user_id='$user_id'";
            $stmtUpdate = $telegram->db->prepare($sqlUpdate);
            $stmtUpdate->execute();
            //--------------------query
            $telegram->replyKeyboardRemove($user_id, 'ربات مجدد استارت شد');
            $sql = "SELECT register_user FROM tbl_user WHERE user_id=" . $user_id;
            $stmt = $telegram->db->prepare($sql);
            $stmt->execute();
            $result_register = $stmt->fetch(PDO::FETCH_ASSOC);
            //-------------------------
            User::Index($chat_id, $user_id, $message_id);
        } else {
            User::DisplayStart($user_id, $chat_id, $first_name, $last_name, $user_name);
        }
    }

    public function enable_disable($chat_id)
    {
        $telegram = new telegram();
        $txtSendEnOrDi = "ربات در حال بروزرسانی است لطفا مدتی صبر کنید از صبر وشکیبایی شما متشکریم ";
        $photoFileID = "AgACAgQAAxkBAAIWg2XqDhBhHEkAAaiE5CMbMaqZhlpUzwACFMQxG1xGUVNA42OrQDF6LgEAAwIAA3gAAzQE";
        $telegram->sendPhoto($chat_id, $photoFileID, $txtSendEnOrDi);
    }

    public static function tarefe_gheymatha($user_id, $chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        //--------------------query
        $sqlUpdate = "UPDATE tbl_user SET step_user='Tarefe_Gheymatha' WHERE user_id='$user_id'";
        $stmtUpdate = $telegram->db->prepare($sqlUpdate);
        $stmtUpdate->execute();
        //--------------------query
        $msg = "<b>یکی از گزینه های زیر را انتخاب کنید </b>:" . "\n" . "\n" .
            '<b>1- سرویس ssh </b>:' . 'سرویس پرسرعت ssh بدون محدودیت حجم بسیار ایمن و دارای محدودیت کاربر، قابلیت تعریف کاربر به تعداد دلخواه' . "\n" . "\n" . '<b>2-سرویس ویتوری </b>:' . 'اشتراک موشک ویتوری بسیار سریع، ایمن، بدون محدودیت کاربر و دارای محدودیت حجم، راه اندازی بسیار سریع و آسان، قابلیت تنظیم حجم و زمان به انتخاب کاربر' . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
        $keyboardHome = [
            //            [['text' => "💣| سرویس v2ray"], ['text' => "🚀| سرویس ssh"]],
            [['text' => "💣| سرویس v2ray"]],
            [
                //                ['text' => "🔙| بازگشت به مرحله قبل"],
                ['text' => "🏘| خانه"]
            ]
        ];
        $telegram->sendMessage2($chat_id, $msg, $keyboardHome);
    }

    public static function tarefe_gheymatha_shh($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $telegram = new telegram();
        $msg = "<b>با توجه به حجم و زمان مصرفی خودتان یک  مورد را انتخاب و با ادمین در ارتباط باشید </b>:" . "\n" . "\n" .
            "<b>📣📣| یک ماهه</b>:" . "\n" .
            "\n" . "تعداد کاربر       <pre></pre>" . "|" . "    حجم        " . "|" . "    قیمت        "
            .
            "\n" . "تک کاربره         " . "|" . "   نامحدود     " . "|" . "  110,000 تومان"
            .
            "\n" . "دو کاربره         " . "|" . "   نامحدود     " . "|" . " 130,000 تومان" . "\n" . "===================" . "\n" . "\n" .
            "<b>📣📣| دو ماهه</b>:" . "\n" .
            "\n" . "تعداد کاربر       <pre></pre>" . "|" . "    حجم        " . "|" . "    قیمت        "
            .
            "\n" . "تک کاربره         " . "|" . "   نامحدود     " . "|" . "  199,000 تومان"
            .
            "\n" . "دو کاربره         " . "|" . "   نامحدود     " . "|" . " 215,000 تومان" . "\n" . "===================" . "\n" . "\n" .
            "<b>📣📣| سه ماهه</b>:" . "\n" .
            "\n" . "تعداد کاربر       <pre></pre>" . "|" . "    حجم        " . "|" . "    قیمت        "
            .
            "\n" . "تک کاربره         " . "|" . "   نامحدود     " . "|" . "  299,000 تومان"
            .
            "\n" . "دو کاربره         " . "|" . "   نامحدود     " . "|" . " 315,000 تومان" . "\n" . "==================="

            . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
        $keyboard = [
            [['text' => "👨🏻‍💻| ارتباط با ادمین"]],
            //            [['text' => "🔙| بازگشت به مرحله قبل"]],
            [['text' => "🏘| خانه"]]
        ];
        $telegram->sendMessage2($chat_id, $msg, $keyboard);
    }

    public static function tarefe_gheymatha_v2ray($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $telegram = new telegram();
        $msg = '<b>' . " 📣| سرویس فوق العاده سریع ویتوری|v2ray به صورت حجمی ارائه می شود"
            . "\n" . "👨‍👨‍👦| بدون محدودیت کاربر"
            . "\n" . "⏰| قابلیت مدیریت حجم و زمان به صورت پویا در داخل اپلیکیشن" .
            "\n" . "\n" . "✅| جهت خرید از طریق دکمه زیر (ارتباط با ادمین)به پشتیبانی پیام دهید " . '</b>';

        $keyboard = [
            [['text' => "ارتباط با ادمین|👨🏻‍💻"]],
            //            [['text' => "بازگشت به مرحله قبل|🔙"]],
            [['text' => "🏘| خانه"]]
        ];
        $telegram->sendMessage2($chat_id, $msg, $keyboard);
    }

    public static function moshahede_amoozesha($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $msg = "<b>برای مشاهده نصب و راه اندازی، سرویس مورد نظر خودرا انتخاب کنید  </b>:" . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
        $keyboardHome = [
            [['text' => "💣| آموزش سرویس v2ray"]],
            //            [['text' => "🚀| آموزش سرویس ssh"]],
            [['text' => "🏘| خانه"]]

        ];;
        $telegram->sendMessage2($chat_id, $msg, $keyboardHome);
    }

    public static function amoozesh_service_ssh($chat_id)
    {

        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $msg = "<b>لطفا سیستم عامل مورد نظر خود را انتخاب کنید </b>" . "\n" . '📞| به هر دلیلی در نصب و راه اندازی مشکل داشتید با ادمین در ارتباط باشید ' . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
        $keyboardHome = [
            [['text' => "آموزش ssh اندروید"], ['text' => "آموزش ssh آیفون"]],
            [['text' => "آموزش ssh ویندوز"], ['text' => "🏘| خانه"]]
        ];
        $telegram->sendMessage2($chat_id, $msg, $keyboardHome);

        //-----------------------

    }

    public static function amoozesh_service_shh_android($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');


        $video_android = 'BAACAgQAAxkBAAKB72b8HPTGBPlMZAm0pg1SHSkcw8_XAALRGAACGDvhU4qRqE1Tz_W2NgQ';
        //  $msg = "BAACAgQAAxkBAAIa2WUxLaSBV_ERl2AssFGptUCNRwrkAAJDDgAC4atxUmYj6Fy7bXCSMAQ";
        //    $caption_android = $rows['caption_android'];
        $caption_android = 'برای دانلود فایل هم به صورت مستقیم هم به صورت دانلود از استور گوگلی پلی روی دکمه های زیر کلیک کنید '
            . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید ";
        $keyboard = [
            [['text' => '📎|دانلود از گوگل پلی ⏬ ', 'url' => 'https://play.google.com/store/apps/details?id=com.napsternetlabs.napsternetv']],
            [['text' => ' 📎|دانلود به صورت مستقیم ⏬', 'url' => 'https://t.me/abzarvpn/114']]

        ];

        $telegram->sendAnimation($chat_id, $caption_android, $video_android, $keyboard);
    }

    public static function amoozesh_service_shh_iphone($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $telegram = new telegram();

        $video_iphone = 'BAACAgQAAxkBAAKCe2b8JPZFe0L5sXTRDdwAAeap3zCYqwAC_xgAAhg74VN0FrslqGC0kjYE';
        $caption_iphone = 'برای دانلود فایل  ازآپ استور ایفون  روی دکمه  زیر کلیک کنید '
            . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید ";
        $keyboard = [
            [['text' => '📎|دانلود از گوگل پلی ', 'url' => 'https://apps.apple.com/us/app/napsternetv/id1629465476']],

        ];
        $telegram->sendAnimation($chat_id, $caption_iphone, $video_iphone, $keyboard);
    }

    public static function amoozesh_service_shh_windows($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $telegram = new telegram();

        $video_widows = 'AAMCBAADGQEAAoHvZvwc9MYE-UxkCbSmDVIdKRzDz9cAAtEYAAIYO-FTipGoTVPP9bYBAAdtAAM2BA';
        //$msg = "BAACAgQAAxkBAAIa2WUxLaSBV_ERl2AssFGptUCNRwrkAAJDDgAC4atxUmYj6Fy7bXCSMAQ";

        $keyboard = [

            [['text' => '🏘| خانه', 'callback_data' => 'homeLearning']]
        ];
        $telegram->sendAnimation($chat_id, "مطابق فایل بالا فایل را مشاهده کنید", $video_widows, $keyboard);
    }

    public static function amoozesh_service_v2ray($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $msg = "<b>لطفا سیستم عامل مورد نظر خود را انتخاب کنید </b>" . "\n" . '📞| به هر دلیلی در نصب و راه اندازی مشکل داشتید با ادمین در ارتباط باشید ' . "\n" . "\n"
            . "===========📛📛==========" . "\n" . "\n" . "<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
        $keyboardHome = [
            [['text' => "آموزش v2ray اندروید"], ['text' => "آموزش v2ray آیفون"]],
            [['text' => "آموزش v2ray ویندوز"], ['text' => "🏘| خانه"]]
        ];
        $telegram->sendMessage2($chat_id, $msg, $keyboardHome);
    }

    public static function amoozesh_service_v2ray_android($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $telegram = new telegram();
        $dlFile = 'https://t.me/abzarvpn/226';
        $caption = '◀️ کانفیگ اختصاصی ارسال شده برای شما را مطابق تصویر بالا راه اندازی کنید' . "\n"
            . "⏬ لینک دانلود نرم افزار(در پایین)" . "\n" . ".";
        $photoFileId_1 = 'AgACAgQAAxkBAAJLQmbSDnQkzr-4qIgZTrjglaGrQqqEAALzvjEbSbGZUtbvXvNVxBRzAQADAgADeQADNQQ';

        $keyboard = [
            [['text' => 'دانلود نرم افزار|⏬', 'url' => 'https://t.me/abzarvpn/226']],

        ];
        $telegram->sendPhoto($chat_id, $photoFileId_1, $caption, $keyboard);
    }

    public static function amoozesh_service_v2ray_iphone($chat_id)
    {
        $telegram = new telegram();

        $telegram->sendChatAction($chat_id, 'typing');
        $telegram = new telegram();
        $dlFile = 'https://t.me/abzarvpn/226';
        $caption = '◀️ کانفیگ اختصاصی ارسال شده برای شما را مطابق تصویر بالا راه اندازی کنید' . "\n"
            . "⏬ لینک دانلود نرم افزار(در پایین)" . "\n" . ".";
        $photoFileId_1 = 'AgACAgQAAxkBAAJLQmbSDnQkzr-4qIgZTrjglaGrQqqEAALzvjEbSbGZUtbvXvNVxBRzAQADAgADeQADNQQ';

        $keyboard = [
            [['text' => 'دانلود نرم افزار|⏬', 'url' => 'https://apps.apple.com/us/app/v2box-v2ray-client/id6446814690']],

        ];
        $telegram->sendPhoto($chat_id, $photoFileId_1, $caption, $keyboard);
    }

    public static function amoozesh_service_v2ray_windows($chat_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        $telegram = new telegram();
        $dlFile = 'https://t.me/abzarvpn/226';
        $caption = '◀️ کانفیگ اختصاصی ارسال شده برای شما را مطابق تصویر بالا راه اندازی کنید' . "\n"
            . "⏬ لینک دانلود نرم افزار(در پایین)" . "\n" . ".";
        $photoFileId_1 = 'AgACAgQAAxkBAAJL5GbSJT7XIYRQvM9h8KT4WJ5YZMENAALdwjEbwTSRUnDCYeO1E9LMAQADAgADeQADNQQ';

        $keyboard = [
            [['text' => 'دانلود نرم افزار|⏬', 'url' => 'https://apps.apple.com/us/app/v2box-v2ray-client/id6446814690']],

        ];
        $telegram->sendPhoto($chat_id, $photoFileId_1, $caption, $keyboard);
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

    public static function Display_user_account_information($user_id, $chat_id)
    {
        $telegram = new telegram();

        //-----------------------------------
        $sqlUpdate = "UPDATE tbl_user SET step_user='Update_Information' WHERE user_id='$user_id'";
        $stmtUpdate = $telegram->db->prepare($sqlUpdate);
        $stmtUpdate->execute();
        //-----------------------------------

        ///--------------------
        $sql = "SELECT * FROM tbl_user WHERE user_id=" . $user_id;
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $resutl_datauser = $stmt->fetch(PDO::FETCH_ASSOC);
        ///--------------------
        $msgSendMessage = '<b>' . "✋🏻| سلام" . " " . $resutl_datauser['first_name'] . " " . 'عزیز به پنل کاربری خود خوش آمدید' . '</b>' . "\n"
            . '<u>' . '📋| اطلاعات پروفایل شما به صورت زیر است:' . '</u>' . "\n" .
            '👤| نام پروفایل شما: ' . '<code>' . $resutl_datauser['first_name'] . '</code>' . "\n" .
            '◀️| آیدی تلگرام شما: ' . '<code>' . $resutl_datauser['username_telegram'] . '</code>' . "\n" .
            '🔹| یوزرآیدی شما: ' . '<code>' . $resutl_datauser['user_id'] . '</code>' . "\n" .
            '🔑| یوزرنیم پنل شما: ' . '<code>' . $resutl_datauser['username_panel'] . '</code>' . "\n" .
            '🔑| پسورد پنل شما: ' . '<code>' . $resutl_datauser['password_panel'] . '</code>' . "\n" .
            '<b>' . '💰| موجودی کیف پول شما: ' . '</b>' . '<code>' . $resutl_datauser['col_wallet'] . '</code>' . "  " . "تومان" . "\n" .
            '⏰| زمان ورود به پنل: ' . '<code>' . $resutl_datauser['time_persion'] . '</code>' . "\n" . '➖➖➖➖➖➖' . "\n" . "مشخصات اشتراک های خریداری شده شما:" . "\n" . "⬅️| اشتراک [SHH]" . ": " . "فعال" . "\n" . "⏳ تاریخ پایان اشتراک" . ": " . "1300" . "\n" . "🔑| یوزرنیم اکانت " . ": " . '<code>' . 'aligholie' . '</code>' . "\n" . "🔐| پسورد اکانت: " . '<code>' . '433323' . '</code>' . "\n" . "👤| تعداد کاربر مجاز : " . "1 " . "کاربر " . "\n" . "⌛️| حجم مصرفی شما: " . " نامحدود" . "\n" . '➖➖➖➖➖➖' . "\n" . "⬅️| اشتراک [v2ray]" . ": " . "فعال" . "\n" . "⏳| تاریخ پایان اشتراک" . ": " . "1300" . "\n" . '📝| لینک کانفیگ شما: ' . '[روی کانفیگ کلیک کنید تا کپی شود]' . "\n" . '<code>' . 'vless://3bf6cb61-7f9e-4258-8027-6c8cf6038058@net.abznet.top:11891?type=tcp&security=none#users-ireh4tx1-keood' . '</code>' . "\n" . "👤| تعداد کاربر مجاز : " . "نامحدود " . "کاربر " . "\n" . "⌛️| حجم مصرفی شما: " . " محدود در حال محاسبه" . "\n" . ".";
        $keyboardHome = [
            [['text' => '♻️| تمدید اشتراک'], ['text' => '◀️| خرید اشتراک جدید']],
            [['text' => "👨‍🏫| مشاهده آموزش ها"], ['text' => "🔌| شارژ حساب کاربری"]],
            [['text' => "🕹| ورود به حساب دیگر"], ['text' => "🔄| بروزرسانی اطلاعات"]],
            [['text' => "👨🏻‍💻| ارتباط با ادمین"], ['text' => "💰| تعرفه قیمت ها"]],
            [['text' => "🖇| اشتراک گذاری"], ['text' => "💎| خرید تلگرام پرمیوم"]],
            [
                //                ['text' => "🔙| بازگشت به مرحله قبل"],
                ['text' => "🏘| خانه"]
            ]
        ];
        $telegram->sendMessage2($chat_id, $msgSendMessage, $keyboardHome);
    }

    public static function voroudbe_hesab_karbari_digar($user_id)
    {
        $telegram = new telegram();
        //-----------------------------------
        $sqlUpdate = "UPDATE tbl_user SET step_user='Chagne_Account' WHERE user_id='$user_id'";
        $stmtUpdate = $telegram->db->prepare($sqlUpdate);
        $stmtUpdate->execute();
        //-----------------------------------
        $message_account = "⚠| برای ورود به حساب کاربری دیگر لازم است از حساب کاربری خود خارج شوید[دقت داشته باشید مجدد می توانید به حساب کاربری اول خود وارد شوید و اطلاعات شما از دست نمی رود]" . "\n" . '.';
        $keyboard = [
            [['text' => '❌|انصراف', 'callback_data' => 'Enseraf_OtherAccount'], ['text' => '✅| تایید ', 'callback_data' => 'Confirm_OtherAccount']]
        ];

        $telegram->sendMessage($user_id, $message_account, $keyboard);
    }

    public static function send_username($chat_id, $user_id, $text_message)
    {
        //        $telegram = new telegram();
        //        $telegram->sendChatAction($chat_id, 'typing');
        //        //-----------------------
        //        $sql = "UPDATE tbl_user SET step_panel='Send_Username', username_panel='$text_message' WHERE user_id='$user_id'";
        //        $stmt = $telegram->db->prepare($sql);
        //        $stmt->execute();
        //        //------------------------
        //        $msgReplayUser = "پسورد خود را ارسال کنید";
        //        $telegram->forceReply($user_id, $msgReplayUser);
    }

    public static function send_password($chat_id, $user_id, $text_message)
    {
        //        $telegram = new telegram();
        //        $telegram->sendChatAction($chat_id, 'typing');
        //        //------------------------
        //        $sql = "UPDATE tbl_user SET step_user='Recive_DataUser',already_login='1' , password_panel='$text_message' WHERE user_id='$user_id'";
        //        $stmt = $telegram->db->prepare($sql);
        //        $stmt->execute();
        //        //------------------------
        //        $sql2 = "SELECT * FROM tbl_user WHERE user_id=" . $user_id;
        //        $stmt2 = $telegram->db->prepare($sql2);
        //        $stmt2->execute();
        //        $result_panel = $stmt2->fetch(PDO::FETCH_ASSOC);
        //
        //
        //        $keyboard = [
        //            [['text' => '⬅️| ورود به پنل', 'callback_data' => 'login_account']],
        //            [['text' => '📝| ویرایش اطلاعات', 'callback_data' => 'login_account2']],
        ////                            [['text'=>'خانه|⬅️','callback_data' => 'login_account3']]
        //        ];
        //        $showData = "✏️| نام کاربری شما: " . $result_panel['username_panel'] . "\n" . "🔐| پسورد شما: " . $result_panel['password_panel'] . "\n" . "📋| اطلاعات شما با موفقیت در تاریخ:  " . jdate("Y/n/j ساعت H:i:s ") . " ثبت شد" . "\n" .
        //            "🥰| ضمن تشکر از ثبت اطلاعات هم اکنون می توانید از طریق دکمه زیر وارد پنل کاربری خود شوید " . ".";
        //
        //        $telegram->sendMessage($user_id, $showData, $keyboard);
        //------------------------
    }

    public static function tamdide_eshterak($chat_id, $user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Tamdide_Eshterak' WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $txtTamdid = '⚠| ' . "در حال حاضر امکان تمدید اتوماتیک وجود ندارد شما می توانید یا از گزینه خرید اکانت جدید اقدام به تهیه اشتراک کنید یا از طریق ادمین اقدام به تمدید اکانت قبلی خود کنید" . "\n" . ".";
        $telegram->sendMessage($user_id, $txtTamdid);
    }

    public static function sharje_hesab($chat_id, $user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($chat_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Sharje_Hesab' WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $txtSharjeHesab = "مبلغ مورد نظر برای شارژ کیف پول خود را به صورت عددی و برحسب تومان وارد کنید  " . "\n" . "به عنوان مثال : 100000" . "\n" . '.';

        $telegram->sendMessage($user_id, $txtSharjeHesab);
    }

    public static function ersal_mablagh_sharje($text_message, $chat_id, $user_id, $first_name, $last_name, $user_name)
    {
        /*   $telegram = new telegram();
           $telegram->sendChatAction($chat_id, 'typing');
           //------------------------
           $sql = "UPDATE tbl_user SET step_user='ErsaleMablagh_SharjeHesab' WHERE user_id='$user_id'";
           $stmt = $telegram->db->prepare($sql);
           $stmt->execute();
           //------------------------
           if (is_numeric($text_message)) {
               $txtSharjeHesab = "فاکتور اولیه شما ایجاد شد:" . "\n" . "شارژ کیف پول به مبلغ: " . $text_message . " " . "تومان" . "\n" . "نام پرداخت کننده: " . "$first_name" . "\n" . 'نام خانوادگی پرداخت کننده: ' . "$last_name" . "\n" . "آیدی تلگرام پرادخت کننده: " . "$user_name" . "\n" . "تاریخ و زمان ثبت شفارش " . ": " . jdate("Y/n/j ساعت H:i:s ") . "\n" . '.';
               $keyboard = [
                   [['text' => '✅ تایید و پرداخت [کلیک کنید]', 'url' => baseurl . "pay/zp/pay.php?user_id=$user_id&amount=$text_message" . '0']],
                   [['text' => '❌ انصراف', 'url' => 'https://google.com' . "/" . "$text_message"]]
               ];
               $telegram->sendMessage($user_id, $txtSharjeHesab, $keyboard);
           } else {
               $telegram->sendMessage($user_id, 'string');

           }*/
    }

    public static function sendUnicCodeUser($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='SendUnicCodeUser' , role='user'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $txtGetData = "◀️ لطفا کد اختصاصی و یا یوزرنیم اختصاصی خود را که ادمین برای شما ارسال کرده را در وارد کنید" . "\n" . '.';
        $telegram->forceReply($user_id, $txtGetData);
    }

    public static function byNewInstance($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='KharideEshterake_jadid', role='user'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $sql2 = "SELECT * FROM tbl_user WHERE user_id='$user_id'";
        $stmt2 = $telegram->db->prepare($sql2);
        $stmt2->execute();
        $result = $stmt2->fetch(PDO::FETCH_ASSOC);
        $txt = "موجودی کیف پول شما:" . " " . $result['col_wallet'] . ' ' . 'تومان' . "\n" . '.';
        $keyboard = [
            [['text' => 'خرید اشتراک v2ray', 'callback_data' => 'byV2rayAccount'], ['text' => 'خرید اشتراک SSH', 'callback_data' => 'bySSHAccount']]
        ];
        $telegram->sendMessage($user_id, $txt, $keyboard);
    }

    public static function byV2rayAccount($user_id, $message_id)
    {

        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');

        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Kharide_Account_V2ray', role='user'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------

        $txt = "لطفا یکی از پلن های زیر را انتخاب کنید" . "\n" . '.';
        $keyboard = [

            [['text' => '10 گیگ|یک ماهه', 'callback_data' => '1month10gb'], ['text' => '20 گیگ|یک ماهه', 'callback_data' => '1month20gb'], ['text' => '40 گیگ|یک ماهه', 'callback_data' => '1month40gb']],

            [['text' => '30 گیگ|دو ماهه', 'callback_data' => '2month30gb'], ['text' => '60 گیگ|دو ماهه', 'callback_data' => '2month60gb'], ['text' => '90 گیگ|دو ماهه', 'callback_data' => '2month90gb']],

            [['text' => '60 گیگ|سه ماهه', 'callback_data' => '3month60gb'], ['text' => '120 گیگ|سه ماهه', 'callback_data' => '3month120gb'], ['text' => '180 گیگ|سه ماهه', 'callback_data' => '3month180gb']],
            [['text' => 'مدت زمان دلخواه', 'callback_data' => 'time_delkhah']]
        ];


        $telegram->editMessageText($user_id, $message_id, $txt, $keyboard);
    }

    public static function time_delkhah($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='Time_Delkhah', role='user'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $txtMsg = "لطفا زمان را به صورت [عددی] وارد کنید " . "\n" . "به عنوان مثال: 30" . "\n" . ".";
        $telegram->forceReply($user_id, $txtMsg);
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

    public static function byTelegramPermium($user_id)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //------------------------
        $sql = "UPDATE tbl_user SET step_user='ByTelegram_Permium', role='user'  WHERE user_id='$user_id'";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        //------------------------
        $msgtoadmin = "💎💎" . "شما می توانید از طریق تیم ما تلگرام پرمیوم به صورت اورجینال و اصلی نه فیک و موقت با مدت زمان تعیین شده از سمت خود تلگرام به صورت " . "\n" . "◀️ سه ماهه" . "\n" . "◀️ شش ماهه" . "\n" . "◀️ یکساله " . "\n" . 'تهیه کنید' . "\n" . "برای دریافت اخرین قیمت به ایدی پشتیبانی پیام دهید" . "\n" . ".";
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

    public static function display_traffic($user_id, $text_message)
    {
        $telegram = new telegram();
        $sql = "UPDATE tbl_user SET step_user='display_traffic' WHERE user_id='$user_id' ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $telegram->sendMessage($user_id, 'یوزرنیم اکانت خود را ارسال کنید.' . "\n" . '(به عنوان مثال: vipuser332)');
        //------------------------

    }

    public static function display_traffic_api($user_id, $text_message)
    {
        $telegram = new telegram();
        $telegram->sendChatAction($user_id, 'typing');
        //        $number_request = 0;
        $sql = "SELECT * FROM tbl_traffic WHERE user_id='$user_id' ";
        $stmt = $telegram->db->prepare($sql);
        $stmt->execute();
        $result_request = $stmt->fetch(PDO::FETCH_ASSOC);
        $number_request = $result_request['number_request'];
        if ($number_request >= 6) {
            $txt_message_result = 'کاربر گرامی تعداد درخواست های شما بیش از حد مجاز  بوده دسترسی شما به مدت 30 دقیقه مسدود شد پس ازآن مجدد میتوانید اطلاعات ترافیک خود را مشاهده کنید' . "\n" . '.';
            $telegram->sendMessage($user_id, $txt_message_result);
        } else {
            $number_request = $number_request + 1;
            $sql_request = "UPDATE tbl_traffic SET number_request='$number_request' WHERE user_id='$user_id' ";
            $stmt_request = $telegram->db->prepare($sql_request);
            $stmt_request->execute();


            $text_message = strtolower($text_message);
            $time_stamp = time();
            $time_persion = jdate('Y/n/j-H:i:s', time());
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://net.abznet.top:8443/XLOo5XjGeMM1n18/login');
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=mrkgnetnet&password=65006500");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
            curl_setopt($ch, CURLOPT_COOKIEFILE, '/var/www/ip4.x/file/tmp');  //could be empty, but cause problems on some hosts
            $answer = curl_exec($ch);
            if (curl_error($ch)) {
                echo curl_error($ch);
            }
            //another request preserving the session
            curl_setopt($ch, CURLOPT_URL, 'https://net.abznet.top:8443/XLOo5XjGeMM1n18/panel/api/inbounds/getClientTraffics/' . $text_message);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            $answer2 = curl_exec($ch);
            if (curl_error($ch)) {
                echo curl_error($ch);
            }
            echo '<br>';
            $convertString = json_decode($answer2);
            //                    $telegram->sendMessage($user_id, $convertString);
            //                    $telegram->sendMessage($user_id, $answer2);
            if (array_key_exists('obj', $convertString)) {
                //$telegram->sendMessage($user_id, 'yes');
                $username_account = $convertString->obj->email;
                $all_traffic_account = $convertString->obj->total;
                $all_traffic_account = ($all_traffic_account / 1073735424.880463);
                $all_traffic_account = round($all_traffic_account, 2);
                $status_account = $convertString->obj->enable;
                if ($status_account == 'true') {
                    $status_account = 'فعال|✅';
                } else {
                    $status_account = 'غیرفعال|❌';
                }
                $upload_account = $convertString->obj->up;
                $upload_account = ($upload_account / 1073735424.880463);
                $upload_account = round($upload_account, 2);
                $download_account = $convertString->obj->down;
                $download_account = ($download_account / 1073735424.880463);
                $download_account = round($download_account, 2);
                $end_time = $convertString->obj->expiryTime;
                //  $expire_time_account1= date('Y-m-d H:i:s',  $expire_time_account);
                $end_time = $end_time / 1000;
                $expire_time_account = jdate('Y/n/j ساعت H:i:s ', $end_time);
                $sum_traffic_user = $download_account + $upload_account;
                $baghi_mande_traffic = $all_traffic_account - $sum_traffic_user;

                if ($baghi_mande_traffic == 0 and $download_account == 0 and $upload_account == 0) {
                    $txt = 'اطلاعات شما یافت نشد احتمالا یوزر خود را به اشتباه وارد کردید برای دریافت یوزرنیم خود به ادمین پیام دهید';
                    $keyboard = [
                        [
                            ['text' => '👨🏻‍💻| ارتباط با ادمین', 'url' => 'https://t.me/abzarvpn_admin1']
                        ]
                    ];
                    $telegram->sendMessage($user_id, $txt, $keyboard);
                } else {
                    //$telegram->sendMessage($user_id, $temp);
                    $keyboard = [
                        [
                            ['text' => '👨🏻‍💻| ارتباط با ادمین', 'url' => 'https://t.me/abzarvpn_admin1']
                        ]
                    ];
                    $text_valume = '<b>' . 'اطلاعات اشتراک شما به شرح زیر است ' . '</b>' . "\n" . 'نام کاربری: ' . $username_account . "\n" . 'وضعیت اکانت: ' . $status_account . "\n" . 'کل ترافیک اولیه: ' . $all_traffic_account . ' گیگ ' . "\n" . "دانلود: " .
                        $download_account . ' گیگ ' . "\n" . 'آپلود: ' . $upload_account . ' گیگ ' . "\n" . 'مجموع کل ترافیک مصرفی: ' . $sum_traffic_user . ' گیگ ' . "\n" .
                        'باقی مانده ترافیک: ' . $baghi_mande_traffic . ' گیگ ' . "\n" . 'زمان پایان اشتراک: ' . $expire_time_account . "\n" . '---------' . "\n" . 'بروزرسانی شده در تاریخ: ' . $time_persion . "\n" . "." . "\n";
                    $telegram->sendMessage($user_id, $text_valume, $keyboard);
                    //            -------------------------------------------------------
                    /*
                        وارد کردن اطلاعات کاربر در دیتابیس
                    */
                    $query = "SELECT * FROM tbl_traffic WHERE user_id='$user_id' ";
                    $stmt = $telegram->db->prepare($query);
                    $stmt->execute();
                    $result = $stmt->rowCount();
                    if ($result == 0) {

                        $sql = "INSERT INTO tbl_traffic (user_id,account_username,remaining_traffic,expiration_time) VALUES ('$user_id','$username_account','$baghi_mande_traffic','$end_time')";
                        $stmt = $telegram->db->prepare($sql);
                        $stmt->execute();
                    } else {
                        $sql = "UPDATE tbl_traffic SET account_username ='$username_account' , remaining_traffic = '$baghi_mande_traffic' , expiration_time ='$end_time' WHERE user_id='$user_id' ";
                        $stmt = $telegram->db->prepare($sql);
                        $stmt->execute();
                    }
                }
            }
        }
    }
}