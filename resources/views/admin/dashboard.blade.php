@extends('admin.layout.main')

@section('content')
<style>
.approved-row {
    background-color: #ffffff !important; /* açık yeşil */
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
.video-container {
    position: relative;
    width: 97%;
    max-width: 1150px; /* Video boyutunu sınırlandırmak için */
    margin: 0 auto; /* Ortalamak için */
    overflow: hidden; /* Kenarlardan taşmayı engellemek için */
    border-radius: 15px; /* İstediğin değeri burada değiştirebilirsin */
    border: 3px solid rgba(255, 255, 255, 0.3); /* Zarif ince beyaz kenarlık */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Hafif gölge efekti */
    margin-top: 10vh;
}
.card-body{
    font-size: 15px !important;
    font-family: emoji;

}
.card-header h4{
    color:white;
}
.card-header{
    font-size: 15px !important;
    font-family: emoji;
}
.video-player {
    width: 100%;
    height: auto;
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

.neon-title {
  color: black; /* Daha parlak mavi */
  text-shadow:
    0 0 8px #00e5ff,
    0 0 16px #00e5ff,
    0 0 32px #00e5ff,
    0 0 64px #00f7ff,
    0 0 128px #00ffff;
}

.neon-value {
  color: #ffffff;
  text-shadow:
  0 0 8px #000781, 0 0 16px #000781, 0 0 32px #000781, 0 0 64px #80ffff, 0 0 128px #ccffff
}
.neon-wrapper {
  position: relative;
  width: 120px;
  height: 120px;
  background-color: white;
  padding: 8px;
  border-radius: 1rem;
  overflow: hidden;
  z-index: 0;
}

.neon-wrapper::before {
  content: '';
  position: absolute;
  inset: 0;
  padding: 2px;
  background: conic-gradient(#0ff, #0f0, #f0f, #0ff);
  border-radius: 1rem;
  z-index: 1;
  animation: neonRotate 3s linear infinite;
  mask: 
    linear-gradient(#fff 0 0) content-box, 
    linear-gradient(#fff 0 0);
  -webkit-mask: 
    linear-gradient(#fff 0 0) content-box, 
    linear-gradient(#fff 0 0);
  mask-composite: exclude;
  -webkit-mask-composite: destination-out;
}

.neon-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
  border-radius: 0.75rem;
  position: relative;
  z-index: 2;
  background-color: white;
}

@keyframes neonRotate {
  0% {
    transform: rotate(0turn);
  }
  100% {
    transform: rotate(1turn);
  }
}
<style>
@keyframes neon-border {
  0% {
    background-position: 0% 50%;
  }
  100% {
    background-position: 200% 50%;
  }
}

@keyframes neon-border {
  0% {
    background-position: 0% 50%;
  }
  100% {
    background-position: 200% 50%;
  }
}

.neon-border {
  position: relative;
  display: inline-block;
  padding: 8px;
  border-radius: 4rem !important;
  background: linear-gradient(90deg, #cdffff, #f0f, #ffffff);
  background-size: 300% 300%;
  animation: neon-border 3s linear infinite;
  display: flex; justify-content: center; align-items: center;
}

.neon-border::before {
  content: '';
  position: absolute;
  top: -4px;
  left: -4px;
  right: -4px;
  bottom: -4px;
  border-radius: 1rem;
  background: linear-gradient(90deg, #0ff, #f0f, #0ff);
  background-size: 300% 300%;
  animation: neon-border 3s linear infinite;
  z-index: -1;
  filter: blur(10px);
  opacity: 0.7;
}
.neon-button {
  position: relative;
  display: inline-block;
  background:white
  color: #000;
  text-decoration: none !important;
  font-weight: 600;
  padding: 0.75rem 2rem;
  border-radius: 1.5rem;
  transition: all 0.3s ease-in-out;
  box-shadow: 0 0 10px rgb(253, 17, 234), 0 0 20px rgb(253, 17, 234), 0 0 30px rgb(253, 17, 234);
  overflow: hidden;
}

.neon-button:hover {
  background:rgb(252, 73, 252);
  color: white;

  box-shadow: 0 0 15px rgb(192, 3, 176), 0 0 25px rgb(206, 7, 189), 0 0 35px rgb(253, 17, 234);
}

.neon-button::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: conic-gradient(from 0deg,rgb(255, 45, 192),rgb(67, 249, 255),rgb(253, 138, 238),rgb(69, 212, 255));
  animation: rotate-neon 4s linear infinite;
  z-index: -1;
  filter: blur(20px);
  opacity: 0.6;
}
.icon-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px; /* Yüksekliği ihtiyaca göre ayarlayabilirsiniz */
}
@keyframes rotate-neon {
  to {
    transform: rotate(360deg);
  }
}
</style>
    <div class="section-header">
        <h1 style=" font-family: emoji;">Anasayfa</h1>
    </div>

    <div class="row">
        @if (request()->user()->username == "murtaza" || request()->user()->username == "admin")
       
            <div class="col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary neon-border" style="display: flex; justify-content: center; align-items: center;">
                        <i style="color:aqua;" class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 style="color:white; font-family: emoji;">Müşteri Sayısı</h4>
                        </div>
                        <div class="card-body">
                            {{ $total['customer']}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info neon-border">
                        <i style="color:aqua;" class="fas fa-wifi"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 style="color:white;">Abonelik Sayısı</h4>
                        </div>
                        <div class="card-body">
                            {{ $total['subscription'] }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (request()->user()->role_id != 12)
        <div class="col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div style="border-radius:10vh;" class="neon-border card-icon ">
            <img style="width:100%;margin:auto;" alt="image" src="/assets/images/ruzgarfault.png" class="">

                </div>
                <div class="card-wrap">
                    <div style="padding-top:20px !important;" class="card-header">
                        <h4><a style="font-size: 15px;
    font-family: emoji;color:white;font-weight:800;" href="{{route('admin.active.fault.records')}}">AKTİF ARIZA KAYDI</a></h4>
                    </div>
                    <div class="card-body">
                        {{ $total['faultRecord'] }}
                    </div>
                </div>
            </div>
        </div>
        @endif
      @if (in_array(request()->user()->role_id, [8,10, 11, 12]) || request()->user()->username == "admin" || request()->user()->username == "murtaza")

<div class="col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div style="border-radius:10vh;" class="neon-border card-icon">
            <img style="width:100%;margin:auto;" alt="image" src="/assets/images/crmxgift.png" class="">

        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4><a  style="font-size: 15px;
    font-family: emoji; display:flex;flex-direction: column; color:white;font-weight:800;" href="{{route('admin.new.subs')}}"> {{$total['nowdate']}}  <span>TAMAMLANAN ABONE</span> </a></h4>
            </div>
            <div class="card-body">
                {{ $total['newapplications'] }}
            </div>
        </div>
    </div>
</div>
@endif
@if (in_array(request()->user()->role_id, [8,10, 11, 12]) || request()->user()->username == "admin" || request()->user()->username == "murtaza")

<div class="col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div style="border-radius:10vh;" class="neon-border card-icon ">
            <img style="width:100%;margin:auto;" alt="image" src="/assets/images/plusone.png" class="">

        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4><a style="font-size: 15px;
    font-family: emoji;display:flex;flex-direction: column; color:white !important; font-size:17px;" href="{{route('admin.new.subsentercompany')}}">{{$total['nowdate']}}  <span>İÇERİ ALINANLAR</span> </a></h4>
            </div>
            <div class="card-body">
                {{ $total['subsCount']}}
            </div>
        </div>
    </div>
</div>
@endif
@if (in_array(request()->user()->role_id, [8,10, 11, 12]) || request()->user()->username == "admin" || request()->user()->username == "murtaza")

<div class="col-md-6 col-sm-6 col-12">
    <div class="icon-container card card-statistic-1">
        <div style="border-radius:10vh;" class="neon-border card-icon bg-danger">
            <img style="width:85%;margin:auto;" alt="image" src="/assets/images/crmxlogo.png" class="">

        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4><a  style="font-size: 15px;
    font-family: emoji;display:flex;flex-direction: column;  color:white !important; font-size:17px;" href="{{route('admin.cancel.iptal')}}">{{$total['nowdate']}}  <span> İPTAL EDİLENLER</span> </a></h4>

            </div>
            <div class="card-body">
                {{ $total['cancelApp'] }}
            </div>
        </div>
    </div>
</div>
@endif
@if (request()->user()->username == "admin" || request()->user()->username == "murtaza")

            <div class="col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning neon-border">
                        <i style="color:aqua;" class="fas fa-lira-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 style="color:white; font-size:15px;">BU AYIN TAHSİLATI</h4>
                        </div>
                        <div class="card-body">
                            {{ print_money($total['payment']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div  class="card-icon bg-primary neon-border">

                        <i style="color:aqua;" class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4  style="color:white; font-size:15px;"><a href="{{route('admin.payment.notpaid')}}">ÖDEME YAPMAYAN ABONELER</a></h4>
                        </div>
                        <div class="card-body">
                            {{ $total['notpaidcount']}}
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger neon-border">
                        <i style="color:aqua;" class="fas fa-lira-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 style="color:white; font-size:15px;"><a href="{{route('admin.payment.notpaid')}}">ÖDENMEYEN TUTAR</a></h4>
                        </div>
                        <div class="card-body">
                            {{ print_money($total['notpaid']) }}
                        </div>
                    </div>
                </div>
            </div>
        @endif


  @if (request()->user()->role_id != 12)
        <div class="col-lg-12">
            <div class="card list">
                <div class="card-header">
                    <h4 style=" font-family: emoji;">Son Eklenen Abonelikler</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive">
    <table class="table table-striped table-hover align-middle text-center" id="dataTable">
        <thead class="table-custom-header">
            <tr>
                <th class="title-table" scope="col">#</th>
                <th class="title-table" scope="col">@lang('fields.customer')</th>
                <th class="title-table" scope="col">@lang('fields.service')</th>
                <th class="title-table" scope="col">@lang('fields.price')</th>
                <th class="title-table" scope="col">@lang('fields.start_date')</th>
                <th class="title-table" scope="col">@lang('fields.end_date')</th>
                <th class="title-table" scope="col">@lang('fields.approve_date')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr data-id="{{ $subscription->id }}"
                    class="{{ $subscription->approved_at == null ? 'un-approved-row' : 'approved-row' }}">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        <a href="{{ route('admin.customer.show', $subscription->customer_id) }}">
                            {{ $subscription->customer->full_name }}
                        </a>
                    </td>
                    <td>
                        <div>
                            {{ $subscription->service->name }}
                            @if ($subscription->isCanceled())
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-toggle="popover" data-bs-html="true"
                                    data-bs-content="
                                        <b>Tarih:</b> {{ convert_date($subscription->cancellation->created_at, 'large') }} <br>
                                        <b>Personel</b>: {{ $subscription->cancellation->staff->full_name }} <br>
                                        <b>Sebep</b>: {{ $subscription->cancellation->description }}">
                                    @lang('titles.cancel')
                                </button>
                            @endif
                        </div>
                        @if ($subscription->isChanged())
                            <div>
                                <small class="text-muted">
                                    <a href="{{ route('admin.subscription.payments', $subscription->getChanged()) }}">
                                        {{ $subscription->getChanged()->service->name }}
                                    </a>
                                </small>
                            </div>
                        @endif
                    </td>
                    <td><span class="badge text-white  bg-success">{{ $subscription->price_print }}</span></td>
                    <td>{{ convert_date($subscription->start_date, 'mask') }}</td>
                    <td>
                        @if ($subscription->end_date)
                            <span class="badge bg-warning text-dark">
                                {{ convert_date($subscription->end_date, 'mask') }}
                            </span>
                        @else
                            <span class="badge bg-primary">@lang('fields.commitless')</span>
                        @endif
                    </td>
                    <td>
                        @if ($subscription->approved_at != null)
                            <span class="badge bg-info text-dark">
                                {{ convert_date($subscription->approved_at, 'mask_time') }}
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

                    </div>
                    
                </div>
            </div>
        </div>
  @endif        

<div class="video-container">
    <video class="video-player" autoplay loop muted>
        <source src="/assets/images/videohome.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

    </div>
@endsection
