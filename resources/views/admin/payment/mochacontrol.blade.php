@extends('admin.layout.main')

@section('title', meta_title('Moka Kontrol'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:20px;"><span class="text-dark">TRX_CODE İLE ARAMA</span></h4>
                </div>
                <hr style="border-bottom:2px solid #0000FF;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Müşteri</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">Trx_code</th>
                                    <th scope="col">Customer_id</th>
                                    <th scope="col">Tarih</th>
                                    
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($moka_payments as $moka_payment )
                                    <tr>
                                        <td><span class="text-dark"><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$moka_payment->customer_id}}">{{ $moka_payment->isim }}</a></span></td>
                                        <td><span class="badge badge-pill badge-info">{{  $moka_payment->price  }}</span></td>
                                        <td>{{  $moka_payment->trx_code  }}</td>
                                        <td>{{  $moka_payment->customer_id  }}</td>
                                        <td><span class="badge badge-pill badge-light">{{  $moka_payment->created_at  }}</span></td>
                                        
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        
        
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:20px;"><span class="text-danger">CUSTOMER_ID İLE ARAMA</span></h4>
                </div>
                <hr style="border-bottom:2px solid red;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable2">
                            <thead>
                                <tr>
                                    <th scope="col">Müşteri</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">Trx_code</th>
                                    <th scope="col">Customer_id</th>
                                    <th scope="col">Tarih</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer )
                                    <tr>
                                        <td><span class="text-dark"><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$customer->customer_id}}">{{ $customer->isim }}</a></span></td>
                                        <td><span class="badge badge-pill badge-danger">{{  $customer->price  }}</span></td>
                                        <td>{{  $customer->trx_code  }}</td>
                                        <td>{{  $customer->customer_id  }}</td>
                                        <td><span class="badge badge-pill badge-light">{{  $customer->created_at  }}</span></td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
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
    
    
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>


<script>
        $(function() {
            $("#dataTable").dataTable({
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                columnDefs: [{
                    "type": "num",
                    "targets": 0 

                },{ "orderable": false, "targets": [1, 2,3,4] }],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 2 && column[0][0] != 3 && column[0][0] != 4 )
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
                        if(column[0][0] == 2)
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
                },{ "orderable": false, "targets": [0,1, 2,3,4] }],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 2 && column[0][0] != 3 && column[0][0] != 4 )
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
                        if(column[0][0] == 3)
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
                }
            });
        })

    </script>
@endpush
