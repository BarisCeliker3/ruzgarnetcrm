@extends('admin.layout.main')

@section('title', meta_title('tables.accounting.add'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.accounting.add.post') }}">
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('tables.accounting.add')</h4>

                        
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inpFirstName">İsim Soyisim</label>
                                    <input type="text" name="name_surname" id="inpFirstName" class="form-control">
                                    <input type="hidden" name="payment_type" id="payment_type" value="1" class="form-control">
                                    <input type="hidden" value="{{ isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id }}" name="staff_id" class="form-control" required>
                                </div>
                            </div>
						
                            
							<!--İçerik-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">İçerik</label>
                                    <select name="contents" id="contents" class="custom-select selectpicker">
                                        <option selected disabled>İçerik Seç</option>
                                        <option value="1">Fatura</option>
                                        <option value="2">Ödeme Fazlası</option>
                                        <option value="3">Diğerleri</option>
                                        <option value="4">Önceki Ay Ödemesi</option>
                                        <option value="5">Açık Kalanlar</option>
                                    </select>
                                </div>
                            </div>
                            <!--Banka-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Banka</label>
                                    <select name="bank" id="bank" class="custom-select selectpicker">
                                        <option selected disabled>Banka Seç</option>
                                        <option value="1">TEB Bankası</option>
                                        <option value="2">Halk Bankası</option>
                                        <option value="3">PTT</option>
                                        <option value="4">Geriden Ödeme</option>
                                        <option value="5">Garanti Bankası</option>
                                    </select>
                                </div>
                            </div>
                            <!--Ödeme Tipi
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Ödeme Tipi</label>
                                    <select name="payment_type" id="payment_type" class="custom-select selectpicker">
                                        <option selected disabled>Ödeme Seç</option>
                                        <option value="1">Post</option>
                                        <option value="2">Havale</option>

                                    </select>
                                </div>
                            </div>
                            -->
                            	<!--Tutar-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inpPrice">Tutar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="price" id="inpPrice"
                                            class="form-control money-input" min="0" step=".01">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcbitistarihi">Tarih</label>
                                    <input type="date" name="date" id="slcbitistarihi" class="form-control">
                                </div>
                            </div>
                        </div>
						<!--Not-->
                        <div class="form-group">
                            <label for="txtDescription">@lang('fields.description')</label>
                            <textarea name="note" id="txtDescription" class="form-control"
                                rows="3"></textarea>
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















