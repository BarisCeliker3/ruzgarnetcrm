@extends('admin.layout.main')

@section('title', meta_title('Aylık Gider Raporu'))

@section('content')
    <div class="section-header">
        <h1>@lang('tables.expensereport.title')</h1>
    </div>
    <div class="row">
        <div class="col-12">
   <!--          
            <div class="card list">
                <div class="card-header">
                    <h4></h4>
                   
                    <div class="card-header-buttons">
                        <a href="{{ route('admin.stokCustomersEkle') }}">
                            <button type="button" class="button">
                        		<span class="button__text">Gider Ekle</span>
                        		<span class="button__icon">
                        			<ion-icon name="person-add-outline"></ion-icon>
                        		</span>
                            </button>
                        </a>
                       
                    </div>
                </div>
 -->
 
 
        <!-- 
       // $aylik = "";
        //foreach($GenelToplam as $GenelTopla){
           // $aylik.= "$GenelTopla->id";
        }
       -->
 
 @php

       
        $aylik1 = "";
        foreach($mutfakToplam as $mutfakTopla){
            $aylik1.= "$mutfakTopla->id";
        }
        
        $aylik2 = "";
        foreach($posToplam as $posTopla){
            $aylik2.= "$posTopla->id";
        }
        $aylik3 = "";
        foreach($yakitToplam as $yakitTopla){
            $aylik3.= "$yakitTopla->id";
        }
        
        $aylik4 = "";
        foreach($digerGiderlerToplam as $digerGiderlerTopla){
            $aylik4.= "$digerGiderlerTopla->id";
        }
        
        $aylik5 = "";
        foreach($kasaToplam as $kasaTopla){
            $aylik5.= "$kasaTopla->id";
        }
        
        $aylik6 = "";
        foreach($dekontToplam as $dekontTopla){
            $aylik6.= "$dekontTopla->id";
        }
        
        
 @endphp
                <div class="row">
                        <!-- GİDERLER -->
                        <div class="container">
                            <div class="row align-middle">
                                <!-- GİDER-->
                                <div class="col-md-6 col-lg-4 column">
                                    <div class="card gr-1">
                                        <div class="txt">
                                            <h1>MUTFAK GİDERLERİ <br>Toplam Gider: <b>{!!  $aylik1 !!} ₺</b></h1>
                                        </div>
                                        <a href="{{ route('admin.mutfak') }}">İncele</a>
                                        <div class="ico-card">
                                            <i class="fas fa-utensils"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- //GİDER-->
                                <!-- GİDER-->
                                <div class="col-md-6 col-lg-4 column">
                                    <div class="card gr-2">
                                        <div class="txt">
                                            <h1>POS <br>Toplam Gider: <b>{!!  $aylik2 !!} ₺</b></h1>
                                        </div>
                                        <a href="{{ route('admin.pos') }}">İncele</a>
                                        <div class="ico-card">
                                            <i class="fa fa-turkish-lira"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- //GİDER-->
                                <!-- GİDER-->
                                <div class="col-md-6 col-lg-4 column">
                                    <div class="card gr-3">
                                        <div class="txt">
                                            <h1>GÜNLÜK KASA <br>Toplam Gider: <b>{!!  $aylik5 !!} ₺</b></h1>
                                        </div>
                                        <a href="{{ route('admin.kasa') }}">İncele</a>
                                        <div class="ico-card">
                                            <i class="fas fa-cash-register"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- //GİDER-->
                                <!-- GİDER-->
                                <div class="col-md-6 col-lg-4 column">
                                    <div class="card gr-4">
                                        <div class="txt">
                                            <h1>YAKIT<br>Toplam Gider: <b>{!!  $aylik3 !!} ₺</b></h1>
                                            
                                        </div>
                                        <a href="{{ route('admin.yakit') }}">İncele</a>
                                        <div class="ico-card">
                                            <i class="fas fa-gas-pump"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- //GİDER-->
                                <!-- GİDER-->
                                <div class="col-md-6 col-lg-4 column">
                                    <div class="card gr-5">
                                        <div class="txt">
                                            <h1>DİĞER GİDERLER <br>Toplam Gider: <b>{!!  $aylik4 !!} ₺</b></h1>
                                        </div>
                                        <a href="{{ route('admin.digerGiderler') }}">İncele</a>
                                        <div class="ico-card">
                                            <i class="fa fa-list"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- //GİDER-->
                                <!-- GİDER-->
                                <div class="col-md-6 col-lg-4 column">
                                    <div class="card gr-6">
                                        <div class="txt">
                                            <h1>DEKONT <br>Toplam Gider: <b>{!!  $aylik6 !!} ₺</b></h1>
                                        </div>
                                        <a href="{{ route('admin.dekont') }}">İncele</a>
                                        <div class="ico-card">
                                            <i class="fa fa-list-alt"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- //GİDER-->
                                
                            </div>
                        </div>
                    <!-- //GİDERLER -->

                      
                </div>
            </div>
            
        </div>
    </div>
   
   
   
    <div class=" container-fluid my-5 ">
    <div class="row justify-content-center ">
        <div class="col-xl-10">
            <div class="card shadow-lg ">
                
                <div class="row  mx-auto justify-content-center text-center">
                    <div class="col-12 mt-3 ">
                         <h4 style="font-size:37px;">Bu Aylık Genel Toplam</h4>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-md-9">
                        <div class="card border-0 ">
                            <div class="card-header">
                                <p class="card-text text-muted mb-2 space">Gider Listesi <span class=" small text-muted ml-2 cursor-pointer">AYLIK GENEL TOPLAM</span> </p>
                                <hr class="my-2">
                            </div>
                            
                            <div class="card-body pt-0">
                                <div class="sehir zoom row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="/resimlers/mutfak-rp.png" width="50" height="50">
                                            <div style="margin-left: 15px;" class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col-auto"><p class="mb-0"><a style="font-size:18px; text-align:left;" href="{{ route('admin.mutfak') }}"><b>MUTFAK GİDERLERİ</b></a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" pl-0 flex-sm-col col-auto  my-auto "><p style="font-size:15px; color:#f00;"><b>{!!  $aylik1 !!} ₺</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="sehir zoom  row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="/resimlers/pos-rp.png" width="50" height="50">
                                            <div style="margin-left: 15px;" class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><a style="font-size:18px;" href="{{ route('admin.pos') }}"><b>POS</b></a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p style="font-size:15px; color:#f00;"><b>{!!  $aylik2 !!} ₺</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="sehir zoom  row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="/resimlers/kasa-rp.png" width="50" height="50">
                                            <div style="margin-left: 15px;" class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><a style="font-size:18px;" href="{{ route('admin.kasa') }}"><b>GÜNLÜK KASA</b></a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p style="font-size:15px; color:#f00;"><b>{!!  $aylik5 !!} ₺</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="sehir zoom  row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="/resimlers/yakit-rp.png" width="50" height="50">
                                            <div style="margin-left: 15px;" class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><a style="font-size:18px;" href="{{ route('admin.yakit') }}"><b>YAKIT</b></a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p style="font-size:15px; color:#f00;"><b>{!!  $aylik3 !!} ₺</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="sehir zoom  row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="/resimlers/diger-rp.png" width="50" height="50">
                                            <div style="margin-left: 15px;" class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><a style="font-size:18px;" href="{{ route('admin.digerGiderler') }}"><b>DİĞER GİDERLER</b></a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p style="font-size:15px; color:#f00;"><b>{!!  $aylik4 !!} ₺</b></p></div>
                                </div>
                                <hr class="my-2">
                                <div class="sehir zoom  row  justify-content-between">
                                    <div class="col-auto col-md-7">
                                        <div class="media flex-column flex-sm-row">
                                            <img class=" img-fluid" src="/resimlers/dekont-rp.png" width="55" height="50">
                                            <div style="margin-left: 15px;" class="media-body  my-auto">
                                                <div class="row ">
                                                    <div class="col"><p class="mb-0"><a style="font-size:18px;" href="{{ route('admin.dekont') }}"><b>DEKONT</b></a></p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-0 flex-sm-col col-auto my-auto"><p style="font-size:15px; color:#f00;"><b>{!!  $aylik6 !!} ₺</b></p></div>
                                </div>
                                <hr class="my-2" style="border-bottom:2px solid #6777ef;">
                                <div class="sehir zoom  row ">
                                    <div class="col">
                                        <div class="row justify-content-between">
                                            <div class="col-4"><p style="font-size:20px"><b>Toplam</b></p></div>
                                            <div class="pl-0 flex-sm-col col-auto  my-auto"> <p style="font-size:20px" class="boxed">{{ number_format($GenelToplam, 2, '.', ',') }} ₺</p></div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                          
                            
                                <hr class="my-2">
                                <div id="accordion">
                                <div  class="card">
                                    <div class="card-header" id="headingTwo">
                                      <h4  style="text-decoration: underline;" class="mb-0">
                                        <button  style="color:black;font-size:25px;" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                          Aylık Gider Raporu
                                        </button>
                                      </h4>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                      <div class="card-body">
                                          
                                        @php 
                                            $labelsabone17 = "";
                                            $dataabone17 = "";
                                        
                                            
                                            
                                            foreach($aylikToplam as $mutfakRapo){
                                                $labelsabone17.= "\"$mutfakRapo->created_at\",";
                                                $dataabone17.= "$mutfakRapo->id,";
                                                 
                                            }
                                        @endphp
        
                                            <div class="gider-tablosu col-12">
                                                <div id="ocak" class="gider-tablo tabcontent">
                                                    <h1 class="text-dark"> <span  class="text-dark">2023 Yılı <span style="color:#824abe;">Aylık</span> Gider Raporu</span></h1>
                                                	<div class="col-md-12 bg-light text-dark">
                                                      <canvas id="myChart"  style="position: relative; height:100vh; width:100vw"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'><link rel="stylesheet" href="./style.css">
   
      
   <style>
   .sehir{
       padding:7px 10px!important;
   }
       .sehir:hover{
           background: #FAD7A0 ;
           
       }
       .zoom{
         transition: transform .2s;
         text-align: left;
    }
    .zoom:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(1.1); 
      text-align: left;
      position:relative;
      z-index:99999999999;
    }
    .sehir-kpy{
        opacity: 0;
    }
   </style>
   
   <style>
       .shop{
    font-size: 10px;
}

