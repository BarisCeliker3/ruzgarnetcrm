@extends('admin.layout.main')

@section('title', meta_title('tables.assignment.title'))

@section('content')
    <div class="row">
        <div style=" background: #fff; padding: 20px; margin-top:56px" class=" col-md-12">
            
       
   
	
  <div class="col-12">
            
       
    <!-- START Sözleşmenin Bitmesine 15 Gün Kalan -->
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:22px;"><img style="width:38px;height:16px;" alt="image" src="/assets/images/ruzgar-logo-white.png" class="rounded-circle mr-1 bg-primary">
                    <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> <span class="text-success">Personel Görev Takip Sistemi.</span></h4>

                <!--    <div class="card-header-buttons">
                        <a href="/contract-notes/1" class="btn btn-primary"><i
                            class="fas fa-sm fa-plus"></i>Not Ekle
                        </a>
                    </div>
                    -->
                </div>
                
                <hr style="border-bottom:2px solid #6777ef;">
    
           @php
                $Dinamiksaat = date('Y-m-d');
                $saat = date('Y-m-d H:i:s');
                $bitis = date('Y-m-d 19:00:00');
               
           @endphp
           
           @if(strtotime($saat) < strtotime($bitis))                                
              <div style="max-width:100%" class="table-responsive">

                                <table class="table table-hover" style="background:#1d3e78">

              <thead>

                <tr>

                    <th>Personel</th>

                    <th>Birim</th>

                    <th>1.Görev</th>

                    <th>2.Görev</th>

                    <th>3.Görev</th>

                    <th>4.Görev</th>

                    <th>5.Görev</th>

                    <th>İşlemler</th>

                </tr>

              </thead>

              <tbody>

                 @foreach ($tasks as $task)

                                        <tr>

                                           

                                            

                                            <td><span  style="font-size:18px;" class="text-light">{{ $task->name_lastname }}</span></td>

                                            <td>

                                                @if($task->roles_id =='9')

                                                  <span  style="font-size:18px;" class="text-light">Müdür</span>

                                                  @elseif($task->roles_id == '8')

                                                  <span  style="font-size:18px;" class="text-light">Geliştirici</span>

                                                  @elseif($task->roles_id == '7')

                                                  <span  style="font-size:18px;" class="text-light">Yönetici</span>

                                                  @elseif($task->roles_id == '1')

                                                  <span  style="font-size:18px;" class="text-light">Danışma</span>

                                                  @elseif($task->roles_id == '5')

                                                  <span  style="font-size:18px;" class="text-light">Muhasebe</span>

                                                  @elseif($task->roles_id == '4')

                                                  <span  style="font-size:18px;" class="text-light">Satış</span>

                                                  @elseif($task->roles_id == '3')

                                                  <span  style="font-size:18px;" class="text-light">Müşteri Temsilcisi</span>

                                                  @elseif($task->roles_id == '2')

                                                  <span  style="font-size:18px;" class="text-light">Personel</span>

                                                  @elseif($task->roles_id == '6')

                                                  <span  style="font-size:18px;" class="text-light">Teknik</span>

                                                @endif

                                            </td>

           @if($task->task1 )

                                            <td>

                                               <a  href="#" data-toggle="modal"

                                               data-target="#icerik10{{ $task->id }}">

                                               <span class="badge badge-light badge-pill"> 

                                                   @if($task->status1 =='0')

                                                      <span  style="font-size:21px;" value="{{$task->status1}}" class="badge badge-pill badge-danger">X</span>

                                                      @elseif($task->status1 ='1')

                                                      <span style="font-size:21px;" value="{{$task->status1}}" class="badge badge-pill badge-success">✓</span>

                                                    @endif

                                                </span>

                                               </a>

                                            <!-- Logout Modal-->

                                            <div class="modal fade" id="icerik10{{ $task->id }}" tabindex="-1" role="dialog"

                                                 aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                            <button class="close" type="button" data-dismiss="modal"

                                                                    aria-label="Close">

                                                                <span aria-hidden="true">×</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">{{ $task->task1 }}</div>

                                                        <div class="modal-footer">

                                                            <button class="btn btn-dark" type="button"

                                                                    data-dismiss="modal">Kapat

                                                            </button>

        

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                             @else

                                        <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                         @endif

                                         

                                         @if($task->task2 )

                                            

                                           <td>

                                               <a  href="#" data-toggle="modal"

                                               data-target="#icerik9{{ $task->id }}">

                                               <span class="badge badge-light badge-pill"> 

                                                   @if($task->status2 =='0')

                                                      <span  style="font-size:21px;" value="{{$task->status2}}" class="badge badge-pill badge-danger">X</span>

                                                      @elseif($task->status2 ='1')

                                                      <span style="font-size:21px;" value="{{$task->status2}}" class="badge badge-pill badge-success">✓</span>

                                                    @endif

                                                </span>

                                               </a>

                                            <!-- Logout Modal-->

                                            <div class="modal fade" id="icerik9{{ $task->id }}" tabindex="-1" role="dialog"

                                                 aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                            <button class="close" type="button" data-dismiss="modal"

                                                                    aria-label="Close">

                                                                <span aria-hidden="true">×</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">{{ $task->task2 }}</div>

                                                        <div class="modal-footer">

                                                            <button class="btn btn-dark" type="button"

                                                                    data-dismiss="modal">Kapat

                                                            </button>

        

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                           @else

                                        <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                         @endif

                                         

                                         @if($task->task3 )

                                         <td>

                                               <a  href="#" data-toggle="modal"

                                               data-target="#icerik8{{ $task->id }}">

                                               <span class="badge badge-light badge-pill"> 

                                                   @if($task->status3 =='0')

                                                      <span  style="font-size:21px;" value="{{$task->status3}}" class="badge badge-pill badge-danger">X</span>

                                                      @elseif($task->status3 ='1')

                                                      <span style="font-size:21px;" value="{{$task->status3}}" class="badge badge-pill badge-success">✓</span>

                                                    @endif

                                                </span>

                                               </a>

                                            <!-- Logout Modal-->

                                            <div class="modal fade" id="icerik8{{ $task->id }}" tabindex="-1" role="dialog"

                                                 aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                            <button class="close" type="button" data-dismiss="modal"

                                                                    aria-label="Close">

                                                                <span aria-hidden="true">×</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">{{ $task->task3 }}</div>

                                                        <div class="modal-footer">

                                                            <button class="btn btn-dark" type="button"

                                                                    data-dismiss="modal">Kapat

                                                            </button>

        

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                          @else

                                        <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                         @endif

                                         

                                         @if($task->task4 )

                                         <td>

                                               <a  href="#" data-toggle="modal"

                                               data-target="#icerik7{{ $task->id }}">

                                               <span class="badge badge-light badge-pill"> 

                                                   @if($task->status4 =='0')

                                                      <span  style="font-size:21px;" value="{{$task->status4}}" class="badge badge-pill badge-danger">X</span>

                                                      @elseif($task->status4 ='1')

                                                      <span style="font-size:21px;" value="{{$task->status4}}" class="badge badge-pill badge-success">✓</span>

                                                    @endif

                                                </span>

                                               </a>

                                            <!-- Logout Modal-->

                                            <div class="modal fade" id="icerik7{{ $task->id }}" tabindex="-1" role="dialog"

                                                 aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                            <button class="close" type="button" data-dismiss="modal"

                                                                    aria-label="Close">

                                                                <span aria-hidden="true">×</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">{{ $task->task4 }}</div>

                                                        <div class="modal-footer">

                                                            <button class="btn btn-dark" type="button"

                                                                    data-dismiss="modal">Kapat

                                                            </button>

        

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                         @else

                                        <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                         @endif

                                         

                                         @if($task->task5 )

                                        

                                         <td>

                                               <a  href="#" data-toggle="modal"

                                               data-target="#icerik6{{ $task->id }}">

                                               <span class="badge badge-light badge-pill"> 

                                                   @if($task->status5 =='0')

                                                      <span  style="font-size:21px;" value="{{$task->status5}}" class="badge badge-pill badge-danger">X</span>

                                                      @elseif($task->status1 ='1')

                                                      <span style="font-size:21px;" value="{{$task->status5}}" class="badge badge-pill badge-success">✓</span>

                                                    @endif

                                                </span>

                                               </a>

                                            <!-- Logout Modal-->

                                            <div class="modal fade" id="icerik6{{ $task->id }}" tabindex="-1" role="dialog"

                                                 aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                            <button class="close" type="button" data-dismiss="modal"

                                                                    aria-label="Close">

                                                                <span aria-hidden="true">×</span>

                                                            </button>

                                                        </div>

                                                        <div class="modal-body">{{ $task->task5 }}</div>

                                                        <div class="modal-footer">

                                                            <button class="btn btn-dark" type="button"

                                                                    data-dismiss="modal">Kapat

                                                            </button>

        

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                         @else

                                        <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                         @endif

                                            <td> 

                                               <div class="buttons">

                                                        <a href="{{ route('admin.task.edit', $task) }}"

                                                            class="btn btn-light" title="@lang('titles.edit')">

                                                            <i class="fas fa-edit text-warning"></i>

                                                        </a>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach   

              </tbody>

            </table>    

           </div>   
                <div class="messenger">
                <div class="mesgcircle">
                    <div class="msgscrol">
                        <span>Son görev kayıt saati 19:00</span>
                    </div>
                    <div class="mesgload">
                        <span></span>
                        <span></span>
                        <span></span>
                        
                    </div>
                </div>
            </div>
