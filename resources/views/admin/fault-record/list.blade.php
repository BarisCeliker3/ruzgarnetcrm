@extends('admin.layout.main')

@section('title', meta_title('tables.fault.record.title'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.fault.record.title')</h4>

                    <div class="card-header-buttons">
                        <a href="{{ route('admin.fault.record.add') }}" class="btn btn-primary"><i
                                class="fas fa-sm fa-plus"></i> @lang('tables.fault.record.add')</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('fields.customer')</th>
                                    <th scope="col">Temsilci</th>
                                    <th scope="col">@lang('fields.fault_type')</th>
                                    <th scope="col">@lang('fields.description')</th>
                                    <th scope="col">@lang('fields.status')</th>
                                    <th scope="col">Sehir</th>
                                    <th scope="col">Tarih</th>
                                    <th scope="col">@lang('fields.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faultRecords as $faultRecord)
                                    <tr data-id="{{ $faultRecord->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$faultRecord->customer_id}}">{{ $faultRecord->customer_full_name }}</a></td>
                                        <td>{{ $faultRecord->staff_full_name }}</td>
                                        <td>{{ $faultRecord->title }}</td>
                                        <td>{{ $faultRecord->description }}</td>
                                        <td>@lang('tables.fault.record.status.'.$faultRecord->status)</td>                          
                                        <td>{{ $faultRecord->city_name}}</td>
                                        <td>{{ $faultRecord->updated_at}}</td>
                                        <td>
                                            <div class="buttons">
                                                <a href="{{ route('admin.fault.record.edit', $faultRecord->id) }}"
                                                    class="btn btn-primary" title="@lang('titles.edit')">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
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
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [1, 3, 4,]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] == 2 || column[0][0] == 5 || column[0][0] == 6) {
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
