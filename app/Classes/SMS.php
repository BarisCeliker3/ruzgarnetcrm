<?php

namespace App\Classes;

use SoapClient;
use Exception;
//use Illuminate\Support\Facades\Storage;
//use App\Models\DetailedSMSTransactions;
 use Storage;
// Not güncelleme: 28.07.2023 ::.. --> http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl adresindeki web servis dosyası çözülmek suretiyle cevaplar buradan elde edilebilir.
//ilk etapta $Result namındaki değişkenin içeriğini bir metin dosyasına yazdıralım, istenilen cevap varsa sonucu sorgulamak için gerekli işlemi terkib edelim.
//dahili olarak $client değişkenine ait alt metodlar da yazdırılabilir.
//Sms gönderildiği esnada, hata mesajı döndüğünde işleme tabii tutulacak.
//İlk aşamada 2 adet dosya oluştur. Birisi çoklu gönderilenler için, diğeri ise tekli gönderimler için
/*
28.07.2023 15:13
draft method for requesting message (only 1 or multiple):
*/

class SMS
{
    private $username;
    private $password;
    
    public function __construct()
    {
        $this->username = env('NETGSM_SMS_USERNAME');
        $this->password = env('NETGSM_SMS_PASSWORD');
        
    }


    public function submitMulti($title,$messages)
    {
        //$detailedSMSDAO = DetailedSMSTransactions::getInstance();   
        for ($row = 0; $row < sizeof($messages); $row++) {
            $gsm [] = $messages[$row][0];
            $msg [] = $messages[$row][1];
        }
        try {
            $client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl", array("trace" => 1));
            $Result = $client -> smsGonderNNV2(array('username'=>$this->username,'password' => $this->password,'header' => $title,'msg' => $msg,'gsm' => $gsm,'filter' => '','startdate'  => '','stopdate'  => '','encoding' => 'TR'));
            /*$xml = $client->__getLastResponse();
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
            $xml = simplexml_load_string($xml);
            $json = json_encode($xml);
            $responseArray = json_decode($json,true);
            
            print_r($responseArray, true);*/
            $intResult = print_r($responseArray['SBody']['ns2smsGonderNNV2Response']['return'], true);
           // Storage::disk('local')->append("messageResult.txt", $intResult, "\n");
            //$detailedSMSDAO->saveMulti($title, $gsm, $msg, $intResult);
            //Storage::disk('local')->append("SMSSubmitMulti.txt", "Çalıştım");
            return true;
        } catch (Exception $exc){
            // Hata olusursa yakala
            //Storage::disk('local')->append("SMSSubmitMulti.txt", $ex->__toString(), "\n");
            echo "Soap Hatasi Olustu: " . $exc->getMessage();
            return false;
        }

    }

    public function submit($title,$message,$phone)
    {
        //$detailedSMSDAO = DetailedSMSTransactions::getInstance();
        try {
            //"trace"=>1
            $client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl", array("trace" => 1));

            $msg  = $message;
            $gsm  = $phone;
            

            $Result = $client -> smsGonder1NV2(array('username'=>$this->username,'password' => $this->password,'header' => $title,'msg' => $msg,'gsm' => $gsm,'filter' => '','startdate'  => '','stopdate'  => '','encoding' => 'TR'));
            //$results = print_r($Result, true);
                
                /*$xml = $client->__getLastResponse();
                $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
                $xml = simplexml_load_string($xml);
                $json = json_encode($xml);
                $responseArray = json_decode($json,true);
                //print_r($responseArray, true)
                
            $intResult = print_r($responseArray['SBody']['ns2smsGonder1NV2Response']['return'], true);*/
                //Storage::disk('local')->append("messageResult.txt", $intResult, "\n");
                      
                    //Storage::disk('local')->append("messageResult.txt", $intResult, "\n");
    
                //$detailedSMSDAO->save($title, $message, $phone, $intResult);
                //Storage::disk('local')->append("SMSSubmit.txt", "Çalıştım");
                
            return true;
        } catch (Exception $exc){
            //Storage::disk('local')->append("SMSSubmit.txt", $ex->__toString(), "\n");
            // Hata olusursa yakala
            echo "Soap Hatasi Olustu: " . $exc->getMessage();
            return false;
        }

    }