<!--
     <h3 style="text-align:center;color:#1d3e78;">Görev Kayıt Süresi</h3><br>
     <div id="countdown" class="countdown">
         
   
       <div class="box">
          <span class="text">Saat</span>
          <span class="num" id="hours">00</span>
       </div>
    
       <div class="box">
          <span class="text">Dakika</span>
          <span class="num" id="minutes">00</span>
       </div>
   
       <div class="box">
          <span class="text">Saniye</span>
          <span class="num" id="seconds">00</span>
       </div>
     </div>
    <div id="countdown">
      <div id="days"></div>
      <div id="hours"></div>
      <div id="minutes"></div>
      <div class="num"></div>
    </div>
    -->
<div id="countdown1"></div>
             


           @else  
             
              <div class="card-header bg-danger ">
                 <h3 style="text-align:center;margin: auto;color:#fff">ÜZGÜNÜM!</h3> 
              </div>
              <div class="card-body">
                <h4 style="font-weight: bold;" class="card-title"><img style="max-width:12%;" class="card-img-top" src="/resimlers/gorev-img.png" alt="Card image cap">Günlük görevinizin kayıt süresi sona ermiştir...</h4>
                
                     <div style="margin:auto;" class="time">
                        <span class="hms"></span>
                        <span class="ampm"></span>
                        <br>
                        <span style="font-weight: bold;" class="date"></span>
                     </div>
              
              
              </div>
              <div class="card-footer text-muted">
              </div>
           
            

          @endif   
          
            </div>
            
    <!-- END Sözleşmenin Bitmesine 15 Gün Kalan -->   

             
            

    </div>
  

