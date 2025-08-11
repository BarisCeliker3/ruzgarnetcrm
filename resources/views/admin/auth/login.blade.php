@extends('admin.layout.auth')

@section('content')
       	<!-- google recaptcha -->
        <style>
            .card-primary{
                    
    justify-self: center;
    border-radius:5vh !important;
            }
            .card-header{
                border-radius 5vh;
            }
@keyframes neon-border-animation {
  0% {
    border-color: #ff00ff;
  }
  50% {
    border-color: #00ffff;
  }
  100% {
    border-color: #ff00ff;
  }
}

.neon-border {
  position: relative;
  border: 4px solid transparent;
  border-radius: 8px; /* Kenarları yuvarlatmak için */
  padding: 20px;
  animation: neon-border-animation 2s infinite alternate;
  background-clip: padding-box; /* Border'ın içerikle örtüşmemesi için */
}



        </style>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	 <!--<script src="https://www.google.com/recaptcha/enterprise.js?render=6LdRozYqAAAAAJ6BGVYRZaWVc4Lj59l07E1wqba9"></script>-->

         <div class="neon-border card-primary bg-transparent w-full max-w-[1200px] mx-auto px-4">

    <div style="3rem;align-self: center; text-align: center;" class=" bg-transparent">
                            <img src="/assets/images/titleheader.png" width="300">
    
</div>
<div style="width:80%;" class="w-full max-w-full mx-auto p-12 rounded-lg shadow-md bg-transparent">

    <form method="POST" action="{{ route('admin.login') }}" autocomplete="off">
        @csrf
        <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">

        <!-- Kullanıcı Adı -->
        <div class="form-group mb-3">
            <label for="txtKullaniciAdi" class="text-sm text-white">@lang('fields.username')</label>
            <input 
                type="text" 
                name="username" 
                id="txtKullaniciAdi" 
                class="form-control w-3/4 p-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                autocomplete="off" 
                autofocus 
                onfocus="this.removeAttribute('readonly');"
            >
        </div>

        <!-- Şifre -->
        <div class="form-group mb-3">
            <label for="txtSifre" class="text-sm text-white">@lang('fields.password')</label>
            <input 
                type="password" 
                class="stealthy" 
                tabindex="-1" 
                style="position: absolute; opacity: 0; height: 1px; width: 1px; pointer-events: none;"
            >
            <input 
                type="password" 
                name="password" 
                id="txtSifre" 
                class="form-control w-3/4 p-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                autocomplete="new-password" 
                onfocus="this.setAttribute('autocomplete', 'new-password');" 
                autofill="off" 
                autocapitalize="off"
            >
        </div>

        <!-- Google Captcha ve Buton -->
        <div style="    place-items: center;" class="form-group mb-4 mx-auto">
            <div class="g-recaptcha sa-form-isim" data-sitekey="6LedvjYqAAAAAAdMIq8p99YZGx1rJCNNcjYGXGPe"></div>
            <label class="control-label text-sm" id="lblGoogle" style="color:red"></label>
          <button 
    style="font-size: 20px; width:50%; color:#ff00ae !important" 
    type="button" 
    class="btn btn-primary btn-lg btn-block px-4 py-2 text-sm text-black rounded-md bg-transparent hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200" 
    id="btnGir" 
    onclick="kontrolEt();">
    @lang('auth.login')
</button>

        </div>
    </form>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let passwordField = document.getElementById('txtSifre');
        // Şifre kaydetme özelliklerini engelleme
        passwordField.setAttribute('autocomplete', 'new-password');
        passwordField.setAttribute('autofill', 'off');
    });
</script>

<script>
    document.querySelector("form").setAttribute("autocomplete", "off");
document.querySelector("input[name='password']").setAttribute("autocomplete", "new-password");
</script>
            
            <form method="POST" action="{{ route('admin.login.post') }}" data-ajax="false" style="display:none;">
                @csrf
                <div class="form-group">
                    <label for="inputUsername">@lang('fields.username')</label>
                    <input type="text" name="username" id="inputUsername"
                        class="form-control @error('username') is-invalid @enderror" autofocus
                        value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="control-label">@lang('fields.password')</label>
                    <input name="password" id="inputPassword" type="password"
                        class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <!--<div class="g-recaptcha sa-form-isim" data-sitekey="6LedvjYqAAAAAAdMIq8p99YZGx1rJCNNcjYGXGPe"></div>-->
                    <button type="submit" class="btn btn-primary text-black btn-lg btn-block" id="btnGiris">
                        @lang('auth.login')
                    </button>
                </div>
            </form>
        </div>
    </div>
    
 <script>
     function kontrolEt() {
         
         var response = grecaptcha.getResponse();
               /* if (response.length == 0) {
                    document.getElementById("lblGoogle").innerHTML="Doğrulama Yapmanız Gerekmektedir";
                }
                else {
                */
                    document.getElementById("inputUsername").value=document.getElementById("txtKullaniciAdi").value;
                    document.getElementById("inputPassword").value=document.getElementById("txtSifre").value;
                    document.getElementById("btnGiris").click();
                /*}*/
     }
     
 </script>
    
@endsection
