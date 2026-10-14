<?php
require_once 'index.php';
require_once 'jdf.php';
require_once 'config.php';
require_once 'telegram.php';
//require_once "addminFunctions.php";
// require_once "endTimeAccoutnUsers_Cronjob.php";


function ComingToBot_SendMsg($chat_id, $message_id)
{
    $telegram = new telegram();

    $msg = "<b>لطفا سیستم عامل مورد نظر خود را انتخاب کنید </b>"."\n".'📞| به هر دلیلی در نصب و راه اندازی مشکل داشتید با ادمین در ارتباط باشید '."\n"."\n"
        ."===========📛📛=========="."\n"."\n"."<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
    $keyboard =[
        [['text' => 'آیفون|📲 ', 'callback_data' => 'send_video_iphone'],['text' => 'اندروید|📱', 'callback_data' => 'send_video_android'] ]
        , [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1'], ['text' => 'ویندوز|💻', 'callback_data' => 'send_video_windows']],
        [['text' => 'بازگشت 🔙', 'callback_data' => 'index'], ['text' => 'خانه|🏘 🔙', 'callback_data' => 'home']]
    ];
    $telegram->editMessageText($chat_id,$message_id,$msg,$keyboard) ;



}

function SendVideoIphone($chat_id, $message_id)
{
    $telegram = new telegram();
    $rows = $telegram->db->query("select * from files ")->fetch();
    $video_iphone = $rows['video_iphone'];
    $caption_iphone ='برای دانلود فایل  ازآپ استور ایفون  روی دکمه  زیر کلیک کنید '
        ."\n"."\n"
        ."===========📛📛=========="."\n"."\n"."📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید " ;
    $keyboard = [
        [['text' => '📎|دانلود از گوگل پلی ', 'url' => 'https://apps.apple.com/us/app/napsternetv/id1629465476']]
        ,
        [['text' => 'خانه|🏘 🔙', 'callback_data' => 'homeLearning']]
    ];
    $telegram->sendAnimation($chat_id,$caption_iphone,$video_iphone,$keyboard );



}

function SendVideoَAndroid($chat_id)
{
    $telegram = new telegram();
    $rows = $telegram->db->query("select * from files ")->fetch();
    $video_android = $rows['fileID_video_android'];
    //  $msg = "BAACAgQAAxkBAAIa2WUxLaSBV_ERl2AssFGptUCNRwrkAAJDDgAC4atxUmYj6Fy7bXCSMAQ";
//    $caption_android = $rows['caption_android'];
    $caption_android = 'برای دانلود فایل هم به صورت مستقیم هم به صورت دانلود از استور گوگلی پلی روی دکمه های زیر کلیک کنید '
        ."\n"."\n"
        ."===========📛📛=========="."\n"."\n"."📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید ";
    $keyboard=[
        [['text' => '📎|دانلود از گوگل پلی ⏬ ', 'url' => 'https://play.google.com/store/apps/details?id=com.napsternetlabs.napsternetv']]
        ,[['text' => ' 📎|دانلود به صورت مستقیم ⏬', 'url' => 'https://t.me/abzarvpn/114']],
         [['text' => 'خانه|🏘 🔙', 'callback_data' => 'homeLearning']]
    ];

    $telegram->sendAnimation($chat_id,$caption_android,$video_android,$keyboard );
}

function SendVideoَWindows($chat_id)
{
    $telegram = new telegram();
    $rows = $telegram->db->query("select * from files ")->fetch();
    $video_android = $rows['fileID_video_windows'];
    //$msg = "BAACAgQAAxkBAAIa2WUxLaSBV_ERl2AssFGptUCNRwrkAAJDDgAC4atxUmYj6Fy7bXCSMAQ";
    $caption_windows = $rows['caption_windows'];
    $keyboard= [
        [['text' => ' 📎|دانلود به صورت مستقیم ⏬', 'url' => 'https://t.me/abzarvpn/156']],
        [['text' => 'خانه|🏘 🔙', 'callback_data' => 'homeLearning']]
    ];
    $telegram->sendAnimation($chat_id,$caption_windows,$video_android,$keyboard );
}

function Pricing($chat_id, $message_id)
{
    $telegram = new telegram();
    $msg = "<b>با توجه به حجم و زمان مصرفی خودتان یک  مورد را انتخاب و با ادمین در ارتباط باشید </b>:"."\n"."\n".
        "<b>📣📣| یک ماهه</b>:" . "\n" .
        "\n" . "تعداد کاربر       <pre></pre>" . "|" . "    حجم        " . "|" . "    قیمت        "
        .
        "\n" . "تک کاربره         " . "|" . "   نامحدود     " . "|" . "  89,000 تومان"
        .
        "\n" . "دو کاربره         " . "|" . "   نامحدود     " . "|" . " 109,000 تومان" . "\n"."==================="."\n"."\n".
        "<b>📣📣| دو ماهه</b>:" . "\n" .
        "\n" . "تعداد کاربر       <pre></pre>" . "|" . "    حجم        " . "|" . "    قیمت        "
        .
        "\n" . "تک کاربره         " . "|" . "   نامحدود     " . "|" . "  178,000 تومان"
        .
        "\n" . "دو کاربره         " . "|" . "   نامحدود     " . "|" . " 198,000 تومان" . "\n"."==================="."\n"."\n".
        "<b>📣📣| سه ماهه</b>:" . "\n" .
        "\n" . "تعداد کاربر       <pre></pre>" . "|" . "    حجم        " . "|" . "    قیمت        "
        .
        "\n" . "تک کاربره         " . "|" . "   نامحدود     " . "|" . "  267,000 تومان"
        .
        "\n" . "دو کاربره         " . "|" . "   نامحدود     " . "|" . " 278,000 تومان" . "\n"."==================="

        ."\n"."\n"
        ."===========📛📛=========="."\n"."\n"."<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>"
    ;
    $telegram->excCurl(apiUrl . 'editMessageText', [
        'chat_id' => $chat_id,
        'text' => $msg,
        'parse_mode' => "html",
        'message_id' => $message_id,
        'reply_markup' => json_encode([
            'inline_keyboard' => [

                [['text' => 'مدت زمان دلخواه|🎖', 'url' => 'https://t.me/abzarvpn_admin1']], [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
            ]
        ])

    ]);


}