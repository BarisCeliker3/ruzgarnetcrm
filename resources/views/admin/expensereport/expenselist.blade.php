@extends('admin.layout.main')

@section('title', meta_title('Gider Listesi'))

@section('content')
    <div class="row">
        <div class="col-12">
            
       
    <!-- START HAZIRLIK -->
            <div class="card list">
                <div class="card-header">
                  
                    <h4 style="font-size:22px;"> 
                    <span style="color:white;">Gider Evrakları </span></h4>

                    <div class="card-header-buttons">
                        <a style="" href="{{ route('admin.giderekle') }}" class="pdf-btn btn">
                            <i class="fa fa-file-pdf bg-danger"></i> Dekont Yükle
                        </a>
                    </div>
                </div>
                
                <hr style="border-bottom:2px solid #ff6347;">
                                
     <div class="card-body">
                    <div class="table-responsive">
                         <table class="table table-striped" id="dataTable">
                            <thead style="font-size:15px;background:#87CEEB;">
								<tr>
                                    <th scope="col">#</th>
                                    <th style="color:#403f3d;" scope="col">Fatura</th>
                                    <th style="color:#403f3d;" scope="col">Kategori</th>
                                    <th style="color:#403f3d;" scope="col">Fiyat</th>
                                    <th style="color:#403f3d;" scope="col">Not</th>
                                    <th style="color:#403f3d;" scope="col">Personel</th>
                                    <th style="color:#403f3d;" scope="col">Tarih</th>
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($expens as $expen)
                                    <tr>
                                        <th scope="row"><span class="text-black"> {{ $loop->iteration }}</span></th>
                                        <td>
                                            
                                            @if($expen->image)
                                            <span class="btn btn-outline-secondary badge-pill"> 
                                               <a href="/dekont/{{$expen->image}}" target="_blank">
                                                @if($expen->name=='MUTFAK')
                                                    <i class="fas fa-utensils" aria-hidden="true" title="{{ $expen->id }}" style="color:#1378e7; font-size:35px;"></i>
                                                @elseif($expen->name=='POS')
                                                    <i class="fa fa-turkish-lira" aria-hidden="true" title="{{ $expen->id }}" style="color:#65af30; font-size:35px;"></i>
                                                @elseif($expen->name=='GÜNLÜK KASA')
                                                    <i class="fas fa-cash-register" aria-hidden="true" title="{{ $expen->id }}" style="color:#6d41bf; font-size:35px;"></i>
                                                @elseif($expen->name=='YAKIT')
                                                    <i class="fas fa-gas-pump" aria-hidden="true" title="{{ $expen->id }}" style="color:#e56515; font-size:35px;"></i>
                                                @elseif($expen->name=='DİĞER GİDERLER')
                                                    <i class="fa fa-list" aria-hidden="true" title="{{ $expen->id }}" style="color:#217d80; font-size:35px;"></i>
                                                @elseif($expen->name=='DEKONT')
                                                    <i class="fa fa-list-alt" aria-hidden="true" title="{{ $expen->id }}" style="color:#ad0000; font-size:35px;"></i>
                                                @endif 
                                               </a>
                                             </span>
                                             @else
                                             <span style="font-size:15px;" class="badge badge-pill badge-secondary">BOŞ</span>
                                             @endif
                                        </td>
                                        <td title="{{ $expen->id}}">{{ $expen->name }}</td>
                                        <td><span style="font-size:15px" class="badge badge-pill badge-success">{{number_format($expen->price,2,'.',',')}} ₺</span></td>
                                        <td><span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true"  data-placement="right" title="{{ $expen->note }}">
                                              <button class="btn btn-info badge-pill" style="font-size:15px; pointer-events: none;" type="button" disabled>Not</button>
                                            </span></td>
                                        <td>{{ $expen->first_name }} {{ $expen->last_name }}  </td>
                                        <td title="{{ $expen->start_date }}">{{ \Carbon\Carbon::parse($expen->start_date)->format('m Y') }} </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
    <!-- END HAZIRLIK -->   


        @php
        
    $labelsabone17 = "";
    $dataabone17 = "";

    foreach($mtfkRapor as $mutfakRapo){
        $labelsabone17.= "\"$mutfakRapo->created_at\",";
        $dataabone17.= "$mutfakRapo->id,";

    }
    
    
    
    $labelsabone18 = "";
    $dataabone18 = "";

    foreach($psRapor as $psRapo){
        $labelsabone18.= "\"$psRapo->created_at\",";
        $dataabone18.= "$psRapo->id,";

    }
    
    
    $labelsabone19 = "";
    $dataabone19 = "";

    foreach($gnlkRapor as $gnlkRapo){
        $labelsabone19.= "\"$gnlkRapo->created_at\",";
        $dataabone19.= "$gnlkRapo->id,";

    }
    
    
    $labelsabone20 = "";
    $dataabone20 = "";

    foreach($yktRapor as $yktRapo){
        $labelsabone20.= "\"$yktRapo->created_at\",";
        $dataabone20.= "$yktRapo->id,";

    }
    
    
    $labelsabone21 = "";
    $dataabone21 = "";

    foreach($dgdrRapor as $dgdrRapo){
        $labelsabone21.= "\"$dgdrRapo->created_at\",";
        $dataabone21.= "$dgdrRapo->id,";

    }
    
    $labelsabone22 = "";
    $dataabone22 = "";

    foreach($dkntRapor as $dkntRapo){
        $labelsabone22.= "\"$dkntRapo->created_at\",";
        $dataabone22.= "$dkntRapo->id,";

    }
    
        @endphp

        <div class="card-header">
            <h3 style="text-align:center;" style="font-size:22px;"> 
            <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 
            <span   class="text-dark">2023 Yılı Gider Raporu</span></h3>
        </div>
        
        <div class="aylar">
          <button class="col-md-2 tablink" onclick="openCity('ocak', this, 'orange')" id="defaultOpen"><i style="20px" class="fas fa-utensils"></i> MUTFAK</button>
          <button class="col-md-1 tablink" onclick="openCity('subat', this, 'green')"><i style="20px" class="fa fa-turkish-lira"></i> POS</button>
          <button class="col-md-2 tablink" onclick="openCity('mart', this, 'blue')"><i style="20px" class="fas fa-cash-register"></i> GÜNLÜK KASA</button>
          <button class="col-md-2 tablink" onclick="openCity('nisan', this, 'orange')"><i style="20px" class="fas fa-gas-pump"></i> YAKIT</button>
          <button class="col-md-3 tablink" onclick="openCity('mayis', this, 'red')"><i style="20px" class="fa fa-list"></i> DİĞER GİDERLER</button>
          <button class="col-md-2 tablink" onclick="openCity('haziran', this, 'orange')"><i style="20px" class="fa fa-list-alt"></i> DEKONT</button>
        </div>
    
    
    
        <div id="ocak" class="tabcontent">
            <h1 class="text-dark">Mutfak Raporu</h1>
        	<div class="col-md-12 bg-light text-dark">
              <canvas id="myChart1" style="position: relative; height:40vh; width:80vw"></canvas>
            </div>
            
        </div>
        
        <div id="subat" class="tabcontent">
          <h1 class="text-dark">POS Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart2" style="position: relative; height:40vh; width:80vw"></canvas>
            </div>
        </div>
        
        <div id="mart" class="tabcontent">
           <h1 class="text-dark">Günlük Kasa Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart3" style="position: relative; height:40vh; width:80vw"></canvas>
         </div>
        </div>
        
        <div id="nisan" class="tabcontent">
          <h1 class="text-dark">Yakıt Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart4" style="position: relative; height:40vh; width:80vw"></canvas>
         </div>
        </div>

        <div id="mayis" class="tabcontent">
           <h1 class="text-dark">Diğer Giderler Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart5" style="position: relative; height:40vh; width:80vw"></canvas>
         </div>
        </div>
        
        <div id="haziran" class="tabcontent">
           <h1 class="text-dark">Dekont Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart6" style="position: relative; height:40vh; width:80vw"></canvas>
         </div>
        </div>
        
     
        </div>
        
        
        
        

    </div>
    
    

