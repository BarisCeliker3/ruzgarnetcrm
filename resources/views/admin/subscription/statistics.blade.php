@extends('admin.layout.main')

@section('title', meta_title('tables.subscription.subscriber_statistics'))

@section('content')
    <div class="row">
        <div class="col-12">
            
            <div class="card list">
                    <h4 class="text-center">@lang('tables.subscription.sub_stats_bw_dates')</h4>
                    <p class="text-center">Bu sayfada iki tarih aralığında sisteme dahil olan müşteri sayısını görüntüleyebilirsiniz. <span class="text-warning">Soldaki tarihin sağdakinden küçük olmasına dikkat ediniz. Öntanımlı olarak bulunduğumuz ayın başından, sayfanın görüntülendiği ana kadarki kazanılmış müşteri sayısını gösterilir.</span></p>
                    <p class="text-danger text-center">Sorgulama sonucunda elde edilen verilerin fazla olabileceği gözönüne alınarak, seçilen tarihler arasındaki gün sayısı 100 gün ile sınırlandırılmıştır.</p>
                    <h5 class="text-danger text-center">{{$startDate}} - {{$endDate}} tarihleri arasında aboneliği onaylananlar</h5>
                    <div class="card-header">
                        <form method="POST" action="{{ route('admin.subscription.subscriber_statistics') }}" data-ajax="false" class="card-header-buttons">
                            @csrf
                            <label for="first_date"><b>Başlangıç Tarihi:</b> </label>
                            <input type="date" name="first_date" id="first_date" class="form-control" value="{{ $date ?? '' }}" required>
                            <label for="end_date"><b>Bitiş Tarihi: </b></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $date ?? '' }}" required>
                            <button type="submit" id="sortByDates" name="sortByDates" class="btn btn-primary">Listele</button>
                        </form>
                    </div>
                    
                    
                    <div class="card-body mb-2">
                        <p>Toplam kayıt sayısı: {{ $numberOfSubscribers }}</p>
                        @if($subscribers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ADI</th>
                                        <th scope="col">SOYADI</th>
                                        <th scope="col">TELEFON NO.</th>
                                        <th scope="col">TARİFE ADI</th>
                                        <th scope="col">ÇALIŞAN İSİM - SOYİSİM</th>
                                        <th scope="col">ONAY TARİHİ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscriber)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $subscriber->first_name }}</td>
                                        <td>{{ $subscriber->last_name }}</td>
                                        <td>{{ $subscriber->telephone }}</td>
                                        <td>{{ $subscriber->service_name}}</td>
                                        <td>{{ $subscriber->staffs_full_name}}</td>
                                        <td>{{ $subscriber->approved_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <h4 class="text-danger text-center">{{ $startDate }} - {{ $endDate }} aralığında müşteri bulunamadı!</h4>
                        @endif
                        
                        <div class="bg-primary border border-primary my-4">
                            <h4 class="text-warning">KAYIT GİREN ÇALIŞANIN GÜNLERE GÖRE ABONELİK GİRME SAYISI</h4>
                            <h4 class="text-danger">YAPIM AŞAMASINDADIR, BAZI KİLİT ÖZELLİKLER TATBİK EDİLECEĞİNDEN BİRKAÇ GÜN SÜREBİLİR..!</h4>
                        @foreach($staff as $staffs)
                            <div class="my-4 bg-warning pe-auto">{{ $staffs->staffs_full_name }}</div>
                        @endforeach
                        
                        

                        
                        
                        
                        
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
        pageLength: 50,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json',
        },
        buttons: [
            'excel', 'pdf'
        ],
        initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] == 4 || column[0][0] == 5) {
                            var select = $('<select class="form-control" style="width:280px;"><option value="">Tümü</option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        }
                    } );
                }
    } );

    $('#first_date').change(function() {
        var first_date = new Date($('#first_date').val());
        var end_date = new Date($('#end_date').val());
        var diff = end_date - first_date;
        var days = diff/1000/60/60/24;
        // end - start returns difference in milliseconds 
        //console.log("first_date = ", first_date, "\n");
        //console.log("end_date = ", end_date, "\n");
        if(end_date < first_date)
        {
            alert("Sol kutudaki tarih, sağdakinden küçük olmalıdır.");
            $('#first_date').val("");
            $('#end_date').val("");
        }
        else
        {
          if(Date.parse(first_date) && Date.parse(end_date))
            {
                if(days > 100)
                {
                    alert("Tarih aralığı 100 günü geçemez.");
                    $('#first_date').val("");
                    $('#end_date').val("");                    
                }
            }
        }
    });



    $('#end_date').change(function() {
        var first_date = new Date($('#first_date').val());
        var end_date = new Date($('#end_date').val());
        var diff = end_date - first_date;
        var days = diff/1000/60/60/24;
        //console.log("first_date = ", first_date, "\n");
        //console.log("end_date = ", end_date, "\n");
        if(end_date < first_date)
        {
            alert("Başlangıç tarihi, bitiş tarihinden küçük olmalıdır.");
            $('#first_date').val("");
            $('#end_date').val("");
        }
        else
        {
          if(Date.parse(first_date) && Date.parse(end_date))
            {
                if(days > 100)
                {
                    alert("Tarih aralığı 100 günü geçemez.");
                    $('#first_date').val("");
                    $('#end_date').val("");
                }

            }
        }
    });
    
    
});   
</script>



@endpush
