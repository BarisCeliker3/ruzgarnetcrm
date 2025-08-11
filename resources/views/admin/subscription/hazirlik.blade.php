@extends('admin.layout.main')

@section('title', meta_title('Hazırlık Aşaması'))

@section('content')
    <div class="row">
        <div class="col-12">
            
       
    <!-- START HAZIRLIK -->
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:22px;"><span class="text-white">Hazırlık</span> Aşamasında Olan Aboneler</h4>

                <!-- <div class="card-header-buttons">
                        <a href="/contract-notes/1" class="btn btn-primary"><i
                            class="fas fa-sm fa-plus"></i>Not Ekle
                        </a>
                    </div>
                    -->
                </div>
                
                <hr style="border-bottom:2px solid #ff6347;">
                                
     <div class="card-body">
                    <div class="table-responsive">
                         <table class="table table-striped" id="dataTable">
                            <thead style="font-size:15px;background:#3498DB;">
								<tr>
                                    <th scope="col">#</th>
                                    <th style="color:white;" scope="col">Temsilci</th>
                                    <th style="color:white;" scope="col">Müşteri</th>
                                    <th style="color:white;" scope="col">Tarife</th>
                                    <th style="color:white;" scope="col">Durumu</th>
                                    <th style="color:white;" scope="col">Tarih</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($subsupgradesalti as $subsupaltiend)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $subsupaltiend->temsilci}} {{ $subsupaltiend->last_name}}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subsupaltiend->customer_id}}">{{ $subsupaltiend->isim }}</a></td>
                                        <td><span class="text-dark bg-white">{{ $subsupaltiend->name}}</span></td>
                                        <td>
                                            @if($subsupaltiend->status == 0)
                                            <span style="font-size:13px;" class="badge badge-pill badge-warning">Hazırlık</span>
                                            @endif
                                        </td>
                                        <td><span style="font-size:14px;" class="badge badge-pill badge-light">{{$subsupaltiend->created_at}}</span></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
    <!-- END HAZIRLIK -->   
     @php
      $dataid1 = "";
    foreach($huriyes as $huriye){
        $dataid1.= "$huriye->id";
    }
    
    $dataid2 = "";
    foreach($fatmas as $fatma){
        $dataid2.= "$fatma->id";
    }
    
    $dataid3 = "";
    foreach($yunuss as $yunus){
        $dataid3.= "$yunus->id";
    }
    
    $dataid4 = "";
    foreach($serkans as $serkan){
        $dataid4.= "$serkan->id";
    }
    
    $dataid5 = "";
    foreach($gizems as $gizem){
        $dataid5.= "$gizem->id";
    }

   
    @endphp
   <div class="container">
    <div style="justify-content: space-between;" class="row">
        <div class="zoom plt-hazirlik col-md-4 col-sm-6">
            <div  class="counter">
                <div class="counter-icon">
                    <i class="fa fa-users"></i>
                </div>
                <span class="counter-value"> {!!  number_format($dataid1) !!}</span>
                <h3>HURİYE KILIÇ</h3>
            </div>
        </div>
        
        <div class="zoom plt-hazirlik col-md-4 col-sm-6">
            <div class="counter2">
                <div class="counter-icon">
                    <i class="fa fa-users"></i>
                </div>
                <span class="counter-value">{!!  number_format($dataid2) !!}</span>
                <h3>FATMANUR BALLI</h3>
            </div>
        </div>
        
       <!--  <div class="zoom plt-hazirlik col-md-4 col-sm-6">
            <div class="counter blue">
                <div class="counter-icon">
                    <i class="fa fa-users"></i>
                </div>
                <span class="counter-value">{!!  number_format($dataid4) !!}</span>
                <h3>SERKAN BİROL</h3>
            </div>
        </div>
        -->
        <!--
        <div class="zoom plt-hazirlik col-md-3 col-sm-6">
            <div class="counter">
                <div class="counter-icon">
                    <i class="fa fa-users"></i>
                </div>
                <span class="counter-value">{!!  number_format($dataid5) !!}</span>
                <h3>GİZEM GÜVEN</h3>
            </div>
        </div>
        -->
    </div>
