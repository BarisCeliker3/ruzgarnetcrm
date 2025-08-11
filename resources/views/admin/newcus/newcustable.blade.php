@extends('admin.layout.main')

@section('title', 'Abonelikler')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="text-center text-[#ce00ff] text-2xl font-semibold mb-4">
            İçeri Alınmış Abonelikler
        </div>

        <form id="filterForm" method="GET" class="mb-4">
            <div class="flex">
                <div class="flex space-x-2">
                    <input type="date" name="start_date" id="start_date" class="form-control" />
                    <input type="date" name="end_date" id="end_date" class="form-control" />
                </div>
                <button type="button" class="ml-4 bg-purple-600 text-white px-4 py-2 rounded-md">Filtrele</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table id="subscriptionTable" class="table table-hover table-striped">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-6 text-white text-left">Müşteri Adı</th>
                        <th class="py-3 px-6 text-white text-left">Personel Adı</th>
                        <th class="py-3 px-6 text-white text-left">Servis Adı</th>
                        <th class="py-3 px-6 text-white text-left">Abonelik Başlangıç Tarihi</th>
                        <th class="py-3 px-6 text-white text-left">Durum</th>
                    </tr>
                </thead>
                <tbody id="subscriptionTableBody">
                    <!-- Veriler JS ile buraya yüklenecek -->
                </tbody>
            </table>
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
$(document).ready(function () {
    const dataTable = $('#subscriptionTable').DataTable({
        paging: true,
        searching: false,
        ordering: false,
        language: {
            url: '/assets/admin/vendor/datatables/i18n/tr.json'
        },
        dom: 'ftip'
    });

    fetchData();

    $('.bg-purple-600').on('click', function () {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        fetchData(startDate, endDate);
    });

    function fetchData(startDate = '', endDate = '') {
        $.ajax({
            url: "{{ route('admin.new.subsentercompany') }}",
            type: "GET",
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function (response) {
                dataTable.clear();

                if (response.data.length > 0) {
                    console.log(response.data);
                    
                    $.each(response.data, function (index, subscription) {
                        let customerName = subscription.customer_name;
                        let CusId = subscription.cus_id;
                        let stafname = subscription.staff_names[0];
                        let serviceName = subscription.service_name ? subscription.service_name : '-';
                        let createdAt = formatDate(subscription.created_at);
                        let statusLabel = subscription.stat == "1" ? 'Aktif' : 'Pasif';
                        let statusClass = subscription.stat == "1" ? 'bg-green-500 text-white' : 'bg-red-500 text-white';

                        dataTable.row.add([
                            `<a href="/customer/${CusId}" class="text-blue-600 hover:underline">${customerName}</a>`,
                            stafname,
                            serviceName,
                            createdAt,
                            `<span class="px-4 py-1 rounded-full ${statusClass}">${statusLabel}</span>`
                        ]);
                    });
                } else {
                    dataTable.row.add([
                        '<td colspan="5" class="text-center py-3">Hiç abonelik bulunamadı.</td>',
                        '', '', '', ''
                    ]);
                }

                dataTable.draw();
            }
        });
    }

    function formatDate(dateString) {
        let date = new Date(dateString);
        let day = date.getDate().toString().padStart(2, '0');
        let month = (date.getMonth() + 1).toString().padStart(2, '0');
        let year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }
});
</script>
@endpush
