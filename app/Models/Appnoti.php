<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Appnoti extends Model

{

    use HasFactory;

    protected $table = 'app_noti'; // <-- Tablo adı açıkça belirtildi



    protected $fillable = [

         'title', 'body', 'sent'

    ];



    protected $casts = [

        'sent' => 'boolean',

      

    ];

}