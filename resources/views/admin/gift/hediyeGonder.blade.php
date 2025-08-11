@extends('admin.layout.main')

@section('title', meta_title('Hediye'))

@section('content')
    <div class="row">
        <div class="col-12">
            
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('Akıllı Bileklik Hediye')</h4>
                    </div>
                         <!--tarih-->
                            <div class="card-footer row">                   
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcbitistarihi">Müşteri</label>
                                    <input type="text" name="start_date" id="start_date" value="{{ $paymentGift->isim }}" class="form-control" disabled>
                                </div>
                            </div>
                            <!--tarih-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcbitistarihi">Tarife</label>
                                    <input type="text" name="start_date" id="start_date" value="{{ $paymentGift->name }}" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    <form method="POST" action="{{relative_route('admin.hediyeGonderPost',$paymentGift->id)}}">
                @csrf        
                    <div class="card-body">
                        <div class="row">
						 <input type="hidden" value="{{ isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id }}" name="staff_id" class="form-control">
                         <input type="hidden" name="subscription_id" value="{{ $paymentGift->id }}" class="form-control">
                        </div>
						<!--Not-->
                        <div class="form-group">
                            <label for="txtDescription">Not</label>
                            <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                   
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </div>
                     </form>
                </div>
            
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
@endpush

@push('script')
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
@endpush

@push('script')
    <script>
        var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[4] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);
 
$(document).ready(function() {
    // Create date inputs
    minDate = new DateTime($('#min'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'MMMM Do YYYY'
    });
 
    // DataTables initialisation
    var table = $('#example').DataTable();
 
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });
});
    </script>
@endpush















