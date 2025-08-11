@extends('admin.layout.main')

@section('title', meta_title('Stok Düzenle'))

@section('content')
    <div class="section-header">
        <h1>Stok Güncelleme</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{relative_route('admin.stokPost',$stok_tables->id)}}">
                TEST
                @csrf
                <div class="card form">
                    <div class="card-body">
                        <div class="row">
							<!--kategori-->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label style="color:blue;font-size:16px;" for="slcExpense_name">Kategori</label>
                                    <select name="kategori" id="kategori" class="custom-select selectpicker" disabled>
                                               @if($stok_table->kategori == 1)
                                               <option value="{{$stok_table->kategori}}">MODEM</option>
                                               @elseif($stok_table->kategori == 2)
                                               <option value="{{$stok_table->kategori}}">AKSESUARLAR</option>
                                               @elseif($stok_table->kategori == 3)
                                               <option value="{{$stok_table->kategori}}">CİHAZLAR</option>
                                               @elseif($stok_table->kategori == 4)
                                               <option value="{{$stok_table->kategori}}">UYDU SİSTEMİ</option>
                                               @else
                                               <option value="{{$stok_table->kategori}}">{{$stok_table->kategori}}</option>
                                               @endif
                                    </select>
                                </div>
                            </div>
                            
                            <!--Model-->
                       
                             <div class="col-lg-6">
                                <div class="form-group" disabled>
                                    <label style="color:blue;font-size:16px;" for="slcExpense_name">Model</label>
                                    <input type="hidden" value="{{$stok_table->model}}" name="model" class="form-control">
                                    <input type="text" value="{{$stok_table->model}}" class="form-control" disabled>
                                </div>
                            </div
                            
                            <!--Stok-->
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label style="color:blue;font-size:16px;" for="slcExpense_name">Stok Adet</label>
                                    <input type="number" value="{{$stok_table->stok_adet}}" name="stok_adet" min="0" class="form-control">
                                </div>
                            </div
                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <button style="font-size:16px;" type="submit" class="btn btn-primary">Güncelle</button>
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

















