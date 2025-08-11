@extends('admin.layout.main')

@section('title', meta_title('tables.otherexpense.add'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.otherexpense.edit.put',$otherexpense) }}">
                @method('put')
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('tables.otherexpense.add')</h4>

                        <div class="card-header-buttons">
                            <a href="{{ route('admin.otherexpenses') }}" class="btn btn-primary">
                                <i class="fas fa-sm fa-list-ul"></i> @lang('tables.otherexpense.title')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slcSubscription">@lang('fields.customer')</label>
                            <select name="subscription_id" id="slcSubscription" class="custom-select selectpicker">
                                <option selected disabled>@lang('tables.customer.select')</option>
                                @foreach ($subscriptions as $subscription)
                                    <option @if ($otherexpense->subscription_id == $subscription->id ) selected @else @endif value="{{ $subscription->id }}">{{ $subscription->customer->select_print }} - {{ $subscription->service->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="inpPrice">@lang('fields.price')</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="price" id="inpPrice"
                                            class="form-control money-input" min="0" step=".01" value="{{ $otherexpense->price }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slcProduct_name">@lang('fields.service')</label>
                                    <select name="product_name" id="slcProduct_name" class="custom-select selectpicker">
                                        <option @if ($otherexpense->product_name == "ADSL") selected @else @endif value="ADSL">ADSL</option>
                                        <option @if ($otherexpense->product_name == "VDSL") selected @else @endif value="VDSL">VDSL</option>
                                        <option @if ($otherexpense->product_name == "Kablo") selected @else @endif value="Kablo">Kablo</option>
                                        <option @if ($otherexpense->product_name == "Nakil") selected @else @endif value="Nakil">Nakil</option>
                                        <option @if ($otherexpense->product_name == "Diğer") selected @else @endif value="Diğer">Diğer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slcType">@lang('fields.payment_type')</label>
                                    <select name="type" id="slcType" class="custom-select selectpicker">
                                        <option @if ($otherexpense->type == "1") selected @else @endif value="1">Nakit</option>
                                        <option @if ($otherexpense->type == "2") selected @else @endif value="2">Pos</option>
                                        <option @if ($otherexpense->type == "3") selected @else @endif value="3">Havale</option>
                                        <option @if ($otherexpense->type == "4") selected @else @endif value="4">Online(Moka)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtDescription">@lang('fields.description')</label>
                            <textarea name="description" id="txtDescription" class="form-control"
                                rows="3">{{ $otherexpense->description}}</textarea>
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
