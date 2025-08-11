@extends('admin.layout.main')

@section('title', meta_title('Moka Kontrol'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4><span class="text-danger">CUSTOMER_İD İLE ARAMA</span></h4>
                </div>
                <hr style="border-bottom:2px solid red;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer_Id</th>
                                    <th scope="col">Trx-Code</th>
                                    <th scope="col">Ad Soyad</th>
                                    <th>Fiyat</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->trx_code }}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$customer->id}}">{{  $customer->first_name  }} {{  $customer->last_name  }}</a> </td>
                                        <td><span class="badge badge-warning">{{$customer->price}}</span></td>
                                        <td>{{$customer->created_at}}</td>
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
                    <h4><span class="text-dark">TRX_CODE İLE ARAMA</span></h4>
                </div>
                <hr style="border-bottom:2px solid red;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable2">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Trx_Code</th>
                                    <th scope="col">Customer_Id</th>
                                    <th scope="col">Ad Soyad</th>
                                    <th>Fiyat</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trxcodes as $trxcode)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $trxcode->trx_code }}</td>
                                        <td>{{ $trxcode->id }}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$trxcode->id}}">{{  $trxcode->first_name  }} {{  $trxcode->last_name  }}</a> </td>
                                        <td><span class="badge badge-info">{{$trxcode->price}}</span></td>
                                        <td>{{$trxcode->created_at}}</td>
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
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 6 && column[0][0] != 3 && column[0][0] != 4 && column[0][0] != 2 && column[0][0] != 5)
                        {
                            var select = $('<select class="form-control text-white bg-primary" style="width:100px;"><option value="">Tümü</option></select>')
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
                        if(column[0][0] == 1)
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
                },{ "orderable": false, "targets": [1, 2, 3, 4] }],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 2 && column[0][0] != 4 && column[0][0] != 5 && column[0][0] != 3)
                        {
                            var select = $('<select class="form-control text-white bg-primary" style="width:100px;"><option value="">Tümü</option></select>')
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
                        if(column[0][0] == 1)
                        {
                            $('<input  type="text" id="myInput" oninput="trimInput()" style="width:300px;" type="text" class="form-control text-dark bg-light" placeholder="Arama" />')
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
    function trimInput() {
      var input = document.getElementById("myInput");
      input.value = input.value.trim();
    }
  </script>
@endpush
