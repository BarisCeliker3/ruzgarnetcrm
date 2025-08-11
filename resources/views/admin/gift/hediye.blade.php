@extends('admin.layout.main')

@section('title', meta_title('Hediye'))

@section('content')
    <div class="row">
        <div class="col-12">
            
       
    <!-- START HAZIRLIK -->
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:22px;"><span class="text-warning">Akıllı Bileklik</span> Kampanyasında Hak Kazananlar</h4>

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
                            <thead style="font-size:15px;background:#7c56d9;">
								<tr>
                                    <th style="color:white;" scope="col">#</th>
                                    <th style="color:white;" scope="col">Resim</th>
                                    <th style="color:white;" scope="col">Temsilci</th>
                                    <th style="color:white;" scope="col">Müşteri</th>
                                    <th style="color:white;" scope="col">Tarife</th>
                                    <th style="color:white;" scope="col">Tarih</th>
                                    <th style="color:white;" scope="col">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($paymentGifts as $paymentGift)
                                    
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                         <td><img style="height:50px;" class="zoom img-fluid" src="https://www.ruzgarnet.com.tr/static/images/kampanya/b87ed1698b.jpeg" alt=""> </td>
                                        <td>{{ $paymentGift->temsilci}} {{ $paymentGift->last_name}}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$paymentGift->customer_id}}">{{ $paymentGift->isim }}</a></td>
                                        <td>{{ $paymentGift->name}}</td>
                                        <td class="zoom2"><span style="font-size:14px;" class="badge badge-pill badge-light">{{$paymentGift->approved_at}}</span></td>
                                        <td><a href="{{ route('admin.hediyeGonder', $paymentGift->id) }}" title="Hediye Gönder">
                                                <button type="button" class="btn btn-outline-primary btn-floating" data-mdb-ripple-color="dark">
                                                   <i class="fas fa-edit"></i>
                                               </button>
                                            </a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
    <!-- END HAZIRLIK -->   
    
   
            
        </div>
         <div class="col-12">
            
       
    <!-- START HAZIRLIK -->
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:22px;"><span class="text-success">Akıllı Bileklik</span> Kampanyasında Hediye Gönderilenler</h4>

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
                         <table class="table table-striped" id="dataTable2">
                            <thead style="font-size:15px;background:#e76d33;">
								<tr>
                                    <th style="color:white;" scope="col">#</th>
                                    <th style="color:white;" scope="col">Resim</th>
                                    <th style="color:white;" scope="col">Temsilci</th>
                                    <th style="color:white;" scope="col">Müşteri</th>
                                    <th style="color:white;" scope="col">Tarife</th>
                                    <th style="color:white;" scope="col">Not</th>
                                    <th style="color:white;" scope="col">Tarih</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($paymentGift2 as $paymentGif)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td><img style="height:50px;" class="zoom img-fluid" src="https://www.ruzgarnet.com.tr/static/images/kampanya/b87ed1698b.jpeg" alt=""> </td>
                                        <td>{{ $paymentGif->temsilci}} {{ $paymentGif->last_name}}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$paymentGif->customer_id}}">{{ $paymentGif->isim }}</a></td>
                                        <td>{{ $paymentGif->name}}</td>
                                        <td>{{ $paymentGif->note}}</td>
                                        <td class=""><span style="font-size:14px;" class="badge badge-pill badge-light">{{$paymentGif->approved_at}}</span></td>
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
    .zoom{
         transition: transform .2s;
         text-align: center;
    }
    .zoom:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(2.3); 
      text-align: center;
      position:relative;
      z-index:99999999999;
    }
    .zoom2{
         transition: transform .2s;
         text-align: center;
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
                        if(column[0][0] != 0 && column[0][0] != 1  && column[0][0] != 3 && column[0][0] != 5 && column[0][0] != 6)
                        {
                            var select = $('<select class="form-control " style="color:#511adb!important; background-color: #ffffff!important; width:100px;"><option value="">TÜMÜ</option></select>')
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
            $("#dataTable2").dataTable({
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
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 3  && column[0][0] != 5 && column[0][0] != 6)
                        {
                            var select = $('<select class="form-control" style="color:#ff5300!important; background-color: #ffffff!important;width:100px;"><option value="">TÜMÜ</option></select>')
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



