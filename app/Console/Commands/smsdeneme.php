<?php

namespace App\Console\Commands;

use App\Classes\Moka;
use App\Classes\Telegram;
use SoapClient;
use App\Classes\SMS;
use App\Models\MokaAutoPayment;
use App\Models\MokaSale;
use Exception;
use Illuminate\Console\Command;
use Storage;
use App\Classes\SMS_Api;



class smsdeneme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ruzgarnet:smsdeneme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create smsdeneme plans.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
  

public function handle()
{
    try {
        $sms = new SMS();
        $phone = "905375720297";
        $messages = "deneme";
        $result = $sms->submit("RUZGARNET", $messages, $phone);

        // Sonucun türüne göre detaylı yazdır
        $this->info("API Yanıtı: " . print_r($result, true));
        if (is_array($result) || is_object($result)) {
            $this->info("SMS gönderim sonucu (detaylı):\n" . print_r($result, true));
        } else {
            $this->info("SMS gönderim sonucu: " . $result);

            // Eğer 1 ise başarı, değilse hata kodu
          if ($result == 1) { // dikkat: iki eşitlik (türüne bakmadan karşılaştır)
    $this->info("SMS başarıyla gönderildi ✅");
} else {
    $this->error("SMS gönderilemedi! Hata kodu: " . $result);
}
        }
    } catch (\Exception $e) {
        $this->error("Hata oluştu: " . $e->getMessage());
    }
}
}