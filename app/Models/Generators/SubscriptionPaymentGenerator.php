<?php

namespace App\Models\Generators;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Generate payment datas for subscription model
 */
trait SubscriptionPaymentGenerator
{
    /**
     * Generates first payments
     *
     * @return array
     */
    public function generatePayments()
    {
        $data = [];
        $values = [];

        if ($this->options) {
            foreach ($this->options as $key => $value) {
                if (method_exists($this, $key)) {
                    $row = $this->{$key}($value);
                    $data[] = $row;

                    if (array_key_exists('payment', $row)) {
                        $values[$key] = $row['payment'];
                    }
                    if (array_key_exists('price', $row)) {
                        $values[$key] = $row['price'];
                    }
                    if (array_key_exists('payments', $row)) {
                        $total = 0;
                        foreach ($row['payments'] as $payment) {
                            $total += $payment;
                        }
                        $values[$key] = $total;
                    }
                }
            }

            if ($service_option = $this->service->options) {
                $data[] = $this->serviceOption();
                $values["campaign_price"] = $service_option["price"];
                $values["duration"] = $service_option["duration"];

                if (in_array($this->service_id, [37, 38, 40, 41])) {
                    $plaka = $this->customer->customerInfo->city->plaka;
                    $values["campaign_price"] = $plaka;
                    if ($plaka > 50) {
                        $values["campaign_price"] = floor($plaka / 10) + ($plaka % 10);
                    }
                }
            }

            $values['service_price'] = $this->service->price;
            if (in_array($this->commitment, [0, 6])) {
                if($this->service_id != 80){
                    $values['service_price'] += 10;
                }
            }

            $this->values = $values;

            $data = collect($data);

            $this->payment = $data->sum("payment");
            $this->price += $data->sum("price");

            $payment_variables = $data->filter(function ($value) {
                return in_array("payments", array_keys($value));
            })->pluck("payments");

            $months = $payment_variables->map(function ($item) {
                return count($item);
            })->max();

            $date_append = 1;

            if ($this->getOption('pre_payment')) {
                if ($months < 2) {
                    $months = 2;
                }
                $date_append = 0;
            }

            if ($months == 0) {
                $months = 1;
            }

            $payments = [];
            for ($i = 0; $i < $months; $i++) {
                $payments[$i]["price"] = (float)$this->price;
            }

            foreach ($payment_variables->toArray() as $values) {
                foreach ($values as $index => $value) {
                    $payments[$index]["price"] += (float)$value;
                }
            }

            foreach ($payments as $index => $value) {
                $payments[$index]["subscription_id"] = $this->id;
                $payments[$index]["date"] = Carbon::now()->startOfMonth()->addMonth($date_append)->format('Y-m-15');
                $date_append++;
            }

            if ($this->getOption('pre_payment')) {
                $payments[0]['paid_at'] = DB::raw('current_timestamp()');
                $payments[0]['type'] = 6;
                $payments[0]['status'] = 2;
            }
        }

        return $payments ?? [];
    }

