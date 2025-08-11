@extends('admin.layout.main')

@section('title', meta_title('tables.payment.notpaid'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.payment.notpaid')</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('fields.identification_number')</th>
                                    <th scope="col">@lang('fields.customer')</th>
                                    <th scope="col">@lang('fields.telephone')</th>
                                    <th scope="col">@lang('fields.secondary_telephone')</th>
                                    <th scope="col">@lang('fields.service')</th>
                                    <th scope="col">@lang('fields.price')</th>
                                    <th scope="col">@lang('fields.payment_status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr data-id="{{ $payment->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $payment->identification_number }}</td>
                                        <td>
                                            <a href="https://crm.ruzgarnet.site/customer/{{$payment->customer_id}}"
                                                >{{ $payment->full_name }}</a>
                                        </td>
                                        <td>{{ $payment->telephone }}</td>
                                        <td>{{ $payment->secondary_telephone }}</td>
                                        <td>{{ $payment->category_name }}</td>
                                        <td data-sort="{{ $payment->price }}">{{ print_money($payment->price) }}</td>
                                        <td>{{$payment->service_name}}</td> 
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
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7]}
                ],
                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Ödemeler'
                    }
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] == 5 || column[0][0] == 7) {
                            var select = $('<select class="form-control" style="width:280px;"><option value="">Tümü</option></select>')
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
@endpush
