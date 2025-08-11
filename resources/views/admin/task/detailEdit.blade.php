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
                     <span class="text-success">Personel Görev Takip Sistemi</span><span class="text-dark">(Düzenleme)</span></h4>

                <!--    <div class="card-header-buttons">
                        <a href="/contract-notes/1" class="btn btn-primary"><i
                            class="fas fa-sm fa-plus"></i>Not Ekle
                        </a>
                    </div>
                    -->
                </div>
                         <hr style="border-bottom:2px solid #FF0000;">                
             <form method="POST" action="{{route('admin.assigadds.update.post',$task->id)}}" class="needs-validation" novalidate>
                 @csrf
                <!-- task1 status1   --> 
                  <div class="col-md-12 form-row">
                    <div class="form-group col-md-3">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">USER ID</label>
                      <input value="{{$task->user_id}}" name="user_id" type="text" class="form-control" >
                    </div>
                     <div class="form-group col-md-3">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">ROLES ID</label>
                      <input value="{{$task->roles_id}}" name="roles_id" type="text" class="form-control" >
                    </div>
                    <div class="form-group col-md-6">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">AD SOYAD</label>
                      <input value="{{$task->name_lastname}}" name="name_lastname" type="text" class="form-control" >
                    </div>
                  </div>
           <!-- end task1 status1   --> 
           
            <!-- task1 status1   --> 
                  <div class="col-md-12 form-row">
                    <div class="form-group col-md-9">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">1.GÖREV</label>
                      <input value="{{$task->task1}}" name="task1" type="text" class="form-control" >
                    </div>
                    
                    <div class="form-group col-md-3">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">1.DURUM</label>
                      <select name="status1" id="inputState" class="form-control">
                        <option @if($task->status1==='0') selected @endif value="0">Tamamlanmadı</option>
                        <option @if($task->status1==='1') selected @endif value="1">Tamamlandı</option>
                      </select>
                   </div>
                  </div>
           <!-- end task1 status1   --> 
           
             <!-- task2 status2   --> 
                  <div class="col-md-12 form-row">
                    <div class="form-group col-md-9">
                        <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">2.GÖREV</label>
                      <input value="{{$task->task2}}" name="task2" type="text" class="form-control" >
                    </div>
                    
                  <div class="form-group col-md-3">
                    <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">2.DURUM</label>
                      <select name="status2" id="inputState" class="form-control">
                        <option @if($task->status2==='0') selected @endif value="0">Tamamlanmadı</option>
                        <option @if($task->status2==='1') selected @endif value="1">Tamamlandı</option>
                      </select>
                   </div>
                  </div>
           <!-- end task2 status2   --> 
           
            <!-- task3 status3   --> 
                  <div class="col-md-12 form-row">
                    <div class="form-group col-md-9">
                        <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">3.GÖREV</label>
                      <input value="{{$task->task3}}" name="task3" type="text" class="form-control" >
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">3.DURUM</label>
                      <select name="status3" id="inputState" class="form-control">
                        <option @if($task->status3==='0') selected @endif value="0">Tamamlanmadı</option>
                        <option @if($task->status3==='1') selected @endif value="1">Tamamlandı</option>
                      </select>
                   </div>
                  </div>
           <!-- end task3 status3   --> 
           
            <!-- task4 status4   --> 
                  <div class="col-md-12 form-row">
                    <div class="form-group col-md-9">
                        <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">4.GÖREV</label>
                      <input value="{{$task->task4}}" name="task4" type="text" class="form-control" >
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">4.DURUM</label>
                      <select name="status4" id="inputState" class="form-control">
                        <option @if($task->status4==='0') selected @endif value="0">Tamamlanmadı</option>
                        <option @if($task->status4==='1') selected @endif value="1">Tamamlandı</option>
                      </select>
                   </div>
                  </div>
           <!-- end task4 status4   --> 
           
           <!-- task5 status5   --> 
                  <div class="col-md-12 form-row">
                    <div class="form-group col-md-9">
                        <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">5.GÖREV</label>
                      <input value="{{$task->task5}}" name="task5" type="text" class="form-control" >
                    </div>
                    
                    <div class="form-group col-md-3">
                        <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">5.DURUM</label>
                      <select name="status5" id="inputState" class="form-control">
                        <option @if($task->status5==='0') selected @endif value="0">Tamamlanmadı</option>
                        <option @if($task->status5==='1') selected @endif value="1">Tamamlandı</option>
                      </select>
                   </div>
                  </div>
           <!-- end task5 status5   --> <br><br>

                  <button style="float:right; margin-top:-35px" id="btn" type="submit" class="btn btn-success">Görev Düzenle</button>
            </form>
                
                
 
	</div>
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
        document.getElementById("btn")
            .onclick = function(){
                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/assigadds/create';}, 4000);                        
             };
    </script>
          <script>      
        document.getElementById("btn21")
            .onclick = function(){
                window.setTimeout(function(){location.href = 'https://crm.ruzgarnet.site/task';}, 4000);                        
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