    public function submit_in_time($title, $message, $phone, $time)
    {
        //$detailedSMSDAO = DetailedSMSTransactions::getInstance();
        try {
            //Storage::disk('local')->append("SMSSubmitInTime.txt", "Çalıştım");
            $client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl", array("trace" => 1));

            $msg  = $message;
            $gsm  = $phone;
            $start_date = $time;

            $Result = $client -> smsGonder1NV2(array('username'=>$this->username,'password' => $this->password,'header' => $title,'msg' => $msg,'gsm' => $gsm,'filter' => '','startdate'  =>  $start_date,'stopdate'  => '','encoding' => 'TR'));
           
            /*$xml = $client->__getLastResponse();
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
            $xml = simplexml_load_string($xml);
            $json = json_encode($xml);
            $responseArray = json_decode($json,true);
            //print_r($responseArray, true)
            $intResult = print_r($responseArray['SBody']['ns2smsGonder1NV2Response']['return'], true);            $responseArray = json_decode($json,true);*/
            //$detailedSMSDAO->save($title, $message, $phone, $intResult);
 
            return true;
        } catch (Exception $exc){
            //Storage::disk('local')->append("SMSSubmitInTime.txt", $exc->__toString());
            // Hata olusursa yakala
            echo "Soap Hatasi Olustu: " . $exc->getMessage();
            return false;
        }
    }
    /*
    public function requestForMessage($bulkId)
    {
        try
        {
            $client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl", array("trace" => 1));
            //$bulkId = ... // How to store and retrieve ??? Fix it... maybe = $bulkId;
            //After testing correctivity of number of parameters, $resultOfRequest can be printed into a text file.
            $resultOfRequest = $client -> raporV3(array('username'=>$this->username,'password' => $this->password,'bulkid' => $bulkId, 'type' => 0, 'status' => 100, 'detail' => '1', 'encoding' => 'TR'));
            $xml = $client->__getLastResponse();
            //$eXml = html_entity_decode($xml);
            $xml = str_replace("&lt;?xml version='1.0' encoding='iso-8859-9'?&gt;", '', $xml);
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
            //$xml = str_replace(array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), array('&', '<', '>', '\'', '"'), $xml);
            $array = json_decode(json_encode(simplexml_load_string($xml)),true);
            $innerXmlStr = "XXX";
            $innerJson = "{'onion': 'sogan'}";
            $innerXml = "";
            if(!is_numeric($array['SBody']['ns2raporV3Response']['return']))   
            {   
                $innerXmlStr = $array['SBody']['ns2raporV3Response']['return'];
                $innerXmlStr = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $innerXmlStr);
                $innerXml = simplexml_load_string($innerXmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //$innerXml = simplexml_load_string($innerXmlStr);
                //$innerJson = json_encode($innerXml, JSON_PRETTY_PRINT);
                foreach($innerXml->telno as $val)
                {
                  Storage::disk('local')->append("forgiveme.txt", print_r($val, true), "\n");  
                }
                //Storage::disk('local')->append("letmefin.txt", print_r($innerXml, true), "\n");    
            }
    
        }
        catch(Exception $ex)
        {
            Storage::disk('local')->append("bilbil.txt", $ex->__toString(), "\n");
        }
    }

    public function multiRequestForMessages($phoneArray, $bulkIdArray)
    {
        $resultArray = array();
        try
        {
            $detailedSMSDAO = DetailedSMSTransactions::getInstance();
            
            $client = new SoapClient("http://soap.netgsm.com.tr:8080/Sms_webservis/SMS?wsdl", array("trace" => 1));
            //Storage::disk('local')->append("shin.txt", "Length of phoneArray".count($phoneArray), "\n");
            //Storage::disk('local')->append("shin.txt", "Length of bulkIdArray".count($bulkIdArray), "\n");
            //$bulkId = ... // How to store and retrieve ??? Fix it... maybe = $bulkId;
            //After testing correctivity of number of parameters, $resultOfRequest can be printed into a text file.
            
            for($i=0; $i<count($bulkIdArray); $i++)
            {
            $resultOfRequest = $client -> raporV3(array('username'=>$this->username,'password' => $this->password,'bulkid' => $bulkIdArray[$i], 'type' => 1, 'status' => 100, 'detail' => '1', 'encoding' => 'TR'));
            $xmlResult = $client->__getLastResponse();
            $xmlResult = str_replace("&lt;?xml version='1.0' encoding='iso-8859-9'?&gt;", '', $xmlResult);
            $xmlResult = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xmlResult);
            $array = json_decode(json_encode(simplexml_load_string($xmlResult)),true);
            if(!is_numeric($array['SBody']['ns2raporV3Response']['return']))   
            {   
                $innerXmlStr = $array['SBody']['ns2raporV3Response']['return'];
                $innerXmlStr = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $innerXmlStr);
                $innerXml = simplexml_load_string($innerXmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //$innerXml = simplexml_load_string($innerXmlStr);
                //$innerJson = json_encode($innerXml, JSON_PRETTY_PRINT);
                foreach($innerXml->telno as $val)
                {
                  //Storage::disk('local')->append("sorrow.txt", print_r($val, true), "\n");
                  array_push($resultArray, $val);
                }
                //Storage::disk('local')->append("letmefin.txt", print_r($innerXml, true), "\n");    
            
            $detailedSMSDAO->updateMessages($resultArray);        
            }
            
            Storage::disk('local')->append("dsa.txt", $xmlResult, "\n");
            }
            
            
            
            /*
            $resultOfRequest = $client -> raporV3(array('username'=>$this->username,'password' => $this->password,'bulkid' => $bulkId, 'type' => 0, 'status' => 100, 'detail' => '1', 'encoding' => 'TR'));
            $xml = $client->__getLastResponse();
            //$eXml = html_entity_decode($xml);
            $xml = str_replace("&lt;?xml version='1.0' encoding='iso-8859-9'?&gt;", '', $xml);
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
            //$xml = str_replace(array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), array('&', '<', '>', '\'', '"'), $xml);
            $array = json_decode(json_encode(simplexml_load_string($xml)),true);
            $innerXmlStr = "XXX";
            $innerJson = "{'onion': 'sogan'}";
            $innerXml = "";
            if(!is_numeric($array['SBody']['ns2raporV3Response']['return']))   
            {   
                $innerXmlStr = $array['SBody']['ns2raporV3Response']['return'];
                $innerXmlStr = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $innerXmlStr);
                $innerXml = simplexml_load_string($innerXmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //$innerXml = simplexml_load_string($innerXmlStr);
                //$innerJson = json_encode($innerXml, JSON_PRETTY_PRINT);
                foreach($innerXml->telno as $val)
                {
                  Storage::disk('local')->append("forgiveme.txt", print_r($val, true), "\n");  
                }
                //Storage::disk('local')->append("letmefin.txt", print_r($innerXml, true), "\n");    
            
                
            }
    
        }
        catch(Exception $ex)
        {
            Storage::disk('local')->append("bilbil.txt", $ex->__toString(), "\n");
        }
    }
    */

}