.space{
    letter-spacing: 0.8px !important;
}

.second a:hover {
    color: rgb(92, 92, 92) ;
}

.active-2 {
    color: rgb(92, 92, 92) 
}


.breadcrumb>li+li:before {
    content: "" !important
}

.breadcrumb {
    padding: 0px;
    font-size: 10px;
    color: #aaa !important;
}

.first {
    background-color: white ;
}

a {
    text-decoration: none !important;
    color: #aaa ;
}

.btn-lg,.form-control-sm:focus,
.form-control-sm:active,
a:focus,a:active {
    outline: none !important;
    box-shadow: none !important
}

.form-control-sm:focus{
    border:1.5px solid #4bb8a9 ; 
}

.btn-group-lg>.btn, .btn-lg {
    padding: .5rem 0.1rem;
    font-size: 1rem;
    border-radius: 0;
    color: white !important;
    background-color: #4bb8a9;
    height: 2.8rem !important;
    border-radius: 0.2rem !important;
}

.btn-group-lg>.btn:hover, .btn-lg:hover {
    background-color: #26A69A;
}

.btn-outline-primary{
    background-color: #fff !important;
    color:#4bb8a9 !important;
    border-radius: 0.2rem !important;   
    border:1px solid #4bb8a9;
}

.btn-outline-primary:hover{
    background-color:#4bb8a9  !important;
    color:#fff !important;
    border:1px solid #4bb8a9;
}

