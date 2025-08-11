@extends('admin.layout.main')

@section('title', meta_title('Müşteri Evrakları'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:22px;"><i class="fa fa-user-circle text-white" aria-hidden="true"> </i> <span class="text-white">Müşteri Evrakları</span></h4>
                </div>
                <hr style="border-bottom:2px solid #0000FF;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#No</th>
                                    <th scope="col">Ad Soyad</th>
                                    <th scope="col">Temsilci</th>
                                    <th scope="col">Evrak</th>
                                    <th scope="col">Açıklama</th>
                                    <th scope="col">Durumu</th>
                                    <th scope="col">Yükleme Tarihi</th>
                                    <th scope="col">Güncelle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer_documents as $customer_document )
                                    <tr>
                                        <th scope="row"> <a class="text-dark" title="{{  $customer_document->isim  }}" style="font-size:15px;" target="_blank" href="https://crm.ruzgarnet.site/customer/{{ $customer_document->customer_id }}" >{{ $loop->iteration }}</a></th>
                                        <td><a target="_blank" href="/customer-documents/{{ $customer_document->customer_id }}">{{  $customer_document->isim  }}</a></td>
                                        <td>{{$customer_document->first_name}} {{$customer_document->last_name}}</td>
                                        <td><span class="btn btn-outline-secondary badge-pill"> 
                                            @if($customer_document->status==1)
                                               <a href="/public/evrak/{{$customer_document->image}}" target="_blank">
                                                 <i class="fa fa-file-pdf text-danger" aria-hidden="true" title="Hazırlık Aşamasında" style="font-size:35px;"></i>
                                               </a>
                                            @else
                                               <a href="/public/evrak/{{$customer_document->image}}" target="_blank">
                                                 <i class="fa fa-file-pdf text-warning" aria-hidden="true" title="Teslim Alındı" style="font-size:35px;"></i>
                                               </a>
                                            @endif
                                             </span>
                                        </td>
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true"  data-placement="right" title="{{ $customer_document->note }}">
                                              <button class="btn btn-info badge-pill" style="pointer-events: none;" type="button" disabled>Açıklama</button>
                                            </span>
                                        </td>            
                                        <td>@if($customer_document->status!=null) @lang('tables.pdfdocument.status.'.$customer_document->status) @endif</td>
                                        <td><span class="text-dark">{{ $customer_document->created_at }}</span></td>
                                        <td>@php
                                               $users =isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id;
                                            @endphp
                                            
                                            @if($users ==39 || $users ==34 || $users ==57 || $users ==58 )
                                                 <i class="fa fa-exclamation-triangle text-warning" aria-hidden="true" style="font-size:32px;" title="Düzenlemeye Yetkiniz Yok"></i>
                                            @else 
                                                <a href="{{route('admin.customer.document.edit', $customer_document->id)}}">
                                                    <button type="button" class="btn btn-outline-success btn-floating" data-mdb-ripple-color="dark">
                                                       <i class="fas fa-edit"></i>
                                                   </button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
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
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    
    
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(function () {
  $('[data-toggle="tooltip1"]').tooltip()
})
</script>
</script>
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
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 3 && column[0][0] != 4 && column[0][0] != 6 && column[0][0] != 7)
                        {
                            var select = $('<select class="form-control text-white bg-info" style="width:100px;"><option value="">TÜMÜ</option></select>')
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
                        if(column[0][0] == 1)
                        {
                            $('<input style="width:90px;" type="text" class="form-control text-dark bg-light" placeholder="Arama" />')
                            .appendTo( $(column.header()).empty() )
                            .on( 'input', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search('^'+val, true, false)
                                    .draw();
                            } );
                        }
                    } );
                }
            });
        })

    </script>
@endpush
