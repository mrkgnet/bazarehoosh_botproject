<?php
//require_once 'index.php';
//require_once 'telegram.php';
//require_once 'config.php';
//require_once 'userFunctions.php';
//require_once "jdf.php";
//require_once "endTimeAccoutnUsers_Cronjob.php";

//function disableBot($chat_id, $message_id, $callback_id)
//{
//
//    $telegram = new telegram();
//    $telegram->db->query("update info set disablebot='true'");
//    $txtdiablebot = "ربات برای کاربران غیر فعال شد";
//    $keyboard = [
//        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//    ];
//    $telegram->editMessageText($chat_id, $message_id, $txtdiablebot, $keyboard);
//    $telegram->answerCallbackQuery($callback_id, $txtdiablebot, false);
//}

//function enableBot($chat_id, $message_id, $callback_id)
//{
//    $telegram = new telegram();
//    $telegram->db->query("update info set disablebot='false'");
//    $txtdiablebot = "ربات برای کاربران  فعال شد";
//    $keyboard = [
//        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//    ];
//    $telegram->editMessageText($chat_id, $message_id, $txtdiablebot, $keyboard);
//    $telegram->answerCallbackQuery($callback_id, $txtdiablebot, false);
//}

//function showMsgDisablebot($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $keyboard = [[['text' => 'خیر', 'callback_data' => 'confirm_Notdisablebot'], ['text' => 'بله|تایید', 'callback_data' => 'confirm_disablebot']], [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]];
//    $msgdisable = 'آیا از غیرفعال کردن ربات برای کاربران اطمینان دارید ؟';
//    $telegram->editMessageText($chat_id, $message_id, $msgdisable, $keyboard);
//}

//function showMsgEnablebot($chat_id, $message_id)
//{
//
//    $telegram = new telegram();
//    $telegram->db->query("update users set step = 'falsazi_bot'");
//    $keyboard = [[['text' => 'خیر', 'callback_data' => 'confirm_Notdisablebot'], ['text' => 'بله|تایید', 'callback_data' => 'confirm_enablebot']], [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]];
//    $msgdisable = 'آیا ازفعال کردن ربات برای کاربران اطمینان دارید ؟';
//    $telegram->editMessageText($chat_id, $message_id, $msgdisable, $keyboard);
//}

//function AdminPannelUi($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $telegram->db->query("update users set StepTable= 'modiriat'");
//    $txtAdminPannel = "به پنل مدیریت خوش آمدید لطفا یکی از گزینه های زیر را انتخاب کنید ";
//
//    $keyboard = [
//        [['text' => 'ویرایش اکانت 📌', 'callback_data' => 'Account_Renewal'], ['text' => 'تعریف اکانت 📝', 'callback_data' => 'Account_Definition']],
//        [['text' => 'ارسال پیام تبلیغاتی 📡', 'callback_data' => 'send_advertising_message'], ['text' => 'ارسال پیام به کانال| ⬅️', 'callback_data' => 'sendMessageToChannel']],
//        [['text' => 'خروج🔚', 'callback_data' => 'ExitFromAdminPannel'], ['text' => 'ارسال پیام به یک یوزر خاص 👤 ', 'callback_data' => 'send_message_to_unic_user']], [['text' => 'غیرفعالسازی بات', 'callback_data' => 'disablebot'], ['text' => 'فعالسازی بات', 'callback_data' => 'enablebot']], [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//    ];
//
//
//    $telegram->sendMessage($chat_id, $txtAdminPannel, $keyboard);
//}

//function sendMessageToChannel($chat_id)
//{
//    $telegram = new telegram();
//    $msgSendToChannel = "لطفا یکی از گزینه های زیر را انتخاب کنید";
//    $keyboard = [
//        [['text' => 'ارسال متن و تصویر', 'callback_data' => 'sendTextAndImage'], ['text' => 'ارسال فقط متن', 'callback_data' => 'sendTextOnly']]
//    ];
//    $telegram->sendMessage($chat_id, $msgSendToChannel, $keyboard);
//}

//function sendTextOnly($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $msgSendToChannel = "لطفا متن خود را جهت ارسال در کانال ارسال کنید";
//    $keyboard = [
//        [['text' => 'بازگشت', 'callback_data' => 'index']]
//    ];
//    $telegram->editMessageText($chat_id, $message_id, $msgSendToChannel, $keyboard);
//}

