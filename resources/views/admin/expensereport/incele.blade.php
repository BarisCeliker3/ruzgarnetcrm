@extends('admin.layout.main')

@section('title', meta_title('Aylık Gider Raporu'))

@section('content')
    <div class="section-header">
        <h1>@lang('tables.expensereport.giderincele')</h1>
    </div>
    <div class="row">
        <div class="col-12">
   <!--          
            <div class="card list">
                <div class="card-header">
                    <h4></h4>
                   
                    <div class="card-header-buttons">
                        <a href="{{ route('admin.stokCustomersEkle') }}">
                            <button type="button" class="button">
                        		<span class="button__text">Gider Ekle</span>
                        		<span class="button__icon">
                        			<ion-icon name="person-add-outline"></ion-icon>
                        		</span>
                            </button>
                        </a>
                       
                    </div>
                </div>
 -->
                <div class="row">
                        <!-- GİDERLER -->
                        <hr style="border-bottom:2px solid #008000;">  
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Gider</th>
                                    <th scope="col">Tutar</th>
                                    <th scope="col">Açıklama</th>
                                    <th scope="col">Resim</th>
                                    <th scope="col">Tarih</th>
                                    <th scope="col">İşlem</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Satır -->
                                    <tr data-id="">
                                        <td>1</td>
                                        <td>Mutfak Gideri</td>
                                        <td>157.00</td>
                                        <td>
                                           <button type="button" class="btn btn-info btn-sm" 
                                            data-toggle="tooltip" 
                                            data-placement="right" 
                                            title="DENEME NOT...">
                                              Not
                                           </button>
                                        </td>
                                        <td> 
                                                <a href="https://crm.ruzgarnet.site/files/yFArcmusabgdDCxjhwnvEfptBelozkiq.jpeg" target="_blank">
                                                <i style="font-size:28px;color:green" class="fa fa-images" aria-hidden="true"></i>
                                              </a> 
                                           
										</td>
										<td>2023-04-27</td>
                                        <td>
                                            <div class="buttons">
                                                <a href=""
                                                  target="_blank"  class="btn btn-primary" title="@lang('titles.edit')">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                        
                                    </tr>
                               <!-- //Satır -->
                            </tbody>
                        </table>
                    </div>
                </div>
                    <!-- //GİDERLER -->

                      
                </div>
            </div>
            
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/DataTables-1.10.24/css/dataTables.bootstrap4.min.css">
    
    
//button  
    <style>
        .button {
	display: flex;
	height: 50px;
	padding: 0;
	background: #090979	;
	border: none;
	outline: none;
	border-radius: 5px;
	overflow: hidden;
	font-family: "Quicksand", sans-serif;
	font-size: 18px;
	font-weight: 500;
	cursor: pointer;
}

.button:hover {
	background: #FFA500	;
}

.button:active {
	background: #ffd700;
}

.button__text,
.button__icon {
	display: inline-flex;
	align-items: center;
	padding: 0 24px;
	color: #fff;
	height: 100%;
}

.button__icon {
	font-size: 1.5em;
	background: rgba(0, 0, 0, 0.08);
}
    </style>
@endpush

@push('script')
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="/assets/admin/vendor/datatables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <script>
        $(function() {
            $("#dataTable").dataTable({
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
