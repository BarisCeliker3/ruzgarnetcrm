@extends('admin.layout.main')

@section('title', meta_title('Stok Takip'))

@section('content')
    <div class="section-header">
        <h1>@lang('tables.stoktakip.title') Sistemi</h1>
    </div>
    <div class="row">
        <div class="col-12">
            
            <div class="card list">
                <div class="card-header">
                    <h4></h4>

                    <div class="card-header-buttons">
                        
                        <a href="{{ route('admin.eskiiade') }}">
                            <button type="button" class="button">
                        		<span class="button__text">Eski İade</span>
                        		<span class="button__icon">
                        			<ion-icon name="person-add-outline"></ion-icon>
                        		</span>
                            </button>
                        </a>
                        
                        <a href="{{ route('admin.stokCustomersEkle') }}">
                            <button type="button" class="button">
                        		<span class="button__text">Stok Müşteri Kaydı</span>
                        		<span class="button__icon">
                        			<ion-icon name="person-add-outline"></ion-icon>
                        		</span>
                            </button>
                        </a>
                        
                         @if (request()->user()->role_id == 5)
                           
                            @else
                        <a href="{{ route('admin.stokekle') }}">
                            <button type="button" class="button">
                        		<span class="button__text">Stok Ekle</span>
                        		<span class="button__icon">
                        			<ion-icon name="bag-add-outline"></ion-icon>
                        		</span>
                            </button>
                        </a>
                       @endif    
                    </div>
                </div>
<hr style="border-bottom:2px solid #ff6347;">
               
                <div class="row">
                    <div class="col-md-3 card-body">
                        <ul class="list-group">
                          <li href="#" class="list-group-item list-group-item-action active">
                             <h5>Kiralık Ürünler</h5>
                          </li>
                          @foreach($stok_kiralıks as $stok_kiralık)
                          <li class="zoom sehir list-group-item d-flex justify-content-between align-items-center">
                            <span style="font-size:15px;font-weight: bold;">{{ $stok_kiralık->model }}</span>
                            <span style="font-size:16px;" class="badge badge-primary badge-pill"> {{ $stok_kiralık->id }}</span>
                          </li>
                         @endforeach
                         
                        </ul>
                    </div>
                      <div class="col-md-3 card-body">
                        <ul class="list-group">
                          <li href="#" class="list-group-item list-group-item-action active">
                          <h5>Satılık Ürünler</h5> 
                          </li>
                          @foreach($stok_satlıks as $stok_satlık)
                          <li class="zoom sehir list-group-item d-flex justify-content-between align-items-center">
                             <span style="font-size:15px;font-weight: bold;">{{ $stok_satlık->model }}</span>
                            <span style="font-size:16px;" class="badge badge-primary badge-pill"> {{ $stok_satlık->id }}</span>
                          </li>
                         @endforeach
                         
                        </ul>
                      </div> 
                      <div class="col-md-3 card-body">
                        <ul class="list-group">
                          <li href="#" class="list-group-item list-group-item-action active">
                           <h5>Geri İade Ürünler</h5>
                          </li>
                          @foreach($stok_geriiades as $stok_geriiade)
                          <li class="zoom sehir list-group-item d-flex justify-content-between align-items-center">
                             <span style="font-size:15px;font-weight: bold;">{{ $stok_geriiade->model }}</span>
                             <span style="font-size:16px;" class="badge badge-primary badge-pill"> {{ $stok_geriiade->id }}</span>
                          </li>
                         @endforeach
                         
                        </ul>
                      </div> 
                      
                      <div class="col-md-3 card-body">
                        <ul class="list-group">
                          <li href="#" class="list-group-item list-group-item-action active">
                           <h5>Eski İade Ürünler</h5>
                          </li>
                          @foreach($eski_iade as $eski_iad)
                          <li class="zoom sehir list-group-item d-flex justify-content-between align-items-center">
                             <span style="font-size:15px;font-weight: bold;">{{ $eski_iad->model }}</span>
                             <span style="font-size:16px;" class="badge badge-primary badge-pill"> {{ $eski_iad->id }}</span>
                          </li>
                         @endforeach
                         
                        </ul>
                      </div>
                      
                    </div>
                    <hr style="border-bottom:2px solid #ff6347;">
                <div class="row">
                         @foreach($stok_tables as $stok_table)
                        <!-- Ürün -->
                    <div class="col-md-4 card-body">
                        <div class="card2">
                            <div class="card-body-mdm card-body">
                                @if($stok_table->name =="MODEM")
                                <img style="height:90px;" class="zoom2 img-fluid" src="resimlers/stok-modem.png" alt="">
                                @elseif($stok_table->name =="AKSESUARLAR")
                                <img style="height:90px;" class="zoom2 img-fluid" src="resimlers/stok-aksesuar.png" alt="">
                                @elseif($stok_table->name =="CİHAZLAR")
                                <img style="height:90px;" class="zoom2 img-fluid" src="resimlers/stok-cihaz.png" alt="">
                                @elseif($stok_table->name =="UYDU SİSTEMİ")
                                <img style="height:90px;" class="zoom2 img-fluid" src="resimlers/stok-uydu.png" alt="">
                                @else
                                
                                @endif
                                
                                <p class="name">{{ $stok_table->name }}</p>
                                <a href="javascript:void(0);" class="mail"><b>{{ $stok_table->model }}</b></a>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="stok-sayisi col-md-12">
                                        <h2><span class="badge badge-pill badge-warning">{{ $stok_table->stok_adet }}</span></h2>
                                        <span class="text-light">Stok Sayısı</span>
                                    </div>

                                </div>
                            </div>
                            @if (request()->user()->role_id == 5)
                           
                            @else
                             <div class="social-links">
                                <a href="{{ route('admin.stokedit', $stok_table->id) }}" class="social-icon"> Düzenle</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- //Ürün -->
                      @endforeach
                      
                      
                </div>
            </div>
            
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    
    
     <style>

     .sehir:hover{
           background: #FF8C00;
           color: white;
    }
    
    .zoom{
         transition: transform .2s;
         text-align: center;
         color: black;
    }
    .zoom:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(1.1); 
      text-align: center;
      position:relative;
      z-index:99999999999;
       
    }
    
     .zoom2:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(1.6); 
      text-align: center;
      position:relative;
      z-index:99999999999;
    }

   </style>
   
   
    <style>