//function fetchTextChannel($chat_id)
//{
//
//    $telegram = new telegram();
//    $resFetch = $telegram->db->query("SELECT * FROM users")->fetch();
//
//    $keyboard = [
//        [['text' => 'ویرایش', 'callback_data' => 'editTxtChannel'], ['text' => 'تایید|ارسال✅', 'callback_data' => 'confirmSendToChannel']],
//        [['text' => 'بازگشت', 'callback_data' => 'index']]
//    ];
//    $telegram->sendMessage($chat_id, $resFetch['sendTextOnly'], $keyboard);
//}

//function confirmSendToChannel($callback_id)
//{
//    $telegram = new telegram();
//    $txtCallBack = "پیام با موفقیت ارسال شد|✅";
//    $telegram->answerCallbackQuery($callback_id, $txtCallBack, 'true');
//    $resFetch = $telegram->db->query("SELECT * FROM users")->fetch();
//    $keyboard = [
//        [['text' => 'ربات جهت خرید|🤖', 'url' => 'https://t.me/abzarvpnbot']],
//        [['text' => 'ارتباط با ادمین|👨🏻‍💻', 'url' => 'https://t.me/abzarvpn_admin1']]
//    ];
//    $telegram->sendMessage('-1001947887061', $resFetch['sendTextOnly'], $keyboard);
//}

//function AdminPannelUi_EditMsgText($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $telegram->db->query("update users set StepTable= 'modiriat'");
//    $txtAdminPannel = "به پنل مدیریت خوش آمدید لطفا یکی از گزینه های زیر را انتخاب کنید ";
//
//    $keyboard = [
//        [['text' => 'ویرایش اکانت 📌', 'callback_data' => 'Account_Renewal'], ['text' => 'تعریف اکانت 📝', 'callback_data' => 'Account_Definition']],
//        [['text' => 'ارسال پیام تبلیغاتی 📡', 'callback_data' => 'send_advertising_message'], ['text' => 'ارسال پیام به کانال| ⬅️', 'callback_data' => 'sendMessageToChannel']],
//        [['text' => 'خروج🔚', 'callback_data' => 'ExitFromAdminPannel'], ['text' => 'ارسال پیام به یک یوزر خاص 👤 ', 'callback_data' => 'send_message_to_unic_user']], [['text' => 'غیرفعالسازی بات', 'callback_data' => 'disablebot'], ['text' => 'فعالسازی بات', 'callback_data' => 'enablebot']], [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//    ];
//
//    $telegram->editMessageText($chat_id, $message_id, $txtAdminPannel, $keyboard);
//
//
//}

// این تابع به منظور ویرایش اطلاعات کاربر مورد استفاده قرار می گیرد
//function virayeshEtelatUsers($chat_id, $text_message)
//{
//    $telegram = new telegram();
//    $userprofile = explode(':', $text_message);
//    if (($userprofile[0] == null) || ($userprofile[1] == null) || ($userprofile[2] == null)) {
//        $msg = "نام کاربری یا پسورد یا روز به درستی وارد نشده است لطفا مطابق فرمت زیر اطلاعات را وارد کنید " . "\n" . "-------------------------------------------" . "\n" . '<code>' . 'username:password:day' . '</code>' . "\n" . "برای مثال : " . "\n" . "ali:99003:31" . "\n" . "-------------------------------------------";
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => $msg,
//            'parse_mode' => "HTML",
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [['text' => 'بازگشت 🔙', 'callback_data' => 'index']],
//                ]
//            ])
//        ]);
//
//
//    } else {
//        $userpro = strtolower(trim($userprofile[0]));
//        // $chRows= $telegram->db->query("select * from users")->fetch();
//        $chRows = $telegram->db->query("select * from users where username like '$userpro'")->fetch();
//        if ($chRows == null) {
//            $step = 'virayeshe_etelaate_user_dar_db';
//            $stepTable = 'modiriat';
//            $telegram->db->query("insert into users (username , password, days , step , StepTable) values('" . $userpro . "','" . $userprofile[1] . "','" . $userprofile[2] . "','" . $step . "','" . $stepTable . "')");
//
//
//            $rows = $telegram->db->query("select * from users where username like '$userpro'")->fetch();
//            $msg = "مشخصات اکانت شما شامل موارد زیر است." . "\n" . "username: " . '<code>' . $rows['username'] . '</code>' . "\n" . "password: " . '<code>' . $userprofile[1] . '</code>' . "\n" . "days: " . '<code>' . $userprofile[2] . '</code>';
//            $telegram->excCurl(apiUrl . 'sendMessage', [
//                'chat_id' => $chat_id,
//                'text' => $msg,
//                'parse_mode' => "HTML",
//                'reply_markup' => json_encode([
//                    'inline_keyboard' => [
//                        [['text' => 'ویرایش ✏️', 'callback_data' => 'EditTextUserProfile'], ['text' => 'ثبت اطلاعات | تایید ✅', 'callback_data' => 'InsertUserProfielToDbUsers']],
//                        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//                    ]
//                ])
//            ]);
//
//
//        } else {
//            $telegram->db->query("update users set  username = '$userpro',  password= '$userprofile[1]' , days = '$userprofile[2]' where username like '$userpro'");
//
//            $rows = $telegram->db->query("select * from users where username like '$userpro'")->fetch();
//            $msg = "مشخصات اکانت شما شامل موارد زیر است." . "\n" . "username: " . '<code>' . $rows['username'] . '</code>' . "\n" . "password: " . '<code>' . $userprofile[1] . '</code>' . "\n" . "days: " . '<code>' . $userprofile[2] . '</code>';
//            $telegram->excCurl(apiUrl . 'sendMessage', [
//                'chat_id' => $chat_id,
//                'text' => $msg,
//                'parse_mode' => "HTML",
//                'reply_markup' => json_encode([
//                    'inline_keyboard' => [
//                        [['text' => 'ویرایش ✏️', 'callback_data' => 'EditTextUserProfile'], ['text' => 'ثبت اطلاعات | تایید ✅', 'callback_data' => 'InsertUserProfielToDbUsers']],
//                        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//                    ]
//                ])
//            ]);
//        }
//
//
//    }
//
//}

