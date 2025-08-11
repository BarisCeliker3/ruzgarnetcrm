@extends('admin.layout.main')

@section('title', meta_title('Genel Rapor'))

@section('content')
@push('script')
<script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
    
    <script src="https://cdn.plot.ly/plotly-2.27.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
<div class="row">
            <div style=" margin-top:40px" class=" col-md-12">
            
        	</div>
    	
    <div class="grey-bg container-fluid">

      @php
    $dataid = "";
    
    foreach($customers as $customer){
        $dataid.= "$customer->id";
    }
    
    $dataid1 = "";
    foreach($subscriptions as $subscription){
        $dataid1.= "$subscription->id";
    }
    
     $dataid2 = "";
    foreach($staffs as $staff){
        $dataid2.= "$staff->id";
    }
    
    $dataid3 = "";
    foreach($staffs2 as $staff2){
        $dataid3.= "$staff2->id";
    }
    
    $dataid4 = "";
    foreach($staffs3 as $staff3){
        $dataid4.= "$staff3->id";
    }
    
     $dataid5 = "";
    foreach($services as $service){
        $dataid5.= "$service->id";
    }
    
    @endphp
    
        @php
    $labelsabone15 = "";
    $dataabone15 = "";
    $first_name = "";
    $last_name = "";
    
    
    foreach($satis1 as $satis){
        $labelsabone15.= "\"$satis->created_at\",";
        $dataabone15.= "$satis->id,";
        $first_name ="$satis->first_name";
        $last_name ="$satis->last_name";
    }
    
        $bugunaktif = "";
    
    foreach($bugunAktif as $bugunAkti){
        $bugunaktif.= "$bugunAkti->id";
    }
    
    
    $labelsaboneListe = "";
    $dataaboneListe = "";
    $first_nameListe = "";
    $last_nameListe = "";
    
    
    foreach($platiniumAktifListe as $platiniumAktifList){
 
         $labelsaboneListe.= "\"$platiniumAktifList->created_at\",";
        $dataaboneListe.= "$platiniumAktifList->id";
        $first_nameListe ="$platiniumAktifList->first_name";
        $last_nameListe ="$platiniumAktifList->last_name";
     
    
    }
    
    
        $labelsaboneListe44 = "";
    $dataaboneListe44 = "";
    $first_nameListe44 = "";
    $last_nameListe44 = "";
    
    
    foreach($platiniumAktifListe44 as $platiniumAktifList44){
 
         $labelsaboneListe44.= "\"$platiniumAktifList44->created_at\",";
        $dataaboneListe44.= "$platiniumAktifList44->id";
        $first_nameListe44 ="$platiniumAktifList44->first_name";
        $last_nameListe44 ="$platiniumAktifList44->last_name";
     
    
    }
    
    
    
    
            $labelsaboneListe44 = "";
    $dataaboneListe44 = "";
    $first_nameListe44 = "";
    $last_nameListe44 = "";
    
    
    foreach($platiniumAktifListe44 as $platiniumAktifList44){
 
         $labelsaboneListe44.= "\"$platiniumAktifList44->created_at\",";
        $dataaboneListe44.= "$platiniumAktifList44->id";
        $first_nameListe44 ="$platiniumAktifList44->first_name";
        $last_nameListe44 ="$platiniumAktifList44->last_name";
     
    
    }
    
    
    
            $labelsaboneListe41 = "";
    $dataaboneListe41 = "";
    $first_nameListe41 = "";
    $last_nameListe41 = "";
    
    
    foreach($platiniumAktifListe41 as $platiniumAktifList41){
 
         $labelsaboneListe41.= "\"$platiniumAktifList41->created_at\",";
        $dataaboneListe41.= "$platiniumAktifList41->id";
        $first_nameListe41 ="$platiniumAktifList41->first_name";
        $last_nameListe41 ="$platiniumAktifList41->last_name";
     
    
    }
    
    
    
            $labelsaboneListe53 = "";
    $dataaboneListe53 = "";
    $first_nameListe53 = "";
    $last_nameListe53 = "";
    
    
    foreach($platiniumAktifListe53 as $platiniumAktifList53){
 
         $labelsaboneListe53.= "\"$platiniumAktifList53->created_at\",";
        $dataaboneListe53.= "$platiniumAktifList53->id";
        $first_nameListe53 ="$platiniumAktifList53->first_name";
        $last_nameListe53 ="$platiniumAktifList53->last_name";
     
    
    }
    
    
                $labelsaboneListe54 = "";
    $dataaboneListe54 = "";
    $first_nameListe54 = "";
    $last_nameListe54 = "";
    
    
    foreach($platiniumAktifListe54 as $platiniumAktifList54){
 
         $labelsaboneListe54.= "\"$platiniumAktifList54->created_at\",";
        $dataaboneListe54.= "$platiniumAktifList54->id";
        $first_nameListe54 ="$platiniumAktifList54->first_name";
        $last_nameListe54 ="$platiniumAktifList54->last_name";
     
    
    }
    
    
    
    
    $satisbugun = "";
    
    foreach($satisBugun as $satisBugu){
        $satisbugun.= "$satisBugu->id";
    }
    

    
    $labelsaboneListe33 = "";
    $dataaboneListe33 = "";
    $first_nameListe33 = "";
    $last_nameListe33 = "";
    
    
    foreach($satisBugun33 as $satisBugu33){
 
         $labelsaboneListe33.= "\"$satisBugu33->created_at\",";
        $dataaboneListe33.= "$satisBugu33->id";
        $first_nameListe33 ="$satisBugu33->first_name";
        $last_nameListe33 ="$satisBugu33->last_name";
     
    
    }
    
    $labelsaboneListe34 = "";
    $dataaboneListe34 = "";
    $first_nameListe34 = "";
    $last_nameListe34 = "";
    
    
    foreach($satisBugun34 as $satisBugu34){
 
         $labelsaboneListe34.= "\"$satisBugu34->created_at\",";
        $dataaboneListe34.= "$satisBugu34->id";
        $first_nameListe34 ="$satisBugu34->first_name";
        $last_nameListe34 ="$satisBugu34->last_name";
     
    
    }
    
    $labelsaboneListe38 = "";
    $dataaboneListe38 = "";
    $first_nameListe38 = "";
    $last_nameListe38 = "";
    
    
    foreach($satisBugun38 as $satisBugu38){
 
        $labelsaboneListe38.= "\"$satisBugu38->created_at\",";
        $dataaboneListe38.= "$satisBugu38->id";
        $first_nameListe38 ="$satisBugu38->first_name";
        $last_nameListe38 ="$satisBugu38->last_name";
     
    
    }
    
        $labelsaboneListe57 = "";
    $dataaboneListe57 = "";
    $first_nameListe57 = "";
    $last_nameListe57 = "";
    
    
    foreach($satisBugun57 as $satisBugu57){
 
         $labelsaboneListe57.= "\"$satisBugu57->created_at\",";
        $dataaboneListe57.= "$satisBugu57->id";
        $first_nameListe57 ="$satisBugu57->first_name";
        $last_nameListe57 ="$satisBugu57->last_name";
     
    
    }
    
    
    $labelsaboneListe11 = "";
    $dataaboneListe11= "";
    $first_nameListe11 = "";
    $last_nameListe11 = "";
    
    
    foreach($satisBugun11 as $satisBugu11){
 
         $labelsaboneListe11.= "\"$satisBugu11->created_at\",";
        $dataaboneListe11.= "$satisBugu11->id";
        $first_nameListe11 ="$satisBugu11->first_name";
        $last_nameListe11 ="$satisBugu11->last_name";
     
    
    }
    
    
    $labelsaboneListe60 = "";
    $dataaboneListe60= "";
    $first_nameListe60 = "";
    $last_nameListe60 = "";
    
    
    foreach($satisBugun60 as $satisBugu60){
 
         $labelsaboneListe60.= "\"$satisBugu60->created_at\",";
        $dataaboneListe60.= "$satisBugu60->id";
        $first_nameListe60 ="$satisBugu60->first_name";
        $last_nameListe60 ="$satisBugu60->last_name";
     
    
    }
   
    @endphp
    
  <section id="stats-subtitle">
  <div class="row">
    <div class="col-xl-6 col-md-12">
      <div style="border:thick double #5dcffd;" class="card overflow-hidden">
        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                
                  <i class="icon-user success font-large-2 mr-2"></i>
              </div>
              <div class="media-body">
                <h4>Aktif Müşteri Sayısı</h4>
                <span></span>
              </div>
              <div class="align-self-center">
                <h1>{!!  number_format($dataid) !!}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-md-12">
      <div class="card">
      <div style="margin-bottom:0px;border:thick double #5dcffd;" class="card overflow-hidden">

          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                  <i class="icon-wallet success font-large-2 mr-2"></i>
                
              </div>
              <div class="media-body">
                <h4>Aktif Abone Sayısı</h4>
                <span></span>
              </div>
              <div class="align-self-center"> 
                <h1>{!!  number_format($dataid1) !!}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xl-6 col-md-12">
      <div style="border:thick double #5dcffd;" class="card overflow-hidden">

        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <h1 class="mr-2">{!!  number_format($dataid2) !!}</h1>
              </div>
              <div class="media-body">
                <h4>Aktif Çalışan Sayısı</h4>
                 <span  class="text-danger">Bayan: {!!  number_format($dataid4) !!} </span>
                 <span  class="text-success">Bay: {!!  number_format($dataid3) !!}</span>
              </div>
              <div class="align-self-center">
                 <i class="fa fa-users danger font-large-2"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
    
   
    
    <div class="col-xl-6 col-md-12">
      <div style="border:thick double #5dcffd;" class="card overflow-hidden">

        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <h1 class="mr-2">{!!  number_format($dataid5) !!}</h1>
              </div>
              <div class="media-body">
                <h4>Toplam Tarife Sayısı</h4>
                <span></span>
              </div>
              <div class="align-self-center">
                  <i class="icon-graph danger font-large-2"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    

        <div class="col-xl-6 col-md-12">
      <div style="border:thick double #5dcffd;" class="card overflow-hidden">

        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <h1  class="mr-2" data-toggle="tooltip" data-placement="bottom" data-html="true" 
            title="<h6>{!! $first_nameListe !!} {!!   $last_nameListe  !!}  <span class='badge badge-pill badge-warning'>{!!  $dataaboneListe   !!}</span><br></h6>
                   <h6>{!! $first_nameListe44 !!} {!!   $last_nameListe44  !!}  <span class='badge badge-pill badge-warning'>{!!  $dataaboneListe44  !!}</span><br></h6>
                   <h6>{!! $first_nameListe41 !!} {!!   $last_nameListe41  !!}  <span class='badge badge-pill badge-warning'>{!!  $dataaboneListe41  !!}</span><br></h6> 
                   <h6>{!! $first_nameListe53 !!} {!!   $last_nameListe53  !!}  <span class='badge badge-pill badge-warning'>{!!  $dataaboneListe53  !!}</span><br></h6>
                   <h6>{!! $first_nameListe54 !!} {!!   $last_nameListe54  !!}  <span class='badge badge-pill badge-warning'>{!!  $dataaboneListe54  !!}</span><br></h6>
                 ">  
                      {!!  number_format($bugunaktif)  !!}

                    </h1>
              </div>
              <div class="media-body">
                <h4><span class="text-success">Platinium Biriminin</span> Günlük Aktif Abone Sayısı</h4>
                <span></span>
              </div>
              <div class="align-self-center">
                  <i class="fa fa-check-circle success font-large-2"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    

     
     <div class="col-xl-6 col-md-12">
      <div style="border:thick double #32a1ce;" class="card">
        <div class="card-content">
          <div class="card-body cleartfix">
            <div class="media align-items-stretch">
              <div class="align-self-center">
                <h1 class="mr-2" data-toggle="tooltip1" data-placement="bottom" data-html="true"
            title="
                   <h6>{!! $first_nameListe33 !!} {!!   $last_nameListe33  !!}  <span class='badge badge-pill badge-primary'>{!!  $dataaboneListe33  !!}</span><br></h6>
                   <h6>{!! $first_nameListe38 !!} {!!   $last_nameListe38  !!}  <span class='badge badge-pill badge-primary'>{!!  $dataaboneListe38  !!}</span><br></h6>
                   <h6>{!! $first_nameListe57 !!} {!!   $last_nameListe57  !!}  <span class='badge badge-pill badge-primary'>{!!  $dataaboneListe57  !!}</span><br></h6>
                   <h6>{!! $first_nameListe34 !!} {!!   $last_nameListe34  !!}  <span class='badge badge-pill badge-primary'>{!!  $dataaboneListe34  !!}</span><br></h6>
                   <h6>{!! $first_nameListe60 !!} {!!   $last_nameListe60  !!}  <span class='badge badge-pill badge-primary'>{!!  $dataaboneListe60  !!}</span><br></h6>
                   <h6>{!! $first_nameListe11 !!} {!!   $last_nameListe11  !!}  <span class='badge badge-pill badge-primary'>{!!  $dataaboneListe11  !!}</span><br></h6>
                "> 
                      {!!  number_format($satisbugun)  !!}

                    </h1>
              </div>
              <div class="media-body">
                <h4><span class="text-info">Satış Biriminin</span> Günlük Satılan Abone Sayısı</h4>
                <span></span>
              </div>
              <div class="align-self-center">
                  <i class="fa fa-user-plus info font-large-2"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
    <!-- Formu değiştirelim: -->
    <form onsubmit="event.preventDefault(); submitForm();" class="max-w-xl mx-auto bg-white rounded-xl shadow-lg p-2 space-y-1 text-sm">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="start_date" class="block text-gray-600 font-medium mb-1">Başlangıç</label>
          <input type="date" name="start_date" id="start_date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-400">
        </div>
        <div>
          <label for="end_date" class="block text-gray-600 font-medium mb-1">Bitiş</label>
          <input type="date" name="end_date" id="end_date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-400">
        </div>
      </div>
      <div class="flex justify-center pt-2">
        <button type="submit"
          class="bg-blue-500 text-white font-medium px-6 py-2 rounded-full hover:bg-blue-600 transition-all duration-200">
          Filtrele
        </button>
      </div>
    </form>
    
    <div id="totals-container" class="space-y-6">
      @include('admin.partial._totals', ['totals' => $totals, 'typeLabels' => $typeLabels])
    </div>
    
    <script>
    const typeLabels = {
  1: 'Nakit',
  2: 'POS',
  3: 'Havale',
  4: 'Kredi/Banka Kartı (Online)',
  5: 'Otomatik Ödeme',
  6: 'Nakit Ödeme (Manuel)',
  7: 'Kredi/Banka Kartı (Manuel)',
};

