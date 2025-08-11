@extends('admin.layout.main')

@section('title', meta_title('Kod Mesajı Düzenle'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.code.message_edit.put') }}">
                @method('put')
                <div class="card form">
                    <div class="card-header">


                        <div class="card-header-buttons">
                            <a href="{{ route('admin.codes') }}" class="btn btn-primary"><i
                                    class="fas fa-sm fa-list-ul"></i> @lang('tables.code.title')</a>
                        </div>
                    </div>
                    <div class="card-body">


                        <div class="form-group">
                            <label for="txtMessage">@lang('fields.message')</label>
                            <textarea name="message" id="txtMessage" class="form-control"
                                rows="3">{{$code_message->message}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="slcType">@lang('fields.code')</label>
                            <select name="type" id="slcType" class="custom-select">

                                @foreach(trans('tables.code.type') as $key => $type)
                                    <option @if ($code_message->type==$key) selected @else @endif value="{{ $key }}">{{ $type }}</option>
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