//function Account_Definition($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $msg = "لطفا مشخصات کاربر جدید را به فرمت زیر ارسال کنید" . "\n" . "\n" . '<code>' . 'username:password:days' . '</code>' . "\n" . "\n";
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => $msg,
//        'parse_mode' => "HTML",
//        'message_id' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'index']],
//            ]
//        ])
//
//    ]);
//}

//function InsertDataToDBUsers($chat_id, $text_message)
//{
//    $telegram = new telegram();
//    $userprofile = explode(':', $text_message);
//    if (($userprofile[0] == null) || ($userprofile[1] == null) || ($userprofile[2] == null)) {
//        $msg = "نام کاربری یا پسورد یا روز به درستی وارد نشده است لطفا مطابق فرمت زیر اطلاعات را وارد کنید " . "\n" . "-------------------------------------------" . "\n" . '<code>' . 'username:password:day' . '</code>' . "\n" . "برای مثال : " . "\n" . "ali:99003:31" . "\n" . "-------------------------------------------";
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => $msg,
//            'parse_mode' => "HTML",
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [['text' => 'بازگشت 🔙', 'callback_data' => 'index']],
//                ]
//            ])
//        ]);
//
//
//    } else {
//        $userpro = strtolower(trim($userprofile[0]));
//
//
//        $rows = $telegram->db->query("select users.username from users where username like '$userpro'")->fetch();
//        if ($rows['username'] == $userpro) {
//            $telegram->excCurl(apiUrl . 'sendMessage', [
//                'chat_id' => $chat_id,
//                'parse_mode' => "HTML",
//                'text' => 'نام کاربری وارد شده قبلا در سیستم موجود است ',
//                'reply_markup' => json_encode([
//                    'inline_keyboard' => [
//                        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']],
//                    ]
//                ])
//            ]);
//        } else {
//            $msg = "مشخصات اکانت شما شامل موارد زیر است." . "\n" . "username: " . '<code>' . $userpro . '</code>' . "\n" . "password: " . '<code>' . $userprofile[1] . '</code>' . "\n" . "days: " . '<code>' . $userprofile[2] . '</code>';
//            $telegram->excCurl(apiUrl . 'sendMessage', [
//                'chat_id' => $chat_id,
//                'text' => $msg,
//                'parse_mode' => "HTML",
//                'reply_markup' => json_encode([
//                    'inline_keyboard' => [
//                        [['text' => 'ویرایش ✏️', 'callback_data' => 'EditTextUserProfile'], ['text' => 'ثبت اطلاعات | تایید ✅', 'callback_data' => 'InsertUserProfielToDbUsers']],
//                        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//                    ]
//                ])
//            ]);
//            $telegram->db->query("insert into users (username , password ,days,ActiveUser) values ('" . $userpro . "','" . $userprofile[1] . "','" . $userprofile[2] . "' , 'true') ");
//        }
//    }
//}