function submitForm() {
  const startDate = document.getElementById('start_date').value;
  const endDate = document.getElementById('end_date').value;
  const url = `/servicesraport?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;

  fetch(url, {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest' // Bu opsiyonel ama bazı Laravel middleware'leri ister.
    }
  })
  .then(response => {
    if (!response.ok) throw new Error("Veri alınamadı");
    return response.json();
  })
  .then(data => {
  const container = document.getElementById('totals-container');
  container.innerHTML = ''; // Eski içeriği temizle

  // Genel Ciro Kartı
  const formattedGeneralTotal = new Intl.NumberFormat('tr-TR', {
    style: 'decimal',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(data.general_total);

  const generalCard = `
    <div class="mb-6">
      <div class="mt-4 bg-gradient-to-r from-blue-400 to-blue-600 text-white rounded-3xl shadow-lg p-6 flex items-center justify-between">

        <div>
          <h4 class="text-lg font-semibold">Genel Ciro</h4>
          <h1 class="text-3xl font-bold mt-2">${formattedGeneralTotal} ₺</h1>
        </div>
        <div class="text-5xl opacity-30">
          <i class="icon-wallet"></i>
        </div>
      </div>
    </div>
  `;

  // Ödeme Türü Kartları
  const cardContent = `
    <div class="card border-2 border-double border-teal-400 rounded-lg shadow-lg p-6 mb-6 bg-white">
      <div class="card-content">
        <div class="card-body">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            ${data.totals.map(item => {
              if (item.type !== 0) {
                const label = typeLabels[item.type] ?? 'Bilinmeyen Tür';
                const formattedPrice = new Intl.NumberFormat('tr-TR', {
                  style: 'decimal',
                  minimumFractionDigits: 2,
                  maximumFractionDigits: 2,
                }).format(item.total_price);

                return `
                  <div class="col-12 md:col-6 lg:col-4 xl:col-3 mb-6">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-[#5dcffd]">
                      <div class="p-6 flex items-center justify-between">
                        <div class="flex flex-col space-y-2">
                          <h4 class="text-lg font-semibold text-gray-600">${label}</h4>
                        </div>
                        <div class="text-4xl text-[#5dcffd]">
                          <i class="icon-graph"></i>
                        </div>
                      </div>
                      <div class="p-4 bg-[#f4f9fd] rounded-b-lg">
                        <h1 class="text-2xl font-bold text-gray-800">${formattedPrice} ₺</h1>
                      </div>
                    </div>
                  </div>
                `;
              }
              return '';
            }).join('')}
          </div>
        </div>
      </div>
    </div>
  `;

  container.innerHTML += generalCard + cardContent;
})
  .catch(error => {
    console.error('Hata:', error);
  });
}
    </script>
    
    <div class="mt-5 bg-white p-8 mb-8 border-2 border-[rgb(45,212,191)] border-opacity-[1] shadow-lg rounded-lg">
      <h1 class="text-center text-dark text-2xl font-semibold">Toplam Tarife Satış Raporu</h1>
      <canvas id="chartpayments" style="height:460px; width:100%;"></canvas>
    </div>
  
  <div class="row">
    <div class="col-md-6" >
      <div class="card">
        <div class="card-content">
            <h1 style="text-align:center; margin-top:15px" class="text-dark">Yıllara Göre Müşteri Sayısı</h1>
            <canvas style="padding:45px" id="myChartmusteri"></canvas>
        </div>
        </div>
    </div>
    
    <div class="col-md-6">
      <div class="card">
        <div class="card-content">
            <h1 style="text-align:center; margin-top:15px" class="text-dark">Yıllara Göre Abone Sayısı</h1>
           <canvas style="padding:45px" id="myChartabone" ></canvas>
        </div>
        </div>
    </div>
    <div class="col-md-6" >
      <div class="card">
        <div class="card-content">
            <h1 style="text-align:center; margin-top:15px" class="text-dark">Yıllara Göre İptal Abone Sayısı</h1>
            <canvas style="padding:45px" id="myChartabone3"></canvas>
        </div>
        </div>
    </div>
    <div class="col-md-6" >
      <div class="card">
        <div class="card-content">
            <h1 style="text-align:center; margin-top:15px" class="text-dark">Aylara Göre İptal Abone Sayısı</h1>
            <canvas style="padding:45px" id="myChartabone4"></canvas>
        </div>
        </div>
    </div>
  </div>
  
 
</section>
</div>


    <div class="col-md-12">
     
        
     <div class="row col-md-12"> 
        <div style="background:#f8f8ff; padding:35px 20px; margin-bottom:30px;" class="col-md-6">
        	<h2 style="text-align:center;" class="text-danger">2022 Abone Aylık Satış Raporu</h2>
                 <canvas id="myChart13" height="150"></canvas>
        </div>
        
        <div style="background:#f8f8ff; padding:35px 20px; margin-bottom:30px;" class="col-md-6">
        	<h2 style="text-align:center;" class="text-success">2023 Abone Aylık Satış Raporu</h2>
                 <canvas id="myChart14" height="150"></canvas>
        </div>
     </div> 
      
        <div class="card-header">
            <h3 style="text-align:center;" style="font-size:22px;"> 
            <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 
            <span   class="text-dark">2023 Yılı Abone Raporu</span></h3>
        </div>
        
        <div class="aylar">
          <button class="col-md-1 tablink" onclick="openCity('ocak', this, 'red')" id="defaultOpen">Ocak</button>
          <button class="col-md-1 tablink" onclick="openCity('subat', this, 'green')">Şubat</button>
          <button class="col-md-1 tablink" onclick="openCity('mart', this, 'blue')">Mart</button>
          <button class="col-md-1 tablink" onclick="openCity('nisan', this, 'orange')">Nisan</button>
          <button class="col-md-1 tablink" onclick="openCity('mayis', this, 'red')">Mayıs</button>
          <button class="col-md-1 tablink" onclick="openCity('haziran', this, 'green')">Haziran</button>
          <button class="col-md-1 tablink" onclick="openCity('temmuz', this, 'blue')">Temmuz</button>
          <button class="col-md-1 tablink" onclick="openCity('agustos', this, 'green')">Ağustos</button>
          <button class="col-md-1 tablink" onclick="openCity('eylul', this, 'orange')">Eylül</button>
          <button class="col-md-1 tablink" onclick="openCity('ekim', this, 'red')">Ekim</button>
          <button class="col-md-1 tablink" onclick="openCity('kasim', this, 'green')">Kasım</button>
          <button class="col-md-1 tablink" onclick="openCity('aralik', this, 'blue')">Aralık</button>
        </div>
    
    
    
        <div id="ocak" class="tabcontent">
            <h1 class="text-dark">Ocak Ayı Raporu</h1>
        	<div class="col-md-12 bg-light text-dark">
              <canvas id="myChart1" height="120"></canvas>
            </div>
            
        </div>
        
        <div id="subat" class="tabcontent">
          <h1 class="text-dark">Şubat Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart2" height="120"></canvas>
            </div>
        </div>
        
        <div id="mart" class="tabcontent">
           <h1 class="text-dark">Mart Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart3" height="120"></canvas>
         </div>
        </div>
        
        <div id="nisan" class="tabcontent">
          <h1 class="text-dark">Nisan Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart4" height="120"></canvas>
         </div>
        </div>
        
        
        
        <div id="mayis" class="tabcontent">
           <h1 class="text-dark">Mayıs Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart5" height="120"></canvas>
         </div>
        </div>
        
        <div id="haziran" class="tabcontent">
           <h1 class="text-dark">Haziran Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart6" height="120"></canvas>
         </div> 
        </div>
        
        <div id="temmuz" class="tabcontent">
          <h1 class="text-dark">Temmuz Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart7" height="120"></canvas>
         </div> 
        </div>
        
        <div id="agustos" class="tabcontent">
          <h1 class="text-dark">Ağustos Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart8" height="120"></canvas>
         </div> 
        </div>
        
        <div id="eylul" class="tabcontent">
          <h1 class="text-dark">Eylül Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart9" height="120"></canvas>
         </div> 
        </div>
        
        
        <div id="ekim" class="tabcontent">
          <h1 class="text-dark">Ekim Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart10" height="120"></canvas>
         </div> 
        </div>
        
        <div id="kasim" class="tabcontent">
          <h1 class="text-dark">Kasım Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart11" height="120"></canvas>
         </div> 
        </div>
        
        <div id="aralik" class="tabcontent">
          <h1 class="text-dark">Aralık Ayı Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart12" height="120"></canvas>
         </div> 
        </div>
        
 

  
<!--
  <div class="row" style="margin-top:50px">
    <div class="col-md-6" >
      <div class="card">
        <div class="card-content">
            <h1 style="text-align:center; margin-top:15px" class="text-dark">En Çok Satılan 10 iL'in Müşteri Sayısı</h1>
            <div id="myPlot"  style="width:100%; max-width:1200px; height:700px;"></div>
        </div>
        </div>
  </div>
</div>
   --> 
    </div>
    
    
</div>
  

@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <style>.grey-bg {  
    background-color: #F5F7FA;
}</style>
    <style>


.tablink {
  background-color: #3F51B5;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
}

.tablink:hover {
  background-color: #FFB300;
}

/* Style the tab content */
.tabcontent {
  color: white;
  display: none;
  padding: 50px;
  text-align: center;
}


#ocak {background-color:#e3eaef;}
#subat {background-color:#e3eaef;}
#mart {background-color:#e3eaef;}
#nisan {background-color:#e3eaef;}

#mayis {background-color:#e3eaef;}
#haziran {background-color:#e3eaef;}
#temmuz {background-color:#e3eaef;}
#agustos {background-color:#e3eaef;}

#eylul {background-color:#e3eaef;}
#ekim {background-color:#e3eaef;}
#kasim {background-color:#e3eaef;}
#aralik {background-color:#e3eaef;}
.aylar{
    margin-bottom:120px!important;
}
</style>


<style>

.tablink1 {
  background-color: #3F51B5;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 25%;
}

.tablink1:hover {
  background-color: #FFB300;
}

/* Style the tab content */
.tabcontent1 {
  color: white;
  display: none;
  padding: 50px;
  text-align: center;
}

#satis1 {background-color:#e3eaef;}
#satis2 {background-color:#e3eaef;}
#satis3 {background-color:#e3eaef;}
#satis4 {background-color:#e3eaef;}

.aylar2{
    margin-bottom:120px!important;
}
</style>

<!-- START toltip satış platinium ekibi günlik liste -->
<style>
.tooltip-inner {
    background-color: #2E7D32 !important;
    color: #fff ;
    min-width: 100px;
    max-width: 100%; 
   /* background-image: url('/resimlers/logoRzgr.png');
    background-size: 100% 200%; */
}

.bs-tooltip-bottom .arrow::before, 
.bs-tooltip-auto[x-placement^="bottom"] .arrow::before {
    border-bottom-color: green !important;
}
</style>
<!-- END toltip satış platinium ekibi günlik liste -->
@endpush

@push('script')
    
    <script>
    
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
       $(function () {
      $('[data-toggle="tooltip1"]').tooltip()
    })

        @php
    $labeliller = "";
    $datailler = "";
    
    foreach($illers as $iller){
        $labeliller.= "\"$iller->name\",";
        $datailler.= "$iller->id,";
    }
    @endphp
    
    
        var xArray = [{!! $labeliller !!}];
        var yArray = [{!! $datailler !!}];
        
        var layout = {title:"İllere Göre Müşteri Sayısı"};
        
        var data = [{labels:xArray, values:yArray, type:"pie"}];
        
        Plotly.newPlot("myPlot", data, layout);
    </script>
    
    
    <script>

  const myChartabone15 = document.getElementById('myChart15');

  new Chart(myChartabone15, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Abone Satış Sayısı',
        data: [{!! $dataabone15 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script> 
    
    <script>
    @php
    $labelsabone14 = "";
    $dataabone14 = "";
    
    foreach($aylars2 as $aylar){
        $labelsabone14.= "\"$aylar->yil\",";
        $dataabone14.= "$aylar->id,";
    }
    @endphp
  const myChartabone14 = document.getElementById('myChart14');

  new Chart(myChartabone14, {
    type: 'line',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Abone Aylık Raporu',
        data: [{!! $dataabone14 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script> 
    
    <script>
    @php
    $labelsabone13 = "";
    $dataabone13 = "";
    
    foreach($aylars1 as $aylars){
        $labelsabone13.= "\"$aylars->yil\",";
        $dataabone13.= "$aylars->id,";
    }
    @endphp
  const myChartabone13 = document.getElementById('myChart13');

  new Chart(myChartabone13, {
    type: 'line',
    data: {
      labels: ['Ocak', 'Şubat', 'Mart','Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2022 Abone Aylık Raporu',

        
        fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: [{!! $dataabone13 !!}],
      borderWidth: 2
      
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script> 
<script>
    @php
    $labelsabone = "";
    $dataabone = "";
    
    foreach($yillars3 as $yillar3){
        $labelsabone.= "\"$yillar3->created_at\",";
        $dataabone.= "$yillar3->id,";
    }
    @endphp
  const myChartabone3 = document.getElementById('myChartabone3');

  new Chart(myChartabone3, {
    type: 'pie',
    data: {
      labels: [{!! $labelsabone !!}],
      datasets: [{
        label: 'Yıllara Göre İptal Abone Sayısı',
        data: [{!! $dataabone !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
    @php
    $labelsabone = "";
    $dataabone = "";
    
    foreach($aylars4 as $aylar4){
        $labelsabone.= "\"$aylar4->created_at\",";
        $dataabone.= "$aylar4->id,";
    }
    @endphp
  const myChartabone4 = document.getElementById('myChartabone4');

  new Chart(myChartabone4, {
    type: 'pie',
    data: {
      labels: ['Ocak', 'Şubat', 'Mart','Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: 'Aylara Göre İptal Abone Sayısı',
        data: [{!! $dataabone !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
    @php
    $labelsabone = "";
    $dataabone = "";
    
    foreach($yillars2 as $yillar2){
        $labelsabone.= "\"$yillar2->created_at\",";
        $dataabone.= "$yillar2->id,";
    }
    @endphp
  const myChartabone = document.getElementById('myChartabone');

  new Chart(myChartabone, {
    type: 'pie',
    data: {
      labels: [{!! $labelsabone !!}],
      datasets: [{
        label: 'Abone Raporu (Satış Sayısı)',
        data: [{!! $dataabone !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labelsmusteri = "";
    $datamusteri = "";
    
    foreach($yillars as $yillar){
        $labelsmusteri.= "\"$yillar->created_at\",";
        $datamusteri.= "$yillar->id,";
    }
    @endphp
  const ctxmusteri = document.getElementById('myChartmusteri');

  new Chart(ctxmusteri, {
    type: 'pie',
    data: {
      labels: [{!! $labelsmusteri !!}],
      datasets: [{
        label: 'Müşteri Raporu (Sayısı)',
        data: [{!! $datamusteri !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script> 

@php
$labels = "";
$data = "";

foreach($satislar as $raport){
    // Tarihleri alıp etiketler için diziye ekliyoruz
    $labels .= "\"$raport->gun\",";
    // Satış sayılarını diziye ekliyoruz
    $data .= "$raport->adet,";
}
@endphp
<script>
  const ctx = document.getElementById('chartpayments');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [{!! $labels !!}], // PHP'den gelen tarihler
      datasets: [{
        label: 'Toplam Satış Sayısı', // Başlık
        data: [{!! $data !!}], // PHP'den gelen satış sayıları
        borderWidth: 2, // Çubuğun kenar kalınlığı
        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Barların iç renkleri
        borderColor: 'rgba(75, 192, 192, 1)', // Çubuğun kenar renkleri
        borderRadius: 5 // Çubuğun kenarlarını yuvarlatma
      }]
    },
    options: {
      responsive: true, // Grafik boyutu ekran boyutuna göre uyum sağlar
      maintainAspectRatio: true, // Yükseklik ve genişlik oranını sabit tutmaz
      scales: {
        y: {
          beginAtZero: true, // Y ekseninin sıfırdan başlamasını sağlar
          title: {
            display: true,
            text: 'Satış Sayısı' // Y ekseninin başlığı
          }
        }
      },
      plugins: {
        legend: {
          position: 'top', // Efsanenin üstte görünmesi sağlanır
        }
      }
    }
  });
</script>



    <script>
    @php
    $labels1 = "";
    $data1 = "";
    
    foreach($ocaks as $rapo){
        $labels1.= "\"$rapo->name\",";
        $data1.= "$rapo->service_id,";
    }
    @endphp
  const ctx1 = document.getElementById('myChart1');

  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: [{!! $labels1 !!}],
      datasets: [{
        label: 'Ocak Ayı Tarife Satış Sayısı',
        data: [{!! $data1 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels2 = "";
    $data2 = "";
    
    foreach($subats as $raporsubats){
        $labels2.= "\"$raporsubats->name\",";
        $data2.= "$raporsubats->service_id,";
    }
    @endphp
  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: [{!! $labels2 !!}],
      datasets: [{
        label: 'Şubat Ayı Tarife Satış Sayısı',
        data: [{!! $data2 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels3 = "";
    $data3 = "";
    
    foreach($marts as $raporm){
        $labels3.= "\"$raporm->name\",";
        $data3.= "$raporm->service_id,";
    }
    @endphp
  const ctx3 = document.getElementById('myChart3');

  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: [{!! $labels3 !!}],
      datasets: [{
        label: 'Mart Ayı Tarife Satış Sayısı',
        data: [{!! $data3 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels4 = "";
    $data4 = "";
    
    foreach($nisans as $raporn){
        $labels4.= "\"$raporn->name\",";
        $data4.= "$raporn->service_id,";
    }
    @endphp
  const ctx4 = document.getElementById('myChart4');

  new Chart(ctx4, {
    type: 'bar',
    data: {
      labels: [{!! $labels4 !!}],
      datasets: [{
        label: 'Nisan Ayı Tarife Satış Sayısı',
        data: [{!! $data4 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels5 = "";
    $data5 = "";
    
    foreach($mayiss as $mayis){
        $labels5.= "\"$mayis->name\",";
        $data5.= "$mayis->service_id,";
    }
    @endphp
  const ctx5 = document.getElementById('myChart5');

  new Chart(ctx5, {
    type: 'bar',
    data: {
      labels: [{!! $labels5 !!}],
      datasets: [{
        label: 'Mayıs Ayı Tarife Satış Sayısı',
        data: [{!! $data5 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels6 = "";
    $data6 = "";
    
    foreach($hazirans as $haziran){
        $labels6.= "\"$haziran->name\",";
        $data6.= "$haziran->service_id,";
    }
    @endphp
  const ctx6 = document.getElementById('myChart6');

  new Chart(ctx6, {
    type: 'bar',
    data: {
      labels: [{!! $labels6 !!}],
      datasets: [{
        label: 'Haziran Ayı Tarife Satış Sayısı',
        data: [{!! $data6 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
    
    <script>
    @php
    $labels7 = "";
    $data7 = "";
    
    foreach($temmuzs as $temmuz){
        $labels7.= "\"$temmuz->name\",";
        $data7.= "$temmuz->service_id,";
    }
    @endphp
  const ctx7 = document.getElementById('myChart7');

  new Chart(ctx7, {
    type: 'bar',
    data: {
      labels: [{!! $labels7 !!}],
      datasets: [{
        label: 'Temmuz Ayı Tarife Satış Sayısı',
        data: [{!! $data7 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels8 = "";
    $data8 = "";
    
    foreach($agustoss as $agustos){
        $labels8.= "\"$agustos->name\",";
        $data8.= "$agustos->service_id,";
    }
    @endphp
  const ctx8 = document.getElementById('myChart8');

  new Chart(ctx8, {
    type: 'bar',
    data: {
      labels: [{!! $labels8 !!}],
      datasets: [{
        label: 'Ağustos Ayı Tarife Satış Sayısı',
        data: [{!! $data8 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels9 = "";
    $data9 = "";
    
    foreach($eyluls as $eylul){
        $labels9.= "\"$eylul->name\",";
        $data9.= "$eylul->service_id,";
    }
    @endphp
  const ctx9 = document.getElementById('myChart9');

  new Chart(ctx9, {
    type: 'bar',
    data: {
      labels: [{!! $labels9 !!}],
      datasets: [{
        label: 'Eylül Ayı Tarife Satış Sayısı',
        data: [{!! $data9 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels10 = "";
    $data10 = "";
    
    foreach($ekims as $ekim){
        $labels10.= "\"$ekim->name\",";
        $data10.= "$ekim->service_id,";
    }
    @endphp
  const ctx10 = document.getElementById('myChart10');

  new Chart(ctx10, {
    type: 'bar',
    data: {
      labels: [{!! $labels10 !!}],
      datasets: [{
        label: 'Ekim Ayı Tarife Satış Sayısı',
        data: [{!! $data10 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
  @php
  $labels = "";
  $data = "";
  
  foreach($tarife as $raport){
      $labels.= "\"$raport->name\",";
      $data.= "$raport->service_id,";
  }
  @endphp
const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [{!! $labels !!}],
    datasets: [{
      label: 'Tarife Raporu (Satış Sayısı)',
      data: [{!! $data !!}],
      borderWidth: 2
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>
    <script>
    @php
    $labels11 = "";
    $data11 = "";
    
    foreach($kasims as $kasim){
        $labels11.= "\"$kasim->name\",";
        $data11.= "$kasim->service_id,";
    }
    @endphp
  const ctx11 = document.getElementById('myChart11');

  new Chart(ctx11, {
    type: 'bar',
    data: {
      labels: [{!! $labels11 !!}],
      datasets: [{
        label: 'Kasım Ayı Tarife Satış Sayısı',
        data: [{!! $data11 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

    <script>
    @php
    $labels12 = "";
    $data12 = "";
    
    foreach($araliks as $aralik){
        $labels12.= "\"$aralik->name\",";
        $data12.= "$aralik->service_id,";
    }
    @endphp
  const ctx12 = document.getElementById('myChart12');

  new Chart(ctx12, {
    type: 'bar',
    data: {
      labels: [{!! $labels12 !!}],
      datasets: [{
        label: 'Aralık Ayı Tarife Satış Sayısı',
        data: [{!! $data12 !!}],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>





    <script>
function openCity(cityName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(cityName).style.display = "block";
  elmnt.style.backgroundColor = color;

}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>



<script>
function openCity1(cityName1,elmnt1,color1) {
  var i, tabcontent1, tablinks1;
  tabcontent1 = document.getElementsByClassName("tabcontent1");
  for (i = 0; i < tabcontent1.length; i++) {
    tabcontent1[i].style.display = "none";
  }
  tablinks1 = document.getElementsByClassName("tablink1");
  for (i = 0; i < tablinks1.length; i++) {
    tablinks1[i].style.backgroundColor = "";
  }
  document.getElementById(cityName1).style.display = "block";
  elmnt1.style.backgroundColor = color1;

}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen1").click();
</script>



   
    <script>
$(document).ready(function() {
    $('#options').select2();
});
</script>


      <script>      
        document.getElementById("btn")
            .onclick = function(){
                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/assigadds/create';}, 4000);                        
             };
    </script>
      <script>      
        document.getElementById("btn21")
            .onclick = function(){
                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/task';}, 4000);                        
             };
    </script>
@endpush

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        
       body{
    background:#f5f5f5;
    margin-top:20px;
}
.card {
    border: none;
    -webkit-box-shadow: 1px 0 20px rgba(96,93,175,.05);
    box-shadow: 1px 0 20px rgba(96,93,175,.05);
    margin-bottom: 30px;
}
.table th {
    font-weight: 500;
    color: #827fc0;
}
.table thead {
    background-color: #f3f2f7;
}
.table>tbody>tr>td, .table>tfoot>tr>td, .table>thead>tr>td {
    padding: 14px 12px;
    vertical-align: middle;
}
.table tr td {
    color: #8887a9;
}
.thumb-sm {
    height: 32px;
    width: 32px;
}
.badge-soft-warning {
    background-color: rgba(248,201,85,.2);
    color: #f8c955;
}

.badge {
    font-weight: 500;
}
.badge-soft-primary {
    background-color: rgba(96,93,175,.2);
    color: #605daf;
}
    </style>
    
    

@endpush

@push('script')
    <script src="/assets/admin/vendor/slugify/slugify.js"></script>
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/admin/vendor/cleave/cleave.min.js"></script>
    <script src="/assets/admin/vendor/vue/vue.min.js"></script>


    
    <script type="text/javascript">
  var query=<?php echo json_encode((object)Request::only(['services','options'])); ?>;
//search ara butonu

  function search_post(){

           Object.assign(query,{'service': $('#service_filter').val()});
           Object.assign(query,{'options': $('#options_filter').val()});

            window.location.href="{{route('admin.contractendings')}}?"+$.param(query);

  }

</script>

@endpush
@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>

    <script>
       $(document).ready(function() {
            $('#dataTable').DataTable( {
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
               columnDefs: [{
                    "type": "num",
                    "targets": 0
                }],
                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Ödemeler'
                    }
                ],
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [ 2, 3, 4, 5, 6]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 1 ) {
                            var select = $('<select class="form-control text-white bg-info" style="width:100px;"><option value="">Tümü</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
            });
        });

    </script>
    
        <script>
       $(document).ready(function() {
            $('#dataTable3').DataTable( {
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
               columnDefs: [{
                    "type": "num",
                    "targets": 0
                }],
                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Ödemeler'
                    }
                ],
                columnDefs: [
                    {"type": "num", "targets": 0},
                    {"orderable": false, "targets": [ 2, 3, 4, 5, 6]}
                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if( column[0][0] == 1 ) {
                            var select = $('<select class="form-control text-white bg-info" style="width:100px;"><option value="">Tümü</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
            });
        });

    </script>

    
    <script>
        $(function() {
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            alert()->success('Başarılı!', 'Makaleniz Başarılı Bir Şekilde oluşturuldu.');
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
    </script>
    

    
<script>
    $(function checkRegistration() {
        $('#btnSave').on('click', function (event) {
            //alert()->success('Başarılı!', 'Makaleniz Başarılı Bir Şekilde oluşturuldu.');
           alert('Given data is incorrect21');
             return redirect();
            // relative_route('admin.contractending.store')
        });

    });

</script>

@endpush



