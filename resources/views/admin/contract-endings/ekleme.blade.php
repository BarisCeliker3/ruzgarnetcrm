@extends('admin.layout.main')

@section('title', meta_title('tables.contractendings.title'))

@section('content')
    <div class="row">
        <div class="col-10">
            <div style=" background: #fff; padding: 20px; margin-top:56px" class="offset-md-3 col-md-6">
                  <div>
                    <h5 class="text-center" style="color:red;">Taahhüt Süresi & Fiyat Güncelleme</h5>
                  </div><br>
                  
                  <div class="form-row">
                    <div class="form-group col-md-12">
                       <label style="color:#304FFE; font-weight: bold;font-size:16px;" for="inputCity">Tarife: <span class="text-danger">
@if($subsupend->service_id =='1') 
		{{$subsupend->service_id =='1' ? 'RüzgarFiber Eko( satışa kapalı)' : ''}}
	@elseif($subsupend->service_id =='2') 
		{{$subsupend->service_id =='2' ? 'RüzgarFiber Aktif' : ''}}
	@elseif($subsupend->service_id =='3') 
		{{$subsupend->service_id =='3' ? 'RüzgarFiber LİFE 24 AY( satışa kapalı)' : ''}}
	@elseif($subsupend->service_id =='4') 
		{{$subsupend->service_id =='4' ? 'RüzgarFiber Twin ( SATIŞA KAPALI )' : ''}}
	@elseif($subsupend->service_id =='5') 
		{{$subsupend->service_id =='5' ? 'RüzgarFiber Jet ( SATIŞA KAPALI)' : ''}}
	@elseif($subsupend->service_id =='6') 
		{{$subsupend->service_id =='6' ? 'RüzgarFiber STAR (SATIŞA KAPALI)' : ''}}
	@elseif($subsupend->service_id =='7') 
		{{$subsupend->service_id =='7' ? 'RüzgarFiber Small' : ''}}
	@elseif($subsupend->service_id =='8') 
		{{$subsupend->service_id =='8' ? 'RüzgarFiber Speed ( SATIŞA KAPALI)' : ''}}
	@elseif($subsupend->service_id =='9') 
		{{$subsupend->service_id =='9' ? 'RüzgarFiber Yeni Small' : ''}}
	@elseif($subsupend->service_id =='10') 
		{{$subsupend->service_id =='10' ? 'RüzgarFiber yaz SATIŞA KAPALI' : ''}}
	@elseif($subsupend->service_id =='11') 
		{{$subsupend->service_id =='11' ? 'RüzgarFiber Turbo SATIŞA KAPALI' : ''}}
	@elseif($subsupend->service_id =='12') 
		{{$subsupend->service_id =='12' ? 'RüzgarNET Eko SATIŞA KAPALI' : ''}}
	@elseif($subsupend->service_id =='13') 
		{{$subsupend->service_id =='13' ? 'RüzgarNET Small' : ''}}
	@elseif($subsupend->service_id =='14') 
		{{$subsupend->service_id =='14' ? 'RüzgarNET Pasif' : ''}}
	@elseif($subsupend->service_id =='15') 
		{{$subsupend->service_id =='15' ? 'RüzgarNET Aktif' : ''}}
	@elseif($subsupend->service_id =='16') 
		{{$subsupend->service_id =='16' ? 'RüzgarNET Ekstra' : ''}}
	@elseif($subsupend->service_id =='17') 
		{{$subsupend->service_id =='17' ? 'RüzgarNET Ultra SATIŞA KAPALI' : ''}}
	@elseif($subsupend->service_id =='18') 
		{{$subsupend->service_id =='18' ? 'RüzgarNET Pro SATIŞA KAPALI' : ''}}
	@elseif($subsupend->service_id =='19') 
		{{$subsupend->service_id =='19' ? 'RüzgarNET Maxi SATIŞA KAPALI' : ''}}
	@elseif($subsupend->service_id =='20') 
		{{$subsupend->service_id =='20' ? 'RüzgarNET Joker' : ''}}
	
	@elseif($subsupend->service_id =='21') 
		{{$subsupend->service_id =='21' ? 'RüzgarNET Double' : ''}}
	
	@elseif($subsupend->service_id =='22') 
		{{$subsupend->service_id =='22' ? 'RüzgarNET Simetri 2' : ''}}
	
	@elseif($subsupend->service_id =='23') 
		{{$subsupend->service_id =='23' ? 'RüzgarNET Ultra SATIŞA KAPALI' : ''}}
	
	@elseif($subsupend->service_id =='24') 
		{{$subsupend->service_id =='24' ? 'RüzgarNET Pro Yeni SATIŞA KAPALI' : ''}}
	
	@elseif($subsupend->service_id =='25') 
		{{$subsupend->service_id =='25' ? 'RüzgarNET Maxi Yeni' : ''}}

	@elseif($subsupend->service_id =='37') 
		{{$subsupend->service_id =='37' ? 'PLAKA RÜZGAR FİBER LİFE' : ''}}
		
	@elseif($subsupend->service_id =='38') 
		{{$subsupend->service_id =='38' ? 'PLAKA RÜZGAR FİBER JET SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='39') 
		{{$subsupend->service_id =='39' ? 'PLAKA RÜZGAR FİBER TURBO' : ''}}
		
	@elseif($subsupend->service_id =='40') 
		{{$subsupend->service_id =='40' ? 'PLAKA RÜZGAR FİBER STAR ( SATIŞA KAPALI)' : ''}}
		
	@elseif($subsupend->service_id =='41') 
		{{$subsupend->service_id =='41' ? 'PLAKA RÜZGAR FİBER SPEED satışa kapalı' : ''}}
		
	@elseif($subsupend->service_id =='42') 
		{{$subsupend->service_id =='42' ? 'Yeni RüzgarFİBER LİFE(SATISA-KAPALI)' : ''}}
		
	@elseif($subsupend->service_id =='43') 
		{{$subsupend->service_id =='43' ? 'RüzgarFİBER NEXT' : ''}}
		
	@elseif($subsupend->service_id =='44') 
		{{$subsupend->service_id =='44' ? 'RüzgarFİBER STAR NEXT ( SATIŞA KAPALI)' : ''}}
		
	@elseif($subsupend->service_id =='45') 
		{{$subsupend->service_id =='45' ? 'RüzgarFİBER SPEED NEXT ( SATIŞA KAPALI)' : ''}}
		
	@elseif($subsupend->service_id =='46') 
		{{$subsupend->service_id =='46' ? 'RüzgarFİBER OKULA DÖNÜŞ TABLET' : ''}}
		
	@elseif($subsupend->service_id =='47') 
		{{$subsupend->service_id =='47' ? 'RüzgarFİBER Taahhüt Bozan' : ''}}
		
	@elseif($subsupend->service_id =='48') 
		{{$subsupend->service_id =='48' ? 'RüzgarFİBER Eğlence' : ''}}
		
	@elseif($subsupend->service_id =='51') 
		{{$subsupend->service_id =='51' ? 'RüzgarFİBER Yeni TURBO ( SATIŞA KAPALI)' : ''}}
		
	@elseif($subsupend->service_id =='52') 
		{{$subsupend->service_id =='52' ? 'Rüzgar 11 Kampanyası SATIŞA KAPALI' : ''}}
	
	@elseif($subsupend->service_id =='53') 
		{{$subsupend->service_id =='53' ? 'RüzgarFiber Efsane( satışa kapalı)' : ''}}
	
	@elseif($subsupend->service_id =='54') 
		{{$subsupend->service_id =='54' ? 'RüzgarFiber Speed Pırlanta SATIŞA KAPALI' : ''}}
	
	@elseif($subsupend->service_id =='55') 
		{{$subsupend->service_id =='55' ? 'RüzgarFİBER 11 Kampanyası 3 Ay SATIŞA KAPALI' : ''}}
	
	@elseif($subsupend->service_id =='56') 
		{{$subsupend->service_id =='56' ? 'Rüzgarnet Simetri 3' : ''}}
	
	@elseif($subsupend->service_id =='57') 
		{{$subsupend->service_id =='57' ? 'RüzgarFİBER LİFE 12 Ay Taahhütlü SATIŞA KAPALI' : ''}}
	
	@elseif($subsupend->service_id =='58') 
		{{$subsupend->service_id =='58' ? 'RüzgarFİBER JET 12 ay taahhütlü SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='59') 
		{{$subsupend->service_id =='59' ? 'RüzgarFİBER TURBO 12 ay Taahhütlü ( SATIŞA KAPANDI)' : ''}}
		
	@elseif($subsupend->service_id =='60') 
		{{$subsupend->service_id =='60' ? 'RüzgarFİBER STAR ( 12 Aylık ) SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='61') 
		{{$subsupend->service_id =='61' ? 'RüzgarFİBER SPEED ( 12 Aylık) SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='62') 
		{{$subsupend->service_id =='62' ? 'RüzgarFİBER Efsane ( 12 Aylık)' : ''}}
		
	@elseif($subsupend->service_id =='63') 
		{{$subsupend->service_id =='63' ? 'RüzgarFİBER Traş Makinasi' : ''}}
		
	@elseif($subsupend->service_id =='64') 
		{{$subsupend->service_id =='64' ? 'RüzgarFİBER Speed 12 Ay Taahhütlü SATIŞA KAPANDI ' : ''}}
		
	@elseif($subsupend->service_id =='65') 
		{{$subsupend->service_id =='65' ? 'RüzgarFİBER STAR 12 Ay taahhütlü SATIŞA KAPANDI' : ''}}
		
	@elseif($subsupend->service_id =='66') 
		{{$subsupend->service_id =='66' ? 'RüzgarFİBER EKO YENİ TARİFE' : ''}}
		
	@elseif($subsupend->service_id =='67') 
		{{$subsupend->service_id =='67' ? 'RüzgarNET SÜPER 6 aylık Taahhütlü SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='68') 
		{{$subsupend->service_id =='68' ? 'RüzgarNET SÜPER 12 Ay Taahhütlü SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='69') 
		{{$subsupend->service_id =='69' ? 'RüzgarNET FAST 6 Aylık Taahhütlü SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='70') 
		{{$subsupend->service_id =='70' ? 'RüzgarNET FAST 12 Aylık Taahhütlü SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='71') 
		{{$subsupend->service_id =='71' ? 'Rüzgar ULTRA 12 Aylık ' : ''}}
		
	@elseif($subsupend->service_id =='72') 
		{{$subsupend->service_id =='72' ? 'RüzgarNET PRO 12 Aylık ' : ''}}
		
	@elseif($subsupend->service_id =='73') 
		{{$subsupend->service_id =='73' ? 'RüzgarNET MAXİ 12 Aylık ' : ''}}
		
	@elseif($subsupend->service_id =='74') 
		{{$subsupend->service_id =='74' ? 'RüzgarFİBER Giga 200 SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='75') 
		{{$subsupend->service_id =='75' ? 'RüzgarFİBER Gİga 500' : ''}}
		
	@elseif($subsupend->service_id =='76') 
		{{$subsupend->service_id =='76' ? 'RüzgarFİBER GİGA 1000 -1G HIZ' : ''}}
		
	@elseif($subsupend->service_id =='77') 
		{{$subsupend->service_id =='77' ? 'RüzgarFİBER 75 mbps ceptelefonu ' : ''}}
		
	@elseif($subsupend->service_id =='78') 
		{{$subsupend->service_id =='78' ? 'RüzgarNET 20/20 kurumsal' : ''}}
		
	@elseif($subsupend->service_id =='79') 
		{{$subsupend->service_id =='79' ? 'RüzgarFİBER EKO 2.KURGU' : ''}}
		
	@elseif($subsupend->service_id =='80') 
		{{$subsupend->service_id =='80' ? 'Rüzgar Fiber Giga 200 Mbps Kampanya ' : ''}}
		
	@elseif($subsupend->service_id =='81') 
		{{$subsupend->service_id =='81' ? 'RüzgarFİBER Sonbahar Kampanyası SATIŞA KAPANDI' : ''}}
		
	@elseif($subsupend->service_id =='82') 
		{{$subsupend->service_id =='82' ? 'Rüzgar FİBER 1000 Mbps Kampanyası 2 aylık' : ''}}
		
	@elseif($subsupend->service_id =='83') 
		{{$subsupend->service_id =='83' ? 'Rüzgar FİBER 75 Mbps hız ZÜMRÜT KOLYE HEDİYE SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='84') 
		{{$subsupend->service_id =='84' ? 'Rüzgar FİBER Taahhütbozan' : ''}}
		
	@elseif($subsupend->service_id =='86') 
		{{$subsupend->service_id =='86' ? 'RüzgarFİBER LİFE 6 Ay Taahhütlü SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='87') 
		{{$subsupend->service_id =='87' ? 'Rüzgar FİBER 11 kampanyası 2 ay İndirimli SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='88') 
		{{$subsupend->service_id =='88' ? 'Engel Tanımayan 12 aylık' : ''}}
		
	@elseif($subsupend->service_id =='89') 
		{{$subsupend->service_id =='89' ? 'RüzgarNET Turbo İlk Ay Hediye SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='90') 
		{{$subsupend->service_id =='90' ? 'RüzgarNET Star ilk ay Hediye SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='91') 
		{{$subsupend->service_id =='91' ? 'RüzgarNET Speed İlk ay Hediye SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='92') 
		{{$subsupend->service_id =='92' ? 'RüzgarFİBER Turbo Niğdeye ozel SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='93') 
		{{$subsupend->service_id =='93' ? 'RüzgarFİBER STAR Niğdeye Özel SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='94') 
		{{$subsupend->service_id =='94' ? 'RüzgarFİBER Speed Niğdeye özel SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='95') 
		{{$subsupend->service_id =='95' ? 'Rüzgar FİBER LİFE 3 AYLIK SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='96') 
		{{$subsupend->service_id =='96' ? 'Rüzgar FİBER KIŞ Kampanyası TAAHHÜTSÜZ' : ''}}
		
	@elseif($subsupend->service_id =='97') 
		{{$subsupend->service_id =='97' ? 'Rüzgar FİBER JET adsl ve vdsl modem satışlı NİGDE' : ''}}
		
	@elseif($subsupend->service_id =='98') 
		{{$subsupend->service_id =='98' ? 'Rüzgar FİBER TURBO adsl ve vdsl modem satışlı NİGDE' : ''}}
		
	@elseif($subsupend->service_id =='99') 
		{{$subsupend->service_id =='99' ? 'Rüzgar FİBER STAR adsl ve vdsl modem satişlı NİGDE' : ''}}
		
	@elseif($subsupend->service_id =='100') 
		{{$subsupend->service_id =='100' ? 'Rüzgar FİBER SPEED adsl ve vdsl satışlı SATIŞA KAPANDI' : ''}}
		
	@elseif($subsupend->service_id =='101') 
		{{$subsupend->service_id =='101' ? 'Rüzgar FİBER POWER Taahhütsüz SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='102') 
		{{$subsupend->service_id =='102' ? 'RüzgarFİBER JET TAAHHÜTSÜZ SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='103') 
		{{$subsupend->service_id =='103' ? 'Rüzgar DESTEK Kampanyası SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='104') 
		{{$subsupend->service_id =='104' ? 'Rüzgar FİBER LİFE TAAHHÜTSÜZ' : ''}}
		
	@elseif($subsupend->service_id =='105') 
		{{$subsupend->service_id =='105' ? 'RüzgarFİBER TURBO İLK AY İNDİRİMLİ SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='106') 
		{{$subsupend->service_id =='106' ? 'Rüzgar FİBER STAR İLK AY İNDİRİMLİ SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='107') 
		{{$subsupend->service_id =='107' ? 'RüzgarFİBER SPEED İLK AY İNDİRİMLİ SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='108') 
		{{$subsupend->service_id =='108' ? 'RüzgarFİBER POWER SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='109') 
		{{$subsupend->service_id =='109' ? 'RüzgarFİBER 75 Mbps 12 Taahhütlü' : ''}}
		
	@elseif($subsupend->service_id =='111') 
		{{$subsupend->service_id =='111' ? 'RüzgarFİBER TWİN 12 AYLIK SATIŞA KAPANDI' : ''}}
		
	@elseif($subsupend->service_id =='112') 
		{{$subsupend->service_id =='112' ? 'RüzgarFİBER DESTEK Kampanyası SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='113') 
		{{$subsupend->service_id =='113' ? 'RüzgarFİBER POWER SATIŞA KAPANDI' : ''}}
		
	@elseif($subsupend->service_id =='114') 
		{{$subsupend->service_id =='114' ? 'RüzgarNET HIZ 12 Ay Taahhütlü' : ''}}
		
	@elseif($subsupend->service_id =='115') 
		{{$subsupend->service_id =='115' ? 'RüzgarFİBER SMART SATIŞA KAPALI' : ''}}
		
	@elseif($subsupend->service_id =='116') 
		{{$subsupend->service_id =='116' ? 'Rüzgar FİBER TWİN YENİ' : ''}}
		
	@elseif($subsupend->service_id =='117') 
		{{$subsupend->service_id =='117' ? 'Rüzgar Yeni SMART SATIŞA KAPANDI' : ''}}
	
	@elseif($subsupend->service_id =='118') 
		{{$subsupend->service_id =='118' ? 'Rüzgar Yeni DESTEK SATIŞA KAPANDI' : ''}}
	
	@elseif($subsupend->service_id =='119') 
		{{$subsupend->service_id =='119' ? 'Rüzgar TURBO YENİ' : ''}}
	
	@elseif($subsupend->service_id =='120') 
		{{$subsupend->service_id =='120' ? 'Rüzgar STAR YENİ' : ''}}
	
	@elseif($subsupend->service_id =='121') 
		{{$subsupend->service_id =='121' ? 'Rüzgar SPEED YENİ' : ''}}
	
	@elseif($subsupend->service_id =='122') 
		{{$subsupend->service_id =='122' ? 'Rüzgar SPEED GOLD' : ''}}
	
	@elseif($subsupend->service_id =='123') 
		{{$subsupend->service_id =='123' ? 'Rüzgar TWİN GOLD' : ''}}
	
	@elseif($subsupend->service_id =='124') 
		{{$subsupend->service_id =='124' ? 'Niğde YAZ KAMPANYASI' : ''}}
	
	@elseif($subsupend->service_id =='125') 
		{{$subsupend->service_id =='125' ? 'Rüzgar POWER YENİ satışa Kapandı' : ''}}
	
	@elseif($subsupend->service_id =='126') 
		{{$subsupend->service_id =='126' ? 'Rüzgar SMART YENi Satışa Kapandı' : ''}}
	
	@elseif($subsupend->service_id =='127') 
		{{$subsupend->service_id =='127' ? 'Rüzgar DESTEK YENİ Satışa KAPANDI' : ''}}
	
	@elseif($subsupend->service_id =='128') 
		{{$subsupend->service_id =='128' ? 'Rüzgar 100 Güldüren Yeni Satışa KAPANDI' : ''}}
	
	@elseif($subsupend->service_id =='129') 
		{{$subsupend->service_id =='129' ? 'Rüzgar POWER NEW' : ''}}
	
	@elseif($subsupend->service_id =='130') 
		{{$subsupend->service_id =='130' ? 'Rüzgar SMART NEW' : ''}}
	
	@elseif($subsupend->service_id =='131') 
		{{$subsupend->service_id =='131' ? 'Rüzgar DESTEK NEW' : ''}}
	
	@elseif($subsupend->service_id =='132') 
		{{$subsupend->service_id =='132' ? 'Rüzgar 100 Güldüren NEW' : ''}}
	
	@elseif($subsupend->service_id =='133') 
		{{$subsupend->service_id =='133' ? 'Rüzgar FREE' : ''}}
	
	@elseif($subsupend->service_id =='26') 
		{{$subsupend->service_id =='26' ? '15 GB' : ''}}
	
	@elseif($subsupend->service_id =='27') 
		{{$subsupend->service_id =='27' ? '30 GB' : ''}}
	
	@elseif($subsupend->service_id =='28') 
		{{$subsupend->service_id =='28' ? '60 GB' : ''}}

	@endif
                          
                          </span>	

                       </label>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                       <label style="color:#304FFE; font-weight: bold;font-size:16px;" for="inputCity">Eski Fiyat: <span class="text-danger">{{$subsupend->price}} ₺</span></label>
                    </div>
                  </div>
                  
                <form method="POST" action="{{relative_route('admin.contractending.store')}}" class="needs-validation" novalidate>
                @csrf
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">Fiyat:</label>
                      <input name="new_price" type="text" min="1" class="form-control"required>
                <div style="color:#dd0a0a; font-weight: bold;font-size:15px;" class="invalid-feedback">
                  Lütfen fiyat girin
                </div>
                    </div>
                  </div>
                  <div class="form-row">
                  <div class="form-group col-md-12">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">Taahhüt Süresi:</label>
                      <select name="new_commitment" id="inputState" class="form-control" required>
                        <option value="">Taahhüt Seçiniz</option>
                        <option value="1">1 AY</option>
                        <option value="2">2 AY</option>
                        <option value="3">3 AY</option>
                        <option value="4">4 AY</option>
                        <option value="5">5 AY</option>
                        <option value="6">6 AY</option>
                        <option value="7">7 AY</option>
                        <option value="8">8 AY</option>
                        <option value="9">9 AY</option>
                        <option value="10">10 AY</option>
                        <option value="11">11 AY</option>
                        <option value="12">12 AY</option>
                      </select>
                <div style="font-weight: bold;font-size:15px;" class="invalid-feedback">
                 Lütfen Taahhüt süresini seçiniz.
                </div>
                   </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputCity"></label>
                      <input type="hidden" value="{{$subsupend->id}}" name="subscription_id" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputZip"></label>
                      <input type="hidden" value="{{ isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id }}" name="staff_id" class="form-control" required>
                    </div>
                  </div>

                  <button style="float:right; margin-top:-35px" id="btn" type="submit" class="btn btn-primary">Güncelle</button>
                  <button style="float:right; margin-right:10px;margin-top:-35px" type="reset" class="btn btn-danger">Temizle</button>
            </form>
        </div>
    </div>
</div>

@endsection

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

@endpush

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('script')
    <script src="/assets/admin/vendor/slugify/slugify.js"></script>
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/admin/vendor/cleave/cleave.min.js"></script>
    <script src="/assets/admin/vendor/vue/vue.min.js"></script>


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
        document.getElementById("btn")
            .onclick = function(){
                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/contractendings';}, 4000);                        
             };
    </script>

@endpush



