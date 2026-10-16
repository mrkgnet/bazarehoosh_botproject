<?php
require_once "telegram.php";
require_once "config.php";
require_once "jdf.php";
require_once __DIR__ . '/functions/Start.php';


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
                    ':step_user' => 'STARTBOT',
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

    public static function sendMessageToAdmin($user_id)
    {
        $telegram = new telegram();

        // نمایش وضعیت تایپ کردن
        $telegram->sendChatAction($user_id, 'typing');

        // تغییر مرحله کاربر
        $sql = "UPDATE tbl_user
            SET step_user = 'SENDMESSAGE_TO_ADMIN',
                role = 'user'
            WHERE user_id = :user_id";

        $stmt = $telegram->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $user_id
        ]);

        // متن ارتباط با پشتیبانی
        $msgtoadmin =
            "👨🏻‍💻 <b>ارتباط با پشتیبانی بازار هوش</b>\n\n" .
            "برای ارتباط مستقیم با پشتیبانی، از طریق دکمه زیر اقدام کنید.\n\n" .
            "📩 آیدی پشتیبانی:\n" .
            "<a href=\"https://t.me/AToluifar\">@AToluifar</a>\n\n" .
            "✅ با کلیک روی آیدی بالا می‌توانید مستقیماً وارد گفتگوی پشتیبانی شوید.";

        // دکمه شیشه‌ای ارتباط با ادمین
        $keyboard = [
            [
                [
                    'text' => '👨🏻‍💻 ارتباط با پشتیبانی',
                    'url' => 'https://t.me/AToluifar'
                ]
            ]
        ];

        // ارسال پیام
        $telegram->sendMessage(
            $user_id,
            $msgtoadmin,
            $keyboard
        );
    }


    public static function Index($user_id, $message_id)
    {
        $telegram = new telegram();

        // ====================================
        // دریافت اطلاعات کاربر
        // ====================================

        $sql = "SELECT * FROM tbl_user
            WHERE user_id = :user_id
            LIMIT 1";

        $stmt = $telegram->db->prepare($sql);

        $stmt->execute([
            ':user_id' => $user_id
        ]);

        $result_start = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result_start) {
            return;
        }

        // ====================================
        // گزارش اولین ورود به ادمین
        // ====================================

        if ($result_start['message_coming'] == '0') {

            $first_name = htmlspecialchars(
                $result_start['first_name'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );

            $last_name = htmlspecialchars(
                $result_start['last_name'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );

            $username = htmlspecialchars(
                $result_start['username_telegram'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );

            $txtStartBotUses =
                "<u>📣 گزارش ورود کاربر جدید به ربات</u>\n\n" .
                "◀️ کاربر " . $first_name . " وارد ربات شد.\n\n" .
                "⏱ تاریخ ورود: " . jdate("Y/n/j-H:i:s") . "\n\n" .
                "<b>📌 مشخصات کاربر</b>\n\n" .
                "🔹 نام: " . $first_name . "\n" .
                "🔹 نام خانوادگی: " . $last_name . "\n" .
                "🔹 شناسه تلگرام: <code>" . $result_start['user_id'] . "</code>\n" .
                "🔹 شناسه دیتابیس: <code>" . $result_start['id'] . "</code>\n" .
                "🔹 نام کاربری: " . $username;

            // دکمه‌های گزارش ادمین
            // این دکمه‌ها همچنان شیشه‌ای هستند
            $admin_keyboard = [
                [
                    [
                        'text' => 'مسدود کردن کاربر',
                        'callback_data' => 'masdudkardn_karbar'
                    ],
                    [
                        'text' => 'ارسال پیام خوش آمدید',
                        'callback_data' => 'sendMsgWelcomeUser'
                    ]
                ]
            ];

            // ارسال گزارش به ادمین
            $result_admin = $telegram->sendMessage(
                adminChatIDMain,
                $txtStartBotUses,
                $admin_keyboard
            );

            // ثبت ارسال گزارش
            if (isset($result_admin->ok) && $result_admin->ok === true) {

                $sql = "UPDATE tbl_user
                    SET message_coming = '1'
                    WHERE user_id = :user_id";

                $stmt = $telegram->db->prepare($sql);

                $stmt->execute([
                    ':user_id' => $user_id
                ]);
            }
        }

        // ====================================
        // متن منوی اصلی
        // ====================================

        $msg = "<b>🏠 منوی اصلی فروشگاه بازار هوش</b>\n\n" .
            "👋 به فروشگاه بازار هوش خوش آمدید.\n\n" .
            "برای استفاده از خدمات فروشگاه، لطفاً یکی از گزینه‌های زیر را انتخاب کنید.\n\n" .
            "✨ اینجا تکنولوژی فردا را آسان بخر";

        // ====================================
        // کیبورد معمولی منوی اصلی
        // ====================================

        $keyboard = [

            // ردیف اول: فروشگاه و محصولات
            [
                ['text' => '🛍 فروشگاه و محصولات']
            ],

            // ردیف دوم: اکانت‌های تست و سفارشات
            [
                ['text' => '🧪 اکانت‌های تست'],
                ['text' => '📦 سفارشات']
            ],

            // ردیف سوم: پروفایل و دعوت دوستان
            [
                ['text' => '👤 پروفایل و حساب کاربری'],
                ['text' => '🎁 دعوت و معرفی به دوستان']
            ],

            // ردیف چهارم: پشتیبانی
            [
                ['text' => '🎧 پشتیبانی و ثبت تیکت']
            ],

            // ردیف پنجم: دستیار هوشمند و مخزن پرامپت
            [
                ['text' => '🤖 دستیار هوشمند'],
                ['text' => '📝 مخزن پرامپت']
            ],

            // ردیف ششم: انتخاب زبان
            [
                ['text' => '🌐 زبان']
            ],
            [
                ['text' => '🏘 خانه']
            ]
        ];

        // ====================================
        // ارسال منوی اصلی با کیبورد معمولی
        // ====================================

        $result = $telegram->sendMessage2(
            $user_id,
            $msg,
            $keyboard
        );

        // ====================================
        // بروزرسانی وضعیت ثبت‌نام
        // ====================================

        if (isset($result->ok) && $result->ok === true) {

            if ($result_start['register_user'] == '0') {

                $sql = "UPDATE tbl_user
                    SET register_user = '1'
                    WHERE user_id = :user_id";

                $stmt = $telegram->db->prepare($sql);

                $stmt->execute([
                    ':user_id' => $user_id
                ]);
            }
        }
    }

    public static function DisplayStart($user_id, $chat_id, $first_name, $last_name, $user_name)
    {
        $telegram = new telegram();

        // ====================================
        // تصویر خوشامدگویی
        // ====================================

        $photo = 'AgACAgQAAxkBAAIC42rRHJMwWH9QcZhogQwuxGHXsR8xAAKVEWsbw0CRUjBECwvHFy4WAQADAgADeQADPQQ';

        // ====================================
        // متن خوشامدگویی
        // ====================================

        $msg = "<b>سلام. به فروشگاه بازار هوش خوش آمدید.</b> 👋\n\n" .

            "اینجا گسترده‌ترین مرجع تخصصی خرید اکانت پریمیوم ابزارهای هوش‌مصنوعی و پلتفرم های خارجی با رقابتی‌ترین قیمت است. ✨\n\n" .

            "<b>گوشه‌ای از ویژگی‌های فروشگاه بازار هوش:</b>\n" .

            "✅ اشتراک‌های اورجینال و معتبر ⭐️\n" .
            "✅ تحویل در سریع‌ترین زمان ممکن ⚡️\n" .
            "✅ گارانتی‌ با بازه زمانی مناسب 👑\n" .
            "✅ قیمت رقابتی خدمات 💵\n" .
            "✅ پشتیبانی کامل و سریع 24/7 ⏱️\n\n" .

            "<b>فروشگاه بازار هوش از ابتدا تا الان یک شعار داشته:</b>\n\n" .

            "<b>«اینجا تکنولوژی فردا را آسان بخر»</b>";

        // ====================================
        // دکمه ورود به ربات
        // ====================================

        $keyboard = [
            [
                [
                    'text' => 'ورود به ربات |📲',
                    'callback_data' => 'FirstComingToBot'
                ]
            ]
        ];

        // ====================================
        // ارسال عکس و ثبت وضعیت
        // ====================================

        try {

            // ارسال تصویر همراه متن و دکمه
            $result = $telegram->sendPhoto(
                $chat_id,
                $photo,
                $msg,
                $keyboard
            );

            // بررسی موفقیت ارسال عکس
            if (isset($result->ok) && $result->ok === true) {

                // تغییر وضعیت خوشامدگویی به 1
                $sql = "UPDATE tbl_user
                    SET welcome_shown = 1
                    WHERE user_id = :user_id
                    AND welcome_shown = 0";

                $stmt = $telegram->db->prepare($sql);

                $stmt->execute([
                    ':user_id' => $user_id
                ]);

                return true;
            }
        } catch (Exception $e) {

            // ثبت خطا در لاگ سرور
            error_log(
                "DisplayStart Error: " . $e->getMessage()
            );
        }

        return false;
    }
}