@extends('admin.layout.main')

@section('title', meta_title('tables.contractending.iss'))

@section('content')
    <div class="row">
        <div class="col-12">
            
       
    <!-- START Sözleşmenin Bitmesine 15 Gün Kalan -->
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:22px;">Sözleşmenin Bitmesine 15 Gün Kalan  <span class="text-success">Güncellenmiş</span> Aboneler</h4>

                <!--    <div class="card-header-buttons">
                        <a href="/contract-notes/1" class="btn btn-primary"><i
                            class="fas fa-sm fa-plus"></i>Not Ekle
                        </a>
                    </div>
                    -->
                </div>
                
                <hr style="border-bottom:2px solid #6777ef;">
                                
     <div class="card-body">
                    <div class="table-responsive">
                         <table class="table table-striped" id="dataTable">
                            <thead>
								<tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Temsilci</th>
                                    <th scope="col">İsim</th>
                                    <th scope="col">Telefon</th>
                                    <th scope="col">Tarife</th>
                                    <th scope="col">Güncel Fiyat</th>
                                    <th scope="col">Taahüt Süresi</th>
                                    <th scope="col">Bitiş Tarihi</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($subsupgradesalti as $subsupaltiend)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $subsupaltiend->temsilci}} {{ $subsupaltiend->last_name}}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subsupaltiend->customer_id}}">{{ $subsupaltiend->isim }}</a></td>
                                        <td><span class="text-dark bg-white">{{ $subsupaltiend->telephone}}</span></td>
                                        <td><span class="text-dark bg-white">{{ $subsupaltiend->name}}</span></td>
                                        <!-- <td>@if($subsupaltiend->price) 
                                             <span style="margin-bottom:5px;" class="badge badge-pill badge-light">{{$subsupaltiend->price}} ₺</span>
                                            @endif
                                        </td> -->
                                            
                                            <td>
                                            @if($subsupaltiend->new_price) 
                                             <span class="badge badge-pill badge-info">{{$subsupaltiend->new_price}} ₺</span>
                                            @endif 
                                        </td>
                                        <td><span class="badge badge-pill badge-success">{{$subsupaltiend->new_commitment}} Ay</span></td>
                                        <td><span class="badge badge-pill badge-light">{{$subsupaltiend->bitistarihi}}</span></td>
                                       
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
    <!-- END Sözleşmenin Bitmesine 15 Gün Kalan -->   
    
    <!-- START 9 GÜN KALAN -->
            <hr style="border-bottom:2px solid #6777ef;">
            <div class="card list">
                <div class="card-header">
                    <h3><span class="badge badge-pill badge-danger">ISS' te Süresi Uzayacaklar</span></h3>


                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable3">
                             <thead>
								<tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Temsilci</th>
                                    <th scope="col">İsim</th>
                                    <th scope="col">Telefon</th>
                                    <th scope="col">Tarife</th>
                                    <th scope="col">Güncel Fiyat</th>
                                    <th scope="col">Taahüt Süresi</th>
                                    <th scope="col">Bitiş Tarihi</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($subsupgradesyedi as $subsupgradesyediend)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $subsupgradesyediend->temsilci}} {{ $subsupgradesyediend->last_name}}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subsupgradesyediend->customer_id}}">{{ $subsupgradesyediend->isim }}</a></td>
                                        <td><span class="text-dark bg-white">{{ $subsupgradesyediend->telephone}}</span></td>
                                        <td><span class="text-dark bg-white">{{ $subsupgradesyediend->name}}</span></td>
                                       
                                        <td>
                                            @if($subsupgradesyediend->new_price) 
                                             <span class="badge badge-pill badge-info">{{$subsupgradesyediend->new_price}} ₺</span>
                                            @endif 
                                        </td>
                                        <td><span class="badge badge-pill badge-success">{{$subsupgradesyediend->new_commitment}} Ay</span></td>
                                        <td><span class="badge badge-pill badge-light">{{$subsupgradesyediend->bitistarihi}}</span></td>
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <hr style="border-bottom:2px solid #6777ef;">
            
    <!-- AND 9 GÜN KALAN -->
             
            
            
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
                        if( column[0][0] == 1 ) {
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
       $(document).ready(function() {
            $('#dataTable3').DataTable( {
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
                        if( column[0][0] == 1 ) {
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



