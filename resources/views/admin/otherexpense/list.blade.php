@extends('admin.layout.main')

@section('title', meta_title('tables.otherexpense.title'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.otherexpense.title')</h4>
                    
                    <div class="card-header-buttons">
                        <a href="{{ route('admin.otherexpense.add') }}" class="btn btn-primary">
                            <i class="fas fa-sm fa-plus"></i> @lang('tables.otherexpense.add')
                        </a>
                        <a href="{{ route('admin.otherexpense.report') }}" class="btn btn-primary">
                            Rapor
                        </a>
                        <a href="{{ route('admin.otherexpense.expenselist') }}" class="btn btn-primary">
                            Giderler
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">@lang('fields.paid_date')</th>
									<th scope="col">@lang('fields.type')</th>
									<th scope="col">@lang('fields.price')</th>
									<th scope="col">@lang('fields.description')</th>
									<!--<th scope="col">@lang('fields.actions')</th>-->
								</tr>
                            </thead>
                            <tbody>
                                @foreach ($otherexpenses as $otherexpense)
                                    <tr data-id="{{ $otherexpense->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $otherexpense->created_at }}</td>
                                        
                                        <td>@if($otherexpense->expense_name!=null) @lang('tables.otherexpense.expense_name.'.$otherexpense->expense_name) @endif</td>
										<td>{{ $otherexpense->price }} ₺</td>
                                        <td>{{ $otherexpense->description }}</td>
                                        <!-- Düzenleme Btn
										<td>
                                            <div class="buttons">
                                                <a href="{{ relative_route('admin.otherexpense.edit',$otherexpense->id )}}"
                                                    class="btn btn-primary" title="@lang('titles.edit')">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
										-->
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
                }],
                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                buttons: [
                    {
                        extend: 'excelHtml5'

                    }
                ]
            });
        })

    </script>
@endpush
