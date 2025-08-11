@extends('admin.layout.main')



@section('title', meta_title('tables.contractendings.title'))



@section('content')

    <div class="row">

        <div style=" background: #fff; padding: 20px; margin-top:56px" class=" col-md-12">

            

       

    <!-- START Sözleşmenin Bitmesine 15 Gün Kalan -->

            <div class="card list">

                <div class="card-header">

                    

                    <h4 style="font-size:22px;"> 

                    <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 

                    <span class="text-white">Personel Görev Takip Sistemi</span><span class="text-dark">(Ekleme)</span></h4>

                    

                <!--    <div class="card-header-buttons">

                        <a href="/contract-notes/1" class="btn btn-primary"><i

                            class="fas fa-sm fa-plus"></i>Not Ekle

                        </a>

                    </div>

                    -->

                </div><br>

                

                <form method="post" action="{{route('admin.assigadds.post')}}" class="needs-validation" novalidate>

                    @csrf

                    

                  <div class="form-row">

                    <div class="col-md-4 mb-3">

                      <label class="text-dark" for="validationTooltip04">USER ID</label>

                      <input type="text" class="form-control" name="user_id" id="validationTooltip04" placeholder="User id" required>

                      <div class="invalid-tooltip">

                        Lütfen user_id giriniz

                      </div>

                    </div>

                     <div class="col-md-4 mb-3">

                      <label class="text-dark" for="validationTooltip04">ROLES ID</label>

                      <input type="text" class="form-control" name="roles_id" id="validationTooltip04" placeholder="Roles id" required> 

                    <!-- <select name="roles_id" id="validationTooltip04" class="custom-select selectpicker" required>

                            <option selected disabled>Role Seç</option>

                            <option value="2">Personel</option>

                            <option value="3">Müşteri Temsilcisi</option>

                            <option value="4">Satış</option>

                            <option value="5">Muhasebe</option>

                            <option value="6">Teknik</option>

                            <option value="7">root</option>

                            <option value="8">Geliştirici</option>

                            <option value="9">Müdür</option>

                            <option value="10">RCB</option>

                            <option value="11">Genel Müdür</option>

                        </select> -->

                      <div class="invalid-tooltip">

                        Lütfen roles_id giriniz

                      </div>

                    </div>

                    <div class="col-md-4 mb-3">

                      <label class="text-dark" for="validationTooltip04">AD SOYAD</label>

                      <input type="text" name="name_lastname" class="form-control" id="validationTooltip04" placeholder="Ad Soyad" required>

                      <div class="invalid-tooltip">

                        Lütfen name_lastname giriniz

                      </div>

                    </div>

                  </div>

                  

                  <div class="form-row">

                    <div class="col-md-6 mb-3">

                      <label class="text-dark" for="validationTooltip04">1.GÖREV</label>

                      <input type="text" class="form-control" name="task1" id="validationTooltip04" placeholder="1.Görev">

                      <div class="invalid-tooltip">

                        Lütfen task1 giriniz

                      </div>

                    </div>

                    <div class="col-md-6 mb-3">

                      <label class="text-dark" for="validationTooltip04">2.GÖREV</label>

                      <input type="text" class="form-control" name="task2" id="validationTooltip04" placeholder="2.Görev">

                      <div class="invalid-tooltip">

                        Lütfen task2 giriniz

                      </div>

                    </div>

                  </div>



                  

                  <div class="form-row">

                    <div class="col-md-6 mb-3">

                      <label class="text-dark" for="validationTooltip04">3.GÖREV</label>

                      <input type="text" class="form-control" name="task3" id="validationTooltip04" placeholder="3.Görev">

                      <div class="invalid-tooltip">

                        Lütfen task3 giriniz

                      </div>

                    </div>

                    <div class="col-md-6 mb-3">

                      <label class="text-dark" for="validationTooltip04">4.GÖREV</label>

                      <input type="text" class="form-control" name="task4" id="validationTooltip04" placeholder="4.Görev">

                      <div class="invalid-tooltip">

                        Lütfen task4 giriniz

                      </div>

                    </div>

                  </div>

                  

                  

                  <div class="form-row">

                    <div class="col-md-6 mb-3">

                      <label class="text-dark" for="validationTooltip04">5.GÖREV</label>

                      <input type="text" class="form-control" name="task5" id="validationTooltip04" placeholder="5.Görev">

                      <div class="invalid-tooltip">

                        Lütfen task5 giriniz

                      </div>

                    </div>

                     <div class="col-md-6 mb-3">

                      <label class="text-dark" for="validationTooltip04"></label>

                       <button style="font-size:16px;margin-top:30px;float:right;" id="btn21" class="btn btn-primary" type="submit">Görevi Ekle</button>

                    </div>

                  </div>

                  </div>

                  

              </form>

                                         

            

	   </div>

  

    

    

    

 <!-- START TABLO GÜNCELLEME -->   

