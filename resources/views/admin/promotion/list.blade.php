@extends('admin.layout.main')

@section('title', meta_title('tables.promotion.title'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.promotion.title')</h4>

                    <div class="card-header-buttons">
                        <a href="{{ route('admin.promotion.add') }}" class="btn btn-primary"><i
                                class="fas fa-sm fa-plus"></i> @lang('tables.promotion.add')</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('fields.staff')</th>
                                    <th scope="col">@lang('fields.customer')</th>
                                    <th scope="col">@lang('fields.promotion')</th>
                                    <th scope="col">@lang('fields.description')</th>
                                    <th scope="col">@lang('fields.startingdate')</th>
                                    <th scope="col">@lang('fields.status')</th>
                                    
                                    <th scope="col">@lang('fields.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotions as $promotion)
                                    <tr data-id="{{ $promotion->id }}">
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $promotion->staff->full_name }}</td>
                                        <td>{{ $promotion->subscription->customer->full_name }}</td>
                                        <td>{{ $promotion->promotion_name }}</td>
                                        <td>{{ $promotion->promotion_description }}</td>
                                        <td>{{ $promotion->created_at }}</td>
                                        <td>@lang('tables.promotion.status.'.$promotion->status)</td>
                                        <td>
                                            <div class="buttons">
                                                <a href="{{ relative_route('admin.promotion.edit', $promotion->id) }}"
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
                columnDefs: [{
                    "type": "num",
                    "targets": 0
                }]
            });
        })

    </script>
@endpush
