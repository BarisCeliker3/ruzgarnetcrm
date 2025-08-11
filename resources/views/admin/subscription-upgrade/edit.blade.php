@extends('admin.layout.main')

@section('title', meta_title('tables.subscription_upgrade.edit'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.subscriptionupgrade.edit.put', $subscriptionupgrade) }}">
                @method('put')
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('tables.subscription_upgrade.edit')</h4>

                        <div class="card-header-buttons">
                            <a href="{{ route('admin.subscriptionupgrades') }}" class="btn btn-primary"><i
                                    class="fas fa-sm fa-list-ul"></i> @lang('tables.subscription_upgrade.title')</a>
                        </div>
                    </div>

                    <div class="card-body">


                        <div class="form-group">
                            <label for="inpName">@lang('fields.name')</label>
                            <input disabled type="text" name="name" id="inpName" class="form-control"
                                value="{{ $subscription[0]->customer->full_name }}">
                        </div>
                        <div class="form-group">
                            <label for="inpService">@lang('fields.name')</label>
                            <input disabled type="text" name="service" id="inpService" class="form-control"
                                value="{{ $subscription[0]->service->name }}">
                        </div>

                        <div class="form-group">
                            <label for="txtDescription">@lang('fields.message')</label>
                            <textarea name="description" id="txtDescription" class="form-control"
                                rows="3">{{$subscriptionupgrade->description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="slcStatus">@lang('fields.request_role')</label>
                            <select name="status" id="slcStatus" class="custom-select selectpicker">

                                @foreach(trans('tables.subscription_upgrade.status') as $key => $status)
                                    <option @if ($subscriptionupgrade->status==$key) selected @else @endif value="{{ $key }}">{{ $status }}</option>
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
