@extends('admin.layout.main')

@section('title', meta_title('Rapor'))

@section('content')
<div class="row">
            <div style=" margin-top:40px" class=" col-md-12">
            
        	</div>
    	
    <div class="grey-bg container-fluid">

    
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
    
    
     $labelsabone16 = "";
    $dataabone16 = "";
    $first_name2 = "";
    $last_name2 = "";
    
    
    foreach($satis2 as $sati){
        $labelsabone16.= "\"$sati->created_at\",";
        $dataabone16.= "$sati->id,";
        $first_name2 ="$sati->first_name";
        $last_name2 ="$sati->last_name";
    }
    
     $labelsabone17 = "";
    $dataabone17 = "";
    $first_name3 = "";
    $last_name3 = "";
    
    
    foreach($satis3 as $sati3){
        $labelsabone17.= "\"$sati3->created_at\",";
        $dataabone17.= "$sati3->id,";
        $first_name3 ="$sati3->first_name";
        $last_name3 ="$sati3->last_name";
    }
    
    $labelsabone177 = "";
    $dataabone177 = "";
    $first_name37 = "";
    $last_name37 = "";
    
    
    foreach($satis37 as $sati37){
        $labelsabone177.= "\"$sati37->created_at\",";
        $dataabone177.= "$sati37->id,";
        $first_name37 ="$sati37->first_name";
        $last_name37 ="$sati37->last_name";
    }
    
    
    $labelsabone60 = "";
    $dataabone60 = "";
    $first_name60 = "";
    $last_name60 = "";
    
    
    foreach($satis60 as $sati60){
        $labelsabone60.= "\"$sati60->created_at\",";
        $dataabone60.= "$sati60->id,";
        $first_name60 ="$sati60->first_name";
        $last_name60 ="$sati60->last_name";
    }
    
    $labelsabone18 = "";
    $dataabone18 = "";
    $first_name4 = "";
    $last_name4 = "";
    
    
    foreach($satis4 as $sati4){
        $labelsabone18.= "\"$sati4->created_at\",";
        $dataabone18.= "$sati4->id,";
        $first_name4 ="$sati4->first_name";
        $last_name4 ="$sati4->last_name";
    }

    $labelsabone01 = "";
    $dataabone01 = "";
    $first_name01 = "";
    $last_name01 = "";
    
    
    foreach($satis01 as $sati01){
        $labelsabone01.= "\"$sati01->created_at\",";
        $dataabone01.= "$sati01->id,";
        $first_name01 ="$sati01->first_name";
        $last_name01 ="$sati01->last_name";
    }
    
    $labelsabone02 = "";
    $dataabone02 = "";
    $first_name02 = "";
    $last_name02 = "";
    
    
    foreach($satis02 as $sati02){
        $labelsabone02.= "\"$sati02->created_at\",";
        $dataabone02.= "$sati02->id,";
        $first_name02 ="$sati02->first_name";
        $last_name02 ="$sati02->last_name";
    }
    
    $labelsabone03 = "";
    $dataabone03 = "";
    $first_name03 = "";
    $last_name03 = "";
    
    
    foreach($satis03 as $sati03){
        $labelsabone03.= "\"$sati03->created_at\",";
        $dataabone03.= "$sati03->id,";
        $first_name03 ="$sati03->first_name";
        $last_name03 ="$sati03->last_name";
    }
    
    $labelsabone04 = "";
    $dataabone04 = "";
    $first_name04 = "";
    $last_name04 = "";
    
    
    foreach($satis04 as $sati04){
        $labelsabone04.= "\"$sati04->created_at\",";
        $dataabone04.= "$sati04->id,";
        $first_name04 ="$sati04->first_name";
        $last_name04 ="$sati04->last_name";
    }
    
    $labelsabone05 = "";
    $dataabone05 = "";
    $first_name05 = "";
    $last_name05 = "";
    
    
    foreach($satis05 as $sati05){
        $labelsabone05.= "\"$sati05->created_at\",";
        $dataabone05.= "$sati05->id,";
        $first_name05 ="$sati05->first_name";
        $last_name05 ="$sati05->last_name";
    }
    
    $labelsabone19 = "";
    $dataabone19 = "";
    $first_name5 = "";
    $last_name5 = "";
    
    
    foreach($satis5 as $sati5){
        $labelsabone19.= "\"$sati5->created_at\",";
        $dataabone19.= "$sati5->id,";
        $first_name5 ="$sati5->first_name";
        $last_name5 ="$sati5->last_name";
    }
    
    $labelsabone20 = "";
    $dataabone20 = "";
    $first_name6 = "";
    $last_name6 = "";
    
    
    foreach($satis6 as $sati6){
        $labelsabone20.= "\"$sati6->created_at\",";
        $dataabone20.= "$sati6->id,";
        $first_name6 ="$sati6->first_name";
        $last_name6 ="$sati6->last_name";
    }
    
    
     $labelsabone21 = "";
    $dataabone21 = "";
    $first_name7 = "";
    $last_name7 = "";
    
    
    foreach($satis7 as $sati7){
        $labelsabone21.= "\"$sati7->created_at\",";
        $dataabone21.= "$sati7->id,";
        $first_name7 ="$sati7->first_name";
        $last_name7 ="$sati7->last_name";
    }
    
    $labelsabone22 = "";
    $dataabone22 = "";
    $first_name8 = "";
    $last_name8 = "";
    
    
    foreach($satis8 as $sati8){
        $labelsabone22.= "\"$sati8->created_at\",";
        $dataabone22.= "$sati8->id,";
        $first_name8 ="$sati8->first_name";
        $last_name8 ="$sati8->last_name";
    }
    
    
     $labelsabone23 = "";
    $dataabone23 = "";
    $first_name9 = "";
    $last_name9 = "";
    
    
    foreach($iptal1s as $iptal1){
        $labelsabone23.= "\"$iptal1->created_at\",";
        $dataabone23.= "$iptal1->id,";
        $first_name4 ="$iptal1->first_name";
        $last_name4 ="$iptal1->last_name";
    }
    
    
         $labelsabone24 = "";
        $dataabone24 = "";
        $first_name10 = "";
        $last_name10 = "";
    
    
    foreach($iptal2s as $iptal2){
        $labelsabone24.= "\"$iptal2->created_at\",";
        $dataabone24.= "$iptal2->id,";
        $first_name10 ="$iptal2->first_name";
        $last_name10 ="$iptal2->last_name";
    }
    
    
             $labelsabone25 = "";
        $dataabone25 = "";
        $first_name11 = "";
        $last_name11 = "";
    
    
    foreach($iptal3s as $iptal3){
        $labelsabone25.= "\"$iptal3->created_at\",";
        $dataabone25.= "$iptal3->id,";
        $first_name11 ="$iptal3->first_name";
        $last_name11 ="$iptal3->last_name";
    }
    
    
                 $labelsabone26 = "";
        $dataabone26 = "";
        $first_name12 = "";
        $last_name12 = "";
    
    
    foreach($iptal4s as $iptal4){
        $labelsabone26.= "\"$iptal4->created_at\",";
        $dataabone26.= "$iptal4->id,";
        $first_name12 ="$iptal4->first_name";
        $last_name12 ="$iptal4->last_name";
    }
   
   
    $labelsabone27 = "";
        $dataabone27 = "";
        $first_name13 = "";
        $last_name13 = "";
    
    
    foreach($iptal5s as $iptal5){
        $labelsabone27.= "\"$iptal5->created_at\",";
        $dataabone27.= "$iptal5->id,";
        $first_name13 ="$iptal5->first_name";
        $last_name13 ="$iptal5->last_name";
    }
   
   
   
   
   
    @endphp
    


  <section id="stats-subtitle">
 
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-content">
            <h2 style="text-align:center; margin-top:15px" class="text-dark"><span class="text-warning">Platinium</span> Biriminin Bu Ay ki <span class="text-success">Aktif</span> Abone Sayısı</h2>
           <canvas style="padding:45px" id="myChartabone" ></canvas>
        </div>
        </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-content">
            <h2 style="text-align:center; margin-top:15px" class="text-dark"><span class="text-warning">Platinium</span> Biriminin Bu Ay ki <span class="text-primary">Tarife Değiştiren</span> Abone Sayısı</h2>
           <canvas style="padding:45px" id="myChartabone2" ></canvas>
        </div>
        </div>
    </div>
    <div class="col-md-6" >
      <div class="card">
        <div class="card-content">
            <h2 style="text-align:center; margin-top:15px" class="text-dark"><span class="text-info">Satış</span> Biriminin Bu Ay ki Abone Sayısı</h2>
            <canvas style="padding:45px" id="myChartmusteri"></canvas>
        </div>
        </div>
    </div>
    

    <div class="col-md-6">
      <div class="card">
        <div class="card-content">
            <h2 style="text-align:center; margin-top:15px" class="text-dark"><span class="text-info">Satış</span> Biriminin Bu Ay <span class="text-success">Aktif</span> Abone Sayısı</h2>
           <canvas style="padding:45px" id="myChartabonel" ></canvas>
        </div>
        </div>
    </div>
    
        <div class="col-md-6">
      <div class="card">
        <div class="card-content">
            <h2 style="text-align:center; margin-top:15px" class="text-dark"><span class="text-info">Satış</span> Biriminin Bu Ay <span class="text-primary">Onay</span> Bekleyen Abone Sayısı</h2>
           <canvas style="padding:45px" id="myChartabonel2" ></canvas>
        </div>
        </div>
    </div>
    
    
    
  </div>
  
 
