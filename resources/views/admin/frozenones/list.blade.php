@extends('admin.layout.main')

@section('title', meta_title('Dondurulanlar'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4><i class="fa fa-user-times text-danger" aria-hidden="true"> </i> <span class="text-warning">Dondurulan Aboneler</span></h4>
                </div>
                <hr style="border-bottom:2px solid red;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ad Soyad</th>
                                    <th scope="col">Temsilci</th>
                                    <th scope="col">Not</th>
                                    <th scope="col">Dondurma Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscription_freezes as $subscription_freeze)
                                    <tr data-id="{{ $subscription_freeze->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a target="_blank" href="https://crm.ruzgarnet.site/customer/{{$subscription_freeze->customer_id}}">{{  $subscription_freeze->isim  }}</a> </td>
                                        <td>{{ $subscription_freeze->first_name }} {{ $subscription_freeze->last_name }}</td>
                                        <td>
                                            @if($subscription_freeze->description)
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" data-html="true"  data-placement="right" title="{{ $subscription_freeze->description }}">
                                                  <button class="btn btn-success" style="pointer-events: none;" type="button" disabled>Not</button>
                                                </span>
                                            @else
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip"  data-placement="right" title="{{ $subscription_freeze->description }}">
                                                  <button class="btn btn-danger" style="pointer-events: none;" type="button" disabled>Not</button>
                                                </span>
                                            @endif
                                            
                                            
                                        </td>
                                        <td><span  class="text-dark">{{ $subscription_freeze->created_at }}</span> </td>
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
                        if(column[0][0] != 0 && column[0][0] != 1 && column[0][0] != 3 && column[0][0] != 4)
                        {
                            var select = $('<select class="form-control text-white bg-primary" style="width:100px;"><option value="">Tümü</option></select>')
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
