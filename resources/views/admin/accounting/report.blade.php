@extends('admin.layout.main')



@section('title', meta_title('tables.accounting.title'))



@section('content')
<style>
    .approved-row {
        background-color: #e6ffed !important; /* açık yeşil */
        transition: background-color 0.3s ease;
    }
    
    .un-approved-row {
        background-color: #fff5f5 !important; /* açık kırmızı */
        transition: background-color 0.3s ease;
    }
    .title-table{
        color:white !important;
    }
    .table-custom-header {
        border-top-left-radius: 10vh;
    border-top-right-radius: 10vh;
        background: linear-gradient(90deg, #1e3a8a, #2563eb); /* Lacivert - Mavi geçiş */
        color: white; /* Turkuaz tonlu yazı */
        font-weight: bold;
        border-bottom: 2px solid #0ea5e9;
    }
    .table-custom-header:hover {
        background: linear-gradient(90deg, #2563eb, #1e3a8a); /* Ters geçiş */
        color: #ffffff;
    }
    /* Hover efekti */
    .table-hover tbody tr:hover {
        background-color: #f0f8ff !important;
        cursor: pointer;
        transform: scale(1.01);
        transition: all 0.2s ease-in-out;
    }
    
    /* Popover butonu */
    .btn-danger.btn-sm {
        margin-top: 5px;
        font-size: 0.75rem;
        padding: 2px 6px;
    }
    
    /* Responsive tablo */
    .table-responsive {
        border-radius: 10px;
        overflow-x: auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    </style>
    <div class="row">

        <div class="col-12">

            <div class="card list">

                <div class="card-header">

                    <h4>Aylık<span class="text-danger"> Eft/Havale</span></h4>

                    

                    <div class="card-header-buttons">

                        <a href="{{ route('admin.accounting.add') }}" class="btn btn-primary">

                            <i class="fas fa-sm fa-plus"></i> @lang('tables.accounting.add')

                        </a>

                    </div>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table border="0" cellspacing="5" cellpadding="5">

                        <tbody>

                            <tr>

                                <td><span  style="font-size:18px;" class="text-primary">Başlangıç Tarihi:</span></td>

                                <td><input style="background:#de39ff; color:#fff; font-size:18px;" type="text" id="min" name="min" class="form-control"></td>

                                <td><span  style="font-size:18px;" class="text-danger">Bitiş Tarihi:</span></td>

                                <td><input style="background:#de39ff; color:#fff; font-size:18px;" type="text" id="max" name="max" class="form-control"></td>

                                <td><button type="button" onclick="location.href='https://crm.ruzgarnet.site/accounting/report'" class="btn12 btn-danger">Temizle</button></td>

                            </tr>

                            

                        </tbody>

                    </table>

                        <table id="example" class="table table-hover table-striped" >




        <thead class="table-custom-header">

								<tr>

									<th class="title-table" scope="col">#</th>

									<th class="title-table" scope="col">İsim Soyisim</th>

									<th class="title-table" scope="col">İçerik</th>

									<th class="title-table" scope="col">Banka</th>

									<th class="title-table" scope="col">Ödeme</th>

									<th class="title-table" style="min-width:170px;" scope="col">Tutar</th>  <!-- style="min-width:115px;" -->

									<th class="title-table" scope="col">Not</th>

									<th class="title-table" scope="col">Tarih</th>

								</tr>

                            </thead>



                            <tbody style="background: aliceblue;">

                                @foreach ($accountings as $accounting)

                                    <tr data-id="{{ $accounting->id }}">

                                        <th scope="row">{{ $loop->iteration }}</th>

                                        <td>{{ $accounting->name_surname }}</td>

                                        <td>@if($accounting->contents!=null) @lang('tables.accounting.contents.'.$accounting->contents) @endif</td>

                                        <td>@if($accounting->bank!=null) @lang('tables.accounting.bank.'.$accounting->bank) @endif</td>

                                        <td>@if($accounting->payment_type!=null) @lang('tables.accounting.payment_type.'.$accounting->payment_type) @endif</td>

                                        <td class="text-green-500">{{number_format( $accounting->price, 2, '.',',') }}</td>

                                        <td>

                                            <a  href="#" data-toggle="modal"

                                       data-target="#icerik{{ $accounting->id }}">

                                       <span class="badge badge-light badge-pill"> 

                                              <span style="font-size:14px; background-color: #8e44ad; /* Mor ton */
    color: #fff;" value="{{$accounting->note}}" class="badge badge-pill badge-purple">OKU</span>

                                           

                                        </span>

                                       </a>

                                    <!-- Logout Modal-->

                                    <div class="modal fade" id="icerik{{ $accounting->id }}" tabindex="-1" role="dialog"

                                         aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Fatura Notu</h5>

                                                    <button class="close" type="button" data-dismiss="modal"

                                                            aria-label="Close">

                                                        <span aria-hidden="true">×</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">{{ $accounting->note }}</div>

                                                <div class="modal-footer">

                                                    <button class="btn btn-dark" type="button"

                                                            data-dismiss="modal">Kapat

                                                    </button>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                            

                                        </td>

                                        <td>{{ $accounting->date }}</td>

                                    </tr>

                                @endforeach

                            </tbody>



    <tfoot>

    	<tr>

    		<th colspan="5" style="text-align:right">Toplam:</th>

    		<th></th>

    	</tr>

    </tfoot>



                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

    

 <section id="stats-subtitle">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <div class="card">

                <div class="card-content" style="background: #ededed;">

                    <h2 style="text-align:center; margin-top:15px" class="text-dark">Muhasebe Yıllık <span class="text-warning">Eft/Havale</span> Ödeme</h2>

                    <canvas style="padding:45px" id="myChartabone" ></canvas>

                </div>

            </div>

        </div>

        <!--

        <div class="col-md-6">

            <div class="card">

                <div class="card-content">

                    <h2 style="text-align:center; margin-top:15px" class="text-dark">Muhasebe Yıllık <span class="text-danger"> POST </span> Ödeme</h2>

                    <canvas style="padding:45px" id="myChartabone2" ></canvas>

                </div>

            </div>

        </div>

        -->

    </div>

   

   

</section>

        

    

@endsection



@push('style')

    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">

    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">

    

     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

      <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.3.1/css/dataTables.dateTime.min.css">



<style>



button {

  text-decoration: none;

  display: inline-block;

  font-size: 12px;

  width: 110px;

  padding: 1em 2em;

  text-align:center;

  letter-spacing: .10em;

  background: #000000;

  color: #ffffff;

  border-radius: .3em;

  transition: all 0.4s ease;

}

    .btn12 {

  position: relative;

  top: 0px;

  left: 0px;

}



.btn12:hover {

  box-shadow: 10px 10px 0px #a7a7a7;

  top: -5px;

  left: -5px;

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

    <script src="/assets/admin/vendor/datatables/dataTables.dateTime.min.js"></script>

    

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    

    

   <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script> 

    <script src="https://cdn.datatables.net/datetime/1.3.1/js/dataTables.dateTime.min.js"></script> -->





<script>

    var minDate, maxDate;

 

// 2 Tarih Arası Filtreleme

$.fn.dataTable.ext.search.push(

    function( settings, data, dataIndex ) {

        var min = minDate.val();

        var max = maxDate.val();

        var date = new Date( data[7] );

 

        if (

            ( min === null && max === null ) ||

            ( min === null && date <= max ) ||

            ( min <= date   && max === null ) ||

            ( min <= date   && date <= max )

        ) {

            return true;

        }

        return false;

    }

);

 



       $(document).ready(function() {

            

            $('#example').DataTable( {

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

                        title: 'Post/Havale-Raporu'

                    }

                ],

                columnDefs: [

                    {"type": "num", "targets": 0},

                    {"orderable": false, "targets": [ 2, 3, 4, 5, 6]}

                ],

                lengthMenu: [

                    [10, 25, 50, 100, -1],

                    [10, 25, 50, 100, 'Tümü'],

                ],

                initComplete: function () {

                    this.api().columns().every( function () {

                        var column = this;

                        if( column[0][0] == 2 || column[0][0] == 3  || column[0][0] == 7 ) {

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

                    

                      if(column[0][0] == 1)

                        {

                            $('<input style="width:110px;" type="text" class="form-control text-dark bg-light" placeholder="İsim Soyisim" />')

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

            .column(5)

            .data()

            .reduce(function (a, b) {

                return intVal(a) + intVal(b);

            }, 0);

        

        // Total over this page

        pageTotal = api

            .column(5, { page: 'current' })

            .data()

            .reduce(function (a, b) {

                return intVal(a) + intVal(b);

            }, 0);

        

        // Update footer

        $(api.column(5).header()).html( 'Toplamı: '+pageTotal + ' ₺ ');

        $(api.column(2).footer()).html('Bulunduğunuz Sayfa Toplamı: '+pageTotal + '₺');

        // $(api.column(5).footer()).html('Toplam: '+total + '₺');

    },



// --TOPLAM TUTAR

        

            });

            minDate = new DateTime($('#min'), {

                format: 'YYYY-MM-DD'

            });

            maxDate = new DateTime($('#max'), {

                format: 'YYYY-MM-DD'

            });

           $('#min, #max').on('change', function () {

                table.draw();

            });

        });

        

    </script>

    

    

    

    

    <script>

    @php

    $labelsabone = "";

    $dataabone = "";

    

    foreach($havele as $havel){

        

        $dataabone.= "$havel->price,";

    }

    @endphp

  const myChartabone = document.getElementById('myChartabone');



  new Chart(myChartabone, {

    type: 'doughnut',

    data: {

      labels: ['Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],

      datasets: [{

        label: 'Aylık Eft/Havale Sayısı',

        data: [{!! $dataabone !!}],

        borderWidth: 2

      }]

    },

    options: {

      scales: {

        y: {

          beginAtZero: true

        }

      }

    }

  });

</script>



 <script>

    @php

    $labelsabone2 = "";

    $dataabone2 = "";

    

    foreach($post as $pos){

        

        $dataabone2.= "$pos->price,";

    }

    @endphp

  const myChartabone2 = document.getElementById('myChartabone2');



  new Chart(myChartabone2, {

    type: 'doughnut',

    data: {

      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],

      datasets: [{

        label: 'Aylık POST Sayısı',

        data: [{!! $dataabone2 !!}],

        borderWidth: 2

      }]

    },

    options: {

      scales: {

        y: {

          beginAtZero: true

        }

      }

    }

  });

</script>



@endpush

