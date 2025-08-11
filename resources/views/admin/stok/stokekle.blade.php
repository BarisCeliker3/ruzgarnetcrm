@extends('admin.layout.main')

@section('title', meta_title('Stok Ekle'))

@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.stokekleme') }}">
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('Stok Ekle')</h4>

                        
                    </div>
                    <div class="card-body">
                        <div class="row">
							<!--kategori-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Kategori</label>
                                    <select name="kategori" id="kategori" class="custom-select selectpicker">
                                        @foreach($stok_kategoris as $stoktable)
                                               <option value="{{$stoktable->id}}">{{$stoktable->name}}</option>
                                          @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!--Model-->
                       
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Model</label>
                                    <input type="text" name="model" class="form-control" required>
                                </div>
                            </div
                            
                            <!--Stok-->
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="slcExpense_name">Stok Adet</label>
                                    <input type="number" name="stok_adet" min="0" class="form-control" required>
                                </div>
                            </div
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
    <script>
        var data = [
  {
    "il": "Modem",
    "plaka": 1,
    "ilceleri": [
      "Adsl",
      "Vdsl",
      "Fiber"
    ]
  },
  {
    "il": "Akıllı Saat",
    "plaka": 2,
    "ilceleri": [
      "A",
      "B",
      "C"
    ]
  },
  {
    "il": "Uydu Modem",
    "plaka": 3,
    "ilceleri": [
      "A1",
      "B1",
      "C1"
    ]
  }
]
function search(nameKey, myArray){
    for (var i=0; i < myArray.length; i++) {
        if (myArray[i].plaka == nameKey) {
            return myArray[i];
        }
    }
}
$( document ).ready(function() {
  $.each(data, function( index, value ) {
    $('#Iller').append($('<option>', {
        value: value.plaka,
        text:  value.il
    }));
  });
  $("#Iller").change(function(){
    var valueSelected = this.value;
    if($('#Iller').val() > 0) {
      $('#Ilceler').html('');
      $('#Ilceler').append($('<option>', {
        value: 0,
        text:  'Lütfen Bir İlçe seçiniz'
      }));
      $('#Ilceler').prop("disabled", false);
      var resultObject = search($('#Iller').val(), data);
      $.each(resultObject.ilceleri, function( index, value ) {
        $('#Ilceler').append($('<option>', {
            value: value,
            text:  value
        }));
      });
      return false;
    }
    $('#Ilceler').prop("disabled", true);
  });
});
    </script>
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















