@extends('admin.layout.main')

@section('title', meta_title('tables.othersale.title'))

@section('content')
    <div class="section-header">
        <h4>Diğer Satış Aylık Rapor [{{ convert_date($date, 'month_period') }}]</h4>

        <form method="POST" action="{{ route('admin.othersale.report') }}" data-ajax="false" class="report card-header-buttons ml-auto">
            @csrf
            <input type="date" name="date" name="dtDate" class="form-control" value="{{ $date ?? date('Y-m-15') }}">
            <button type="submit" class="btn btn-primary">Listele</button>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card list">
                <div class="card-header">
                    <h4>@lang('tables.othersale.title')</h4>
                </div>
                <div class="card-body">

                        <table class="table table-striped" id="dataTable">
                            <tbody>
                                <tr>
                                    <td>Nakit :</td>
                                    <td>
                                        @if($nakit[0]["price"]!=null)
                                            {{$nakit[0]["price"]}} ₺
                                        @else
                                         0.00 ₺
                                        @endif
                                    </td>
                                    <td>Pos :</td>
                                    <td>
                                        @if($pos[0]["price"]!=null)
                                            {{$pos[0]["price"]}} ₺
                                        @else
                                         0.00 ₺
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Havale :</td>
                                    <td>
                                        @if($havale[0]["price"]!=null)
                                            {{$havale[0]["price"]}} ₺
                                        @else
                                         0.00 ₺
                                        @endif
                                    </td>
                                    <td>Online(Moka) :</td>
                                    <td>
                                        @if($moka[0]["price"]!=null)
                                            {{$moka[0]["price"]}} ₺
                                        @else
                                         0.00 ₺
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Harcamalar :</td>
                                    <td>
                                        @if($harcamalar[0]["price"]!=null)
                                            {{$harcamalar[0]["price"]}} ₺
                                        @else
                                         0.00 ₺
                                        @endif
                                    </td>

                                </tr>
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
@endpush


