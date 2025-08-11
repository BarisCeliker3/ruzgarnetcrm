

@extends('admin.layout.main')

@section('title', meta_title('tables.payment.penalty'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.payment.penalty')</h4>
                    <form method="POST" action="{{ route('admin.payment.penalties') }}" data-ajax="false" class="card-header-buttons">
                        @csrf
                        <input type="date" name="date" name="dtDate" class="form-control" value="{{ $date ?? date('Y-m-20') }}">
                        <button type="submit" class="btn btn-primary">Listele</button>
                    </form>
                </div>
                
                
                
                <div class="card-body mb-2">
                    <div class="bg-danger container-fluid col-8 rounded">
                        <h4 class="text-center text-white">{{ $startDate }} - {{ $endDate }}</h4>
                        <h4 class="text-center text-white">Tarihleri Arasında</h4>
                        <h4 class="text-center text-white">@lang('tables.payment.paymentPenalty')</h4>
                    </div>
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
                                    <th scope="col">Cezalı Tutar</th>
                                    <th scope="col">@lang('fields.payment_status')</th>
                                    <th scope="col">@lang('tables.payment.paymentCreatedAt')</th>
                                    <th scope="col">@lang('tables.payment.penaltyCreatedAt')</th>
                                    <th scope="col">Ödeme Tablosundaki Tutar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentPenalties as $pp)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pp['identification_number'] }}</td>
                                    <td>{{ $pp['first_name'] }} {{ $pp['last_name'] }}</td>
                                    <td>{{ $pp['telephone'] }}</td>
                                    <td>{{ $pp['secondary_telephone'] }}</td>
                                    <td>{{ $pp['category_name'] }}</td>
                                    <td>{{ $pp['old_price'] }}</td>
                                    <td>{{ $pp['new_price'] }}</td>
                                    @if($pp['payment_status'] == 2)
                                        <td>Ödendi</td>
                                    @else
                                        <td>Ödenmedi</td>
                                    @endif
                                    <td>{{ $pp['payment_created_at'] }}</td>
                                    <td>{{ $pp['penalty_created_at'] }}</td>
                                    <td>{{ $pp['payment_price'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="bg-danger container-fluid col-8 rounded">
                        <h4 class="text-center text-white">{{ $startDate }} - {{ $endDate }}</h4>
                        <h4 class="text-center text-white">Tarihleri Arasında</h4>                        
                        <h4 class="text-center text-white">@lang('tables.payment.portPenalty')</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTablePort">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('fields.identification_number')</th>
                                    <th scope="col">@lang('fields.customer')</th>
                                    <th scope="col">@lang('fields.telephone')</th>
                                    <th scope="col">@lang('fields.secondary_telephone')</th>
                                    <th scope="col">@lang('fields.service')</th>
                                    <th scope="col">@lang('fields.price')</th>
                                    <th scope="col">Cezalı Tutar</th>
                                    <th scope="col">@lang('fields.payment_status')</th>
                                    <th scope="col">@lang('tables.payment.paymentCreatedAt')</th>
                                    <th scope="col">@lang('tables.payment.penaltyCreatedAt')</th>
                                    <th scope="col">Ödeme Tablosundaki Tutar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($portPenalties as $pp)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pp['identification_number'] }}</td>
                                    <td>{{ $pp['first_name'] }} {{ $pp['last_name'] }}</td>
                                    <td>{{ $pp['telephone'] }}</td>
                                    <td>{{ $pp['secondary_telephone'] }}</td>
                                    <td>{{ $pp['category_name'] }}</td>
                                    <td>{{ $pp['old_price'] }}</td>
                                    <td>{{ $pp['new_price'] }}</td>
                                    @if($pp['payment_status'] == 2)
                                        <td>Ödendi</td>
                                    @else
                                        <td>Ödenmedi</td>
                                    @endif
                                    <td>{{ $pp['payment_created_at'] }}</td>
                                    <td>{{ $pp['penalty_created_at'] }}</td>
                                    <td>{{ $pp['payment_price'] }}</td>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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
                dom: 'Bfrtip',
            	buttons : [ {
            extend : 'excel',
            text : 'Excel',
            exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'applied'     // 'none',    'applied', 'removed'
                }
            }
        } ],
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7]}
                ],
                initComplete: function () {
                    
                    this.api().columns().every( function () {

                        var column = this;
                        if(column[0][0] == 8) {
                            var select = $('<select class="form-control" style="width:100px;"><option value="">Ödeme Durumu</option></select>')
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
            $("#dataTablePort").dataTable({
                                dom: 'Bfrtip',
            	buttons : [ {
            extend : 'excel',
            text : 'Excel',
            exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'index',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'applied'     // 'none',    'applied', 'removed'
                }
            }
        } ],

                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7, 8, 9]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] == 8) {
                            var select = $('<select class="form-control" style="width:100px;"><option value="">Ödeme Durumu</option></select>')
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