    /**
     * Setup payment variables
     *
     * @param int $value
     * @return array
     * Rüzgar Yeni SMART-117 / RüzgarFİBER POWER YENİ PAKET-113 / Rüzgar Yeni DESTEK-118 /100 Güldüren Kampanyası 6 Ay Taahhütlü-110
     */
    public function setup_payment($value)
    {
        $payment = (float)setting('service.setup.payment');

        // İLK 2 AYA YANSITMA BEDELİ

        //Yeni tarife eklendiğinde altta değişiklik yap. (İlk 2 aya yansıt)
        if( $this->service_id==181 || $this->service_id==183 || $this->service_id==185 || $this->service_id==190 || $this->service_id==187 || $this->service_id==188  ){
            // İLK 2 AYA YANSIT 200*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 1500;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 1500;
            }
        }
        else if($this->service_id==204 || $this->service_id==209 || $this->service_id==210 || $this->service_id==212 || $this->service_id==214 || $this->service_id==218 || $this->service_id==219
                || $this->service_id==220 || $this->service_id==221 || $this->service_id==223 || $this->service_id==224  || $this->service_id==227|| $this->service_id==228|| $this->service_id==232|| $this->service_id==230){
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 1500;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 1500;
            }
        }
          else if($this->service_id==225){
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 1500;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 1500;
            }
        }
        else if($this->service_id==238){
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                
                $payment = 1500;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 1500;
            }
        }

        else if($this->service_id==222 || $this->service_id==217 || $this->service_id==216 ){
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 1500;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 1500;
            }
        }
        else if($this->service_id==166|| $this->service_id==199  || $this->service_id==202){
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 1500;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 1500;
            }
        }
        else if($this->service_id==80 || $this->service_id==74){
            // İLK 2 AYA YANSIT 200*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 400;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 400;
            }
        }
        else if($this->service_id==115 || $this->service_id==117 || $this->service_id==113 || $this->service_id==118 || $this->service_id==110   ||   $this->service_id==189  ||
        $this->service_id==125 || $this->service_id==126 || $this->service_id==127 || $this->service_id==128  || $this->service_id == 165 ||$this->service_id == 182 
        ||$this->service_id == 184 ||$this->service_id == 198 ||$this->service_id == 203){
            // İLK 2 AYA YANSIT 150*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 300;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 300;
            }
        }
        
        else if( $this->service_id==129 || $this->service_id==130 || $this->service_id==131 || $this->service_id==132 || $this->service_id==133 || $this->service_id==134 
        || $this->service_id==139 || $this->service_id==135 || $this->service_id==136){
            // İLK 2 AYA YANSIT 225*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 450;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 450;
            }
        }
        else if( $this->service_id==116 || $this->service_id==119 || $this->service_id==120 || $this->service_id==121 || $this->service_id==137 || $this->service_id==138){
            // İLK 2 AYA YANSIT 150*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 300;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 300;
            }
        }
         else if($this->service_id==112 ){
            // İLK 2 AYA YANSIT 125*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 250;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 250;
            }
        }
         else if($this->service_id==124 ){
            // İLK 2 AYA YANSIT 175*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 350;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 350;
            }
        }
          else if($this->service_id==157 || $this->service_id == 159 || $this->service_id == 178 || $this->service_id == 207 ){
            // İLK 2 AYA YANSIT 250*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment =500;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 500;
            }
        }      
        else{
            // İLK 2 AYA YANSIT 100*2
            $modem_type = (int)$this->getOption('modem');
            if($modem_type == 0 || $modem_type == 1 || $modem_type == 4 || $modem_type == 7){
                $payment = 200;
            }else if($modem_type == 2 || $modem_type == 3){
                $payment = 200;
            }
        }


        // if($this->getOption('il_disi')!=1){
        //     $modem_type = (int)$this->getOption('modem');
        //     if($modem_type == 1 || $modem_type == 4 || $modem_type == 7){
        //         $payment = 130;
        //     }else if($modem_type == 2 || $modem_type == 3){
        //         $payment = 150;
        //     }
        // }


        if ($value == 0) {
            return [];
        }

        // if ($value == 1) {
        //     // if($this->getOption('il_disi')!=1){
        //     //     $modem_type = (int)$this->getOption('modem');
        //     //     if($modem_type == 1 || $modem_type == 4 || $modem_type == 7){
        //     //         $payment = 100;
        //     //     }else if($modem_type == 2 || $modem_type == 3){
        //     //         $payment = 150;
        //     //     }
        //     // }

        //     return ['payment' => $payment];
        // }