//function InsertUserProfielToDbUsers($chat_id, $message_id, $callback_id)
//{
//    $telegram = new telegram();
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => 'اطلاعات با موفقیت ذخیره شد ',
//        'message_id' => $message_id,
//        'parse_mode' => "HTML",
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//            ]
//        ])
//    ]);
//
//
//    $telegram->excCurl(apiUrl . 'answerCallbackQuery', [
//        'callback_query_id' => $callback_id,
//        'text' => 'اطلاعات با موفقیت ذخیره شد ✅ ',
//        'show_alert=' => true
//    ]);
//
//
//}

//function Account_RenewalTBLUsers($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $msg = "لطفا یکی از گزینه های زیر را انتخاب کنید ";
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => $msg,
//        'message_id' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'حذف یوزر ✏️', 'callback_data' => 'ِDeleteUserProfile'], ['text' => 'تمدید تاریخ ⏳', 'callback_data' => 'Time_Extension']], [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//            ]
//        ])
//    ]);
//}

//function ِDeleteUserProfile($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $telegram->db->query("update users set step ='delete_users_account' , show_msg_delete='true'");
//    $msg = "نام کاربری یوزری را که می خواهید حذف کنید را ارسال کنید";
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => $msg,
//        'message_id' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//            ]
//        ])
//    ]);
//
//
//}

//این تابع برای حذف مشخصات یوزر از پایگاه داده می باشد
//function DeleteRecordProfileFromUsers($chat_id, $message_id, $text_message)
//{
//    $telegram = new telegram();
//
//    //  $txtExpload = explode(":", $text_message);
//
//    $rows = $telegram->db->query("select * from users  where username like '$text_message'")->fetch();
//    if ($rows['username'] == null) {
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => 'نام کاربری با مشخصات فوق یافت نشد',
//            'message_id' => $message_id,
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//                ]
//            ])
//        ]);
//        //$telegram->db->query("delete from users where username like '$text_message'");
//    } else {
//        $telegram->db->query("DELETE FROM users WHERE username like '$text_message' ");
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => 'کاربر با موفقیت حذف شد',
//            'message_id=' => $message_id,
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//                ]
//            ])
//        ]);
//
//    }
//}

//function Time_Extention($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $text = "نام کاربری و روز را وارد کنید " . "\n" . "username:days";
//    $keyboard = [
//        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//    ];
//    $telegram->editMessageText($chat_id, $message_id, $text, $keyboard);
//}

//function SearchUser_Time_Extention($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id)
//{
//    $telegram = new telegram();
//    $rows = $telegram->db->query("select * from users where username like '$text_message'")->fetch();
//    if ($rows['username'] == $text_message) {
//        $msg = "مشخصات اکانت شما شامل موارد زیر است." . "\n" . "username: " . '<code>' . $rows['username'] . '</code>' . "\n" . "password: " . '<code>' . $rows['password'] . '</code>' . "\n" . "days: " . '<code>' . $rows['days'] . '</code>' . "\n" . "\n" . '<b>' . 'برای تمدید' . '</b>' . "\n" . "نام کاربری پسورد و روز را مطابق با فرمت زیر ارسال کنید:  " . "\n" . "----------------------------" . "\n" . '<code>' . 'username:password:days' . '</code>' . "\n" . "----------------------------" . "\n";
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => $msg,
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//                ]
//            ])
//        ]);
//    } else {
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => 'نام کاربری وارد شده اشتباه است',
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//                ]
//            ])
//        ]);
//    }
//
//
//}

