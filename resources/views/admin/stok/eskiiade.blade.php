@extends('admin.layout.main')

@section('title', meta_title('Eski Ürün İadeleri'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.eskiiadeEkle') }}">
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('Eski Ürün İadeleri')</h4>
                      
                     
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Müşteri</label>
                                    <select name="customers_name" id="customers_name" class="custom-select selectpicker">
                                        <option selected disabled>Müşteri Seç</option>
                                         @foreach($customers as $customer)
                                           <option value="{{$customer->first_name}} {{$customer->last_name}}">{{$customer->first_name}} {{$customer->last_name}}</option>
                                          @endforeach
                                    </select>
                                </div>
                            </div>
						 <input type="hidden" value="{{ isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id }}" name="staff_id" class="form-control" required>
                            
							<!--Stok-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Kategori</label>
                                    <select name="stok_id" id="stok_id" class="custom-select selectpicker" required>
                                        <option selected disabled>kategori Seç</option>
                                          @foreach($stoktables21 as $stoktable2)
                                            @if($stoktable2->stok_adet ==0)
                                            <option disabled>{{$stoktable2->model}}</option>
                                            @else
                                             <option value="{{$stoktable2->id}}">{{$stoktable2->model}}</option>
                                            @endif
                                          @endforeach
                                    </select>
                                </div>
                            </div>
                        <!--Stok-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Seri No</label>
                                    <input type="text" name="serino" id="serino"  class="form-control">
                                </div>
                            </div>
                            
                            <!--Durum-->
                             <input type="hidden" name="status" id="status" value="Eski İade" class="form-control" required>
                             
                          <!--  <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Durum</label>
                                    <select name="status" id="status" class="custom-select selectpicker" required>
                                        <option selected disabled>Durum Seç</option>
                                        <option value="Satılık">Satılık</option>
                                        <option value="Kiralık">Kiralık</option>
                                    </select>
                                </div>
                            </div>  -->
                            
                            <!--Ödeme-->
                             <input type="hidden" name="payment" id="payment" value="Eski İade" class="form-control" required>
                           <!-- <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Ödeme Türü</label>
                                    <select name="payment" id="payment" class="custom-select selectpicker">
                                        <option selected disabled>Ödeme Türü Seç</option>
                                        <option value="Nakit">Nakit</option>
                                        <option value="Havale">Havale</option>
                                        <option value="Kiralık">Kiralık</option>
                                        <option value="Moka">Moka</option>
                                    </select>
                                </div>
                            </div>  -->
                           
                            <!--Tutar-->
                            <input type="hidden" name="price" id="price" value="0" class="form-control" required>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcbitistarihi">Tarih</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                            </div>
                            
                        	<!--adet-->
                            <div class="col-lg-6">
                               <input type="hidden" name="stok_adet" id="stok_adet" value="1" class="form-control">
                            </div>
                        </div>
						<!--Not-->
                        <div class="form-group">
                            <label for="txtDescription">Not</label>
                            <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Kaydet</button>
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















