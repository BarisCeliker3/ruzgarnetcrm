@extends('admin.layout.main')

@section('title', meta_title('Pos Evrakları'))

@section('content')
    <div class="row">
        <div class="col-12">
            
       
    <!-- START HAZIRLIK -->
            <div class="card list">
                <div class="card-header">
                  
                    <h4 style="font-size:22px;"> 
                    <span class="gider-bsl" style="color:#67b030;"> POS </span></h4>
                </div>
                
                <hr style="border-bottom:2px solid #ff6347;">
                                
     <div class="card-body">
                    <div class="table-responsive">
                         <table class="table table-striped" id="dataTable">
                            <thead style="font-size:15px;background:#67b030;">
								<tr>
                                    <th style="color:#2a4a11" scope="col">#</th>
                                    <th style="color:#2a4a11;" scope="col">Fatura</th>
                                    <th style="color:#2a4a11;" scope="col">Fiyat</th>
                                    <th style="color:#2a4a11;" scope="col">Not</th>
                                    <th style="color:#2a4a11;" scope="col">Personel</th>
                                    <th style="color:#2a4a11;" scope="col">Tarih</th>
                                </tr>
                            </thead>
                            <tbody>

                               @foreach($expens as $expen)
                                    <tr>
                                        <th scope="row"><span class="text-black"> {{ $loop->iteration }}</span></th>
                                        <td>@if($expen->image)
                                            <span class="btn btn-outline-secondary badge-pill"> 
                                               <a href="/dekont/{{$expen->image}}" target="_blank">
                                                 <i class="fa fa-turkish-lira text-danger" aria-hidden="true" title="Pos" style="font-size:35px;"></i>
                                               </a>
                                             </span>
                                             @else
                                             <span style="font-size:15px;" class="badge badge-pill badge-secondary">BOŞ</span>
                                             @endif
                                        </td>
                                       
                                        <td><span style="font-size:16px" class="badge badge-pill badge-success">{{number_format($expen->price,2,'.',',')}} ₺</span></td>
                                        <td><span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true"  data-placement="right" title="{{ $expen->note }}">
                                              <button class="btn btn-info badge-pill" style="pointer-events: none; font-size:16px" type="button" disabled>Not</button>
                                            </span></td>
                                        <td>{{ $expen->first_name }} {{ $expen->last_name }}  </td>
                                        <td title="{{ $expen->start_date }}">{{ \Carbon\Carbon::parse($expen->start_date)->format('m Y') }} </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
    <!-- END HAZIRLIK -->   
   
   
            
        </div>
        
        
                @php 
    $labelsabone17 = "";
    $dataabone17 = "";

    
    
    foreach($posRapor as $mutfakRapo){
        $labelsabone17.= "\"$mutfakRapo->created_at\",";
        $dataabone17.= "$mutfakRapo->id,";

    }
        @endphp
                
      <div class="gider-tablosu col-12">
        <div id="ocak" class="gider-tablo tabcontent">
            <h1 class="text-dark"> <span  class="text-dark">2023 Yılı <span style="color:#63a92e;">POS</span> Gider Raporu</span></h1>
        	<div class="col-md-12 bg-light text-dark">
              <canvas id="myChart"  style="position: relative; height:40vh; width:80vw"></canvas>
            </div>
        </div>
    </div>

    </div>

@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'><link rel="stylesheet" href="./style.css">
    <style>
    .gider-tablosu{
        
    }
    .gider-tablo{
        padding:20px;
        background:#fff!important;
    }
  
    
    
    
    .pdf-btn{
        font-size:14px!important;
        background: #ed2626;
        color:#fff;
        padding:4px 10px;
    }
    .pdf-btn:hover{
        color: #fff;
        background: #ad0c0c!important;
    }
    .zoom{
         transition: transform .2s;
         text-align: center;
    }
    .zoom:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(1.2); 
      text-align: center;
      position:relative;
      z-index:99999999999;
    }
    
</style>
    
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
    
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>


<script>
Function.prototype.bind = Function.prototype.bind || function (thisp) {
  var fn = this;
  return function () {
    return fn.apply(thisp, arguments);
  };
};

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Mayıs', 'Haziran', 'Temmuz','Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
        datasets: [{
            label: '# Toplam Gider',
            data: [{!! $dataabone17 !!}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
   
      
  <script>
$(document).ready(function(){
    $('.counter-value').each(function(){
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        },{
            duration: 3500,
            easing: 'swing',
            step: function (now){
                $(this).text(Math.ceil(now));
            }
        });
    });
});
    </script>
    
    <script>
$(document).ready(function() {
    $('#options').select2();
});
</script>



@endpush

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('script')
    <script src="/assets/admin/vendor/slugify/slugify.js"></script>
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/admin/vendor/cleave/cleave.min.js"></script>
    <script src="/assets/admin/vendor/vue/vue.min.js"></script>

   
    
    <script type="text/javascript">
  var query=<?php echo json_encode((object)Request::only(['services','options'])); ?>;
//search ara butonu

  function search_post(){

           Object.assign(query,{'service': $('#service_filter').val()});
           Object.assign(query,{'options': $('#options_filter').val()});

            window.location.href="{{route('admin.contractendings')}}?"+$.param(query);

  }

</script>

@endpush
@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/Buttons-1.7.1/css/buttons.dataTables.min.css">
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    <script src="/assets/admin/vendor/datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>

       <script>
         $(function() {
            $("#dataTable").dataTable({
                language: {
                    url: '/assets/admin/vendor/datatables/i18n/tr.json'
                },
                columnDefs: [{
                    "type": "num",
                    "targets": 0
                },{ "orderable": false, "targets": [1, 2, 3, 4] }],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 2 && column[0][0] != 3 && column[0][0] != 6)
                        {
                            var select = $('<select class="form-control text-white" style="background:#2a4a11;width:100px;"><option value="">TÜMÜ</option></select>')
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
            });
        })

    </script>
    



    
    <script>
        $(function() {
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            alert()->success('Başarılı!', 'Makaleniz Başarılı Bir Şekilde oluşturuldu.');
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
    </script>
    

    
<script>
    $(function checkRegistration() {
        $('#btnSave').on('click', function (event) {
            //alert()->success('Başarılı!', 'Makaleniz Başarılı Bir Şekilde oluşturuldu.');
           alert('Given data is incorrect21');
             return redirect();
            // relative_route('admin.contractending.store')
        });

    });

</script>

@endpush