@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'><link rel="stylesheet" href="./style.css">

    <style>
    .pdf-btn{
        font-size:14px!important;
        background: #ed2626;
        color:#fff;
        padding:4px 10px;
    }
    .pdf-btn:hover{
        color: #fff;
        background: #ad0c0c!important;
    }
    .zoom{
         transition: transform .2s;
         text-align: center;
    }
    .zoom:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(1.2); 
      text-align: center;
      position:relative;
      z-index:99999999999;
    }
    
</style>
    -
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
    

   
      
  <script>
$(document).ready(function(){
    $('.counter-value').each(function(){
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        },{
            duration: 3500,
            easing: 'swing',
            step: function (now){
                $(this).text(Math.ceil(now));
            }
        });
    });
});
    </script>
    
    <script>
$(document).ready(function() {
    $('#options').select2();
});
</script>



@endpush

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     <style>


.tablink {
  background-color: #090979;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
}

.tablink:hover {
  background-color: #FFB300;
}

/* Style the tab content */
.tabcontent {
  color: white;
  display: none;
  padding: 50px;
  text-align: center;
}


#ocak {background-color:#e3eaef;}
#subat {background-color:#e3eaef;}
#mart {background-color:#e3eaef;}
#nisan {background-color:#e3eaef;}
#mayis {background-color:#e3eaef;}
#haziran {background-color:#e3eaef;}