//تابع مربوط به تمدید تاریخ در پنل مدیریت
//function Tamdid_Tarikh_TBL_Users($chat_id, $text_message)
//{
//    $telegram = new telegram();
//    //$userpro = strtolower(trim($userprofile[0]))
//    $text_message = trim($text_message);
//    $txt_tamdid = (explode(':', $text_message));
//    $txt_tamdid[0] = strtolower($txt_tamdid[0]);
//    $txt_tamdid[1] = strtolower($txt_tamdid[1]);
//    // $txt_tamdid= strtolower($txt_tamdid);
//    // $telegram->sendMessage($chat_id,$txt_tamdid[0]);
//    $rows_search = $telegram->db->query("select username from users where username like '$txt_tamdid[0]'")->fetch();
//
//    if (($txt_tamdid[0] == null) || ($txt_tamdid[1] == null)) {
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => 'نام کاربری یا پسورد یا روز وارد نشده لطفا مجدد و به صورت username:days اطلاعات را وارد کنید ',
//            'reply_markup' => json_encode([
//                'inline_keyboard' => [
//                    [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//                ]
//            ])
//        ]);
//
//    } else {
//        if ($rows_search['username'] == null) {
//            $telegram->excCurl(apiUrl . 'sendMessage', [
//                'chat_id' => $chat_id,
//                'text' => 'نام کاربری شما قبلا ثبت نشده است ',
//                'reply_markup' => json_encode([
//                    'inline_keyboard' => [
//                        [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//                    ]
//                ])
//            ]);
//        } else {
//            //  $telegram->db->query("update users set  days='$txt_tamdid[1]' where username like '$txt_tamdid[0]'");
//
//            $endTimeUesr = $txt_tamdid[1];
//            $new_data = time() + ($endTimeUesr * 24 * 3600);
//            $date_user = date('Y-m-d', $new_data);
//            $time_fa = explode('-', $date_user);
//            $expire_time_fa = gregorian_to_jalali($time_fa[0],$time_fa[1],$time_fa[2],'-');
//            // $telegram->sendMessage($chat_id, gregorian_to_jalali($time_fa[0],$time_fa[1],$time_fa[2],'-') );
//            $searchRow = $telegram->db->query("select * from users where username like '$txt_tamdid[0]'")->fetch();
//            $txtSearch = "مشخصات یوزرشما شامل موارد زیر است" . "\n" . "username = " . $txt_tamdid[0] . "\n" . "password = " . $searchRow['password'] . "\n" . "days = " . $txt_tamdid[1];
//            $keyboard = [
//                [['text' => 'ویرایش', 'callback_data' => 'confirmUserDay'], ['text' => 'تایید', 'callback_data' => 'confirmUserDay']]
//            ];
//            $telegram->sendMessage($chat_id, $txtSearch, $keyboard);
//
//            $telegram->db->query("update users set expire_time_en ='$date_user', expire_time_fa='$expire_time_fa' where username like '$txt_tamdid[0]'");
//            $telegram->sendMessage($chat_id, $date_user."  ".$expire_time_fa);
//            //$telegram->sendMessage($chat_id , $date_user);
//
//
//        }
//
//
//    }
//}

//function confirmUserDay($chat_id, $message_id, $callback_id)
//{
//    $telegram = new telegram();
//    $txtEdit = "اطلاعات با موفقیت بروزرسانی شد ";
//    $keyboard = [
//        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//    ];
//    $telegram->editMessageText($chat_id, $message_id, $txtEdit, $keyboard);
//    $telegram->answerCallbackQuery($callback_id, $txtEdit, 'true');
//}

//function Display_Volume_Message($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $msg = 'آیا از ارسال پیام به تمام کاربران اطمینان دارید؟ ';
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => $msg,
//        'message_id' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'index'], ['text' => 'ارسال پیام| تایید✅ ', 'callback_data' => 'comfirm_to_send_volume']]
//            ]
//        ])
//    ]);
//}

//function DisplyConfirmTablighati($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => 'لطفا متن تبلیغاتی خود را وارد کنید و ارسال کنید  ',
//        'message_id' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//            ]
//        ])
//    ]);
//
//}

//function ShowMsgTablighati($chat_id, $user_id, $text_message)
//{
//    $telegram = new telegram();
//    $telegram->excCurl(apiUrl . 'sendMessage', [
//        'chat_id' => $chat_id,
//        'text' => $text_message,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => ' ویرایش ✏️', 'callback_data' => 'edit_send_text_advertising'], ['text' => ' تایید ارسال به کاربران ✅', 'callback_data' => 'send_advertising_to_allusers']],
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//            ]
//        ])
//    ]);
//    $telegram->db->query("UPDATE  info SET txt_advertise = '$text_message' , is_send = 'true' WHERE user_id=" . $user_id);
//}