.card-2{
    margin-top: 40px !important;
}

.card-header{
    background-color: #fff;
    border-bottom:0px solid #aaaa !important;
}

p{
    font-size: 13px ;
}
        
.small{
    font-size: 9px !important;
}

.form-control-sm {
    height: calc(2.2em + .5rem + 2px);
    font-size: .875rem;
    line-height: 1.5;
    border-radius: 0;   
}

.cursor-pointer{
    cursor: pointer;
}

.boxed {
    padding: 0px 8px 0 8px ;
    background-color: #4bb8a9;
    color: white;
}

.boxed-1{
    padding: 0px 8px 0 8px ;
    color: black !important;
    border: 1px solid #aaaa;
}

.bell{
    opacity: 0.5;
    cursor: pointer;
}

@media (max-width: 767px) {
    .breadcrumb-item+.breadcrumb-item {
        padding-left: 0
    }
}
   </style>
   
    <style>
        @import url("https://fonts.googleapis.com/css?family=Oswald:300,400,500,700");
@import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800");
.gr-1 {
  background: linear-gradient(170deg, #01E4F8 0%, #1D3EDE 100%);
}

.gr-2 {
  background: linear-gradient(170deg, #B4EC51 0%, #429321 100%);
}

.gr-3 {
  background: linear-gradient(170deg, #C86DD7 0%, #3023AE 100%);
}
.gr-4 {
    background:linear-gradient(170deg, #de761d 0%, #f83a01 100%);
}
.gr-5 {
    background:linear-gradient(170deg, #57ffd8 0%, #074056 100%);
}
.gr-6 {
    background:linear-gradient(170deg, #e16b6b 0%, #c50e0e 100%);
}

* {
  transition: 0.5s;
}

.h-100 {
  height: 100vh !important;
}

.align-middle {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}

.column {
  margin-top: 3rem;
  padding-left: 3rem;
}
.column:hover {
  padding-left: 0;
}
.column:hover .card .txt {
  margin-left: 1rem;
}
.column:hover .card .txt h1, .column:hover .card .txt p {
  color: white;
  opacity: 1;
}
.column:hover a {
  color: white;
}
.column:hover a:after {
  width: 10%;
}

.card {
  min-height: 170px;
  margin: 0;
  padding: 1.7rem 1.2rem;
  border: none;
  border-radius: 0;
  color: black;
  letter-spacing: 0.05rem;
  font-family: "Oswald", sans-serif;
  box-shadow: 0 0 21px rgba(0, 0, 0, 0.27);
}
.card .txt {
  margin-left: -3rem;
  z-index: 1;
}
.card .txt h1 {
  font-size: 1.5rem;
  font-weight: 300;
  text-transform: uppercase;
}
.card .txt p {
  font-size: 0.7rem;
  font-family: "Open Sans", sans-serif;
  letter-spacing: 0rem;
  margin-top: 33px;
  opacity: 0;
  color: white;
}
.card a {
  z-index: 3;
  font-size: 0.7rem;
  color: black;
  margin-left: 1rem;
  position: relative;
  bottom: -0.5rem;
  text-transform: uppercase;
}
.card a:after {
  content: "";
  display: inline-block;
  height: 0.5em;
  width: 0;
  margin-right: -100%;
  margin-left: 10px;
  border-top: 1px solid white;
  transition: 0.5s;
}
.card .ico-card {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
}
.card i {
  position: relative;
  right: -50%;
  top: 60%;
  font-size: 12rem;
  line-height: 0;
  opacity: 0.2;
  color: white;
  z-index: 0;
}
    </style>  
    

    <style>
        .button {
	display: flex;
	height: 50px;
	padding: 0;
	background: #090979	;
	border: none;
	outline: none;
	border-radius: 5px;
	overflow: hidden;
	font-family: "Quicksand", sans-serif;
	font-size: 18px;
	font-weight: 500;
	cursor: pointer;
}

.button:hover {
	background: #FFA500	;
}

.button:active {
	background: #ffd700;
}

.button__text,
.button__icon {
	display: inline-flex;
	align-items: center;
	padding: 0 24px;
	color: #fff;
	height: 100%;
}

.button__icon {
	font-size: 1.5em;
	background: rgba(0, 0, 0, 0.08);
}
    </style>
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
  
  
  <script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Aylık Gider',
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
        $(function() {
            $("#dataTable").dataTable({
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                columnDefs: [{
                    "type": "num",
                    "targets": 0
                }]
            });
        })

    </script>
@endpush
