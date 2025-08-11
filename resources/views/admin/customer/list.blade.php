@extends('admin.layout.main')

@section('title', meta_title('tables.customer.title'))

@section('content')
<style>
    .approved-row {
        background-color: #e6ffed !important; /* açık yeşil */
        transition: background-color 0.3s ease;
    }
    
    .un-approved-row {
        background-color: #fff5f5 !important; /* açık kırmızı */
        transition: background-color 0.3s ease;
    }
    .title-table{
        color:white !important;
    }
    .table-custom-header {
        border-top-left-radius: 10vh;
    border-top-right-radius: 10vh;
        background: linear-gradient(90deg, #1e3a8a, #2563eb); /* Lacivert - Mavi geçiş */
        color: white; /* Turkuaz tonlu yazı */
        font-weight: bold;
        border-bottom: 2px solid #0ea5e9;
    }
    .table-custom-header:hover {
        background: linear-gradient(90deg, #2563eb, #1e3a8a); /* Ters geçiş */
        color: #ffffff;
    }
    /* Hover efekti */
    .table-hover tbody tr:hover {
        background-color: #f0f8ff !important;
        cursor: pointer;
        transform: scale(1.01);
        transition: all 0.2s ease-in-out;
    }
    
    /* Popover butonu */
    .btn-danger.btn-sm {
        margin-top: 5px;
        font-size: 0.75rem;
        padding: 2px 6px;
    }
    
    /* Responsive tablo */
    .table-responsive {
        border-radius: 10px;
        overflow-x: auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.customer.title')</h4>

                    <div class="card-header-buttons">
                        <a href="{{ route('admin.customer.add') }}" class="btn btn-primary"><i
                                class="fas fa-sm fa-plus"></i> @lang('tables.customer.add')</a>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        
                        <table id="dataTable" class="table table-hover table-striped" >




                            <thead class="table-custom-header">
                    
                                                    <tr>
                    
                                                        <th class="title-table" scope="col">#</th>
                                    <th class="title-table" scope="col">@lang('fields.identification_number')</th>
                                    <th class="title-table" scope="col">@lang('fields.name')</th>
                                    <th class="title-table" scope="col">@lang('fields.telephone')</th>
                                    <th class="title-table" scope="col">@lang('fields.city')</th>
                                    <th class="title-table" scope="col">@lang('fields.staff')</th>
                                    <th class="title-table" scope="col">@lang('fields.actions')</th>
                                </tr>
                            </thead>
                            <tbody style="background:ghostwhite;">
                                    {{-- @foreach ($customers as $customer)
                                        <tr data-id="{{ $customer->id }}"
                                            class="{{ $customer->type == 1 ? 'un-approved-row' : 'approved-row' }}">
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <span class="d-inline-block text-center">
                                                    {{ $customer->identification_secret }}
                                                    @if ($customer->type == 1)
                                                        <div class="customer-type customer-type-{{ $customer->type }}">
                                                            @lang("tables.customer.types.{$customer->type}")
                                                        </div>
                                                    @endif
                                                </span>
                                            </td>
                                            <td>{{ $customer->full_name }}</td>
                                            <td data-filter="0{{ $customer->telephone }}">{{ $customer->telephone_print }}
                                            </td>
                                            <td>{{ $customer->customerInfo->city->name }}</td>
                                            <td>
                                                @if ($customer->staff)
                                                    {{ $customer->staff->full_name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="buttons">
                                                    <a href="{{ route('admin.customer.edit', $customer) }}"
                                                        class="btn btn-primary" title="@lang('titles.edit')">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('admin.customer.show', $customer) }}"
                                                        class="btn btn-primary" title="@lang('titles.show')">
                                                        <i class="fas fa-file"></i>
                                                    </a>

                                                    @if ($customer->type == 1)
                                                        <button type="button"
                                                            class="btn btn-success confirm-modal-btn"
                                                            data-action="{{ route('admin.customer.approve.post', $customer) }}"
                                                            data-modal="#approveCustomer" title="@lang('titles.approve')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach --}}
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
                processing: true,
                serverSide: true,
                ajax: "/customer/list",
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                dom:'ftip',
                columnDefs: [{
                    "type": "num",
                    "targets": 0
                },{ "orderable": false, "targets": [0, 1, 2, 3, 4, 5, 6] }],
            });
        })

    </script>
@endpush

@push('modal')
    <x-admin.confirm-modal
        id="approveCustomer"
        method="put"
        :title="trans('titles.actions.approve.customer')"
        :message="trans('warnings.approve.customer')"
        :buttonText="trans('titles.approve')"
        buttonType="success" />
@endpush