</section>
</div>

    <div class="col-md-12">
        
        <div class="card-header">
            <h3 style="text-align:center;" style="font-size:22px;"> 
            <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 
            <span   class="text-dark">2023 Yılı <span class="text-info">Satış</span> Birimi <span class="text-success">Aktif</span> Abone Raporu</span></h3>
        </div>
            
          <!--START SATIŞ -->  
        <div class="col-md-12">
            <div class="aylar2 row">
                <button class="tablink1 col-md-3" onclick="openCity1('satis1', this, 'red')" id="defaultOpen1">{!!  $first_name !!} {!!  $last_name !!}</button>
                <!-- <button class="tablink1 col-md-3" onclick="openCity1('satis2', this, 'green')">{!!  $first_name2 !!} {!!  $last_name2 !!}</button> -->
                <button class="tablink1 col-md-3" onclick="openCity1('satis3', this, 'blue')">{!!  $first_name3 !!} {!!  $last_name3 !!}</button>
                <button class="tablink1 col-md-3" onclick="openCity1('satis37', this, 'blue')">{!!  $first_name37 !!} {!!  $last_name37 !!}</button>
                <button class="tablink1 col-md-3" onclick="openCity1('satis60', this, 'blue')">{!!  $first_name60 !!} {!!  $last_name60 !!}</button>
            </div>
        </div>

    
        <div  id="satis1" class="tabcontent1">
            <h1 class="text-dark">2023 <span class="text-info">Satış</span> Birimi Yıllık <span class="text-success">Aktif</span> Abone Raporu</h1>
        	<div class="col-md-12 bg-light text-dark">
        	    <canvas id="myChart15" height="80"></canvas>
              
            </div>
            
        </div>
        
        <div id="satis2" class="tabcontent1">
          <h1 class="text-dark">2023 <span class="text-info">Satış</span> Birimi Yıllık <span class="text-success">Aktif</span> Abone Raporu</h1>
         <div class="col-md-12 bg-light text-dark">
             <canvas id="myChart16" height="80"></canvas>
             
            </div>
        </div>
        
        <div id="satis3" class="tabcontent1">
           <h1 class="text-dark">2023 <span class="text-info">Satış</span> Birimi Yıllık <span class="text-success">Aktif</span> Abone Raporu</h1>
           <div class="col-md-12 bg-light text-dark">
             <canvas id="myChart17" height="80"></canvas>
         </div>
        </div>
        
        <div id="satis37" class="tabcontent1">
           <h1 class="text-dark">2023 <span class="text-info">Satış</span> Birimi Yıllık <span class="text-success">Aktif</span> Abone Raporu</h1>
           <div class="col-md-12 bg-light text-dark">
             <canvas id="myChart177" height="80"></canvas>
         </div>
        </div>
        
        <div id="satis60" class="tabcontent1">
           <h1 class="text-dark">2023 <span class="text-info">Satış</span> Birimi Yıllık <span class="text-success">Aktif</span> Abone Raporu</h1>
           <div class="col-md-12 bg-light text-dark">
             <canvas id="myChart60" height="80"></canvas>
         </div>
        </div>
     <!--END SATIŞ -->    
     
     
     
        <div class="card-header">
            <h3 style="text-align:center;" style="font-size:22px;"> 
            <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 
            <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi <span class="text-success">Aktif</span> Abone Raporu</span></h3>
        </div>
        
        <div class="aylar">
          <button class="col-md-4 tablink" onclick="openCity('ocak', this, 'red')" id="defaultOpen">{!!  $first_name4 !!} {!!  $last_name4 !!}</button>
          <button class="col-md-4 tablink" onclick="openCity('subat', this, 'green')">{!!  $first_name5 !!} {!!  $last_name5 !!}</button>
          <button class="col-md-4 tablink" onclick="openCity('mart', this, 'blue')">{!!  $first_name6 !!} {!!  $last_name6 !!}</button>
          <!-- <button class="col-md-2 tablink" onclick="openCity('nisan', this, 'orange')">{!!  $first_name7 !!} {!!  $last_name7 !!}</button> -->
          <!-- <button class="col-md-3 tablink" onclick="openCity('mayis', this, 'red')">{!!  $first_name8 !!} {!!  $last_name8 !!}</button> -->

        </div>
    
    
    
        <div id="ocak" class="tabcontent">
            <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-success"> Aktif</span> Abone Raporu</span></h1>
        	<div class="col-md-12 bg-light text-dark">
              <canvas id="myChart1" height="80"></canvas>
            </div>
            
        </div>
        
        <div id="subat" class="tabcontent">
          <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-success"> Aktif</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart2" height="80"></canvas>
            </div>
        </div>
        
        <div id="mart" class="tabcontent">
           <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-success"> Aktif</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart3" height="80"></canvas>
         </div>
        </div>
        
        <div id="nisan" class="tabcontent">
          <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-success"> Aktif</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart4" height="80"></canvas>
         </div>
        </div>
        
        
        
        <div id="mayis" class="tabcontent">
           <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-success"> Aktif</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart5" height="80"></canvas>
         </div>
        </div>
        
