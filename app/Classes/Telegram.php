<?php

namespace App\Classes;

use CURLFile;
use Exception;
use Storage;

/**
 * Telegram API
 */
class Telegram
{
    /**
     * Telegram Groups
     *
     * @var array
     */
     
    
    public static $groups = [
        'AboneTamamlanan' => "-1001446123222",
        'AltyapıSorgulama' => '-1001234818134',
        'NiğdeSatış' => '-1001312842188',
        'WebÜzerindenSatış' => '-1001239160019',
        'RüzgarNETÖdeme' => '-1001188341295',
        'AboneBilgileri' => '-1001393165900',
        'KaliteKontrolEkibi' => '-1001468489934',
        'İptalİşlemler' => '-1001123700542',
         'BizSiziArayalım' => '-1001459396907',
        //'SiziArayalım' => '-2059509845', 1001459396907
        //'SiziArayalım' => '-1002070566203',
        'RüzgarTeknik' => '-1001270493121',
        'RüzgarCELLKotaSorgulama' => '-1001470398107',
        'SözleşmesiSonaErecekler' => '-1001172443073',
        'DondurulupSuresiUzayanAboneler' => '-1001840361584',
        'TaahhutSayar' => '-1001882621965',
        'BayiSatışlar' => '-1001412338702',
        'Test' => '-1002472885722',
        'YetkiTalep' => '-1001692819257',
        'Promosyon Takip' => '-1001536258752',
        'Dekont yükleme' => '-1001312842188',
        'Bayi Kurulum' => '-459823289',
        'İptal Başvuru' => '-1001458297502',
        'ArizaSayisi' => '-1001693919133',
        'KalanKod' => '-1001617965101',
        'İnternet Kurulum' =>'-1001681898745',
        'evrakYukleme'=>'-1002119133589'

    ];





    /**
     * API Telegram Token
     *
     * @var string
     */
    private static $token = "";

    /**
     * URL
     *
     * @var string
     */
    private static $url = "";

    /**
     * Function
     *
     * @var string
     */
    private static $function = "sendMessage";

    /**
     * Request Parameters
     *
     * @var array
     */
    private static $request_parameters = [];

    /**
     * Send message to id
     *
     * @param string $chat_key
     * @param string $message
     * @return object|null
     */
    public static function send($group_key, $message)
    {
     
        //if (array_key_exists($group_key, self::$groups)) {
            try{
            // Hata olusursa yakala
            //Storage::disk('local')->append("telegramError.txt", "if içerisi", "\n");
         
            self::$request_parameters["chat_id"] = self::$groups[$group_key];
            self::$request_parameters["text"] = $message;
            self::$function = "sendMessage";
            return self::init();
        } //else {
        catch(Exception $ex){
            Storage::disk('local')->append("telegramError1720.txt", $ex->__toString(), "\n");
            throw new Exception('Chat group not found', 101);
        }
    }

    /**
     * Send contact to id
     *
     * @param string $chat_key
     * @param array $user
     * @return object|null
     */
    public static function contact($group_key, array $user)
    {
        if (array_key_exists($group_key, self::$groups)) {
            self::$request_parameters["chat_id"] = self::$groups[$group_key];
            self::$request_parameters["phone_number"] = $user["phone_number"];
            self::$request_parameters["first_name"] = $user["first_name"];
            self::$request_parameters["last_name"] = $user["last_name"];
            self::$function = "sendContact";
            return self::init();
        } else {
            throw new Exception('Chat group not found', 101);
        }
    }

    /**
     * Send photo to id
     *
     * @param string $chat_key
     * @param string $message
     * @return object|null
     */
    public static function send_photo($group_key, $photo)
    {
        if (array_key_exists($group_key, self::$groups)) {

            $token = env("TELEGRAM_API_TOKEN");
            if ($token && !empty($token)) {
                self::$url = "https://api.telegram.org/bot";
                self::$token = env("TELEGRAM_API_TOKEN");
                self::$url .= self::$token . "/";
            } else {
                throw new Exception('Token not found', 100);
            }

            self::$request_parameters["chat_id"] = self::$groups[$group_key];
            self::$request_parameters["photo"] = new CURLFile(realpath($photo));
            self::$request_parameters["caption"] = "Görsel";
            self::$function = "sendPhoto";
            self::$url .= self::$function . "?";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
            curl_setopt($ch, CURLOPT_URL, self::$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, self::$request_parameters);
            $output = curl_exec($ch);

            return $output;
        } else {
            throw new Exception('Chat group not found', 101);
        }
    }
       public static function send2()
    {
        $test='2';
        return $test;
    }

    /**
     * Send message and get response
     *
     * @return string|false
     */
    private static function init()
    {
        try{
        $token = env("TELEGRAM_API_TOKEN");
        if ($token && !empty($token)) {
            self::$url = "https://api.telegram.org/bot";
            self::$token = env("TELEGRAM_API_TOKEN");
            self::$url .= self::$token . "/";
        } else {
            throw new Exception('Token not found', 100);
        }
        
        self::$request_parameters['text'] = self::$request_parameters['text'];
        self::$url .= self::$function . "?" . http_build_query(self::$request_parameters);
        //Storage::disk('local')->append("ibrahim.txt", self::$url, "\n");
        return file_get_contents(self::$url);
        } catch(Exception $ex)
        {
           // Storage::disk('local')->append("ibrahim.txt", self::$url, "\n");

        }
        //return self::$url;
    }

}
