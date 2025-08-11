@extends('admin.layout.main')

@section('title', meta_title('tables.customer.note.add'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.customer.note.add.post',$customer) }}">
                <div class="card form">
                    <div class="card-header">
                        <h4></h4>


                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="txtNote">@lang('fields.note')</label>
                            <textarea name="note" id="txtNote" class="form-control"
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
