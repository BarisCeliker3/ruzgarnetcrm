@extends('admin.layout.main')

@section('title', meta_title('Günlük Şehir Listesi'))

@section('content')
    <div class="section-header">
        <h1>@lang('tables.citylist.title')</h1>
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
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <!-- ŞEHİR LİSTESİ -->
                        <ul class="row list-group">
                            @foreach($citylists as $citylist)
                                <li class="col-md-12 sehir zoom list-group-item d-flex justify-content-between align-items-center">
                                    <span style="font-size:18px;font-weight: bold;" class="text-dark">{{ $citylist->sehir }}</span> 
                                    <span class="badge badge-success badge-pill">{{ $citylist->id }}</span>
                                </li>
                            @endforeach
                        </ul>
                    <!-- //ŞEHİR LİSTESİ -->
                    </div>
<div class="col-md-4">
<div class="row p-2 justify-content-center">
<div class="col-md-12 d-flex justify-content-center align-items-center mt-2">
<button onclick="kopyala()" class="btn btn-primary">Şehir Listesini Kopyala</button>
</div>
<div class="col-md-6 d-flex justify-content-center align-items-center">
<textarea class="sehir-kpy form-control" id="metin">
@foreach($citylists as $citylist)@if($citylist->id == 1){{ $citylist->sehir }}@else{{ $citylist->sehir }}-{{ $citylist->id }} @endif 
@endforeach
</textarea>
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
           background: #f7b687;
           
       }
       .zoom{
         transition: transform .2s;
         text-align: center;
    }
    .zoom:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(1.1); 
      text-align: center;
      position:relative;
      z-index:99999999999;
    }
    .sehir-kpy{
        opacity: 0;
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
    <script>
        function kopyala(){
var text = document.getElementById("metin");
text.select();
document.execCommand("copy");
}
    </script>
@endpush
