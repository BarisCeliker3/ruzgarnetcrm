@extends('admin.layout.main')

@section('title', meta_title('tables.subscription.extend_subscribers_end_date'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4 class="text-center">{{ $convertedDate }} tarihinde abonelik süresi bitenler</h4>
                    <form method="POST" action="{{ route('admin.subscription.extend_subscribers_end_date') }}" data-ajax="false" class="card-header-buttons">
                        @csrf
                        <input type="date" name="date" name="dtDate" class="form-control" value="{{ $date ?? date('Y-m-15') }}">
                        <button type="submit" class="btn btn-primary">Listele</button>
                    </form>
                </div>
                <div class="card-body">
                    <div>
                    <div class="bg-danger container-fluid col-8 rounded">
                        <h4 class="text-center text-white"><u>GİRİŞ</u></h4>
                        <p class="text-center text-white">Bu sayfa, abonelik süresi sona erdiği halde, aktif olan abonelikleri listeletmek amacıyla yapılmıştır. Manuel kontrollerde gözden kaçan bu durumun ortadan kalkması ve otomatik olarak tarih güncellenmesi yapılmayan aboneliklerin tespiti amaçlanmıştır.</p>
                        <h4 class="text-center text-white">KULLANIM</h4>
                        <p class="text-center text-white">Hiç tarih seçmeden açıldığında, aboneliği bulunulan günde biten, ancak halen aktif olan abonelikleri gösterir. Seçilen tarihe ait listeleme yapılabilmektedir. Veritabanına müdahil olmadan abonelik süresi uzatılabilmektedir. İlgili aboneliğin bulunduğu satırdaki "Güncelle" kutusu tıklandıktan sonra, ufak bir güncelleme formu görünür hale gelir. Bu formda aboneliğin uzatılacağı tarihin girilebileceği kutudan tarih seçildikten sonra yeşil butona tıklandığında güncelleme yapılabilmektedir. Amaç, süreden tasarruf.</p>
                    </div>  
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Müşteri ID</th>
                                    <th scope="col">İsim - Soyisim</th>
                                    <th scope="col">Telefon</th>
                                    <th scope="col">Tarife İsmi</th>
                                    <th scope="col">Kaç Ay</th>
                                    <th scope="col">Bitiş Tarihi</th>
                                    <th scope="col">Güncelle</th>
                                    <th scope="col" id="updateFormHeader">Güncelleme Formu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($missedSubscribers as $l30)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <th><a href="https://crm.ruzgarnet.site/customer/{{ $l30->customer_id }}"/>{{ $l30->customer_id }}</a></th>
                                        <td>{{ $l30->customer_first_name }} {{ $l30->customer_last_name }}</td>
                                        <td>{{ $l30->customer_tel}}</td>
                                        <td>{{ $l30->service_name }}</td>
                                        <td>{{ $l30->commitment }}</td>
                                        <td>{{ $l30->end_date }}</td>
                                        <td>  <input type="checkbox" id="{{ $l30->customer_id }}" name="updateCheck" value="updateCheck">
                                              <label for="updateCheck">Güncelle</label><br>
                                        </td>
                                        <td id="updateFormContent">
                                            <form name="updateForm" id="form{{ $l30->customer_id }}" method="POST" data-ajax="false" action="{{ route('admin.subscription.finish_extend_transaction') }}">
                                                @csrf
                                                <input type="date" name="updateDate" id="date{{ $l30->customer_id }}" name="updateDate" class="form-control" value="" required>
                                                <input type="hidden" name="subscription_id" id="subscription_id" value="{{$l30->subscription_id}}">
                                                <input type="hidden" name="previous_date" id="previous_date" value="{{ $convertedDate }}">
                                                <button type="submit" id="submit{{ $l30->customer_id }}" class="btn btn-success">Güncelle</button>
                                            </form>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@push('script')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // Get all forms which is named as updateForm
        const forms = document.getElementsByName('updateForm');
        const updateDates = document.getElementsByName('updateDate');
        for(let i=0; i < forms.length; i++)
        {
            forms[i].style.visibility = 'hidden';
            updateDates[i].style.visibility = 'hidden';
        }
        // Checkboxes and transactions related with relevant checkboxes
        const checkboxes = document.getElementsByName('updateCheck');
        let isVisible = false;
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
            checkboxes[i].addEventListener('change', (event) => {
              const button = document.getElementById(`submit${event.currentTarget.id}`); 
              const form = document.getElementById(`form${event.currentTarget.id}`);
              const date = document.getElementById(`date${event.currentTarget.id}`);
              if (event.currentTarget.checked) {
                    button.style.visibility = "visible";
                    form.style.visibility = "visible";
                    date.style.visibility = "visible";
              } else {
                    button.style.visibility = "hidden";
                    form.style.visibility = "hidden";
                    date.style.visibility = "hidden";
              }
            })
        }
    })
</script>
@endpush