</div>
   
            
        </div>

    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    <style>
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
    <style>
    /*TOPLAM VERİLER*/
    .plt-hazirlik{
        margin-bottom:20px;
    }
    /*TOPLAM VERİLER*/
       .counter2{
      color: #b721f2;
    font-family: 'Open Sans', sans-serif;
    text-align: center;
    height: 190px;
    width: 190px;
    padding: 30px 25px 25px;
    margin: 0 auto;
    border: 3px solid #da21f2;
    border-radius: 20px 20px;
    position: relative;
    z-index: 1;
}
       .counter{
      color: #3900ef;
    font-family: 'Open Sans', sans-serif;
    text-align: center;
    height: 190px;
    width: 190px;
    padding: 30px 25px 25px;
    margin: 0 auto;
    
    border: 3px solid #3900ef;
    border-radius: 20px 20px;
    position: relative;
    z-index: 1;
}
.counter2:before,
.counter2:after{
    content: "";
    background: #f3f3f3;
    border-radius: 20px;
    box-shadow: 4px 4px 2px rgba(0,0,0,0.2);
    position: absolute;
    left: 15px;
    top: 15px;
    bottom: 15px;
    right: 15px;
    z-index: -1;
}
.counter:before,
.counter:after{
    content: "";
    background: #f3f3f3;
    border-radius: 20px;
    box-shadow: 4px 4px 2px rgba(0,0,0,0.2);
    position: absolute;
    left: 15px;
    top: 15px;
    bottom: 15px;
    right: 15px;
    z-index: -1;
}
.counter2:after{
    background: transparent;
    width: 100px;
    height: 100px;
 
    border: 15px solid #b721f2;
    border-top: none;
    border-right: none;
    border-radius: 0 0 0 20px;
    box-shadow: none;
    top: auto;
    left: -10px;
    bottom: -10px;
    right: auto;
}
.counter:after{
    background: transparent;
    width: 100px;
    height: 100px;
    border:15px solid #4521f2;
 
    border-top: none;
    border-right: none;
    border-radius: 0 0 0 20px;
    box-shadow: none;
    top: auto;
    left: -10px;
    bottom: -10px;
    right: auto;
}

.counter2 .counter-icon{
    font-size: 35px;
    line-height: 35px;
    margin: 0 0 15px;
    transition: all 0.3s ease 0s;
}
.counter .counter-icon{
    font-size: 35px;
    line-height: 35px;
    margin: 0 0 15px;
    transition: all 0.3s ease 0s;
}
.counter:hover .counter-icon{ transform: rotateY(360deg); }
.counter2:hover .counter-icon{ transform: rotateY(360deg); }
.counter .counter-value{
    color: #555;
    font-size: 30px;
    font-weight: 600;
    line-height: 20px;
    margin: 0 0 20px;
    display: block;
    transition: all 0.3s ease 0s;
}
.counter2 .counter-value{
    color: #555;
    font-size: 30px;
    font-weight: 600;
    line-height: 20px;
    margin: 0 0 20px;
    display: block;
    transition: all 0.3s ease 0s;
}
.counter:hover .counter-value{ text-shadow: 2px 2px 0 #d1d8e0; }
.counter2:hover .counter-value{ text-shadow: 2px 2px 0 #d1d8e0; }
.counter h3{
    font-size: 17px;
    font-weight: 700;
    text-transform: uppercase;
    margin: 0 0 15px;
}
.counter2 h3{
    font-size: 17px;
    font-weight: 700;
    text-transform: uppercase;
    margin: 0 0 15px;
}
.counter.blue{
    color: #4accdb;
    border-color: #4accdb;
}
.counter.blue:after{
    border-bottom-color: #4accdb;
    border-left-color: #4accdb;
}
.counter2.blue{
    color: #4accdb;
    border-color: #4accdb;
}
.counter2.blue:after{
    border-bottom-color: #4accdb;
    border-left-color: #4accdb;
}


@media screen and (max-width:990px){
    .counter{ margin-bottom: 40px; }
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
                        if(column[0][0] != 0 && column[0][0] != 2 && column[0][0] != 3 && column[0][0] != 4 && column[0][0] != 5)
                        {
                            var select = $('<select class="form-control text-white bg-danger" style="width:100px;"><option value="">TÜMÜ</option></select>')
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

@endpush