<!-- PLATİN TARİFE DEĞİŞİMİ -->
         <div class="card-header">
            <h3 style="text-align:center;" style="font-size:22px;"> 
            <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 
            <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi <span class="text-primary">Tarife Değişim</span> Abone Raporu</span></h3>
        </div>
        
        <div class="aylar4">
          <button class="col-md-4 tablink3" onclick="openCity3('ocak01', this, 'red')" id="defaultOpen01">{!!  $first_name01 !!} {!!  $last_name01 !!}</button>
          <button class="col-md-4 tablink3" onclick="openCity3('subat01', this, 'green')">{!!  $first_name02 !!} {!!  $last_name02 !!}</button>
          <button class="col-md-4 tablink3" onclick="openCity3('mart01', this, 'blue')">{!!  $first_name03 !!} {!!  $last_name03 !!}</button>
          <!--<button class="col-md-2 tablink3" onclick="openCity3('nisan01', this, 'orange')">{!!  $first_name04 !!} {!!  $last_name04 !!}</button> -->
          <!-- <button class="col-md-3 tablink3" onclick="openCity3('mayis01', this, 'red')">{!!  $first_name05 !!} {!!  $last_name05 !!}</button> -->

        </div>
    
    
    
        <div id="ocak01" class="tabcontent3">
            <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-primary"> Tarife Değişim </span>  Raporu</span></h1>
        	<div class="col-md-12 bg-light text-dark">
              <canvas id="myChart01" height="80"></canvas>
            </div>
            
        </div>
        
        <div id="subat01" class="tabcontent3">
          <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-primary"> Tarife Değişim </span>  Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart02" height="80"></canvas>
            </div>
        </div>
        
        <div id="mart01" class="tabcontent3">
           <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-primary"> Tarife Değişim </span>  Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart03" height="80"></canvas>
         </div>
        </div>
        
        <div id="nisan01" class="tabcontent3">
          <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-primary"> Tarife Değişim </span>  Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart04" height="80"></canvas>
         </div>
        </div>
        
        
        
        <div id="mayis01" class="tabcontent3">
           <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-primary"> Tarife Değişim </span>  Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChart05" height="80"></canvas>
         </div>
        </div>
