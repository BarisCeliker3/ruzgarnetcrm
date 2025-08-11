@extends('admin.layout.main')

@section('title', meta_title('Müşteri Listesi'))

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="font-bold tracking-wider text-2xl">
            <i class="bi bi-person-fill text-primary me-2"></i>
            Müşteriler Tablosu
        </h2>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-light">
            <strong><i class="bi bi-table me-1"></i>Müşteri Kayıtları</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle" id="customersTable">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>İsim</th>
                        <th>Email</th>
                        <th>TC</th>
                        <th>Başlangıç</th>
                        <th>Telefon</th>
                      
                       
                    </tr>
                </thead>
                <tbody>
@foreach($customers as $customer)
    <tr>
        <td>{{ $customer->id }}</td>
        <td>{{ $customer->appcustomer_name }}</td>
        <td>{{ $customer->appcustomer_email }}</td>
        <td>{{ $customer->appcustomer_tc }}</td>
        <td>{{ $customer->appcustomer_begin }}</td>
        <td>{{ $customer->app_phone }}</td>
       
       
    </tr>
@endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <style>
        .table-primary th {
            background-color: #cfe2ff !important;
        }
        .card-header strong i {
            color: #0d6efd;
        }
        .dataTableFlex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#customersTable')) {
                $('#customersTable').DataTable({
                    language: {
                        url: '/assets/admin/vendor/datatables/i18n/tr.json'
                    },
                    dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, 'Tümü'],
                    ],
                    columnDefs: [
                        {"type": "num", "targets": 0},
                        {"orderable": false, "targets": [1, 2, 3, 4, 5]}
                    ]
                });
            }
        });
    </script>
@endpush