.card2 {
    background-color: #336acb;
    box-shadow: 0 10px 90px #c9c9c9;
    text-align: center;
    font-size: 20px;
    border-radius: 15px;
}
.card-body-mdm{
    background-color: #2cacf7!important;
    margin-bottom:20px;
    border-radius:10px;
}
.stok-sayisi{
    color:#343434;
}
}

.card2 .card-header {
    position: relative;
    height: 48px;
}
.card2 .card-header .profile-img {
    width: 130px;
    height: 130px;
    border-radius: 1000px;
    position: absolute;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 8px solid #c74385;
    box-shadow: 0 0 20px #00000033;
}

.card2 .card-header .profile-img:hover {
    width: 180px;
    height: 180px;
    border: 8px solid #d885af;
}
.card2 .card-body {
    padding: 10px 40px;
    box-shadow: 0px 9px 5px #444
}

.card2 .card-body .name {
    margin-top: 30px;
    font-size: 22px;
    font-weight: bold;
    color: #fff;
}

.card2 .card-body .name:hover {
    margin-top: 30px;
    font-size: 24px;
    color:	#ffff00;
}

.card2 .card-body .mail {
    font-size: 16px;
    color: #fff;
}

.card2 .card-body .mail:hover {
    font-size: 16px;
    color: #ffffff;
}

.card2 .card-body .job {
    margin-top: 10px;
    font-size: 14px;
}
.card2 .social-links {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
}

.card2 .social-links .social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding:10px;
    background-color: red;
    color: #ffffff;
    font-size: 20px;
    border-radius: 20px;
    text-decoration: none;
    margin: 0 13px 30px 0;
}

.card2 .social-links .social-icon:last-child {
    margin-right: 0;
}

.card2 .social-links .social-icon:hover {
    background-color: #ffc107;
   
    text-decoration: none;
}
.card2 .card-footer {
    background-color: #c74385;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
    padding: 20px 0 20px 0;
}

.card2 .card-footer .count {
    font-size: 14px;
}
@media screen and (max-width: 575px) {
    .card2 {
        width: 96%;
    }

    .card2 .card-body {
        padding: 10px 20px;
    }
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
