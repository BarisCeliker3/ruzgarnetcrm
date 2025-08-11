@extends('admin.layout.main')
@section('title', meta_title('tables.accounting.title'))
@section('content')

    <div class="row">
        <div class="col-12">
        <!--  Tablo-1 -->
            <div class="card list">
                <div class="card-header">
                    <h4><span class="text-white">Bu Ayın Ödemeleri </span>(<span style="text-shadow:4px 4px 8px;" class="text-danger"  id="demo"></span>)</h4>
                    <div class="card-header-buttons">
                        <a href="{{ route('admin.accounting.add') }}" class="btn btn-primary">
                            <i class="fa fa-cart-plus"></i> @lang('tables.accounting.add')
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" >
                            <thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">İsim Soyisim</th>
									<th scope="col">İçerik</th>
									<th scope="col">Banka</th>
									<th scope="col">Ödeme</th>
									<th style="min-width:170px;" scope="col">Tutar</th>  <!-- style="min-width:115px;" -->
									<th scope="col">Not</th>
									<th scope="col">Tarih</th>
								</tr>
                            </thead>
                            <tbody>
                                @foreach ($accountings as $accounting)
                                    <tr data-id="{{ $accounting->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $accounting->name_surname }}</td>
                                        <td>@if($accounting->contents!=null) @lang('tables.accounting.contents.'.$accounting->contents) @endif</td>
                                        <td>@if($accounting->bank!=null) @lang('tables.accounting.bank.'.$accounting->bank) @endif</td>
                                        <td>@if($accounting->payment_type!=null) @lang('tables.accounting.payment_type.'.$accounting->payment_type) @endif</td>
                                        <td>{{number_format( $accounting->price, 2, '.',',') }}</td>
                                        <td>{{ $accounting->note }}</td>
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
        <!--  Tablo-1 -->

        <!--  Tablo-2 -->
        <div class="card list">
                <div class="card-header">
                    <h4><span class="text-white">Bir Önceki Ayın Ödemeleri</span> (<span style="text-shadow:4px 4px 8px ;" class="text-dark" id="demo2"></span>)</h4>
                    <div class="card-header-buttons">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped" >
                            <thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">İsim Soyisim</th>
									<th scope="col">İçerik</th>
									<th scope="col">Banka</th>
									<th scope="col">Ödeme</th>
									<th style="min-width:170px;" scope="col">Tutar</th>
									<th scope="col">Not</th>
									<th scope="col">Tarih</th>
								</tr>
                            </thead>
                            <tbody>
                                @foreach ($accountings21 as $accounting)
                                    <tr data-id="{{ $accounting->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $accounting->name_surname }}</td>
                                        <td>@if($accounting->contents!=null) @lang('tables.accounting.contents.'.$accounting->contents) @endif</td>
                                        <td>@if($accounting->bank!=null) @lang('tables.accounting.bank.'.$accounting->bank) @endif</td>
                                        <td>@if($accounting->payment_type!=null) @lang('tables.accounting.payment_type.'.$accounting->payment_type) @endif</td>
                                        <td>{{number_format( $accounting->price, 2, '.',',') }}</td>
                                        <td>{{ $accounting->note }}</td>
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
        <!--  Tablo-2 -->
        
        <!--  Tablo-3 -->
        <div class="card list">
                <div class="card-header">
                    <h4><span class="text-white">İki Önceki Ayın Ödemeleri</span> (<span style="text-shadow:4px 4px 8px ;" class="text-warning" id="demo3"></span>)</h4>
                    <div class="card-header-buttons">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="table table-striped" >
                            <thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">İsim Soyisim</th>
									<th scope="col">İçerik</th>
									<th scope="col">Banka</th>
									<th scope="col">Ödeme</th>
									<th style="min-width:170px;" scope="col">Tutar</th>
									<th scope="col">Not</th>
									<th scope="col">Tarih</th>
								</tr>
                            </thead>
                            <tbody>
                                @foreach ($accountings51 as $accountings5)
                                    <tr data-id="{{ $accountings5->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $accountings5->name_surname }}</td>
                                        <td>@if($accountings5->contents!=null) @lang('tables.accounting.contents.'.$accountings5->contents) @endif</td>
                                        <td>@if($accountings5->bank!=null) @lang('tables.accounting.bank.'.$accountings5->bank) @endif</td>
                                        <td>@if($accountings5->payment_type!=null) @lang('tables.accounting.payment_type.'.$accountings5->payment_type) @endif</td>
                                        <td>{{number_format( $accountings5->price, 2, '.',',') }}</td>
                                        <td>{{ $accountings5->note }}</td>
                                        <td>{{ $accountings5->date }}</td>
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
        <!--  Tablo-3 -->
         <div class="card list">
                <div class="card-header">
                    <h4><span class="text-white">İki Önceki Ayın Ödemeleri</span> (<span style="text-shadow:4px 4px 8px ;" class="text-warning" id="demo4"></span>)</h4>
                    <div class="card-header-buttons">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-striped" >
                            <thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">İsim Soyisim</th>
									<th scope="col">İçerik</th>
									<th scope="col">Banka</th>
									<th scope="col">Ödeme</th>
									<th style="min-width:170px;" scope="col">Tutar</th>
									<th scope="col">Not</th>
									<th scope="col">Tarih</th>
								</tr>
                            </thead>
                            <tbody>
                                @foreach ($accountings55 as $accountings4)
                                    <tr data-id="{{ $accountings5->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $accountings4->name_surname }}</td>
                                        <td>@if($accountings4->contents!=null) @lang('tables.accounting.contents.'.$accountings4->contents) @endif</td>
                                        <td>@if($accountings4->bank!=null) @lang('tables.accounting.bank.'.$accountings4->bank) @endif</td>
                                        <td>@if($accountings4->payment_type!=null) @lang('tables.accounting.payment_type.'.$accountings4->payment_type) @endif</td>
                                        <td>{{number_format( $accountings4->price, 2, '.',',') }}</td>
                                        <td>{{ $accountings4->note }}</td>
                                        <td>{{ $accountings4->date }}</td>
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

    