.aylar{
    margin-bottom:70px!important;
}
</style>

@endpush

@push('script')
    <script src="/assets/admin/vendor/slugify/slugify.js"></script>
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/admin/vendor/cleave/cleave.min.js"></script>
    <script src="/assets/admin/vendor/vue/vue.min.js"></script>

      
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>


<script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx = document.getElementById("myChart1").getContext('2d');

var myChart1 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Toplam Gider',
            data: [{!! $dataabone17 !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


<script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx2 = document.getElementById("myChart2").getContext('2d');

var myChart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Toplam Gider',
            data: [{!! $dataabone18 !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


<script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx3 = document.getElementById("myChart3").getContext('2d');

var myChart3 = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Toplam Gider',
            data: [{!! $dataabone19 !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>



<script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx4 = document.getElementById("myChart4").getContext('2d');

var myChart4 = new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Toplam Gider',
            data: [{!! $dataabone20 !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


<script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx5 = document.getElementById("myChart5").getContext('2d');

var myChart5 = new Chart(ctx5, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Toplam Gider',
            data: [{!! $dataabone21 !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


<script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx6 = document.getElementById("myChart6").getContext('2d');

var myChart6 = new Chart(ctx6, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Toplam Gider',
            data: [{!! $dataabone22 !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

    
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
         $(function() {
            $("#dataTable").dataTable({
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                columnDefs: [{
                    "type": "num",
                    "targets": 0
                },{ "orderable": false, "targets": [1, 2, 3, 4] }],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 3 && column[0][0] != 4)
                        {
                            var select = $('<select class="form-control text-white bg-warning" style="width:100px;"><option value="">TÜMÜ</option></select>')
                            .appendTo( $(column.header()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
            });
        })

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




    <script>
function openCity(cityName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(cityName).style.display = "block";
  elmnt.style.backgroundColor = color;

}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>



<script>
function openCity1(cityName1,elmnt1,color1) {
  var i, tabcontent1, tablinks1;
  tabcontent1 = document.getElementsByClassName("tabcontent1");
  for (i = 0; i < tabcontent1.length; i++) {
    tabcontent1[i].style.display = "none";
  }
  tablinks1 = document.getElementsByClassName("tablink1");
  for (i = 0; i < tablinks1.length; i++) {
    tablinks1[i].style.backgroundColor = "";
  }
  document.getElementById(cityName1).style.display = "block";
  elmnt1.style.backgroundColor = color1;

}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen1").click();
</script>



@endpush



