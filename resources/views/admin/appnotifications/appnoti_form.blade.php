@extends('admin.layout.main')

@section('title', meta_title('Bildirim Oluştur'))

@section('content')
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="font-bold tracking-wider text-2xl">
            <i class="bi bi-bell-fill text-primary me-2"></i>
            Bildirim Oluştur ve Gönder
        </h2>
    </div>
    @if(isset($sonuc))
        {!! $sonuc !!}
    @endif

    @if(session('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
    @endif
    @if(session('status'))
        <div class="alert alert-{{ session('alert-type', 'info') }}">{!! session('status') !!}</div>
    @endif

    {{-- Bildirim Oluşturma Formu --}}
    <div class="card shadow mb-4 border-0">
        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-plus-circle me-1"></i>Yeni Bildirim Ekle</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.appnoti.submit') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Başlık</label>
                        <input type="text" name="title" class="form-control" placeholder="Başlık" value="{{ old('title') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mesaj</label>
                        <input type="text" name="body" class="form-control" placeholder="Mesaj" value="{{ old('body') }}" required>
                    </div>
                    <div class="col-12 d-grid mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-send"></i> Gönder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush