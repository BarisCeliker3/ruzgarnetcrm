@extends('admin.layout.main')



@section('title', meta_title('tables.contractending.title'))



@section('content')

    <div class="row">

        <div class="col-12">

            

        <!-- START Sözleşmenin Bitmesine 43-45 Gün Kalan -->

            <div class="card list">

                <div class="card-header">

                    <h4>Sözleşmenin Bitmesine 43-45 Gün Kalan  <span class="text-white">Güncellenmiş</span> Aboneler</h4>

                     <p>Modem: <span class="text-white">1-YOK / 2-ADSL / 3-VDSL / 4-FİBER / 5-UYDU</span>  / <span class="text-white">7.KENDİ MODEMİ</span></p>



                <!--    <div class="card-header-buttons">

                        <a href="/contract-notes/1" class="btn btn-primary"><i

                            class="fas fa-sm fa-plus"></i>Not Ekle

                        </a>

                    </div>

                    -->

                </div>

                                

     <div class="card-body">

                <hr style="border-bottom:2px solid #6777ef;">

                    <div class="table-responsive">

                        <table class="table table-striped" id="dataTable">

                            <thead>

								<tr>

                                    <th scope="col">#</th>

                                    <th scope="col">İsim</th>

                                    <th scope="col">Tarife</th>

                                    <th scope="col">Telefon</th>

                                    <th scope="col">Modem</th>

                                    <th scope="col">Eski/Yeni</th>

                                    <th scope="col">Bitiş Tarihi</th>

                                    <th scope="col">Günceleyen Kişi</th>

                                    <th scope="col">Durum</th>

                                    <th scope="col">İşlemler</th>

                                </tr>

                            </thead>

                            <tbody>



                                @foreach ($subsupgrades as $subsupend)

                                    <tr>

                                        <th scope="row">{{ $loop->iteration }}</th>

                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subsupend->customer_id}}">{{ $subsupend->isim }}</a></td>

                                       <!-- <td>{{ $subsupend->temsilci}}</td> -->

                                        <td>{{ $subsupend->name }}</td>

                                        <td><span class="text-dark bg-white">{{ $subsupend->telephone}}</span></td>

                                        <td style="max-width:180px;">{{ $subsupend->Options }}</td>

                                        <td>@if($subsupend->price) 

                                             <span style="margin-bottom:5px;" class="badge badge-pill badge-light">{{$subsupend->payment_amount}} ₺</span>

                                            @endif 

                                            @if($subsupend->new_price) 

                                             <span class="badge badge-pill badge-info">{{$subsupend->new_price}} ₺</span>

                                            @endif 

                                        </td>

                                    

                                        <td>{{$subsupend->bitistarihi}} </td>

                                        <td>{{$subsupend->first_name}} {{$subsupend->last_name}}</td>

                                        <td>

                                        @if($subsupend->status =='0')

                                          <span  class="badge badge-pill badge-success">✓</span>

                                          @elseif($subsupend->status !='0')

                                          <span class="badge badge-pill badge-danger">2.✓</span>

                                        @endif

                                        </td>

                                        <td>

                <!-- <a style="margin-top: 5px; padding: 10px; font-size: 14px;" class="badge badge-pill badge-primary" href="{{route('admin.contractending.ekleme',$subsupend->id)}}"> Güncelle</a> -->

                                          <a target="_blank" style="margin-top: 5px; padding: 10px; font-size: 14px;" class="badge badge-pill badge-primary" href="https://crm.ruzgarnet.site/customer/{{$subsupend->customer_id}}"> Güncelle</a> 

                                       

                                        </td>

                                    </tr>

                                @endforeach



                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            

             <div class="card list">

                <div class="card-header">

                    <h4>Sözleşmenin Bitmesine 43-45 Gün Kalan  <span class="text-white">Güncellenmemiş</span> Aboneler<span style="display:none;">({{ $subsupgradesuc->count()}})</span></h4>

                     <p>Modem: <span class="text-white">1-YOK / 2-ADSL / 3-VDSL / 4-FİBER / 5-UYDU</span>  / <span class="text-white">7.KENDİ MODEMİ</span></p>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped" id="dataTable2">

                            <thead>

								<tr>

                                    <th scope="col">#</th>

                                    <th scope="col">İsim</th>

                                    <th scope="col">Tarife</th>

                                    <th scope="col">Telefon</th>

                                    <th scope="col">Modem</th>

                                    <th scope="col">Fiyat</th>

                                    <th scope="col">Bitiş Tarihi</th>

                                    <th scope="col">Durum</th>

                                    <th scope="col">İşlemler</th>

                                </tr>

                            </thead>

                            <tbody>



                                @foreach ($subsupgradesiki as $subsupendiki)

                                    <tr>

                                        <th scope="row">{{ $loop->iteration }}</th>

                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subsupendiki->customer_id}}">{{ $subsupendiki->isim }}</a></td>

                                        <td>{{ $subsupendiki->tarife }}</td>

                                        <td><span class="text-dark bg-white">{{ $subsupendiki->telephone}}</span></td>

                                        <td style="max-width:200px;">{{ $subsupendiki->Options }}</td>

                                        <td>@if($subsupendiki->price)

                                             <span class="badge badge-pill badge-light">{{$subsupendiki->price}} ₺</span>

                                            @endif 

                                        </td>

                                        <td>{{ $subsupendiki->bitistarihi }}</td>

                                        <td><span class="badge badge-pill badge-danger">GÜNCELLENMEMİŞ</span></td>

                                        <td>

                                          <a style="margin-top: 5px; padding: 10px; font-size: 14px;" class="badge badge-outline-pill badge-primary" href="{{route('admin.contractending.ekleme',$subsupendiki->id)}}"> Güncelle</a> 

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

    <!-- END Sözleşmenin Bitmesine 43-45 Gün Kalan -->   

    

<!-- 1 GÜNLÜK RZGR 45 KONTROL -->    

<!--

            <hr style="border-bottom:2px solid #6777ef;">

            <div class="card list">

                <div class="card-header">

                    <h4>Sözleşmenin Bitmesine 1 Gün Kalan Aboneler</h4>





                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped" id="dataTable3">

                            <thead>

								<tr>

                                    <th scope="col">#</th>

                                    <th scope="col">İsim</th>

                                    <th scope="col">Temsilci</th>

                                    <th scope="col">Tarife</th>

                                    <th scope="col">Telefon</th>

                                    <th scope="col">Modem</th>

                                    <th scope="col">Bitiş Tarihi</th>

                                </tr>

                            </thead>

                            <tbody>



                                @foreach ($subsupgradesuc as $subsupenduc)

                                    <tr>

                                        <th scope="row">{{ $loop->iteration }}</th>

                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subsupenduc->customer_id}}">{{ $subsupenduc->isim }}</a></td>

                                        <td>{{ $subsupenduc->temsilci}}</td>

                                        <td>{{ $subsupenduc->tarife }}</td>

                                        <td><span class="text-dark bg-white">{{ $subsupenduc->telephone}}</span></td>

                                        <td>{{ $subsupenduc->Options }}</td>

                                        <td>{{ $subsupenduc->bitistarihi }}</td>

                                        

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

      --> 

             <!-- START Sözleşmenin Bitmesine 30 Gün Kalan -->

            <div class="card list">

                <div class="card-header">

                    <h4>Sözleşmenin Bitmesine 29-30 Gün Kalan  <span class="text-white">Güncellenmiş</span> Aboneler</h4>

                     <p>Modem: <span class="text-white">1-YOK / 2-ADSL / 3-VDSL / 4-FİBER / 5-UYDU</span>  / <span class="text-danger">7.KENDİ MODEMİ</span></p>



                <!--    <div class="card-header-buttons">

                        <a href="/contract-notes/1" class="btn btn-primary"><i

                            class="fas fa-sm fa-plus"></i>Not Ekle

                        </a>

                    </div>

                    -->

                </div>

                                

     <div class="card-body">

                <hr style="border-bottom:2px solid #6777ef;">

                    <div class="table-responsive">

                        <table class="table table-striped" id="dataTable5">

                            <thead>

								<tr>

                                    <th scope="col">#</th>

                                    <th scope="col">İsim</th>

                                 <!--   <th scope="col">Temsilci</th> -->

                                    <th scope="col">Tarife</th>

                                    <th scope="col">Telefon</th>

                                    <th scope="col">Modem</th>

                                    <th scope="col">Eski/Yeni</th>

                                    <th scope="col">Bitiş Tarihi</th>

                                    <th scope="col">Günceleyen Kişi</th>

                                    <th scope="col">Durum</th>

                                    <th scope="col">İşlemler</th>

                                </tr>

                            </thead>

                            <tbody>



                                @foreach ($subsupgradesdort as $subsupgradesdortend)

                                    <tr>

                                        <th scope="row">{{ $loop->iteration }}</th>

                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subsupgradesdortend->customer_id}}">{{ $subsupgradesdortend->isim }}</a></td>

                                       

                                        <td>{{ $subsupgradesdortend->name }}</td>

                                        <td><span class="text-dark bg-white">{{ $subsupgradesdortend->telephone}}</span></td>

                                        <td style="max-width:180px;">{{ $subsupgradesdortend->Options }}</td>

                                        <td>@if($subsupgradesdortend->price) 

                                             <span style="margin-bottom:5px;" class="badge badge-pill badge-light">{{$subsupgradesdortend->price}} ₺</span>

                                            @endif 

                                            @if($subsupgradesdortend->new_price) 

                                             <span class="badge badge-pill badge-info">{{$subsupgradesdortend->new_price}} ₺</span>

                                            @endif 

                                        </td>

                                    

                                        <td>{{$subsupgradesdortend->bitistarihi}} </td>

                                        <td>{{$subsupgradesdortend->first_name}} {{$subsupgradesdortend->last_name}}</td>

                                        <td>

                                        @if($subsupgradesdortend->status =='0')

                                          <span  class="badge badge-pill badge-success">✓</span>

                                        @endif

                                        </td>

                                        <td>

                                          

                                         <!-- <a style="margin-top: 5px; padding: 10px; font-size: 14px;" class="badge badge-pill badge-primary" href="{{route('admin.contractending.ekleme',$subsupgradesdortend->id)}}"> Güncelle</a>  -->

                                          <a target="_blank" style="margin-top: 5px; padding: 10px; font-size: 14px;" class="badge badge-pill badge-primary" href="https://crm.ruzgarnet.site/customer/{{$subsupgradesdortend->customer_id}}"> Güncelle</a> 

                                        </td>

                                    </tr>

                                @endforeach



                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            

             <div class="card list">

                <div class="card-header">

                    <h4>Sözleşmenin Bitmesine 29-30 Gün Kalan  <span class="text-white">Güncellenmemiş</span> Aboneler</h4>

                     <p>Modem: <span class="text-white">1-YOK / 2-ADSL / 3-VDSL / 4-FİBER / 5-UYDU</span>  / <span class="text-white">7.KENDİ MODEMİ</span></p>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped" id="dataTable4">

                            <thead>

								<tr>

                                    <th scope="col">#</th>

                                    <th scope="col">İsim</th>

                                    <th scope="col">Tarife</th>

                                    <th scope="col">Telefon</th>

                                    <th scope="col">Modem</th>

                                    <th scope="col">Fiyat</th>

                                    <th scope="col">Bitiş Tarihi</th>

                                    <th scope="col">Durum</th>

                                    <th scope="col">İşlemler</th>

                                </tr>

                            </thead>

                            <tbody>
                                @if(count($subsupgradesbes) > 0)
                                <p>Veriler var!</p>
                            @else
                                <p>Hiç abonelik bulunamadı.</p>
                            @endif
                           
                                @foreach ($subsupgradesbes as $subsupgradesbesend)

                                    <tr>

                                        <th scope="row">{{ $loop->iteration }}</th>

                                        <td><a target="_blank" href="http://127.0.0.1:8000/customer/{{$subsupgradesbesend->customer_id}}">{{ $subsupgradesbesend->isim }}</a></td>

                                        <td>{{ $subsupgradesbesend->tarife }}</td>

                                        <td><span class="text-dark bg-white">{{ $subsupgradesbesend->telephone}}</span></td>

                                        <td style="max-width:200px;">{{ $subsupgradesbesend->Options }}</td>

                                        <td>@if($subsupgradesbesend->price)

                                             <span class="badge badge-pill badge-light">{{$subsupgradesbesend->price}} ₺</span>

                                            @endif 

                                        </td>

                                        <td>{{ $subsupgradesbesend->bitistarihi }}</td>

                                        <td><span class="badge badge-pill badge-danger">GÜNCELLENMEMİŞ</span></td>

                                        <td>

                                          <a style="margin-top: 5px; padding: 10px; font-size: 14px;" class="badge badge-outline-pill badge-primary" href="{{route('admin.contractending.ekleme',$subsupgradesbesend->id)}}"> Güncelle</a> 

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

      
        
        <!-- Formunuz -->
                <!-- Formunuz -->
              
          
        
        
            

        </div>



    </div>



