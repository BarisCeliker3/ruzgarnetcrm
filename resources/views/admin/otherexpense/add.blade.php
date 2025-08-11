@extends('admin.layout.main')

@section('title', meta_title('tables.otherexpense.add'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.otherexpense.add.post') }}">
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
                        <div class="row">
							<!--Tutar-->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="inpPrice">Giderler</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="price" id="inpPrice"
                                            class="form-control money-input" min="0" step=".01">
                                    </div>
                                </div>
                            </div>
							<!--Hizmetler-->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="slcExpense_name">@lang('fields.expensename')</label>
                                    <select name="expense_name" id="slcExpense_name" class="custom-select selectpicker">
                                        <option selected disabled>@lang('fields.expensename')</option>
                                        <option value="1">Yakıt</option>
                                        <option value="2">Mutfak Gideri</option>
                                        <option value="3">Diğer Giderler</option>
                                        <option value="4">Pos</option>
                                        <option value="5">Dekont</option>
                                    </select>
                                </div>
                            </div>
                        </div>
						<!--Açıklama-->
                        <div class="form-group">
                            <label for="txtDescription">@lang('fields.description')</label>
                            <textarea name="description" id="txtDescription" class="form-control"
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
