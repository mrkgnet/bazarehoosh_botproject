<?php

class telegram
{
    public $db;
    public $name;
    public $dbname = 'bazareho_mrkgviph_sample_1';
    public $dbuser = 'bazareho_mrkgviph_sample_1';
    public $dbpass = 'dwt~%}_Yz-N4LZo$';
    public static $isTested = false;

    public function __construct()
    {
        $data = json_decode(file_get_contents("php://input"));
        $chatid = isset($data->message->chat->id) ? $data->message->chat->id : null;
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=' . $this->dbname, $this->dbuser, $this->dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8mb4"'));
            
            // ارسال پیام در صورت موفقیت‌آمیز بودن اتصال به دیتابیس (فقط یک بار در هر پیام)
            if ($chatid && !self::$isTested) {
                self::$isTested = true;
                $this->excCurl(apiUrl . 'sendMessage', [
                    'chat_id' => $chatid,
                    'text' => "✅✅ اتصال به دیتابیس با موفقیت برقرار است."
                ]);
            }
        } catch (PDOException $e) {
            if ($chatid && !self::$isTested) {
                self::$isTested = true;
                $this->excCurl(apiUrl . 'sendMessage', [
                    'chat_id' => $chatid,
                    'text' => "❌ خطا در برقراری ارتباط با پایگاه داده:\n" . $e->getMessage()
                ]);
            }
        }
    }

    // تابع بدست آوردن ای پی کلاینت
    public function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function sendMessage($chat_id, $text, $keyboard = null)
    {
        $fileds = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => "HTML"
        ];
        if ($keyboard != null) {
            $fileds['reply_markup'] = $this->makeInlineButton($keyboard);
        }
        return $this->excCurl(apiUrl . 'sendMessage', $fileds);
    }

    public function makeInlineButton($keyboard)
    {
        $keyboard = ['inline_keyboard' => $keyboard];
        return json_encode($keyboard);
    }

    public function getChatMember($chat_id, $user_id)
    {
        $fields = [
            'chat_id' => $chat_id,
            'user_id' => $user_id
        ];
        $getChat = ($this->excCurl(apiUrl . 'getChatMember', $fields));
        return $getChat->result->status;
    }

    public function getChatMemberCount($chat_id)
    {
        $fields = [
            'chat_id' => $chat_id
        ];
        $getChatMemberCount = $this->excCurl(apiUrl . 'getChatMemberCount', $fields);
        return $getChatMemberCount->result;
    }

    public function answerCallbackQuery($callback_query_id, $text, $show_alert)
    {
        $fileds = [
            'callback_query_id' => $callback_query_id,
            'text' => $text,
            'parse_mode' => "HTML",
            'show_alert' => $show_alert
        ];
        return $this->excCurl(apiUrl . 'answerCallbackQuery', $fileds);
    }

    public function editMessageText($chat_id, $message_id, $text, $keyboard = null)
    {
        $fileds = [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => $text,
            'parse_mode' => "HTML"
        ];
        if ($keyboard != null) {
            $fileds['reply_markup'] = $this->makeInlineButton($keyboard);
        }
        return $this->excCurl(apiUrl . 'editMessageText', $fileds);
    }

    public function deleteMessage($chat_id, $message_id)
    {
        $fileds = [
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ];
        return $this->excCurl(apiUrl . 'deleteMessage', $fileds);
    }

    public function sendPhoto($chat_id, $photoFileID, $caption, $keyboard = null)
    {
        $fields = [
            'chat_id' => $chat_id,
            'photo' => $photoFileID,
            'caption' => $caption,
            'parse_mode' => "HTML"
        ];
        if ($keyboard != null) {
            $fields['reply_markup'] = $this->makeInlineButton($keyboard);
        }
        return $this->excCurl(apiUrl . 'sendPhoto', $fields);
    }

    public function sendChatAction($chat_id, $action)
    {
        $fileds = [
            'chat_id' => $chat_id,
            'action' => $action
        ];
        return $this->excCurl(apiUrl . 'sendChatAction', $fileds);
    }

    public function sendAnimation($chat_id, $caption, $fileIDAnimation, $keyboard = null)
    {
        $fields = [
            'chat_id' => $chat_id,
            'animation' => $fileIDAnimation,
            'caption' => $caption
        ];
        if ($keyboard != null) {
            $fields['reply_markup'] = $this->makeInlineButton($keyboard);
        }
        return $this->excCurl(apiUrl . 'sendAnimation', $fields);
    }

    public function replyKeyboardRemove($chat_id, $text)
    {
        $fileds = [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => json_encode([
                'remove_keyboard' => true,
                'selective' => true
            ])
        ];
        return $this->excCurl(apiUrl . 'sendMessage', $fileds);
    }

    public function sendMessage2($chat_id, $text, $keyboard = null)
    {
        $fileds = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => "HTML"
        ];
        if ($keyboard != null) {
            $fileds['reply_markup'] = json_encode([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => false,
                'selective' => false
            ]);
        }
        return $this->excCurl(apiUrl . 'sendMessage', $fileds);
    }

    public function forceReply($chat_id, $text)
    {
        $fileds = [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => json_encode([
                'force_reply' => true,
                'selective' => true,
                'parse_mode' => "HTML",
            ])
        ];
        return $this->excCurl(apiUrl . 'sendMessage', $fileds);
    }

    public function excCurl($url, $fields = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        return json_decode($content);
    }
}