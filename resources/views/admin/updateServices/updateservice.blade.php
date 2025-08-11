@extends('admin.layout.main')

@section('title', meta_title('tables.subscription.title'))

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mt-5">
    <!-- Başlık -->
    <div class="text-center mb-6 mt-6">
        <h2 class="text-3xl font-semibold text-primary pt-5">Otomatik Servis Ücret ve Taahhüt Belirleme Sistemi</h2>
        <p class="text-lg text-gray-600">Servisler için yeni ücret ve taahhüt kuralları belirleyin.</p>
    </div>

    <!-- Form -->
    <div style="margin-top:10vh;" class="max-w-2xl mx-auto p-6 shadow-md rounded-lg ">
        <form style="width: 50%; margin: auto; text-align: center;" id="updateSubscriptionsForm" action="{{ route('admin.updateservicespost') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="form-group">
                    <label for="category_id" class="text-lg font-semibold" style="color:blue;">Kategori</label>
                    <select name="category_id" id="category_id" class="form-control mt-2 block w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Kategori Seçin</option>
                        @foreach($filteredCategories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>
        
                <script>
                    document.getElementById('category_id').addEventListener('change', function() {
                        var categoryId = this.value;
                        var newPriceInput = document.getElementById('new_price');
                        var newPriceLabel = document.getElementById('new_price_label');
        
                        if (categoryId == '999') {
        newPriceInput.placeholder = 'Yeni Yüzde Belirle';
        newPriceLabel.innerText = 'Yeni Yüzde';
    } else if (categoryId == '6') {
        newPriceInput.placeholder = 'Box Paketlere Eklenicek Tutar';
        newPriceLabel.innerText = 'Eklenecek Tutar';
    }


        
                        // Kategori seçildiğinde servisleri güncelle
                        if (categoryId) {
                            fetch(`/get-services/${categoryId}`)
                                .then(response => response.json())
                                .then(data => {
                                    var serviceSelect = document.getElementById('service_id');
                                    serviceSelect.innerHTML = ''; // Mevcut seçenekleri temizle
        
                                    var defaultOption = document.createElement('option');
                                    defaultOption.value = '';
                                    defaultOption.text = 'Servis Seçin';
                                    serviceSelect.appendChild(defaultOption);
        
                                    data.services.forEach(service => {
                                        var option = document.createElement('option');
                                        option.value = service.id;
                                        option.text = service.name;
                                        serviceSelect.appendChild(option);
                                    });
                                });
                        } else {
                            document.getElementById('service_id').innerHTML = '<option value="">Önce Kategori Seçin</option>';
                        }
                    });
                </script>
        
                <div class="form-group">
                    <label for="new_comminment" class="text-lg font-semibold text-gray-700" style="color:blue;">Yeni Tahattüt</label>
                    <select id="categoriess" style="width:100%;" name="new_comminent" class="p-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
        
                <div class="form-group">
                    <label id="new_price_label" for="new_price" class="text-lg font-semibold text-gray-700" style="color:blue;">Yeni Fiyat</label>
                    <input type="number" name="new_price" id="new_price" class="form-control mt-2 block w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Yeni Fiyat">
                </div>
        
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm shadow-sm rounded-pill px-4 py-2 transform transition-all hover:scale-105 hover:shadow-lg hover:bg-primary focus:outline-none focus:ring-4 focus:ring-primary focus:ring-opacity-50">
                        Abonelikleri Güncelle
                    </button>
                </div>
            </div>
        </form>
        
    </div>
</div>

<hr class="my-5 border-t-4 border-blue-500 opacity-50">

<div class="container my-5">
    <!-- Başlık -->
    <div class="text-center mb-5">
        <h2 class="text-3xl font-semibold text-primary">Servis Bazlı Abonelik Kuralları</h2>
        <p class="text-lg text-gray-600">Her servise bağlı tüm abonelerin yeni fiyat ve taahhüt bilgilerini otomatik olarak güncelleyebilirsiniz.</p>
    </div>

    <div class="flex flex-col md:flex-row md:items-end md:gap-6 mb-4">
        <div class="w-full md:w-1/3">
            <label for="category-filter" class="ml-4 block text-sm font-semibold text-gray-700 mb-2">
                📂 Kategori Seç:
            </label>
            <select id="category-filter" name="category_id" class="block w-full h-[45px] px-4 py-2 border-2 border-gray-300 focus:border-blue-500 focus:outline-none rounded-xl custom-select">
                <option value="">Tüm Kategoriler</option>
                @foreach($filteredCategories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
    
        <!-- Arama Çubuğu -->
        <div class="w-full md:w-1/3 mt-4 md:mt-0">
            <label for="search" class="ml-5 block text-sm font-semibold text-gray-700 mb-2">
                🔍 Servis Adı ile Ara:
            </label>
            <input type="text" id="search" name="search" placeholder="Örn: Rüzgar Paket"
                   class="block w-full h-[45px] px-4 py-2 border-2 border-gray-300 focus:border-blue-500 focus:outline-none p-2 rounded-xl">
        </div>
    </div>
    
    <!-- Servis Tablosu -->
    <div class="table-responsive shadow-lg rounded-lg overflow-hidden">
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-light bg-blue-100">
                <tr>
                    <th scope="col" class="text-center">Servis Adı</th>
                    <th scope="col" class="text-center">Yeni Fiyat / Yüzde</th>
                    <th scope="col" class="text-center">Yeni Taahhüt</th>
                    <th scope="col" class="text-center">Düzenle / Sil</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach($serviceUpdaters as $serviceUpdater)
                    <tr id="service-{{ $serviceUpdater->service_id }}">
                        <td class="text-center">{{ $serviceUpdater->service_name }}</td>
                        <td class="text-center" id="new-price-{{ $serviceUpdater->service_id }}">
                            {{ $serviceUpdater->service_id == 999 ? 'Yüzde Burada Görünecek' : $serviceUpdater->new_price }}
                        </td>
                        <td class="text-center">{{ $serviceUpdater->new_commitment }}</td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-sm my-2"
                                    onclick="openModal({{ $serviceUpdater->service_id }}, '{{ $serviceUpdater->service_name }}', '{{ $serviceUpdater->new_price }}', '{{ $serviceUpdater->new_commitment }}')">
                                Düzenle
                            </button>
                            <form class="mb-2 delete-form" data-service-name="{{ $serviceUpdater->service_name }}" action="{{ route('admin.deleteservice', $serviceUpdater->service_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-btn">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Sayfalama -->
    <div id="pagination-links" class="mt-4">
        {{ $serviceUpdaters->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    
    <!-- Sayfalama -->
    
    
    <!-- JavaScript -->
    <script>
     document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('category_id');
    const search = urlParams.get('search');

    // Kategori seçicisini güncelle
    if (categoryId) {
        document.getElementById('category-filter').value = categoryId;
    }

    // Arama kutusunu güncelle
    if (search) {
        document.getElementById('search').value = search;
    }

    // Kategori değiştiğinde fiyatı kontrol et
    if (categoryId == '999') {
        updateServicePriceById(999);
    }
});

// Kategori filtresi değiştiğinde URL'yi güncelle
document.getElementById('category-filter').addEventListener('change', function () {
    const categoryId = this.value;
    const search = document.getElementById('search').value;
    const url = new URL(window.location.href);

    if (categoryId) {
        url.searchParams.set('category_id', categoryId);
    } else {
        url.searchParams.delete('category_id');
    }

    if (search) {
        url.searchParams.set('search', search);
    } else {
        url.searchParams.delete('search');
    }

    window.location.href = url.toString();

    // Kategori değiştiğinde, fiyatı kontrol et
    if (categoryId == '999') {
        updateServicePriceById(999);
    }
});

// Arama kutusu değiştiğinde URL'yi güncelle
document.getElementById('search').addEventListener('input', function () {
    const search = this.value;
    const categoryId = document.getElementById('category-filter').value;
    const url = new URL(window.location.href);

    if (search) {
        url.searchParams.set('search', search);
    } else {
        url.searchParams.delete('search');
    }

    if (categoryId) {
        url.searchParams.set('category_id', categoryId);
    } else {
        url.searchParams.delete('category_id');
    }

    window.location.href = url.toString();
});

// serviceUpdater id 999 olan servis için fiyatı güncelleyen fonksiyon
function updateServicePriceById(serviceId) {
    // Service ID 999 olan servisi al
    const serviceRow = document.querySelector(`#service-${serviceId}`);
    if (serviceRow) {
        // Yeni fiyatı al
        const priceElement = serviceRow.querySelector(`#new-price-${serviceId}`);

        // Eğer kategori ID 999 ise fiyat yerine yüzdeyi göster
        if (serviceId == 999) {
            priceElement.textContent = 'Yeni Yüzde Buradan Alındı';  // Yüzdeyi burada değiştiriyoruz
        }
        if (serviceId == 6) {
            priceElement.textContent = 'Box Pakete Eklencek Tutar';  // Yüzdeyi burada değiştiriyoruz
        }
    }
}

    </script>


<!-- Modal for Editing -->
@if(session('status'))
    <script>
        toastr.{{ session('type') }}("{{ session('status') }}");
    </script>
@endif
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.delete-form');
            const serviceName = form.getAttribute('data-service-name') || "bu servisi";
    
            Swal.fire({
                title: 'Emin misiniz?',
                text: `${serviceName} silinecek. Bu işlemi geri alamazsınız!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    </script>
    
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Servis Güncelle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="editForm" method="POST" action="{{ route('admin.updateService') }}">
                @csrf
                <input type="hidden" id="services_id" name="services_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="service_name">Servis Adı</label>
                        <input type="text" id="service_name" name="service_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_price">Yeni Fiyat</label>
                        <input type="text" id="new_price" name="new_price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new_commitment">Yeni Taahhüt</label>
                        <input type="text" id="new_commitment" name="new_commitment" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function openModal(id, name, price, commitment) {
    document.getElementById('services_id').value = id;
    document.getElementById('service_name').value = name;
    document.getElementById('new_price').value = price;  // Fiyatı burada ayarlıyoruz
    document.getElementById('new_commitment').value = commitment;
    $('#editModal').modal('show');
}
 // Ensuring the most recent values are captured before form submission

</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
 $('#editForm').on('submit', function(e) {
    e.preventDefault();  // Normal form post işlemi engelleniyor

$.ajax({
    url: '{{ route('admin.updateService') }}',
    method: 'POST',
    data: $('#editForm').serialize(),
    success: function(response) {
        if (response.success) {
            toastr[response.toastr.type](response.toastr.message, response.toastr.title);
            setTimeout(function () {
                location.reload(); // Sayfayı yenile
            }, 500);
        } else {
            setTimeout(function () {
                location.reload(); // Sayfayı yenile
            }, 500);
            toastr[response.toastr.type](response.toastr.message, response.toastr.title);
        }
    },
    error: function(xhr, status, error) {
        toastr.error('Bir hata oluştu!', 'Hata');
    }
});

});

</script>

</script>

<script>
    var debounceTimer;
$('#search').on('input', function () {
    clearTimeout(debounceTimer); // Önceki timeout'u temizle

    var searchQuery = $(this).val(); // Arama metnini al

    // Yeni timeout oluştur
    debounceTimer = setTimeout(function () {
        // Ajax çağrısı yap
        $.ajax({
            url: "{{ route('admin.updateServices.index') }}", // Laravel rotası
            method: 'GET',
            data: {
                search: searchQuery, // Arama parametresini gönder
                category_id: $('#category-filter').val() // Kategoriyi de gönder
            },
            success: function (data) {
                // Tabloyu ve sayfalama kısmını güncelle
                $('#table-body').html(data.table);
                $('#pagination-links').html(data.pagination);
            }
        });
    }, 500); // 500ms sonra ajax çağrısını yap
});

// Sayfalama linklerine tıklanıldığında Ajax çağrısı yap
$(document).on('click', '#pagination-links a', function (e) {
    e.preventDefault(); // Linkin normal işlevini engelle

    var url = $(this).attr('href'); // Linkin URL'sini al

    // Ajax çağrısı yap
    $.ajax({
        url: url,
        method: 'GET',
        data: {
            search: $('#search').val(), // Arama metnini gönder
            category_id: $('#category-filter').val() // Kategoriyi gönder
        },
        success: function (data) {
            // Tabloyu ve sayfalama kısmını güncelle
            $('#table-body').html(data.table);
            $('#pagination-links').html(data.pagination);
        }
    });
});
</script>


<script>
document.getElementById('updateSubscriptionsForm').addEventListener('submit', function(e) {
// Eğer işlem arka planda yapılmıyorsa, bu satıra gerek yoktur.
// e.preventDefault();

// Submit'ten sonra sayfayı yenilemek için bekle
setTimeout(function () {
    location.reload(); // Sayfayı yenile
}, 1000); // 1 saniye sonra yenile (işlem bitene kadar beklemek için)
});
</script>

@if(session('message'))
<div class="alert alert-danger">
{{ session('message') }}
</div>
@endif
@endsection