@endsection

@push('style')

<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300);
* {
            padding: 0;
            margin: 0;
        }

        .messenger {
            background-color: #ffff00;
            width: 160px;
            height: 160px;
            border-radius: 28px;
            margin: 30px auto;
        }

        .mesgcircle {
            margin: 30px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #0077ff;
            float: left;
            position: relative;
        }

        .mesgcircle:after {
            left: -3px;
            content: '';
            border-top: 23px solid #0077ff;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            display: block;
            width: 0px;
            height: 0;
            transform: rotate(40deg);
            position: absolute;
            top: 82px;
            border-radius: 5px;
        }

        .mesgload {
            width: 100%;
            height: 20px;
            text-align: center;
            margin: 40px 0;
            float: left;
        }

        .mesgload span {
            width: 11px;
            height: 11px;
            background-color: #ffffff;
            border-radius: 50%;
            display: inline-block;
            margin: 5px 3px 0;
            animation-name: dotone;
            animation-duration: 1.8s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        .mesgload span:nth-child(2) {
            animation-delay: .30s;
        }

        .mesgload span:nth-child(3) {
            animation-delay: .61s;
        }

        @keyframes dotone {
            25% {
                transform: translateY(-25px)
            }

            65% {
                transform: translateY(8px)
            }

            80% {
                transform: translateY(0px)
            }
        }

        .msgscrol {
            background-color: #ff2a00;
            width: 150px;
            height: 45px;
            border-radius: 25px;
            overflow: hidden;
            position: absolute;
            top: -55px;
            right: -50px;
        }

        .msgscrol span {
            font-family: 'Open Sans', sans-serif;
            font-size: 30px;
            color: #ffffff;
            display: block;
            white-space: nowrap;
            margin: 1px 0;
            animation: 4s txtscrl linear infinite;
        }

        @keyframes txtscrl {
            0% {
                transform: translateX(130px)
            }

            100% {
                transform: translateX(-290px)
            }
        }

        .inspired {
            width: 100%;
            text-align: center;
        }

        .inspired p {
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
            color: #000000;
        }

        .inspired a {
            color: #000000;
            text-decoration: none;
            border-bottom: 1px solid #555555;
            padding-bottom: 3px;
            font-weight: bold;
        }

        .inspired a:hover {
            border-bottom: 1px solid transparent;
        }
</style>

    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    
    <style>
        * {
padding: 0;
margin: 0;
box-sizing: border-box;
font-family: "Poppins", sans-serif;

}

/* Design a webpage */
body {
background: rgb(20, 129, 208);
background-repeat: no-repeat;
background-attachment: fixed;
background-position: center center;
background-size: cover;
}

.wrapper {
margin:auto;
font-size: 16px;
}
/* Basic design of countdown timer */
.countdown {
    margin:auto;
width: 95vw;
max-width: 900px;
display: flex;
justify-content: space-around;
gap: 10px;
}
/* Design the time view boxes */
.box {
width: 28vmin;
height: 24vmin;
display: flex;
flex-direction: column;
align-items: center;
justify-content: space-evenly;
position: relative;
}
/* Design time viewing numbers */
span.num {
background-color: white;
color: rgb(8, 78, 142);
height: 90%;
width: 90%;
display: grid;
place-items: center;
font-size: 4.2em;
box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
border-radius: 0.1em;
}
/* Design the text to indicate the time */
span.text {
font-size: 1.1em;
background-color: rgb(211, 241, 22);
color: #202020;
display: block;
width: 80%;
position: relative;
text-align: center;
bottom: -10px;
padding: 0.6em 0;
font-weight: 600;
border-radius: 0.3em;
box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
}
    </style>
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>

    <script>
//2 tarih arası
    var hoursContainer = document.querySelector("#hours")
    var minutesContainer = document.querySelector("#minutes")
    var secondsContainer = document.querySelector("#seconds")
    function updateCountdown() {
      var newYear = new Date("May  03, 2023 19:00:00")
      var currentTime = new Date()
      var diff = newYear - currentTime
      var days = Math.floor(diff / (1000 * 60 * 60 * 24))
      var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
      var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
      var seconds = Math.floor((diff % (1000 * 60)) / 1000)
     
      hoursContainer.innerHTML = hours + "<span></span>"
      minutesContainer.innerHTML = minutes + "<span></span>"
      secondsContainer.innerHTML = seconds + "<span></span>"
      
    }
    setInterval(updateCountdown, 1000)
//2 tarih arası end   
    </script>
    
    
    <script>
 function updateTime() {
  var dateInfo = new Date();

  /* time */
  var hr,
    _min = (dateInfo.getMinutes() < 10) ? "0" + dateInfo.getMinutes() : dateInfo.getMinutes(),
    sec = (dateInfo.getSeconds() < 10) ? "0" + dateInfo.getSeconds() : dateInfo.getSeconds(),
    ampm = (dateInfo.getHours() >= 12) ? "PM" : "AM";

  // replace 0 with 12 at midnight, subtract 12 from hour if 13–23
  if (dateInfo.getHours() == 0) {
    hr = 24;
  } else if (dateInfo.getHours() > 24) {
    hr = dateInfo.getHours() - 24;
  } else {
    hr = dateInfo.getHours();
  }

  var currentTime = hr + ":" + _min + ":" + sec;

  // print time
  document.getElementsByClassName("hms")[0].innerHTML = currentTime;
  document.getElementsByClassName("ampm")[0].innerHTML = ampm;

  /* date */
  var dow = [
      "Pazar",
      "Pazartesi",
      "Salı",
      "Çarşamba",
      "Perşembe",
      "Cuma",
      "Cumartesi"
    ],
    month = [
      "Ocak", 
	  "Şubat", 
	  "Mart", 
	  "Nisan", 
	  "Mayıs", 
	  "Haziran", 
	  "Temmuz", 
	  "Ağustos", 
	  "Eylül", 
	  "Ekim", 
	  "Kasım", 
	  "Aralık"
    ],
    day = dateInfo.getDate();

  // store date
  var currentDate = dow[dateInfo.getDay()] + ", " + day + " " + month[dateInfo.getMonth()];

  document.getElementsByClassName("date")[0].innerHTML = currentDate;
};

// print time and date once, then update them every second
updateTime();
setInterval(function() {
  updateTime()
}, 1000);
</script>
    <script>
        
        var span = document.getElementById('span');

function time() {
  var d = new Date();
  var s = d.getSeconds();
  var m = d.getMinutes();
  var h = d.getHours();
  span.textContent = 
    ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
}

setInterval(time, 1000);
    </script>
    
    
    <script>
$(document).ready(function() {
    $('#options').select2();
});
</script>


      <script>      
        document.getElementById("btn")
            .onclick = function(){
                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/';}, 4000);                        
             };
    </script>
@endpush

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    
    <style>

.time {
    background: yellow;
    color: blue;
    border: 7px solid rgb(255, 252, 252);
    box-shadow: 0 2px 10px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    padding: 8px;
    text-align: center;
    width: 500px;
}
.hms {
    font-size: 48pt;
    font-weight: 200;
}
.ampm {
    font-size: 22pt;
}
.date {
    font-size: 15pt;
}
  </style>
    
    <style>
        
       body{
    background:#f5f5f5;
    margin-top:20px;
}
.card {
    border: none;
    -webkit-box-shadow: 1px 0 20px rgba(96,93,175,.05);
    box-shadow: 1px 0 20px rgba(96,93,175,.05);
    margin-bottom: 30px;
}
.table th {
    font-weight: 500;
    color: #827fc0;
}
.table thead {
    background-color: #f3f2f7;
}
.table>tbody>tr>td, .table>tfoot>tr>td, .table>thead>tr>td {
    padding: 14px 12px;
    vertical-align: middle;
}
.table tr td {
    color: #8887a9;
}
.thumb-sm {
    height: 32px;
    width: 32px;
}
.badge-soft-warning {
    background-color: rgba(248,201,85,.2);
    color: #f8c955;
}

.badge {
    font-weight: 500;
}
.badge-soft-primary {
    background-color: rgba(96,93,175,.2);
    color: #605daf;
}
    </style>

@endpush

@push('script')
    <script src="/assets/admin/vendor/slugify/slugify.js"></script>
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/admin/vendor/cleave/cleave.min.js"></script>
    <script src="/assets/admin/vendor/vue/vue.min.js"></script>


    
    <script type="text/javascript">
  var query=<?php echo json_encode((object)Request::only(['services','options'])); ?>;
//search ara butonu

  function search_post(){

           Object.assign(query,{'service': $('#service_filter').val()});
           Object.assign(query,{'options': $('#options_filter').val()});

            window.location.href="{{route('admin.contractendings')}}?"+$.param(query);

  }

</script>

@endpush
@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>

    <script>
       $(document).ready(function() {
            $('#dataTable').DataTable( {
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
               columnDefs: [{
                    "type": "num",
                    "targets": 0
                }],
                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Ödemeler'
                    }
                ],
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [ 2, 3, 4, 5, 6]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 1 ) {
                            var select = $('<select class="form-control text-white bg-info" style="width:100px;"><option value="">Tümü</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
            });
        });

    </script>
    
        <script>
       $(document).ready(function() {
            $('#dataTable3').DataTable( {
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
               columnDefs: [{
                    "type": "num",
                    "targets": 0
                }],
                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Ödemeler'
                    }
                ],
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [ 2, 3, 4, 5, 6]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 1 ) {
                            var select = $('<select class="form-control text-white bg-info" style="width:100px;"><option value="">Tümü</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
            });
        });

    </script>

    
    <script>
        $(function() {
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            alert()->success('Başarılı!', 'Makaleniz Başarılı Bir Şekilde oluşturuldu.');
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
    </script>
    

    
<script>
    $(function checkRegistration() {
        $('#btnSave').on('click', function (event) {
            //alert()->success('Başarılı!', 'Makaleniz Başarılı Bir Şekilde oluşturuldu.');
           alert('Given data is incorrect21');
             return redirect();
            // relative_route('admin.contractending.store')
        });

    });

</script>

@endpush