@endsection



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

$(document).ready(function() {

    $('#options').select2();

});

</script>



    <script>

        $(function() {

            $("#dataTable2").dataTable({

                language: {

                    url: '/assets/admin/vendor/datatables/i18n/tr.json'

                },

                columnDefs: [{

                    "type": "num",

                    "targets": 0

                }],

                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',

                buttons: [

                    {

                        extend: 'excelHtml5',

                        title: 'Ödemeler'

                    }

                ]

            });

            

        })



    </script>

    <script>

        $(function() {

            $("#dataTable3").dataTable({

                language: {

                    url: '/assets/admin/vendor/datatables/i18n/tr.json'

                },

                columnDefs: [{

                    "type": "num",

                    "targets": 0

                }],

                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',

                buttons: [

                    {

                        extend: 'excelHtml5',

                        title: 'Ödemeler'

                    }

                ]

            });

        })



    </script>

        <script>

        $(function() {

            $("#dataTable4").dataTable({

                language: {

                    url: '/assets/admin/vendor/datatables/i18n/tr.json'

                },

                columnDefs: [{

                    "type": "num",

                    "targets": 0

                }]

            });

        })



    </script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @elseif(session('error'))
        toastr.error("{{ session('error') }}");
    @elseif(session('info'))
        toastr.info("{{ session('info') }}");
    @elseif(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

        <script>

        $(function() {

            $("#dataTable5").dataTable({

                language: {

                    url: '/assets/admin/vendor/datatables/i18n/tr.json'

                },

                columnDefs: [{

                    "type": "num",

                    "targets": 0

                }]

            });

        })



    </script>

        <script>

        $(function() {

            $("#dataTable6").dataTable({

                language: {

                    url: '/assets/admin/vendor/datatables/i18n/tr.json'

                },

                columnDefs: [{

                    "type": "num",

                    "targets": 0

                }]

            });

        })



    </script>

        <script>

        $(function() {

            $("#dataTable7").dataTable({

                language: {

                    url: '/assets/admin/vendor/datatables/i18n/tr.json'

                },

                columnDefs: [{

                    "type": "num",

                    "targets": 0

                }]

            });

        })



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



    <script>

        Vue.directive('selectpicker', {

            twoWay: true,

            bind: function(el, binding, vnode) {

                $(el).select2().on("select2:select", (e) => {

                    // v-model looks for

                    //  - an event named "change"

                    //  - a value with property path "$event.target.value"

                    el.dispatchEvent(new Event('change', {

                        target: e.target

                    }));

                });

            },

        });



        Vue.directive('select', {

            twoWay: true,

            bind: function(el, binding, vnode) {

                $(el).on("change", (e) => {

                    let select = el;

                    for (let option in select.options) {

                        select.options.item(option).removeAttribute("selected");

                    }

                    select.options

                        .item(select.selectedIndex)

                        .setAttribute("selected", true);

                });

            },

        });



        const app = new Vue({

            el: '#app',

            data: {

                modem_price: 0,

                price: null,

                service: 0,

                services: @json($service_props),

                options: null,

                category: null,

                startDate: '{{ convert_date(date('Y-m-d'), 'mask') }}',

                duration: 0,

                modem: 0,

                modem_model: 0

            },

            methods: {

                changeService: function() {

                    this.category = this.services[this.service].category;

                    this.options = this.fields[this.category];

                    this.price = this.services[this.service].price;



                    if (this.hasOption('commitments')) {

                        this.duration = this.options.commitments[0].value;

                    }



                    if (this.hasOption('modems')) {

                        this.modem = this.options.modems[0].value;

                    }



                    if (this.hasOption('modem_model')) {

                        this.modem_model = this.options.modem_model[0].value;

                    }





                },

                hasOption: function(key) {

                    for (let option in this.options) {

                        if (option == key) {

                            return true;

                        }

                    }

                    if (option == key) {

                            return true;

                }

            },

            computed: {

                getStartDate() {

                    return this.startDate.toString().replace(/(\d*)[\/](\d*)[\/](\d*)/g,

                        '$3-$2-$1');

                },

                getEndDate() {

                    let date = new Date(this.getStartDate),

                        end_date = new Date(date.setMonth(date.getMonth() + this.duration));



                    if (!isNaN(date.getTime())) {

                        return moment(end_date).format('DD/MM/YYYY');

                    }

                    return '';

                }

            }

        })



    </script>

    

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

       $(document).ready(function() {

            $('#dataTable').DataTable( {

                language: {

                    url: '/assets/admin/vendor/datatables/i18n/tr.json'

                },

               columnDefs: [{

                    "type": "num",

                    "targets": 0

                }],

                dom: '<"dataTableFlex"Bl><rt><"dataTableFlex"ip>',

                buttons: [

                    {

                        extend: 'excelHtml5',

                        title: 'Ödemeler'

                    }

                ],

                columnDefs: [

                    {"type": "num", "targets": 0},

                    {"orderable": false, "targets": [ 2, 3, 4, 5, 6]}

                ],

                initComplete: function () {

                    this.api().columns().every( function () {

                        var column = this;

                        if( column[0][0] == 2 || column[0][0] == 7 || column[0][0] == 6) {

                            var select = $('<select class="form-control text-white bg-info" style="width:100px;"><option value="">Tümü</option></select>')

                                .appendTo( $(column.header()).empty() )

                                .on( 'change', function () {

                                    var val = $.fn.dataTable.util.escapeRegex(

                                        $(this).val()

                                    );



                                    column

                                        .search( val ? '^'+val+'$' : '', true, false )

                                        .draw();

                                } );



                            column.data().unique().sort().each( function ( d, j) {

                                select.append( '<option value="'+d+'">'+d+'</option>' )

                            } );

                        }

                    } );

                }

            });

        });



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