//BAĞLANTI
//Sonbahar Kamapanyası = 81  Kış Kampanyası = 96
//100 Güldüren = 85
// POWER = 101
// GİGA 200 = 80
// RÜzgar DESTEK = 103
// Rüzgar FİBER LİFE 3 Ay Taahhütlü = 95
// Rüzgar FİBER  LİFE TAAHHÜTSÜZ = 104
// RüzgarFİBER POWER YENİ = 108
// RuzgarFİBER SMART = 115
    //Yeni tarife eklendiğinde altta değişiklik yap. (İlk 1. aya yansıt)
        if($value == 2){
            if($this->service_id==193 || $this->service_id==194 || $this->service_id==195){
                $payment = 400;
            }
            if($this->service_id==66){
                $payment = 255;
            }
            if($this->service_id==81 || $this->service_id==96){
                $payment = 200;
            }if($this->service_id==67 || $this->service_id==68 || $this->service_id==69 || $this->service_id==70 || $this->service_id==71 || $this->service_id==72 || $this->service_id==73 ){
                $payment = 200;
            }if($this->service_id==85 ){
                $payment = 200;
            }if($this->service_id==87 ){
                $payment = 200;
            }if($this->service_id==58 || $this->service_id==59 || $this->service_id==65 || $this->service_id==64 || $this->service_id==86){
                $payment = 200;
            }if($this->service_id==80 ){
                $payment = 200;
            }if($this->service_id==101 ){
                $payment = 200;
            }if($this->service_id==103 || $this->service_id==108 ){
                $payment = 200;
            }if($this->service_id==95 || $this->service_id==104){
                $payment = 200;
            }if($this->service_id==112){
                $payment = 200;
            }if($this->service_id==124){
                $payment = 300;
            }if($this->service_id==115 || $this->service_id==117 || $this->service_id==113 || $this->service_id==118 || $this->service_id==110 || $this->service_id==125 || $this->service_id==126  
             || $this->service_id==127 || $this->service_id==128){
                $payment = 200;
            }if($this->service_id==133 || $this->service_id==129 || $this->service_id==130 || $this->service_id==131 || $this->service_id==132 || $this->service_id==134
             || $this->service_id==135 || $this->service_id==136 || $this->service_id==139 || $this->service_id==140 || $this->service_id==141 || $this->service_id==142
             || $this->service_id==143){
                $payment = 250;
             }
             if($this->service_id==157 || $this->service_id == 159 || $this->service_id == 178){
                 $payment = 400;
             }
             if($this->service_id == 157 || $this->service_id == 159 || $this->service_id == 178)
             {
                 $payment = 650;
             }
             if($this->service_id == 168 || $this->service_id == 216 || $this->service_id == 217 ||  $this->service_id==187 || $this->service_id==188  )
             {
                 $payment = 1500;
             }
             if($this->service_id==147 || $this->service_id==146){
                $payment = 500;
             }if($this->service_id==144 || $this->service_id==145 || $this->service_id == 155 || $this->service_id == 174 || $this->service_id == 176){
                $payment = 600;
             }if($this->service_id==148 || $this->service_id==149 || $this->service_id == 153 || $this->service_id == 163 || $this->service_id == 165 || $this->service_id == 166 
                    || $this->service_id == 183 || $this->service_id == 181 || $this->service_id == 170){
                $payment = 1500;
             }
            if($this->service_id==116 || $this->service_id==119 || $this->service_id==120 || $this->service_id==121 || $this->service_id==137 || $this->service_id==138){
                $payment = 250;
            }
            if($this->service_id == 173)
            {
                $payment = 1250;
            }
            if( $this->service_id == 211)
            {
                $payment = 100;
            }
          }
        if($value == 3){
          $payment = $payment;
        }
        //Yeni tarife eklendiğinde altta değişiklik yap. (İlk 1. aya yansıt (CHURN))
        if($value == 4){
            if($this->service_id==193 || $this->service_id==194 || $this->service_id==195){
                $payment = 200;
            }
            if($this->service_id==144 || $this->service_id==145 || $this->service_id == 172){
                $payment = 150;
            }
            if($this->service_id == 146 || $this->service_id == 147 || $this->service_id == 164 || $this->service_id == 170)
            {
                $payment = 99;
            }
            if($this->service_id==152  || $this->service_id == 166 || $this->service_id == 211)
            {
                $payment = 100;
            }
            if($this->service_id == 167)
            {
                $payment = 200;
            }
            if($this->service_id == 165)
            {
                $payment = 250;
            }
             if( $this->service_id == 216 || $this->service_id == 217)
             {
                 $payment = 1500;
             }
            if($this->service_id==148 || $this->service_id==167 || $this->service_id==165 ){
                $payment = 300;
             }if($this->service_id==149){
                $payment = 0;
             }else{
                $payment = $payment;
            }

        }



        $data = [];
        if($value == 4){
            $data[] = $payment;
            return [
                'payments' => $data
            ];
        }
        
         else if($value == 1){
          for ($i = 0; $i < $value + 2; $i++) {
                $data[] = $payment / ($value + 2);
            }
    
            return [
                'payments' => $data
            ];
        }
        
        else{
            for ($i = 0; $i < $value - 1; $i++) {
                $data[] = $payment / ($value - 1);
            }
    
            return [
                'payments' => $data
            ];
        }
    }

    /**
     * Modem payment variables
     *
     * @param int $value
     * @return array
     */
    public function modem_payment($value)
    {
        // 1 => yok
        // 2 => adsl
        // 3 => vdsl
        // 4 => fiber
        // 5 => uydu modem

        $type = (int)$this->getOption('modem');

        $typeVal = '';
        if ($type == 2) {
            $typeVal = 'adsl';
        } else if ($type == 3) {
            $typeVal = 'vdsl';
        }

        $payment = (float)setting("service.modem.{$typeVal}");

        if ($value == 1) {
            return ['payment' => $payment];
        }

        $data = [];
        for ($i = 0; $i < $value - 1; $i++) {
            $data[] = $payment / ($value - 1);
        }

        return [
            'payments' => $data
        ];
    }

    /**
     * Modem Price Variables
     *
     * @return array
     */
    public function modem_price()
    {
        return [
            'price' => (float)$this->getOption('modem_price', 0)
        ];
    }

    public function serviceOption()
    {
        $options = $this->service->options;
        if (in_array($this->service_id, [37, 38, 40, 41])) {
            $plaka = $this->customer->customerInfo->city->plaka;
            $options['price'] = $plaka;
            if ($plaka > 50) {
                $options['price'] = floor($plaka / 10) + ($plaka % 10);
            }
        }
        $data = [];
        if ($this->commitment != null && isset($options["commitment"])) {
            if ($this->commitment == $options["commitment"]) {
                $price = -1 * ($this->price - $options["price"]);

                for ($iteration = 0; $iteration < $options["duration"]; $iteration++) {
                    $data[] = $price;
                }
            }
        }

        if ($data)
            return [
                'payments' => $data
            ];
        return [];
    }
}