//function SendPayameTablighatiToAllUsers($chat_id, $text_message)
//{
//    $telegram = new telegram();
//    $rows = $telegram->db->query("select * from info ")->fetch();
//    $telegram->excCurl(apiUrl . 'sendMessage', [
//        'chat_id' => $chat_id,
//        'text' => $text_message,
//        //'message_id=' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => ' ویرایش ✏️', 'callback_data' => 'edit_send_text_advertising'], ['text' => ' تایید ارسال به کاربران ✅', 'callback_data' => 'send_advertising_to_allusers']],
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//            ]
//        ])
//    ]);
//
//    foreach ($rows as $item) {
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $item['chat_id'],
//            'text' => $item['txt_advertise'],
//            //'message_id=' => $message_id,
//        ]);
//    }
//}

//function GetUserNameUnic($chat_id, $message_id)
//{
//    $telegram = new telegram();
//    $rows = $telegram->db->query("select * from users")->fetchAll();
//    $msgUsers = '';
//    $paging = 0;
//    foreach ($rows as $row) {
//        $msgUsers .= '/' . $row['username'] . "\n" . "----------------------------" . "\n";
//        $paging++;
//
//    }
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => $msgUsers,
//        'message_id' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [
//                    ['text' => 'صفحه قبل 🔙', 'callback_data' => 'prev_page'], ['text' => 'صفحه بعد  🔙', 'callback_data' => 'next_page']
//
//                ],
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
//            ]
//        ])
//    ]);
//}
//
//function SearchUninUserInDB($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id)
//{
//    $telegram = new telegram();
//    $rows1 = $telegram->db->query("select info.first_name,info.user_id,  users.username , users.password , info.chat_id  FROM info inner join users on info.username = users.username  ")->fetch();
//
//    $telegram->excCurl(apiUrl . 'sendMessage', [
//        'chat_id' => $chat_id,
//        'text' => 'وارد شlklklدی',
//    ]);
//    if ($rows1['username'] == $text_message) {
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => 'وارد شدی',
//        ]);
//
//        $msg = "مشخصات اکانت شما شامل موارد زیر است." . "\n" . "username: " . '<code>' . $rows1['username'] . '</code>' . "\n" . "password: " . '<code>' . $rows1['password'] . '</code>' . "\n" . "days: " . '<code>' . $rows1['days'] . "\n" . '</code>' . "userid: " . '<code>' . $rows1['user_id'] . '</code>' . "\n";
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => $msg,
//        ]);
//
//    } else {
//        $msg = 'مشخصات وارد شده در پایگاه داده وجود ندارد';
//        $telegram->excCurl(apiUrl . 'sendMessage', [
//            'chat_id' => $chat_id,
//            'text' => $msg,
//        ]);
//
//    }
//
//
//}
//
//function ConfirmToFetchData($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id)
//{
//    $telegram = new telegram();
//
//    $msg = 'لطفا متن خود را نوشته و ارسال کنید ';
//
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => $msg,
//        'message_id=' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser']]
//            ]
//        ])
//    ]);
//
//}

//function DisplayMsgToUnicUser($chat_id, $user_id, $text_message, $first_name, $last_name, $user_name, $message_id)
//{
//    $telegram = new telegram();
//    $telegram->db->query("update info set  txt_msg_to_unic_user = '$text_message'  ")->fetch();
//    $rows2 = $telegram->db->query("select * from info")->fetch();
//    $msg = "متن شما به شرح زیر است آیا از ارسال آن اطمینان دارید:" . "\n" . "------------------------" . "\n" . $rows2['txt_msg_to_unic_user'] . "\n" . "------------------------" . "\n" . "یوزر دریاف کننده پیام: " . '<code>' . $rows2['username'] . '</code>';
//    $telegram->excCurl(apiUrl . 'editMessageText', [
//        'chat_id' => $chat_id,
//        'text' => $msg,
//        'message_id=' => $message_id,
//        'reply_markup' => json_encode([
//            'inline_keyboard' => [
//                [['text' => 'بازگشت 🔙', 'callback_data' => 'backStepInsertUser'], ['text' => 'تایید ارسال ✅', 'callback_data' => 'SentFinallMessageToUnicUser']]
//            ]
//        ])
//    ]);
//}

//function taeede_ersale_payame_tabligi($chat_id, $message_id, $callback_id)
//{
//    $telegram = new telegram();
//
//    $rows = $telegram->db->query("select * from info ")->fetchAll();
//    $txtAdd = $telegram->db->query("select * from users")->fetch();
//    if ($txtAdd['txt_advertise'] != null) {
//
//        foreach ($rows as $row) {
//            $telegram->sendMessage($row['chat_id'], $txtAdd['txt_advertise']);
//
//        }
//    }
//
//
//}


?>
