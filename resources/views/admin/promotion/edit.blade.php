@extends('admin.layout.main')

@section('title', meta_title('tables.promotion.edit'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.promotion.edit.put', $promotion) }}">
                @method('put')
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
                            <label for="inpStaff">Personel</label>
                            <input type="text" name="staff_id" id="inpStaff" class="form-control" disabled
                            value="{{$promotion->staff->full_name}}">
                        </div>

                        <div class="form-group">
                            <label for="inpCustomer">Müşteri</label>
                            <input type="text" name="subscription_id" id="inpCustomer" class="form-control" disabled
                            value="{{$promotion->subscription->customer->full_name}}">
                        </div>

                        <div class="form-group">
                            <label for="inpPromotion">Promosyon</label>
                            <input type="text" name="promotion_name" id="inpPromotion" class="form-control" disabled
                            value="{{$promotion->promotion_name}}">
                        </div>

                        <div class="form-group">
                            <label for="txtDescription">@lang('fields.description')</label>
                            <textarea name="promotion_description" id="txtDescription" class="form-control"
                                rows="3">{{$promotion->promotion_description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="slcStatus">@lang('fields.request_role')</label>
                            <select name="status" id="slcStatus" class="custom-select">

                                @foreach(trans('tables.promotion.status') as $key => $status)
                                    <option @if ($promotion->status==$key) selected @else @endif value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
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
