@extends('admin.layout.main')

@section('title', meta_title('tables.payment.daily'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.payment.daily')</h4>

                    <form method="POST" action="{{ route('admin.payment.daily') }}" data-ajax="false" class="card-header-buttons">
                        @csrf
                        <input type="date" name="date" name="dtDate" class="form-control" value="{{ $date ?? date('Y-m-15') }}">
                        <button type="submit" class="btn btn-primary">Listele</button>
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Hizmet</th>
                                    <th scope="col">TC</th>
                                    <th scope="col">İsim - Soyisim</th>
                                    <th scope="col">Tel 1</th>
                                    <th scope="col">Tel 2</th>
                                    <th scope="col">Adres</th>
                                    <th scope="col">Tarife</th>
                                    <th scope="col">Tutar</th>
                                    <th scope="col">Durum</th>
                                    <th scope="col">Şehir</th>
                                    <th scope="col">Tarih</th>
                                    <th scope="col">Ödeme Tipi</th>
                                    <th scope="col">Temsilci</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $payment->category_name }}</td>
                                        <td>{{ $payment->TCKN }}</td>
                                        <td>{{ $payment->customer_first_name }} {{ $payment->customer_last_name }}</td>
                                        <td>{{ $payment->customer_tel}}</td>
                                        <td>{{ $payment->customer_secondary_tel }}</td>
                                        <td>{{ $payment->address }}</td>
                                        <td>{{ $payment->service_name }}</td>
                                        <td>{{ print_money($payment->payment_cost) }}</td>
                                        @if($payment->payment_status == 1)
                                        <td>ÖDENMEDİ</td>
                                        @elseif($payment->payment_status == 2)
                                        <td>ÖDENDİ</td>
                                        @endif
                                        <td>{{ $payment->city_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->payment_paid_at)->format('Y-m-d') }}</td>
                                        @switch($payment->payment_type)
                                            @case(1)
                                                <td>Nakit</td>
                                            @break
                                            @case(2)
                                                <td>POS</td>
                                            @break
                                            @case(3)                            
                                                <td>HAVALE</td>
                                            @break
                                            @case(4)
                                                <td>ONLINE ÖDEME (DESTEK)</td>
                                            @break
                                            @case(5)
                                                <td>Otomatik</td>
                                            @break
                                            @default
                                                <td>ÖDENMEDİ</td>
                                            @endswitch
                                        <td>{{ $payment->staffs_first_name }}</td>
                                        
                                    
                                       
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
       $(document).ready(function() {
            $('#dataTable').DataTable( {
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
                        title: 'Ödemeler'
                    }
                ],
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7, 8,9]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] == 1 || column[0][0] == 7 || column[0][0] == 9 || column[0][0] == 10) {
                            var select = $('<select class="form-control" style="width:100px;"><option value="">Tümü</option></select>')
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
        });

    </script>
@endpush