<!-- // PLATİN TARİFE DEĞİŞİMİ-->
        
        

        
         <div class="card-header">
            <h3 style="text-align:center;" style="font-size:22px;"> 
            <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 
            <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-danger"> İptal</span> Abone Raporu</span></h3>
        </div>
        
       
        
        <div class="aylar3">
          <button class="col-md-4 tablink2" onclick="openCity2('iptal1', this, 'red')" id="defaultOpen2">{!!  $first_name4 !!} {!!  $last_name4 !!}</button>
          <button class="col-md-4 tablink2" onclick="openCity2('iptal2', this, 'green')">{!!  $first_name5 !!} {!!  $last_name5 !!}</button>
          <button class="col-md-4 tablink2" onclick="openCity2('iptal3', this, 'blue')">{!!  $first_name6 !!} {!!  $last_name6 !!}</button>
          <!--<button class="col-md-2 tablink2" onclick="openCity2('iptal4', this, 'orange')">{!!  $first_name7 !!} {!!  $last_name7 !!}</button> -->
          <!-- <button class="col-md-3 tablink2" onclick="openCity2('iptal5', this, 'red')">{!!  $first_name8 !!} {!!  $last_name8 !!}</button> -->

        </div>
    
    
    
        <div id="iptal1" class="tabcontent2">
            <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-danger"> İptal</span> Abone Raporu</span></h1>
        	<div class="col-md-12 bg-light text-dark">
              <canvas id="myChartiptal" height="80"></canvas>
            </div>
            
        </div>
        
        <div id="iptal2" class="tabcontent2">
          <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-danger"> İptal</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChartiptal2" height="80"></canvas>
            </div>
        </div>
        
        <div id="iptal3" class="tabcontent2">
           <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-danger"> İptal</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChartiptal3" height="80"></canvas>
         </div>
        </div>
        
        <div id="iptal4" class="tabcontent2">
          <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-danger"> İptal</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChartiptal4" height="80"></canvas>
         </div>
        </div>
        
        
        
        <div id="iptal5" class="tabcontent2">
           <h1 class="text-dark"> <span   class="text-dark">2023 Yılı <span class="text-warning">Platinium</span> Birimi<span class="text-danger"> İptal</span> Abone Raporu</span></h1>
         <div class="col-md-12 bg-light text-dark">
              <canvas id="myChartiptal5" height="80"></canvas>
         </div>
        </div>
        
  
    
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


