<?php
require_once 'index.php';
require_once 'jdf.php';
//require_once 'config_bot/config.php';
require_once 'telegram.php';
//require_once "addminFunctions.php";
// require_once "endTimeAccoutnUsers_Cronjob.php";
function ComingToBot_SendMsg_v2ray($chat_id, $message_id)
{
    $telegram = new telegram();

    $msg = "<b>لطفا سیستم عامل مورد نظر خود را انتخاب کنید </b>"."\n".'📞| به هر دلیلی در نصب و راه اندازی مشکل داشتید با ادمین در ارتباط باشید '."\n"."\n"
        ."===========📛📛=========="."\n"."\n"."<b> 📛: در هر مرحله و به هر دلیلی ربات دچار هنگی شد مجدد گزینه خانه(🏘) در پایین را فشاردهید تا مجدد ربات راه اندازی شود و عملیات مورد نظر را انجام دهید </b>";
    $keyboard=[
        [ ['text' => 'آیفون|📲 ', 'callback_data' => 'send1_video_iphone_v2ray'],['text' => 'اندروید|📱', 'callback_data' => 'send_video_android_v2ray']]
        , [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1'], ['text' => 'ویندوز|💻', 'callback_data' => 'send_video_windows_v2ray']],
        [['text' => 'بازگشت 🔙', 'callback_data' => 'index'], ['text' => 'خانه|🏘 🔙', 'callback_data' => 'home']]
    ];

    $telegram->editMessageText($chat_id,$message_id,$msg,$keyboard);



}

function SendVideoIphone_v2ray($chat_id)
{
    $telegram = new telegram();

    $dlFile = 'https://t.me/abzarvpn/226';
    $caption='مطابق با تصاویر زیر نصب و راه اندازی کنید '."\n"."\n"
        ." لینک دانلود نرم افزار|👇👇👇👇 "."\n"."\n".$dlFile;
    $photoFileId_1='AgACAgQAAxkBAAIswWZcvUtYTmHUnWSWr5EdSkH5VSHPAAJ8xTEbuAEhUfVmmUCZdrZyAQADAgADeQADNQQ';
    $photoFileId_2='AgACAgQAAxkBAAIswWZcvUtYTmHUnWSWr5EdSkH5VSHPAAJ8xTEbuAEhUfVmmUCZdrZyAQADAgADeQADNQQ';
    $keyboard = [
        [['text' => 'خانه|🏘 🔙', 'callback_data' => 'homeLearning']]
    ];
    $photoFileId_attr=[$photoFileId_1, $photoFileId_2];
    foreach ($photoFileId_attr as $item) {
        $telegram->sendPhoto($chat_id,$item,$caption ,$keyboard);
    }

}

function SendVideoَAndroid_v2ray($chat_id)
{
    $telegram = new telegram();
    $dlFile = 'https://t.me/abzarvpn/226';
    $caption='مطابق با تصاویر زیر نصب و راه اندازی کنید '."\n"."\n"
        ." لینک دانلود نرم افزار|👇👇👇👇 "."\n"."\n".$dlFile;
    $photoFileId_1='AgACAgQAAxkBAAIswWZcvUtYTmHUnWSWr5EdSkH5VSHPAAJ8xTEbuAEhUfVmmUCZdrZyAQADAgADeQADNQQ';
    $photoFileId_2='AgACAgQAAxkBAAIswWZcvUtYTmHUnWSWr5EdSkH5VSHPAAJ8xTEbuAEhUfVmmUCZdrZyAQADAgADeQADNQQ';
    $keyboard = [
        [['text' => 'خانه|🏘 🔙', 'callback_data' => 'homeLearning']]
    ];
    $photoFileId_attr=[$photoFileId_1, $photoFileId_2];
    foreach ($photoFileId_attr as $item) {
        $telegram->sendPhoto($chat_id,$item,$caption ,$keyboard);
    }



}

function SendVideoَWindows_v2ray($chat_id,$message_id)
{
    $telegram = new telegram();
    $keyboard=[
        [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']],
        [['text' => 'خانه|🏘 🔙', 'callback_data' => 'homeLearning']]
    ];
$telegram->editMessageText($chat_id,$message_id,"برای دریافت راهنمایی به پشتیبانی پیام دهید",$keyboard);
}

function v2ray_pricing($chat_id, $message_id)
{
    $telegram = new telegram();
    $msg = '<b>'." 📣| سرویس فوق العاده سریع ویتوری|v2ray به صورت حجمی ارائه می شود"
        ."\n"."👨‍👨‍👦| بدون محدودیت کاربر"
        ."\n"."⏰| قابلیت مدیریت حجم و زمان به صورت پویا در داخل اپلیکیشن".
        "\n"."✅| حجم دلخواه به ازای هر گیگ 1500 تومان"."\n"."✅| جهت خرید از طریق دکمه زیر (ارتباط با ادمین)به پشتیبانی پیام دهید ".'</b>';
    $keyboard = [

        [['text' => 'ارتباط با ادمین|👨🏻‍💻 ', 'url' => 'https://t.me/abzarvpn_admin1']],
        [['text' => 'بازگشت 🔙', 'callback_data' => 'index']]
        //, ['text' => 'تعرفه قیمت ها|💰', 'callback_data' => 'pricing']

    ];
    $telegram->editMessageText($chat_id, $message_id, $msg, $keyboard);
}


