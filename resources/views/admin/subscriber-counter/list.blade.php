@extends('admin.layout.main')

@section('title', meta_title('tables.subscribercounter.title'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.subscribercounter.title')</h4>

                    <div class="card-header-buttons">
                        <a href="{{ route('admin.subscribercounter.add') }}" class="btn btn-primary">
                            <i class="fas fa-sm fa-plus"></i> @lang('tables.subscribercounter.add')
                        </a>
                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
								<tr>
                                    <th scope="col">#</th>
									<th scope="col">@lang('fields.name_surname')</th>
									<th scope="col">@lang('fields.telephone')</th>
									<th scope="col">@lang('fields.ended_at')</th>
									<th scope="col">@lang('fields.company')</th>
									<th scope="col">@lang('fields.staff')</th>
									<th scope="col">@lang('fields.note')</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach ($subscribercounters as $subscribercounter)
                                    <tr data-id="{{ $subscribercounter->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $subscribercounter->name_surname }}</td>
                                        <td>{{ $subscribercounter->telephone }} </td>
										<td>{{ $subscribercounter->bitistarihi }} </td>
                                        <td>{{ $subscribercounter->company }}</td>
                                        <td>{{ $subscribercounter->staff_id }}</td>
                                        <td>
                                            <div class="buttons">
                                                <a href="/commitment-notes/{{ $subscribercounter->id }}"
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
                columnDefs: [{
                    "type": "num",
                    "targets": 0
                }]
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
                }]
            });
        })

    </script>
@endpush
