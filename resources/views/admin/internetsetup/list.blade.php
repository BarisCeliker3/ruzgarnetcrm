@extends('admin.layout.main')

@section('title', meta_title('İnternet Kurulum'))

@section('content')
    <div class="row">
        <div class="col-12">
            
       
    <!-- START HAZIRLIK -->
            <div class="card list">
                <div class="card-header">
                  
                    <h4 style="font-size:22px;"> 
                    <span style="color:#0000b4;">İnternet kurulum Listesi</span></h4>
                    <div class="card-header-buttons">
                        <a style="" href="{{ route('admin.internetsetup')}}" class="pdf-btn btn">
                            <i class="fa fa-wifi"></i> Kurulum Ekle
                        </a>
                    </div>
                </div>
                
                <hr style="border-bottom:2px solid #ff6347;">
                                
     <div class="card-body">
                    <div class="table-responsive">
                         <table class="table table-striped" id="dataTable">
                            <thead style="font-size:15px;background:#ff9108;">
								<tr>
                                    <th style="color:#fff;" scope="col">#</th>
                                    <th style="color:#fff;" scope="col">Temsilci</th>
                                    <th style="color:#fff;" scope="col">Müşteri</th>
                                    <th style="color:#fff;" scope="col">Adres</th>
                                    <th style="color:#fff;" scope="col">BBK</th>
                                    <th style="color:#fff;" scope="col">Kullanıcı Adı</th>
                                    <th style="color:#fff;" scope="col">Şifre</th>
                                    <th style="color:#fff;" scope="col">Not</th>
                                    <th style="color:#fff;" scope="col">Durumu</th>
                                    <th style="color:#fff;" scope="col">Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($internetsetups as $internet )
                                    <tr>
                                        <th scope="row"><span class="text-danger">{{ $loop->iteration }}</span></th>
                                        <td>{{ $internet->first_name }} {{ $internet->last_name }}</td>
                                        <td>{{ $internet->customer_name }}<br>{{ $internet->telephone }}</td>
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true"  data-placement="right" title="{{ $internet->adress }}">
                                                <button class="not-btn btn btn-info badge-pill" style="pointer-events: none;" type="button" disabled>Adres</button>
                                            </span>
                                        </td>
                                        <td>{{ $internet->bbk_code }}</td>
                                        <td>{{ $internet->users_name }}</td>
                                        <td>{{ $internet->users_password }}</td>
                                        <td> 
                                             <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true"  data-placement="right" title="{{ $internet->note }}">
                                                <button class="not-btn btn btn-info badge-pill" style="pointer-events: none;" type="button" disabled>Not</button>
                                            </span>
                                        </td>
                                         @if($internet->status == 1)
                                            <td style="font-size:16px; font-weight: bold; " class="text-warning">BEKLEMEDE</td>
                                            @elseif($internet->status == 2)
                                            <td style="font-size:16px; font-weight: bold; " class="text-success">KURULDU</td>
                                            @elseif($internet->status == 3)
                                            <td style="font-size:16px; font-weight: bold; " class="text-danger">İPTAL</td>
                                            @else
                                            {{ $internet->status }}
                                            @endif
                                        <td>{{ $internet->start_date }}</td>
                                    </tr>
                                   @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
    <!-- END HAZIRLIK -->   

   
            
        </div>

    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    <style>
    .drm-kuruldu{
         background: #44dd48!important;
    }
    .drm-iptal{
         background: #f00!important;
         color:#fff!important;
    }
    .drm-bekleme{
        background: #f5cd08!important;
    }
    .not-btn{
        background: #4d08f5!important;
    }
    
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
                        if(column[0][0] != 0 && column[0][0] != 2 && column[0][0] != 3  && column[0][0] != 4 && column[0][0] != 5 && column[0][0] != 6 && column[0][0] != 7 && column[0][0] != 9 )
                        {
                            var select = $('<select class="form-control text-white bg-info" style="width:100px;"><option value="">TÜMÜ</option></select>')
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