<div style=" background: #fff; padding: 20px; margin-top:56px" class=" col-md-12">

    

            <div class="card list">

                <div class="card-header">

                    

                    <h4 style="font-size:22px;"> 

                    <span style="color:#0000b4;">RÜZGAR</span><span class="text-warning">NET</span> 

                    <span class="text-success">Personel Görev Takip Sistemi</span><span class="text-dark">(Düzenleme)</span></h4>



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

                                    <th>#</th>

                                    <th>Personel</th>

                                    <th>Birim</th>

                                    <th>1.Görev</th>

                                    <th>2.Görev</th>

                                    <th>3.Görev</th>

                                    <th>4.Görev</th>

                                    <th>5.Görev</th>

                                    <th>İşlemler</th>

                                   

                                   

                                   

                                </tr>

                            </thead>

                            <tbody>



                                @foreach ($tasks as $task)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $task->name_lastname }}</td>

                                    <td>

                                        @if($task->roles_id =='9')

                                          <span  style="font-size:18px;" class="text-dark">Müdür</span>

                                          @elseif($task->roles_id == '8')

                                          <span  style="font-size:18px;" class="text-dark">Geliştirici</span>

                                          @elseif($task->roles_id == '7')

                                          <span  style="font-size:18px;" class="text-dark">Yönetici</span>

                                          @elseif($task->roles_id == '1')

                                          <span  style="font-size:18px;" class="text-dark">Danışma</span>

                                          @elseif($task->roles_id == '5')

                                          <span  style="font-size:18px;" class="text-dark">Muhasebe</span>

                                          @elseif($task->roles_id == '4')

                                          <span  style="font-size:18px;" class="text-dark">Satış</span>

                                          @elseif($task->roles_id == '3')

                                          <span  style="font-size:18px;" class="text-dark">Müşteri Temsilcisi</span>

                                          @elseif($task->roles_id == '2')

                                          <span  style="font-size:18px;" class="text-dark">Personel</span>

                                          @elseif($task->roles_id == '6')

                                          <span  style="font-size:18px;" class="text-dark">Teknik</span>

                                        @endif

                                    </td>



                                 

                                 @if($task->task1 )

                                    <td>

                                       <a  href="#" data-toggle="modal"

                                       data-target="#icerik10{{ $task->id }}">

                                       <span class="badge badge-light badge-pill"> 

                                           @if($task->status1 =='0')

                                              <span  style="font-size:21px;" value="{{$task->status1}}" class="badge badge-pill badge-danger">X</span>

                                              @elseif($task->status1 ='1')

                                              <span style="font-size:21px;" value="{{$task->status1}}" class="badge badge-pill badge-success">✓</span>

                                            @endif

                                        </span>

                                       </a>

                                    <!-- Logout Modal-->

                                    <div class="modal fade" id="icerik10{{ $task->id }}" tabindex="-1" role="dialog"

                                         aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                    <button class="close" type="button" data-dismiss="modal"

                                                            aria-label="Close">

                                                        <span aria-hidden="true">×</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">{{ $task->task1 }}</div>

                                                <div class="modal-footer">

                                                    <button class="btn btn-dark" type="button"

                                                            data-dismiss="modal">Kapat

                                                    </button>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                     @else

                                <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                 @endif

                                 

                                 @if($task->task2 )

                                    

                                   <td>

                                       <a  href="#" data-toggle="modal"

                                       data-target="#icerik9{{ $task->id }}">

                                       <span class="badge badge-light badge-pill"> 

                                           @if($task->status2 =='0')

                                              <span  style="font-size:21px;" value="{{$task->status2}}" class="badge badge-pill badge-danger">X</span>

                                              @elseif($task->status2 ='1')

                                              <span style="font-size:21px;" value="{{$task->status2}}" class="badge badge-pill badge-success">✓</span>

                                            @endif

                                        </span>

                                       </a>

                                    <!-- Logout Modal-->

                                    <div class="modal fade" id="icerik9{{ $task->id }}" tabindex="-1" role="dialog"

                                         aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                    <button class="close" type="button" data-dismiss="modal"

                                                            aria-label="Close">

                                                        <span aria-hidden="true">×</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">{{ $task->task2 }}</div>

                                                <div class="modal-footer">

                                                    <button class="btn btn-dark" type="button"

                                                            data-dismiss="modal">Kapat

                                                    </button>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                   @else

                                <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                 @endif

                                 

                                 @if($task->task3 )

                                 <td>

                                       <a  href="#" data-toggle="modal"

                                       data-target="#icerik8{{ $task->id }}">

                                       <span class="badge badge-light badge-pill"> 

                                           @if($task->status3 =='0')

                                              <span  style="font-size:21px;" value="{{$task->status3}}" class="badge badge-pill badge-danger">X</span>

                                              @elseif($task->status3 ='1')

                                              <span style="font-size:21px;" value="{{$task->status3}}" class="badge badge-pill badge-success">✓</span>

                                            @endif

                                        </span>

                                       </a>

                                    <!-- Logout Modal-->

                                    <div class="modal fade" id="icerik8{{ $task->id }}" tabindex="-1" role="dialog"

                                         aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                    <button class="close" type="button" data-dismiss="modal"

                                                            aria-label="Close">

                                                        <span aria-hidden="true">×</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">{{ $task->task3 }}</div>

                                                <div class="modal-footer">

                                                    <button class="btn btn-dark" type="button"

                                                            data-dismiss="modal">Kapat

                                                    </button>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                  @else

                                <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                 @endif

                                 

                                 @if($task->task4 )

                                 <td>

                                       <a  href="#" data-toggle="modal"

                                       data-target="#icerik7{{ $task->id }}">

                                       <span class="badge badge-light badge-pill"> 

                                           @if($task->status4 =='0')

                                              <span  style="font-size:21px;" value="{{$task->status4}}" class="badge badge-pill badge-danger">X</span>

                                              @elseif($task->status4 ='1')

                                              <span style="font-size:21px;" value="{{$task->status4}}" class="badge badge-pill badge-success">✓</span>

                                            @endif

                                        </span>

                                       </a>

                                    <!-- Logout Modal-->

                                    <div class="modal fade" id="icerik7{{ $task->id }}" tabindex="-1" role="dialog"

                                         aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                    <button class="close" type="button" data-dismiss="modal"

                                                            aria-label="Close">

                                                        <span aria-hidden="true">×</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">{{ $task->task4 }}</div>

                                                <div class="modal-footer">

                                                    <button class="btn btn-dark" type="button"

                                                            data-dismiss="modal">Kapat

                                                    </button>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                 @else

                                <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                 @endif

                                 

                                 @if($task->task5 )

                                

                                 <td>

                                       <a  href="#" data-toggle="modal"

                                       data-target="#icerik6{{ $task->id }}">

                                       <span class="badge badge-light badge-pill"> 

                                           @if($task->status5 =='0')

                                              <span  style="font-size:21px;" value="{{$task->status5}}" class="badge badge-pill badge-danger">X</span>

                                              @elseif($task->status1 ='1')

                                              <span style="font-size:21px;" value="{{$task->status5}}" class="badge badge-pill badge-success">✓</span>

                                            @endif

                                        </span>

                                       </a>

                                    <!-- Logout Modal-->

                                    <div class="modal fade" id="icerik6{{ $task->id }}" tabindex="-1" role="dialog"

                                         aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">

                                        <div class="modal-dialog" role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="exampleModalLabel">Personel Görevi</h5>

                                                    <button class="close" type="button" data-dismiss="modal"

                                                            aria-label="Close">

                                                        <span aria-hidden="true">×</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">{{ $task->task5 }}</div>

                                                <div class="modal-footer">

                                                    <button class="btn btn-dark" type="button"

                                                            data-dismiss="modal">Kapat

                                                    </button>



                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </td>

                                 @else

                                <td><span style="font-size:15px;" class="badge badge-pill badge-secondary">YOK</span></td>

                                 @endif

                                <td> 

                                   <div class="buttons">

                                            <a href="{{ route('admin.assigadds.update', $task->id) }}"

                                                class="btn btn-primary" title="@lang('titles.edit')">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                    </div>

                                </td>

                               

                                </tr>

                            @endforeach   



                            </tbody>

                        </table>

                    </div>

                </div>

            

	   </div>

    </div>

 <!-- END TABLO GÜNCELLEME  -->   

    

    

    

    

    

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

        document.getElementById("btn")

            .onclick = function(){

                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/task';}, 4000);                        

             };

    </script>

          <script>      

        document.getElementById("btn21")

            .onclick = function(){

                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/assignments';}, 4000);                        

             };

    </script>

@endpush



@push('style')

    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    

    <style>

        

       body{

    background:#f5f5f5;

    margin-top:20px;

}

.card {

    border: none;

    -webkit-box-shadow: 1px 0 20px rgba(96,93,175,.05);

    box-shadow: 1px 0 20px rgba(96,93,175,.05);

    margin-bottom: 30px;

}

.table th {

    font-weight: 500;

    color: #827fc0;

}

.table thead {

    background-color: #f3f2f7;

}

.table>tbody>tr>td, .table>tfoot>tr>td, .table>thead>tr>td {

    padding: 14px 12px;

    vertical-align: middle;

}

.table tr td {

    color: #8887a9;

}

.thumb-sm {

    height: 32px;

    width: 32px;

}

.badge-soft-warning {

    background-color: rgba(248,201,85,.2);

    color: #f8c955;

}



.badge {

    font-weight: 500;

}

.badge-soft-primary {

    background-color: rgba(96,93,175,.2);

    color: #605daf;

}

    </style>



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







