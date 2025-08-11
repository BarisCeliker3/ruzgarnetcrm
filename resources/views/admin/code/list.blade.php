@extends('admin.layout.main')

@section('title', meta_title('tables.code.title'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.code.title')</h4>

                    <div class="card-header-buttons">
                        <a href="{{ route('admin.code.message_edit') }}"
                            class="btn btn-primary" >
                            <i class="fas fa-edit"> Mesaj Düzenle</i>
                        </a>
                        <a href="{{ route('admin.code.add') }}" class="btn btn-primary"><i
                              class="fas fa-sm fa-plus"></i> @lang('tables.code.add')</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('fields.code')</th>
                                    <th scope="col">@lang('fields.type')</th>
                                    <th scope="col">@lang('fields.status')</th>
                                    <th scope="col">@lang('fields.name')</th>
                                    <th scope="col">@lang('fields.date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($codes as $code)
                                    <tr data-id="{{ $code->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $code->code }}</td>
                                        <td>@lang('tables.code.type.'.$code->type)</td>
                                        <td>@lang('tables.code.status.'.$code->status)</td>
                                        <td>{{ $code->subscription_name }}</td>
                                        <td>{{ $code->updated_at }}</td>
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
                }]
            });
        })

    </script>
@endpush
