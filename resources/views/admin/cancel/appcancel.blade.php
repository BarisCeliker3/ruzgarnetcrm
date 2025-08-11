@extends('admin.layout.main')

@section('title', 'Bugün İptal Olan Abonelikler')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="text-center text-[#ce00ff] text-2xl font-semibold mb-4">
            Bugün İptal Olan Abonelikler
        </div>

        <form id="filterForm" method="GET" class="mb-4">
            <div class="flex ">
                <div class="flex space-x-2">
                    <input type="date" name="start_date" id="start_date" class="form-control" />
                    <input type="date" name="end_date" id="end_date" class="form-control" />
                </div>
                <button type="button" class="ml-4 bg-purple-600 text-white px-4 py-2 rounded-md">Filtrele</button>
            </div>
        </form>

        <div class="overflow-x-auto">
                        <table id="dataTable" class="table table-hover table-striped" >

                <thead class="bg-gray-800 text-white">
                        <th class="py-3 px-6 text-white text-left">Müşteri Adı</th>
                        <th class="py-3 px-6 text-white text-left">Personel Adı</th>
                        <th class="py-3 px-6 text-white text-left">Servis Adı</th>
                        <th class="py-3 px-6 text-white text-left">İptal Tarihi</th>
                        <th class="py-3 px-6 text-white text-left">Abonelik Durumu</th>
                    </tr>
                </thead>
                <tbody id="cancelTableBody">
                    <!-- Veriler burada yüklenecek -->
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
    const dataTable = $('#dataTable').DataTable({
        paging: true,
        searching: false,
        ordering: false,
        language: {
            url: '/assets/admin/vendor/datatables/i18n/tr.json'
        },
        dom: 'ftip',
        drawCallback: function() {
            var api = this.api();
            var pageInfo = api.page.info();

            // Pagination butonları güncelle
            $('#paginationControls').html(`
                <div class="flex space-x-2">
                    <button class="bg-purple-600 text-white px-4 py-2 rounded-md ${pageInfo.page === 0 ? 'opacity-50 cursor-not-allowed' : ''}" onclick="movePage(${pageInfo.page - 1})" ${pageInfo.page === 0 ? 'disabled' : ''}>Önceki</button>
                    <span class="py-2 text-lg">${pageInfo.page + 1} / ${pageInfo.pages}</span>
                    <button class="bg-purple-600 text-white px-4 py-2 rounded-md ${pageInfo.page === pageInfo.pages - 1 ? 'opacity-50 cursor-not-allowed' : ''}" onclick="movePage(${pageInfo.page + 1})" ${pageInfo.page === pageInfo.pages - 1 ? 'disabled' : ''}>Sonraki</button>
                </div>
            `);
        }
    });

    // Sayfa yüklendiğinde bugünün iptalleri gelsin
    fetchData();

    // Filtreleme butonuna tıklanınca veri çek
    $('.bg-purple-600').on('click', function () {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        fetchData(startDate, endDate);
    });

    function fetchData(startDate = '', endDate = '') {
        $.ajax({
            url: "{{ route('admin.cancel.iptal') }}",
            type: "GET",
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function (response) {
                dataTable.clear(); // önceki verileri temizle

                if (response.data.length > 0) {
                    $.each(response.data, function (index, cancelApplication) {
                        let customerName = cancelApplication.subscription.customer.first_name + ' ' + cancelApplication.subscription.customer.last_name;
                        let staffName = cancelApplication.subscription.customer.staffs[0] ? cancelApplication.subscription.customer.staffs[0].first_name + ' ' + cancelApplication.subscription.customer.staffs[0].last_name : '-';
                        let serviceName = cancelApplication.subscription.service.name || '-';
                        let cancelDate = formatDate(cancelApplication.created_at);
                        let statusLabel = cancelApplication.status == 1 ? 'Sisteme Tanımlandı' : 'Sisteme Tanımlanmadı';
                        let statusClass = cancelApplication.status == 'active'
                            ? 'bg-green-500 text-white'
                            : (cancelApplication.status == 1
                                ? 'bg-blue-500 text-white'
                                : 'bg-red-500 text-white');

                        // 5 sütun içeren veri ekleyin
                        dataTable.row.add([ 
                            `<a href="/admin/customer/${cancelApplication.customer_id}" class="text-blue-600 hover:underline">${customerName}</a>`,
                            staffName,
                            serviceName,
                            cancelDate,
                            `<span class="px-4 py-2 rounded-full ${statusClass}">${statusLabel}</span>`
                        ]);
                    });
                } else {
                    // Veri yoksa 5 hücreli bir satır ekleyin
                     dataTable.row.add([ 
                        '<td colspan="5" class="text-center py-3">Hiç iptal bulunan abonelik yok.</td>',
                        '', '', '', ''
                    ]);
                }

                dataTable.draw(); // Çizim işlemi
            }
        });
    }

    function formatDate(dateString) {
        var date = new Date(dateString);
        var day = date.getDate().toString().padStart(2, '0');
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    function movePage(page) {
        dataTable.page(page).draw('page');
    }
});

</script>


@endpush
