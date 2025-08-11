@extends('admin.layout.main')

@section('title', meta_title('tables.infrastructure.title'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" id="infrastructure_statu_form" onsubmit="return processForm()" autocomplete="off">
                <div class="card form">
                    <div class="card-header">
                        <h4 class="flex items-center mx-auto justify-center space-x-2">
                            <img src="/assets/images/rightemoji.png" alt="image" class="w-40 h-40">

                            <span class="neon-text2">@lang('tables.infrastructure.title')</span>
                            <img src="/assets/images/emojileft.png" alt="image" class="w-40 h-40">

                          </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="cities">@lang('fields.city')</label>
                                    <select name="cities" id="cities" class="custom-select">

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="districts">@lang('fields.district')</label>
                                    <select name="districts" id="districts" class="custom-select">
                                        <option disabled selected>@lang('tables.district.select')</option>
                                    </select>
                                </div>
                            </div>
                            <!--
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="townships">@lang('fields.townships')</label>
                                    <select name="townships" id="townships" class="custom-select">
                                        <option disabled selected>@lang('tables.infrastructure.townships')</option>
                                    </select>
                                </div>
                            </div>
                            -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="villages">@lang('fields.villages')</label>
                                    <select name="villages" id="villages" class="custom-select">
                                        <option disabled selected>@lang('tables.infrastructure.villages')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="neighborhoods">@lang('fields.neighborhoods')</label>
                                    <select name="neighborhoods" id="neighborhoods" class="custom-select">
                                        <option disabled selected>@lang('tables.infrastructure.neighborhoods')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="streets">@lang('fields.streets')</label>
                                    <select name="streets" id="streets" class="custom-select">
                                        <option disabled selected>@lang('tables.infrastructure.streets')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="buildings">@lang('fields.buildings')</label>
                                    <select name="buildings" id="buildings" class="custom-select selectpicker">
                                        <option disabled selected>@lang('tables.infrastructure.buildings')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="doors">@lang('fields.doors')</label>
                                    <select name="doors" id="doors" class="custom-select selectpicker">
                                        <option disabled selected>@lang('tables.infrastructure.doors')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="inpFullName">@lang('fields.full_name')</label>
                                    <input type="text" maxlength="30" minlength="10" name="full_name" id="inpFullName"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="inpTelephone">@lang('fields.telephone')</label>
                                    <input type="tel" name="telephone" id="inpTelephone" pattern="[5]{1}[0-9]{2}[0-9]{3}[0-9]{4}" placeholder="(5xx)1234567" required=”required” class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" card-footer text-right">
                        <button type="submit" onclick="myFunction()" class="btn btn-primary">@lang('fields.send')</button>
                    </div>



                    <style>
                        .info-list li {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 14px 20px;
                            font-size: 18px;
                            border-bottom: 1px solid #dee2e6;
                            background-color: rgba(255, 255, 255, 0.8);
                        }
                    
                        .info-list li:last-child {
                            border-bottom: none;
                        }
                    
                        .info-label {
                            font-weight: bold;
                            color: #0d6efd;
                            width: 40%;
                        }
                    
                        .info-value {
                            font-weight: 500;
                            color: #333;
                            width: 60%;
                        }
                    
                    
                        #karikatur img {
                            border-radius: 12px;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        }
                    </style>
                 <div class="background-container mt-5 d-flex flex-column w-100 align-items-center py-5" style="min-height: 500px;">
                    <div class="row w-100 d-flex justify-content-center align-items-center">
                      
                      <!-- Liste Alanı -->
                      <div style="
                        border: 2px solid rgba(0, 123, 255, 0.2); 
                        border-radius: 15px; 
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
                        padding: 2rem;
                        background-color: #f9f9f9;" 
                        class="col-md-4 col-sm-12 mb-3">
                        
                        <ul class="list-group info-list">
                          <li class="list-group-item d-flex justify-content-between">
                            <span class="info-label">BBK</span>
                            <span id="bbk" class="info-value">YOK</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between">
                            <span class="info-label">PORT</span>
                            <span id="speed_information" class="info-value">YOK</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between">
                            <span class="info-label">ADSL</span>
                            <span id="adsl" class="info-value">YOK</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between">
                            <span class="info-label">VDSL</span>
                            <span id="vdsl" class="info-value">YOK</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between">
                            <span class="info-label">FİBER</span>
                            <span id="fiber" class="info-value">YOK</span>
                          </li>
                        </ul>
                      </div>
                  
                      <!-- Video Alanı -->
                      <div class="col-md-8 col-sm-12 mb-3 text-center">
                        <video width="100%" autoplay muted loop playsinline style="border: none; outline: none; display: block;">
                          <source src="/assets/images/videoaltyapi.mp4" type="video/mp4">
                          Tarayıcınız video etiketini desteklemiyor.
                        </video>
                      </div>
                    </div>
                  </div>




                </div>
            </form>

        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
@endpush

@push('script')
<script>
function myFunction() {
  var x = document.getElementById("karikatur");
  if (x.style.display === "block") {

  } else {
    x.style.display = "block";
  }
}
</script>
    <script src="/assets/admin/vendor/ckeditor/ckeditor.js"></script>
    <script src="/assets/admin/vendor/slugify/slugify.js"></script>
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
    <script src="/assets/js/tt_api.js?id=22323"></script>
@endpush
