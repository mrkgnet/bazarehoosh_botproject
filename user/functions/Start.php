<?php

class Start
{
    public static function Index($user_id, $message_id)
    {
        $telegram = new telegram();

        $telegram->sendMessage(
            $user_id,
            "✅ کلاس Start با موفقیت اجرا شد."
        );
    }
}