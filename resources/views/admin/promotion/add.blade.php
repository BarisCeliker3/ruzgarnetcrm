@extends('admin.layout.main')

@section('title', meta_title('tables.promotion.add'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.promotion.add.post') }}">
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('tables.promotion.add')</h4>

                        <div class="card-header-buttons">
                            <a href="{{ route('admin.promotions') }}" class="btn btn-primary"><i
                                    class="fas fa-sm fa-list-ul"></i> @lang('tables.promotion.title')</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slcSubscription">@lang('fields.customer')</label>
                            <select name="subscription_id" id="slcSubscription" class="custom-select selectpicker">
                                <option selected disabled>@lang('tables.customer.select')</option>
                                @foreach ($subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">{{ $subscription->customer->select_print }} - {{ $subscription->service->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="slcPromotion">@lang('fields.promotion')</label>
                            <select name="promotion_name" id="slcPromotion" class="custom-select selectpicker">
                                <option selected disabled>@lang('tables.promotion.select')</option>
                                <option value="Digiturk & Bein Connect">Digiturk & Bein Connect</option>
                                <option value="Pırlanta Kolye">Pırlanta Kolye</option>
                                <option value="Bluetooth Kulaklık">Bluetooth Kulaklık</option>
                                <option value="NEXT Android Box">NEXT Android Box</option>
                                <option value="Akıllı Bileklik">Akıllı Bileklik</option>
                                <option value="Akıllı Çocuk Saati">Akıllı Çocuk Saati</option>
                                <option value="Traş Makinası">Traş Makinası</option>
                                <option value="Xaomi Wifi Güçlendirici">Xaomi Wifi Güçlendirici</option>
                                <option value="Onno SV-M3">Onno SV-M3</option>
                                <option value="Tablet">Tablet</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="txtPromotion_description">@lang('fields.description')</label>
                            <textarea name="promotion_description" id="txtPromotion_description" class="form-control"
                                rows="3"></textarea>
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
