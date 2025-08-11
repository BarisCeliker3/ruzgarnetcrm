@extends('admin.layout.main')

@section('title', meta_title('tables.spending.edit'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.spending.edit.put',$spending) }}">
                @method('put')
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('tables.spending.edit')</h4>

                        <div class="card-header-buttons">
                            <a href="{{ route('admin.spendings') }}" class="btn btn-primary">
                                <i class="fas fa-sm fa-list-ul"></i> @lang('tables.spending.title')
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inpPrice">@lang('fields.price')</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="price" id="inpPrice"
                                            class="form-control money-input" min="0" step=".01" value="{{ $spending->price }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inpTitle">@lang('fields.title')</label>
                                    <div class="input-group">

                                        <input type="text" v-model="title" name="title" id="inpTitle"
                                            class="form-control" value="{{ $spending->title }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="txtDescription">@lang('fields.description')</label>
                            <textarea name="description" id="txtDescription" class="form-control"
                                rows="3">{{ $spending->description}}</textarea>
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