@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.3.1/css/dataTables.dateTime.min.css">
@endpush


@push('script')
<script>
    const Aylar = ["OCAK AYI","ŞUBAT AYI","MART AYI","NİSAN AYI","MAYIS AYI","HAZİRAN AYI","TEMMUZ AYI","AĞUSTOS AYI","EYLÜL AYI","EKİM AYI","KASIM AYI","ARALIK AYI"];
    const ay = new Date();
    let aylar = Aylar[ay.getMonth()];
    //let aylar2 = Aylar[ay.getMonth()-1];
    //let aylar3 = Aylar[ay.getMonth()-2];
    let aylar2Index = 0;
    let aylar3Index = 0;
    
    if(ay.getMonth() === 0)
    {
        aylar2Index = 11;
        aylar3Index = aylar2Index - 1;
    }
    else if(ay.getMonth() == 1)
    {
        aylar2Index = 0;
        aylar3Index = 11;
    }
    else{
        aylar2Index = ay.getMonth() - 1;
        aylar3Index = ay.getMonth() - 2;
        aylar4Index = ay.getMonth() - 3;
    }
    let aylar2 = Aylar[aylar2Index];
    let aylar3 = Aylar[aylar3Index];
      let aylar4 = Aylar[aylar4Index];
    //let aylar2 = ay.getMonth() - 1;
    //let aylar3 = ay.getMonth() - 2;
    document.getElementById("demo").innerHTML = aylar;
    document.getElementById("demo2").innerHTML = aylar2;
    document.getElementById("demo3").innerHTML = aylar3;
     document.getElementById("demo4").innerHTML = aylar4;
</script>

    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/admin/vendor/datatables/dataTables.dateTime.min.js"></script>

   <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script> 
    <script src="https://cdn.datatables.net/datetime/1.3.1/js/dataTables.dateTime.min.js"></script> -->

<script>
    var minDate, maxDate;
    
// Custom filtering function which will search data in column four between two values
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
                        if( column[0][0] == 2 || column[0][0] == 3 || column[0][0] == 7 ) {
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
                            $('<input style="width:90px;" type="text" class="form-control text-dark bg-light" placeholder="İsim Soyisim" />')
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
                footerCallback: function (row, data, start, end, display) {
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
            $(api.column(2).footer()).html('<span class="text-danger">Bulunduğunuz Sayfa Toplamı: </span>'+pageTotal + '₺');
            $(api.column(5).footer()).html('<span class="text-primary">Toplam: </span>'+total + '₺');
        },
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
        $(document).ready(function() {
            $('#example2').DataTable( {
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
               columnDefs: [{
                    "type": "num",
                    "targets": 0
                }],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Tümü'],
                ],
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
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 2 || column[0][0] == 3  || column[0][0] == 7 ) 
                        {
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
                            $('<input style="width:90px;" type="text" class="form-control text-dark bg-light" placeholder="İsim Soyisim" />')
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

                
                footerCallback: function (row, data, start, end, display) {
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

            //$(api.column(5).footer()).html( pageTotal + '₺');
             $(api.column(5).header()).html( 'Toplamı: '+pageTotal + ' ₺ ');
             $(api.column(2).footer()).html('<span class="text-danger">Bulunduğunuz Sayfa Toplamı: </span>'+pageTotal + '₺');
             $(api.column(5).footer()).html('<span class="text-primary">Toplam: </span>'+total + '₺');
        },
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
        $(document).ready(function() {
            $('#example4').DataTable( {
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
               columnDefs: [{
                    "type": "num",
                    "targets": 0
                }],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Tümü'],
                ],
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
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 2 || column[0][0] == 3  || column[0][0] == 7 ) 
                        {
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
                            $('<input style="width:90px;" type="text" class="form-control text-dark bg-light" placeholder="İsim Soyisim" />')
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

                
                footerCallback: function (row, data, start, end, display) {
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

            //$(api.column(5).footer()).html( pageTotal + '₺');
             $(api.column(5).header()).html( 'Toplamı: '+pageTotal + ' ₺ ');
             $(api.column(2).footer()).html('<span class="text-danger">Bulunduğunuz Sayfa Toplamı: </span>'+pageTotal + '₺');
             $(api.column(5).footer()).html('<span class="text-primary">Toplam: </span>'+total + '₺');
        },
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
        $(document).ready(function() {
            $('#example3').DataTable( {
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
               columnDefs: [{
                    "type": "num",
                    "targets": 0
                }],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'Tümü'],
                ],
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
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 2 || column[0][0] == 3  || column[0][0] == 7 ) 
                        {
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
                            $('<input style="width:90px;" type="text" class="form-control text-dark bg-light" placeholder="İsim Soyisim" />')
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

                
                footerCallback: function (row, data, start, end, display) {
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

            //$(api.column(5).footer()).html( pageTotal + '₺');
             $(api.column(5).header()).html( 'Toplamı: '+pageTotal + ' ₺ ');
             $(api.column(2).footer()).html('<span class="text-danger">Bulunduğunuz Sayfa Toplamı: </span>'+pageTotal + '₺');
             $(api.column(5).footer()).html('<span class="text-primary">Toplam: </span>'+total + '₺');
        },
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
@endpush

