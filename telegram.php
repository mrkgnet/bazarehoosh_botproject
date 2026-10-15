<?php

require_once __DIR__ . '/config.php';

class telegram
{
    public $db;
    public $name = null;

    // برای سازگاری با کدهای قدیمی
    public static $isTested = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->connectDatabase();
    }

    /**
     * اتصال به دیتابیس
     */
    private function connectDatabase()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST .
                   ";dbname=" . DB_NAME .
                   ";charset=utf8mb4";

            $this->db = new PDO(
                $dsn,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE =>
                        PDO::ERRMODE_EXCEPTION,

                    PDO::ATTR_DEFAULT_FETCH_MODE =>
                        PDO::FETCH_ASSOC,

                    PDO::ATTR_EMULATE_PREPARES =>
                        false
                ]
            );

        } catch (PDOException $e) {

            error_log(
                "[DATABASE ERROR] " . $e->getMessage()
            );

            throw new RuntimeException(
                "Database connection failed.",
                0,
                $e
            );
        }
    }

    /**
     * دریافت IP کلاینت
     */
    public function get_client_ip()
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;

        if ($ip && filter_var(
            $ip,
            FILTER_VALIDATE_IP
        )) {
            return $ip;
        }

        return 'UNKNOWN';
    }

    /**
     * ساخت کیبورد شیشه‌ای
     */
    public function makeInlineButton($keyboard)
    {
        return $this->encodeJson([
            'inline_keyboard' => $keyboard
        ]);
    }

    /**
     * تبدیل آرایه به JSON
     */
    private function encodeJson($data)
    {
        $json = json_encode(
            $data,
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES
        );

        if ($json === false) {
            throw new RuntimeException(
                'JSON Encode Error: ' .
                json_last_error_msg()
            );
        }

        return $json;
    }

    /**
     * ارسال درخواست به Telegram Bot API
     */
    private function request($method, $fields = [])
    {
        return $this->excCurl(
            apiUrl . $method,
            $fields
        );
    }

    /**
     * اضافه کردن کیبورد شیشه‌ای
     */
    private function withInlineKeyboard(
        $fields,
        $keyboard
    ) {
        if ($keyboard !== null) {
            $fields['reply_markup'] =
                $this->makeInlineButton($keyboard);
        }

        return $fields;
    }

    /**
     * ارسال پیام
     */
    public function sendMessage(
        $chat_id,
        $text,
        $keyboard = null
    ) {
        $fields = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        $fields = $this->withInlineKeyboard(
            $fields,
            $keyboard
        );

        return $this->request(
            'sendMessage',
            $fields
        );
    }

    /**
     * ارسال پیام با کیبورد معمولی
     */
    public function sendMessage2(
        $chat_id,
        $text,
        $keyboard = null
    ) {
        $fields = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        if ($keyboard !== null) {

            $fields['reply_markup'] =
                $this->encodeJson([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => false,
                    'selective' => false
                ]);
        }

        return $this->request(
            'sendMessage',
            $fields
        );
    }

    /**
     * ویرایش پیام
     */
    public function editMessageText(
        $chat_id,
        $message_id,
        $text,
        $keyboard = null
    ) {
        $fields = [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        $fields = $this->withInlineKeyboard(
            $fields,
            $keyboard
        );

        return $this->request(
            'editMessageText',
            $fields
        );
    }

    /**
     * حذف پیام
     */
    public function deleteMessage(
        $chat_id,
        $message_id
    ) {
        return $this->request(
            'deleteMessage',
            [
                'chat_id' => $chat_id,
                'message_id' => $message_id
            ]
        );
    }

    /**
     * ارسال تصویر
     */
    public function sendPhoto(
        $chat_id,
        $photoFileID,
        $caption,
        $keyboard = null
    ) {
        $fields = [
            'chat_id' => $chat_id,
            'photo' => $photoFileID,
            'caption' => $caption,
            'parse_mode' => 'HTML'
        ];

        $fields = $this->withInlineKeyboard(
            $fields,
            $keyboard
        );

        return $this->request(
            'sendPhoto',
            $fields
        );
    }

    /**
     * ارسال انیمیشن
     */
    public function sendAnimation(
        $chat_id,
        $caption,
        $fileIDAnimation,
        $keyboard = null
    ) {
        $fields = [
            'chat_id' => $chat_id,
            'animation' => $fileIDAnimation,
            'caption' => $caption
        ];

        $fields = $this->withInlineKeyboard(
            $fields,
            $keyboard
        );

        return $this->request(
            'sendAnimation',
            $fields
        );
    }

    /**
     * ارسال وضعیت فعالیت
     */
    public function sendChatAction(
        $chat_id,
        $action
    ) {
        return $this->request(
            'sendChatAction',
            [
                'chat_id' => $chat_id,
                'action' => $action
            ]
        );
    }

    /**
     * بررسی وضعیت عضویت کاربر
     */
    public function getChatMember(
        $chat_id,
        $user_id
    ) {
        $response = $this->request(
            'getChatMember',
            [
                'chat_id' => $chat_id,
                'user_id' => $user_id
            ]
        );

        return $response->result->status ?? null;
    }

    /**
     * دریافت تعداد اعضای کانال یا گروه
     */
    public function getChatMemberCount($chat_id)
    {
        $response = $this->request(
            'getChatMemberCount',
            [
                'chat_id' => $chat_id
            ]
        );

        return $response->result ?? null;
    }

    /**
     * پاسخ به Callback Query
     */
    public function answerCallbackQuery(
        $callback_query_id,
        $text,
        $show_alert = false
    ) {
        return $this->request(
            'answerCallbackQuery',
            [
                'callback_query_id' =>
                    $callback_query_id,

                'text' => $text,

                'show_alert' =>
                    $show_alert ? 'true' : 'false'
            ]
        );
    }

    /**
     * حذف کیبورد معمولی
     */
    public function replyKeyboardRemove(
        $chat_id,
        $text
    ) {
        return $this->request(
            'sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => $text,

                'reply_markup' =>
                    $this->encodeJson([
                        'remove_keyboard' => true,
                        'selective' => true
                    ])
            ]
        );
    }

    /**
     * دریافت پاسخ مستقیم از کاربر
     */
    public function forceReply(
        $chat_id,
        $text
    ) {
        return $this->request(
            'sendMessage',
            [
                'chat_id' => $chat_id,
                'text' => $text,
                'parse_mode' => 'HTML',

                'reply_markup' =>
                    $this->encodeJson([
                        'force_reply' => true,
                        'selective' => true
                    ])
            ]
        );
    }

    /**
     * اجرای درخواست cURL
     */
    public function excCurl(
        $url,
        $fields = []
    ) {
        $ch = curl_init();

        if ($ch === false) {
            throw new RuntimeException(
                'Unable to initialize cURL.'
            );
        }

        try {

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_POST => true,

                CURLOPT_POSTFIELDS =>
                    http_build_query($fields),

                CURLOPT_RETURNTRANSFER => true,

                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 20,

                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2
            ]);

            $content = curl_exec($ch);

            $curlError = curl_error($ch);

            $httpCode = curl_getinfo(
                $ch,
                CURLINFO_HTTP_CODE
            );

        } finally {
            curl_close($ch);
        }

        if ($content === false) {

            error_log(
                '[CURL ERROR] ' . $curlError
            );

            throw new RuntimeException(
                'Telegram connection failed: ' .
                $curlError
            );
        }

        $response = json_decode($content);

        if (
            json_last_error() !== JSON_ERROR_NONE ||
            !is_object($response)
        ) {
            throw new RuntimeException(
                'Invalid Telegram API response.'
            );
        }

        if (
            $httpCode < 200 ||
            $httpCode >= 300 ||
            !isset($response->ok) ||
            $response->ok !== true
        ) {
            $description =
                $response->description ??
                'Unknown API error';

            error_log(
                '[TELEGRAM API ERROR] HTTP ' .
                $httpCode . ': ' . $description
            );

            throw new RuntimeException(
                'Telegram API Error: ' .
                $description,
                (int) ($response->error_code ?? 0)
            );
        }

        return $response;
    }
}