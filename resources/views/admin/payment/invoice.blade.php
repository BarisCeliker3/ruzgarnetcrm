@extends('admin.layout.main')

@section('title', meta_title('tables.payment.invoice'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.payment.invoice')</h4>

                    <form method="POST" action="{{ route('admin.payment.invoice') }}" data-ajax="false" class="card-header-buttons">
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
                                    <th scope="col">İsim</th>
                                    <th scope="col">Eposta</th>
                                    <th scope="col">TC</th>
                                    <th scope="col">Adres</th>
                                    <th scope="col">İlçe</th>
                                    <th scope="col">İl</th>
                                    <th scope="col">Ürün Adı</th>
                                    <th scope="col">Birim Fiyat</th>
                                    <th scope="col">ÖİV</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($subscriptions as $subscription)
                                @php
                                    $modem_price = $subscription["options"]["modem_price"] ?? 0;
                                @endphp

                                   @if($modem_price > 0)

                                    <tr>

                                        <th>{{ $subscription->customer->full_name }}</th>
                                        <td>{{ $subscription->customer->email }}</td>
                                        <td>{{ $subscription->customer->identification_number }}</td>
                                        <td>{{ $subscription->customer->customerInfo->address }}</td>
                                        <td>{{ $subscription->customer->customerInfo->city->name }}</td>
                                        <td>{{ $subscription->customer->customerInfo->district->name}}</td>
                                        <td>{{ $subscription->service->name }}</td>
                                        <td>{{ (($subscription->price-$modem_price)*100)/128 }}</td>
                                        <td>10.00</td>
                                    </tr>
                                    <tr>
                                        <th>{{ $subscription->customer->full_name }}</th>
                                        <td>{{ $subscription->customer->email }}</td>
                                        <td>{{ $subscription->customer->identification_number }}</td>
                                        <td>{{ $subscription->customer->customerInfo->address }}</td>
                                        <td>{{ $subscription->customer->customerInfo->city->name }}</td>
                                        <td>{{ $subscription->customer->customerInfo->district->name}}</td>
                                        <td>Modem Kullanım Bedeli</td>
                                        <td>{{ ($modem_price*100)/118 }}</td>
                                        <td> 0.00</td>
                                    </tr>


                                   @else
                                    <tr>
                                        <th>{{ $subscription->customer->full_name }}</th>
                                        <td>{{ $subscription->customer->email }}</td>
                                        <td>{{ $subscription->customer->identification_number }}</td>
                                        <td>{{ $subscription->customer->customerInfo->address }}</td>
                                        <td>{{ $subscription->customer->customerInfo->city->name }}</td>
                                        <td>{{ $subscription->customer->customerInfo->district->name}}</td>
                                        <td>{{ $subscription->service->name }}</td>
                                        <td>{{ (($subscription->price)*100)/128 }}</td>
                                        <td>10.00</td>
                                    </tr>


                                   @endif

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
                        title: 'fatura'
                    }
                ],
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7, 8]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 6 ) {
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
