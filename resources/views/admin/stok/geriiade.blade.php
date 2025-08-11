@extends('admin.layout.main')

@section('title', meta_title('Stok Müşteri Geri İade'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{relative_route('admin.stoklistPost2',$stok_takip->id)}}">
                @csrf
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('Stok Müşteri Geri İade')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Müşteri</label>
                                    <input type="text" name="customers_name" id="customers_name" value="{{ $stok_takip->customers_name }}" class="form-control" disabled>
                                </div>
                            </div>
						 <input type="hidden" value="{{ isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id }}" name="staff_id" class="form-control">

                         <input type="hidden" name="stok_id" id="stok_id" value="{{ $stok_takip->stok_id }}" class="form-control">
                 
                            <!--Stok-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Kategori</label>
                                    <select name="stok_id" id="stok_id" class="custom-select selectpicker" disabled>
                                        @foreach ($stok_tables as $stok_table)
                                           <option value="{{ $stok_table->id }}" @if ($stok_table->id == $stok_takip->stok_id) selected @endif>{{ $stok_table->model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!--Durum-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Durum</label>
                                    <select name="status" id="status" class="custom-select selectpicker" disabled>
                                        <option value="Geri İade">Geri İade</option>
                                    </select>
                                </div>
                            </div>
                             <input type="hidden" name="status" id="status" value="Geri İade" class="form-control">
                            
                            <!--Ödeme-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Ödeme Türü</label>
                                    <select name="payment" id="payment" class="custom-select selectpicker" disabled>
                                        <option selected disabled>{{ $stok_takip->payment }}</option>
                                        <option @if($stok_takip->payment==='Nakit')  selected @endif value="Nakit">Nakit</option>
                                        <option @if($stok_takip->payment==='Havale') selected @endif value="Havale">Havale</option>
                                        <option @if($stok_takip->payment==='Kiralık')  selected @endif value="Kiralık">Kiralık</option>
                                    </select>
                                </div>
                            </div>
                           <input type="hidden" name="payment" id="payment" value="{{ $stok_takip->payment }}" class="form-control">
                           <input type="hidden" name="serino" id="serino" value="{{ $stok_takip->serino }}" class="form-control">
                            <!--Tutar-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inpPrice">Fiyat</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="price" id="inpPrice" 
                                            class="form-control money-input" value="{{ $stok_takip->price }}" min="0" step=".01" disabled>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="price" id="price" value="{{ $stok_takip->price }}" class="form-control">
                            
                            <!--tarih-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcbitistarihi">Tarih</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ $stok_takip->start_date }}" class="form-control" disabled>
                                </div>
                            </div>
                            <input type="hidden" name="start_date" id="start_date" value="{{ $stok_takip->start_date }}" class="form-control">
                            <!--adet-->
                            <div class="col-lg-6">
                                
                                    <input type="hidden" name="stok_adet" id="stok_adet" value="{{ $stok_takip->stok_adet }}" class="form-control">
                                
                            </div>

                            
                        </div>
						<!--Not-->
                        <div class="form-group">
                            <label for="txtDescription">Not</label>
                            <textarea name="note" id="note" class="form-control" rows="3">{{ $stok_takip->note }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">İade Et</button>
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















