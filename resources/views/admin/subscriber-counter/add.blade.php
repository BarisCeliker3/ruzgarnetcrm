@extends('admin.layout.main')

@section('title', meta_title('tables.subscribercounter.add'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.subscribercounter.add.post') }}">
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('tables.subscribercounter.add')</h4>

                        <div class="card-header-buttons">
                            <a href="{{ route('admin.subscribercounters') }}" class="btn btn-primary">
                                <i class="fas fa-sm fa-list-ul"></i> @lang('tables.subscribercounter.title')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
							<!--Tutar-->
                           
							<!--Hizmetler-->
                        <div class="col-md-4 form-group">
                            <label for="slcStaff">@lang('fields.staff')</label>
                            <select name="staff_id" id="slcStaff" class="custom-select selectpicker">
                                <option selected disabled>@lang('tables.staff.select')</option>
                                    <option value="YAZ LİMONCU">YAZ LİMONCU</option>
                                    <option value="EMRE ÇİLİ">EMRE ÇİLİ</option>
                                    <option value="HÜMEYRA GÖÇER">HÜMEYRA GÖÇER</option>
                                    <option value="DÖNDÜ BALARBAN">DÖNDÜ BALARBAN</option>
                                    <option value="MERVE HORASAN">MERVE HORASAN</option>
                                    <option value="SEYDA KİRAZCI">SEYDA KİRAZCI</option>
                                    <option value="BELGİN KARTAL">BELGİN KARTAL</option>
                                    <option value="DERYA ÇEVİK">DERYA ÇEVİK</option>
                                    <option value="FİKRİYE ŞENOL">FİKRİYE ŞENOL</option>
                                    <option value="HURİYE KILIÇ">HURİYE KILIÇ</option>
                                    <option value="YUNUS YÜÇEL">YUNUS YÜÇEL</option>
                                    <option value="NİLAY DEMİR">NİLAY DEMİR</option>
                                    <option value="FATMANUR BALLI">FATMANUR BALLI</option>
                                    <option value="TURGAY TÜRKER">TURGAY TÜRKER</option>
                                    <option value="CEMAL ERTUNÇ">CEMAL ERTUNÇ</option>

                            </select>
                        </div>
                           <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slcName_surname">@lang('fields.name_surname')</label>
                                    <input type="text" name="name_surname" id="slcName_surname" class="form-control">
                                </div>
                            </div>
                           <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slcTelephone">@lang('fields.telephone')</label>
                                    <input type="text" name="telephone" id="slcTelephone" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slcbitistarihi">@lang('fields.ended_at')</label>
                                    <input type="date" name="bitistarihi" id="slcbitistarihi" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txtCompany">@lang('fields.company')</label>
                                    <input type="text" name="company" id="txtCompany" class="form-control">
                                </div>
                            </div>
                            
                            
                        </div>

                        
                       
                        
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">@lang('fields.send')</button>
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
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
@endpush
