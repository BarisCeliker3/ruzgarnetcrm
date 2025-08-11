@extends('admin.layout.main')

@section('title', meta_title('Stok Müşteri Listesi'))

@section('content')
    <div class="section-header">
        <h1>Stok Müşteri Listesi</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <hr style="border-bottom:2px solid #0000FF;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead style="font-size:15px;background:#ffd28e ;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ad Soyad</th>
                                    <th scope="col">Resim</th>
                                    <th scope="col">Ürün</th>
                                    <th scope="col">Seri No</th>
                                   <!-- <th scope="col">Stok Adet</th> -->
                                    <th scope="col">Durum</th>
                                    <th scope="col">Ödeme</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">Not</th>
                                    <th scope="col">Tarih</th>
                                    <th scope="col">Düzenle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stok_takips as $stok_takip )
                                    <tr>
                                        <th scope="row"> <a class="text-dark" title="" style="font-size:15px;" target="_blank" href="" >{{ $loop->iteration }}</a></th>
                                        <td><span class="text-dark">{{$stok_takip->customers_name}}</span></td>
                                        <td>
                                            @if($stok_takip->kategori ==1)
                                                <img style="max-height:50px;" class="zoom2 img-fluid" src="/resimlers/stok-modem.png" alt="MODEM">
                                            @elseif($stok_takip->kategori ==2)
                                                <img style="max-height:50px;" class="zoom2 img-fluid" src="/resimlers/stok-aksesuar.png" alt="AKSESUARLAR">
                                            @elseif($stok_takip->kategori ==3)
                                                <img style="max-height:50px;" class="zoom2 img-fluid" src="/resimlers/stok-cihaz.png" alt="CİHAZLAR">
                                            @elseif($stok_takip->kategori ==4)
                                                <img style="max-height:50px;" class="zoom2 img-fluid" src="/resimlers/stok-uydu.png" alt="UYDU SİSTEMİ">
                                            @else
                                            
                                            @endif
                                        </td>
                                        <td>{{$stok_takip->model}}</td>
                                        <td>{{$stok_takip->serino}}</td>
                                        <!-- <td><span class="badge badge-pill badge-info">{{$stok_takip->stok_adet}}</span></td> -->
                                        <td>{{$stok_takip->status}}</td>
                                        <td>{{$stok_takip->payment}}</td>
                                        <td>{{number_format( $stok_takip->price, 2, '.',',') }}</td>
                                                                                    
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true"  data-placement="right" title="{{ $stok_takip->note }}">
                                              <button class="btn btn-danger badge-pill" style="pointer-events: none;" type="button" disabled>NOT</button>
                                            </span>
                                        </td>            
                                        <td title="{{ $stok_takip->start_date }}">{{ \Carbon\Carbon::parse($stok_takip->start_date)->format('m Y') }} </td>
                                        <td>@if ($stok_takip->status == "Geri İade")
                                            <i class="fa fa-exclamation-triangle text-warning" aria-hidden="true" style="font-size:32px;" title="Geri İade"></i>
                                            @else
                                            @if (request()->user()->role_id == 5)
                                            <a href="{{ route('admin.stoklistedit2', $stok_takip->id) }}">
                                                <button type="button" class="btn btn-outline-success btn-floating" data-mdb-ripple-color="dark">
                                                  İade
                                               </button>
                                            </a>
                                            @else
                                            <a href="{{ route('admin.stoklistedit', $stok_takip->id) }}">
                                                <button type="button" class="btn btn-outline-primary btn-floating" data-mdb-ripple-color="dark">
                                                   <i class="fas fa-edit"></i>
                                               </button>
                                            </a>
                                            <a href="{{ route('admin.stoklistedit2', $stok_takip->id) }}">
                                                <button type="button" class="btn btn-outline-success btn-floating" data-mdb-ripple-color="dark">
                                                  İade
                                               </button>
                                            </a>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" style="text-align:right"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        
        
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
     <style>
     .zoom2:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(2.2); 
      text-align: center;
      position:relative;
      z-index:99999999999;
    }

   </style>
    
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(function () {
  $('[data-toggle="tooltip1"]').tooltip()
})
</script>
</script>
    <script>
        $(function() {
            $("#dataTable").dataTable({
                lengthMenu: [

                    [10, 25, 50, 100, -1],

                    [10, 25, 50, 100, 'Tümü'],

                ],
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                columnDefs: [{
                    "type": "num",
                    "targets": 0
                },{ "orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7, 8] }],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] != 0 && column[0][0] != 1  && column[0][0] != 2  && column[0][0] != 4 && column[0][0] != 7  && column[0][0] != 9 && column[0][0] != 10)
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
                        if(column[0][0] == 1 || column[0][0] == 4)
                        {
                            $('<input style="width:90px;" type="text" class="form-control text-dark bg-light" placeholder="Arama" />')
                            .appendTo( $(column.header()).empty() )
                            .on( 'input', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search('^'+val, true, false)
                                    .draw();
                            } );
                        }
                    } );
                },
                 // --TOPLAM TUTAR                

    headerCallback: function (row, data, start, end, display) {

        var api = this.api();

        

        // Remove the formatting to get integer data for summation

        var intVal = function (i) {

            return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;

        };

        

        // Total over all pages

        total = api

            .column(7)

            .data()

            .reduce(function (a, b) {

                return intVal(a) + intVal(b);

            }, 0);

        

        // Total over this page

        pageTotal = api

            .column(7, { page: 'current' })

            .data()

            .reduce(function (a, b) {

                return intVal(a) + intVal(b);

            }, 0);

        

        // Update footer

        $(api.column(7).header()).html( 'Toplamı: '+pageTotal + ' ₺ ');

        $(api.column(6).footer()).html('Bulunduğunuz Sayfa Toplamı: '+pageTotal + '₺');

        // $(api.column(5).footer()).html('Toplam: '+total + '₺');

    }



// --TOPLAM TUTAR
            });
        })

   
       
    </script>
@endpush
