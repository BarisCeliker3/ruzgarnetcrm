@foreach($serviceUpdaters as $serviceUpdater)
<tr>
    <td class="text-center">{{ $serviceUpdater->service_name }}</td>
    <td class="text-center">{{ $serviceUpdater->new_price }}</td>
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

    console.log($('#editForm').serialize()); // Veriyi kontrol et

    console.log('AJAX çağrısı yapıldı!');
$.ajax({
    url: '{{ route('admin.updateService') }}',
    method: 'POST',
    data: $('#editForm').serialize(),
    success: function(response) {
        console.log('AJAX başarılı!', response);
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
        console.error('AJAX hatası:', error);
        toastr.error('Bir hata oluştu!', 'Hata');
    }
});

});
</script>
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