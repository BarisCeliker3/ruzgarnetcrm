@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">

                <div class="card-header">
                    <h4>Sözleşme Notları</h4>

                    <div class="card-header-buttons">
                        <a href="/contract-notes/add/1" class="btn btn-primary"><i
                                class="fas fa-sm fa-plus"></i>Not Ekle</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="activities">
                    @foreach ( $contractNotes as $contractnote )
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-detail">
                                <h4>Müşteri Notları </h4>
                                <div class="mb-2">
                                <span class="text-job text-primary">{{$contractnote->created_at}}</span>
                                <span class="bullet"></span>
                                <a class="text-job" >İşlemi Yapan Kullanıcı : {{$contractnote->staff->full_name ?? 'Sistem' }}</a>
                                </div>
                                <p>{{$contractnote->note}}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
