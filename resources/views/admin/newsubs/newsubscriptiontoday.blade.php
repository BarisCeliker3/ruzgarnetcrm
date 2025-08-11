@extends('admin.layout.main')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-purple-600 text-center mb-6">Yeni Abonelikler</h2>

        <div class="overflow-x-auto">
            <table id="subsTable" class="min-w-full table-auto border border-gray-300">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2">Müşteri</th>
                        <th class="px-4 py-2">Temsilci</th>
                        <th class="px-4 py-2">Hizmet</th>
                        <th class="px-4 py-2">Fiyat</th>
                        <th class="px-4 py-2">Durum</th>
                        <th class="px-4 py-2">Tarih</th>
                      
                    </tr>
                </thead>
                <tbody>
                    @foreach($subsupgradesalti as $item)
                    <tr class="hover:bg-gray-100 border-b">
                        <td class="py-3 px-6">
                            <a href="{{ route('admin.customer.show', $item->customer_id) }}"
                               class="text-blue-600 hover:underline">
                                {{ $item->isim }}
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $item->temsilci }}</td>
                        <td class="px-4 py-2">{{ $item->name }}</td>
                        <td class="px-4 py-2">{{ number_format($item->price, 2) }}₺</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-white 
                                {{ $item->status == 0 ? 'bg-yellow-500' : 'bg-green-600' }}">
                                {{ $item->status == 0 ? 'Hazırlıkta' : 'Aktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d.m.Y H:i') }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#subsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json'
            },
            pageLength: 10
        });
    });
</script>
@endpush