.tablink2 {
  background-color: #3F51B5;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
}

.tablink2:hover {
  background-color: #FFB300;
}

/* Style the tab content */
.tabcontent2 {
  color: white;
  display: none;
  padding: 50px;
  text-align: center;
}

#iptal1 {background-color:#e3eaef;}
#iptal2 {background-color:#e3eaef;}
#iptal3 {background-color:#e3eaef;}
#iptal4 {background-color:#e3eaef;}

#iptal5 {background-color:#e3eaef;}

.aylar3{
    margin-bottom:100px!important;
}




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

#ocak01 {background-color:#e3eaef;}
#subat01 {background-color:#e3eaef;}
#mart01 {background-color:#e3eaef;}
#nisan01 {background-color:#e3eaef;}
#mayis01 {background-color:#e3eaef;}

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
    margin-bottom:100px!important;
}

.aylar4{
    margin-bottom:100px!important;
}
.tablink3 {
  background-color: #3F51B5;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
}

.tablink3:hover {
  background-color: #FFB300;
}

/* Style the tab content */
.tabcontent3 {
  color: white;
  display: none;
  padding: 50px;
  text-align: center;
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
#satis37 {background-color:#e3eaef;}
#satis60 {background-color:#e3eaef;}

.aylar2{
    margin-bottom:50px!important;
}
</style>
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
     <script>
  var barColors = ["DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon"];
  const myChartabone17 = document.getElementById('myChart17');

  new Chart(myChartabone17, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Abone Satış Sayısı',
        data: [{!! $dataabone17 !!}],
        backgroundColor: barColors,
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
  var barColors = ["DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon"];
  const myChartabone177 = document.getElementById('myChart177');

  new Chart(myChartabone177, {
    type: 'bar',
    data: {
      labels: ['Ocak','Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Abone Satış Sayısı',
        data: [{!! " " !!},{!! $dataabone177 !!}],
        backgroundColor: barColors,
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
  var barColors = ["DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon"];
  const myChartabone60 = document.getElementById('myChart60');

  new Chart(myChartabone60, {
    type: 'bar',
    data: {
      labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Abone Satış Sayısı',
        data: [{!! $dataabone60 !!}],
        backgroundColor: barColors,
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

  const myChartabone16 = document.getElementById('myChart16');

  new Chart(myChartabone16, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Abone Satış Sayısı',
        data: [{!! $dataabone16 !!}],
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
  var barColors1 = ["DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon"];
  const myChartabone15 = document.getElementById('myChart15');

  new Chart(myChartabone15, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Aktif Abone Satış Sayısı',
        data: [{!! $dataabone15 !!}],
        backgroundColor: barColors1,
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
    
    foreach($yillars2 as $yillar2){
        $labelsabone.= "\"$yillar2->first_name\",";
        $dataabone.= "$yillar2->id,";
    }
    @endphp
  const myChartabone = document.getElementById('myChartabone');

  new Chart(myChartabone, {
    type: 'pie',
    data: {
      labels: [{!! $labelsabone !!}],
      datasets: [{
        label: 'Abone Satış Sayısı',
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
<!-- PLATİN TARİFE DEĞİŞİMİ -->
<script>
    @php
    $labelsabone28 = "";
    $dataabone28 = "";
    
    foreach($yillars4 as $yillar4){
        $labelsabone28.= "\"$yillar4->first_name\",";
        $dataabone28.= "$yillar4->id,";
    }
    @endphp
  const myChartabone2 = document.getElementById('myChartabone2');

  new Chart(myChartabone2, {
    type: 'pie',
    data: {
      labels: [{!! $labelsabone28 !!}],
      datasets: [{
        label: 'Abone Tarife Değişim Sayısı',
        data: [{!! $dataabone28 !!}],
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
<!-- // PLATİN TARİFE DEĞİŞİMİ -->

<script>
    @php
    $labelsabonebu = "";
    $dataabonebu = "";
    
    foreach($buayiptals as $buayiptal){
        $labelsabonebu.= "\"$buayiptal->first_name\",";
        $dataabonebu.= "$buayiptal->id,";
    }
    @endphp
  const myChartabonebu = document.getElementById('myChartabonel');

  new Chart(myChartabonebu, {
    type: 'pie',
    data: {
      labels: [{!! $labelsabonebu !!}],
      datasets: [{
        label: 'Aktif Abone Sayısı',
        data: [{!! $dataabonebu !!}],
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
    $labelsabonebu1 = "";
    $dataabonebu1 = "";
    
    foreach($buayiptals2 as $buayiptal2){
        $labelsabonebu1.= "\"$buayiptal2->first_name\",";
        $dataabonebu1.= "$buayiptal2->id,";
    }
    @endphp
  const myChartabonebu1 = document.getElementById('myChartabonel2');

  new Chart(myChartabonebu1, {
    type: 'pie',
    data: {
      labels: [{!! $labelsabonebu1 !!}],
      datasets: [{
        label: 'Onay Bekleyen Abone Sayısı',
        data: [{!! $dataabonebu1 !!}],
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

    $datamusteri = "";
    $first_name = "";
    $last_name = "";
    
    foreach($yillars as $yillar){
        
         $first_name.= "\"$yillar->first_name\",";
         
         $datamusteri.= "$yillar->id,";
    }
    @endphp
  const ctxmusteri = document.getElementById('myChartmusteri');

  new Chart(ctxmusteri, {
    type: 'pie',
    data: {
      labels: [{!! $first_name !!}],
      datasets: [{
        label: 'Abone Satış Sayısı',
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
    
  var barColors2 = ["LimeGreen", "LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen", "LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen"];
  const ctx1 = document.getElementById('myChart1');

  new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Aktif Abone Sayısı',
        data: [{!! $dataabone18 !!}],
        backgroundColor: barColors2,
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
<!-- PLATİN TARİFE DEĞİŞİM -->
<script>
    
  var barColors2 = ["mediumslateblue", "mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue", "mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","LimeGreen","LimeGreen"];
  const ctx111 = document.getElementById('myChart01');

  new Chart(ctx111, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Tarife Değiştiren Abone Sayısı',
        data: [{!! $dataabone01 !!}],
        backgroundColor: barColors2,
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
    
  var barColors2 = ["lightseagreen", "lightseagreen","lightseagreen","lightseagreen","lightseagreen","lightseagreen", "lightseagreen","lightseagreen","lightseagreen","lightseagreen","lightseagreen","lightseagreen"];
  const ctx112 = document.getElementById('myChart02');

  new Chart(ctx112, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Tarife Değiştiren Abone Sayısı',
        data: [{!! $dataabone02 !!}],
        backgroundColor: barColors2,
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
    
  var barColors2 = ["mediumslateblue", "mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue", "mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue"];
  const ctx113 = document.getElementById('myChart03');

  new Chart(ctx113, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Tarife Değiştiren Abone Sayısı',
        data: [{!! $dataabone03 !!}],
        backgroundColor: barColors2,
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
    
  var barColors2 = ["lightseagreen", "lightseagreen","lightseagreen","lightseagreen","lightseagreen","lightseagreen", "lightseagreen","lightseagreen","lightseagreen","lightseagreen","lightseagreen","lightseagreen"];
  const ctx114 = document.getElementById('myChart04');

  new Chart(ctx114, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Tarife Değiştiren Abone Sayısı',
        data: [{!! $dataabone04 !!}],
        backgroundColor: barColors2,
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
    
  var barColors2 = ["mediumslateblue", "mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue", "mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue","mediumslateblue"];
  const ctx115 = document.getElementById('myChart05');

  new Chart(ctx115, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Tarife Değiştiren Abone Sayısı',
        data: [{!! $dataabone05 !!}],
        backgroundColor: barColors2,
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
<!-- // PLATİN TARİFE DEĞİŞİM -->

<script>
    
  var barColors2 = ["DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon"];
  const ctx23 = document.getElementById('myChartiptal');

  new Chart(ctx23, {
    type: 'bar',
    data: {
      labels: ['Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 İptal Abone Sayısı',
        data: [{!! $dataabone23 !!}],
        backgroundColor: barColors2,
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
    
  const ctx24 = document.getElementById('myChartiptal2');

  new Chart(ctx24, {
    type: 'bar',
    data: {
      labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 İptal Abone Sayısı',
        data: [{!! $dataabone24 !!}],
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
    
  var barColors2 = ["DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon"];
  const ctx25 = document.getElementById('myChartiptal3');

  new Chart(ctx25, {
    type: 'bar',
    data: {
      labels: ['Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 İptal Abone Sayısı',
        data: [{!! $dataabone25 !!}],
        backgroundColor: barColors2,
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
    
  const ctx26 = document.getElementById('myChartiptal4');

  new Chart(ctx26, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 İptal Abone Sayısı',
        data: [{!! $dataabone26 !!}],
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
    
  var barColors2 = ["DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon", "DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon","DarkSalmon"];
  const ctx27 = document.getElementById('myChartiptal5');

  new Chart(ctx27, {
    type: 'bar',
    data: {
      labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 İptal Abone Sayısı',
        data: [{!! $dataabone27 !!}],
        backgroundColor: barColors2,
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
    const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Aktif Abone Sayısı',
        data: [{!! $dataabone19 !!}],
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
      var barColors3 = ["LimeGreen", "LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen", "LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen"];

       const ctx3 = document.getElementById('myChart3');

  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Aktif Abone Sayısı',
        data: [{!! $dataabone20 !!}],
        backgroundColor: barColors3,
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
    const ctx4 = document.getElementById('myChart4');

  new Chart(ctx4, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Aktif Abone Sayısı',
        data: [{!! $dataabone21 !!}],
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
      var barColors5 = ["LimeGreen", "LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen", "LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen","LimeGreen"];

  const ctx5 = document.getElementById('myChart5');

  new Chart(ctx5, {
    type: 'bar',
    data: {
      labels: ['Ocak', 'Şubat','Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
      datasets: [{
        label: '2023 Aktif Abone Sayısı',
        data: [{!! $dataabone22 !!}],
        backgroundColor: barColors5,
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

<!-- PLATİN TARİFE DEĞİŞİM -->
<script>
    function openCity3(cityName3,elmnt3,color3) {
      var i, tabcontent3, tablinks3;
      tabcontent3 = document.getElementsByClassName("tabcontent3");
      for (i = 0; i < tabcontent3.length; i++) {
        tabcontent3[i].style.display = "none";
      }
      tablinks3 = document.getElementsByClassName("tablink3");
      for (i = 0; i < tablinks3.length; i++) {
        tablinks3[i].style.backgroundColor = "";
      }
      document.getElementById(cityName3).style.display = "block";
      elmnt3.style.backgroundColor = color3;
    
    }
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen01").click();
</script>


<!-- // PLATİN TARİFE DEĞİŞİM -->

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
function openCity2(cityName2,elmnt2,color2) {
  var i, tabcontent2, tablinks2;
  tabcontent2 = document.getElementsByClassName("tabcontent2");
  for (i = 0; i < tabcontent2.length; i++) {
    tabcontent2[i].style.display = "none";
  }
  tablinks2 = document.getElementsByClassName("tablink2");
  for (i = 0; i < tablinks2.length; i++) {
    tablinks2[i].style.backgroundColor = "";
  }
  document.getElementById(cityName2).style.display = "block";
  elmnt2.style.backgroundColor = color2;

}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen2").click();
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



