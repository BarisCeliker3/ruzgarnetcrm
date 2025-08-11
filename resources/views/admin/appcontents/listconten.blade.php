@extends('admin.layout.main')
@section('title', meta_title('Uygulama İçerik Düzenle'))
@section('content')

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="font-bold tracking-wider text-2xl">
            <i class="bi bi-bell-fill text-primary me-2"></i>
            İçerikler Yönetim Paneli
        </h2>
    </div>

    {{-- Create Form --}}
    <div class="card shadow mb-4 border-0">
        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-plus-circle me-1"></i>Yeni İçerik Ekle</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Başlık</label>
                        <input type="text" name="title" class="form-control" placeholder="Başlık" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">İçerik</label>
                        <textarea name="body" class="form-control" placeholder="İçerik" rows="1" required></textarea>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-control" required>
                            <option value="Aile">Aile</option>
                            <option value="Çocuk">Çocuk</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Resim</label>
                        <input type="text" name="resim" class="form-control" placeholder="Resim Yolu veya URL">
                        {{-- 
                        Eğer dosya upload istiyorsan:
                        <input type="file" name="resim" class="form-control">
                        --}}
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-square-dotted"></i> Ekle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <div class="card shadow border-0">
        <div class="card-header bg-light">
            <strong><i class="bi bi-table me-1"></i>İçerikler Tablosu</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle" id="appnotisTable">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>İçerik</th>
                        <th>Kategori</th>
                        <th>Resim</th>
                        <th>Oluşturulma</th>
                        <th>Güncellenme</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
@foreach($contents as $content)
    <tr id="row-{{ $content->id }}">
        <td>{{ $content->id }}</td>
        <td>{{ $content->title }}</td>
        <td>{{ $content->body }}</td>
        <td>{{ $content->category }}</td>
        <td>
            @if($content->resim)
                <img src="{{ $content->resim }}" alt="Resim" style="max-width: 60px; max-height: 60px;">
            @endif
        </td>
        <td>{{ $content->created_at }}</td>
        <td>{{ $content->updated_at }}</td>
        <td class="d-flex gap-1">
            <button 
                type="button"
                class="inline-flex items-center px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm"
                onclick="openModal('modal-{{ $content->id }}')"
            >
                <i class="bi bi-pencil-square"></i>
            </button>
            <form action="{{ route('admin.content.destroy', $content->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm" title="Sil">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </td>
    </tr>
@endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {{ $contents->links() }}
            </div>
        </div>
    </div>
</div>

{{-- TAILWIND MODALS - UPDATE --}}
@foreach($contents as $content)
<div 
    id="modal-{{ $content->id }}" 
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden"
    tabindex="-1" aria-labelledby="modalLabel{{ $content->id }}" aria-modal="true" role="dialog"
>
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-2 relative">
        <div class="flex items-center justify-between px-5 py-3 border-b">
            <h5 class="text-lg font-semibold" id="modalLabel{{ $content->id }}">İçeriği Güncelle</h5>
            <button type="button" class="text-gray-400 hover:text-gray-900 text-2xl" onclick="closeModal('modal-{{ $content->id }}')">&times;</button>
        </div>
        <form action="{{ route('admin.content.update', $content->id) }}" method="POST" class="p-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Başlık</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ $content->title }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">İçerik</label>
                <textarea name="body" class="w-full border rounded px-3 py-2" required>{{ $content->body }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded px-3 py-2" required>
                    <option value="Aile" {{ $content->category == 'Aile' ? 'selected' : '' }}>Aile</option>
                    <option value="Çocuk" {{ $content->category == 'Çocuk' ? 'selected' : '' }}>Çocuk</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Resim</label>
                <input type="text" name="resim" class="w-full border rounded px-3 py-2" value="{{ $content->resim }}">
                {{-- 
                Eğer dosya upload istiyorsan:
                <input type="file" name="resim" class="w-full border rounded px-3 py-2">
                --}}
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeModal('modal-{{ $content->id }}')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Kapat</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Güncelle</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}
window.addEventListener('keydown', function(e){
    if(e.key === "Escape") {
        document.querySelectorAll('.fixed.inset-0.z-50').forEach(function(modal){
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }
});
</script>
@endsection

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.3.1/css/dataTables.dateTime.min.css">
    <style>
        .dataTableFlex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .table-primary th {
            background-color: #cfe2ff !important;
        }
        .card-header strong i {
            color: #0d6efd;
        }
    </style>
@endpush

@push('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/admin/vendor/datatables/dataTables.dateTime.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.3.1/js/dataTables.dateTime.min.js"></script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#appnotisTable')) {
                $('#appnotisTable').DataTable({
                    language: {
                        url: '/assets/admin/vendor/datatables/i18n/tr.json'
                    },
                    dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title: 'İçerikler'
                        }
                    ],
                    columnDefs: [
                        {"type": "num", "targets": 0},
                        {"orderable": false, "targets": [1, 2, 3, 4, 5, 6, 7]}
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, 'Tümü'],
                    ],
                });
            }
        });
    </script>
@endpush