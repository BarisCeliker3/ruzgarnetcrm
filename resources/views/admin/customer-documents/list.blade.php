@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card list">

                <div class="card-header">
                    <h4><i class="fa fa-user-circle" aria-hidden="true"></i> {{$customer->full_name}}</h4>

                    <div style="display:none" class="card-header-buttons">     
                        <a href="/customer-document/ekle/{{ $customer->id }}" class="btn btn-primary"><i
                                class="fas fa-sm fa-plus"></i>Evrak Ekle</a>
                    </div>
                    
                    
                    <div class="card-header-buttons">     
                        <a href="/customer-document/file-upload/{{ $customer->id }}" class="btn btn-success"><i
                                class="fa fa-file-image" style="font-size:15px;"></i> Evrak Yükleme</a>
                    </div>
                    
                </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="card-body">
                        <div class="activities">
                        @foreach ( $customerDocuments as $customerdocuments )
                            <div class="activity" title="{{$customerdocuments->id}}">
                                <div class="activity-icon bg-primary text-white shadow-primary">
                                    <i class="fa fa-file-image"></i>
                                </div>
                                <div class="activity-detail">
                                    <h4>{{$customerdocuments->document_name}}</h4>
                                    <div class="mb-2">
                                    <span class="text-job text-primary">{{$customerdocuments->created_at}}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" >İşlemi Yapan Kullanıcı : {{$customerdocuments->staff->full_name ?? 'Sistem' }}</a>
                                    </div>
                                    <p> <span class="text-dark">{{$customerdocuments->note}}   |    
                                         
                                        @php
                                              $users =isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->staff_id;
                                        @endphp
                                            
                                        @if($users ==38 || $users ==52 || $users ==33 || $users ==63 )
                                         <!-- evrak silme modal -->
                                            
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal{{$customerdocuments->id}}">Evrak Sil</button>
                                           
                                            <!-- Modal -->
                                        <form action="{{route('admin.customer.delete',$customerdocuments->id)}}" method="POST">
                                             @csrf
                                            <div class="modal fade" id="exampleModal{{$customerdocuments->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalLabel">Müşteri Evrak Silme</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <h6 class="text-warning">Silinen müşteri evrakları veritabanından ve kayıtlı olan klasörden silinecektir. Silmek istediğinizde emin misiniz?</h6> 
                                                  </div>
                                                      
                                                      <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Sil</button>
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">İptal</button>
                                                      </div>
                                                  
                                                </div>
                                              </div>
                                            </div>
                                            </form>
                                         <!-- evrak silme modal -->
                                         
                                         @endif
                                    </p></br>
        
                                    @if($customerdocuments->document_name=="PDF İmzasız Sözleşme" and $customerdocuments->status==1)
                                    <a href="/public/evrak/{{$customerdocuments->image}}" title="Hazırlık Aşamasında" target="_blank">
                                      
                                       <i class="fa fa-file-pdf text-danger" aria-hidden="true" style="font-size:50px;"></i>
                                    </a>
                                    @elseif($customerdocuments->document_name=="PDF İmzasız Sözleşme" and $customerdocuments->status==2)
                                    <a href="/public/evrak/{{$customerdocuments->image}}" title="Teslim Alındı" target="_blank">
                                      
                                       <i class="fa fa-file-pdf text-warning" aria-hidden="true" style="font-size:50px;"></i>
                                    </a>
                                    @elseif($customerdocuments->document_name=="PDF İmzasız Sözleşme" and $customerdocuments->status==3)
                                    <a href="/public/evrak/{{$customerdocuments->image}}" title="Sözleşme Tamamlandı" target="_blank">
                                      
                                       <i class="fa fa-file-pdf text-success" aria-hidden="true" style="font-size:50px;"></i>
                                    </a>
                                    @elseif($customerdocuments->document_name=="PDF Kimlik Fotoğrafı" and $customerdocuments->status==1)
                                    <a href="/public/evrak/{{$customerdocuments->image}}" title="PDF Kimlik Fotoğrafı" target="_blank">
                                      
                                       <i class="fa fa-file-pdf text-info" aria-hidden="true" style="font-size:50px;"></i>
                                    </a>
                                     @elseif($customerdocuments->document_name=="Nakil Formu" and $customerdocuments->status==1)
                                    <a href="/public/evrak/{{$customerdocuments->image}}" title="Nakil Formu" target="_blank">
                                      
                                       <i class="fa fa-file-pdf text-info" aria-hidden="true" style="font-size:50px;"></i>
                                    </a>
                                    @elseif($customerdocuments->document_name=="PDF İmzalı Sözleşme" and $customerdocuments->status==1)
                                    <a href="/public/evrak/{{$customerdocuments->image}}" title="PDF İmzalı Sözleşme" target="_blank">
                                      
                                       <i class="fa fa-file-pdf text-primary" aria-hidden="true" style="font-size:50px;"></i>
                                    </a>
                                    
                                    
                                    @else
                                    <div class="zoom">
                                        <a class="" href="/public/evrak/{{$customerdocuments->image}}" target="_blank">
                                           <img src="/public/evrak/{{$customerdocuments->image}}" width="200" >
                                        </a>
                                    </div>
                                    @endif
                                 
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
                
                  @if(isset($customerdocuments->document_name))
                <div class="col-md-3" style="margin-top:50px">
                    <div class="row">
                        <div class="col-md-12"  style="margin-bottom:20px;">
                            <i style="font-size:40px; " class="fa fa-file-pdf text-danger"></i>
                            <span style="font-size:17px; " class="text-danger">Hazırlık Aşamasında</span>
                        </div>
                        <div class="col-md-12"  style="margin-bottom:20px;">
                            <i style="font-size:40px; text-align: center" class="fa fa-file-pdf text-warning"></i>
                            <span style="font-size:17px; " class="text-warning">Teslim Alındı</span>
                        </div>
                        <div class="col-md-12"  style="margin-bottom:20px;">
                            <i style="font-size:40px; text-align: center" class="fa fa-file-pdf text-success"></i>
                            <span style="font-size:17px; " class="text-success">Tamamlandı</span>
                        </div>
                        <div class="col-md-12"  style="margin-bottom:20px;">
                            <i style="font-size:40px; text-align: center" class="fa fa-file-pdf text-primary"></i>
                            <span style="font-size:17px; " class="text-primary">PDF İmzalı Sözleşme</span>
                        </div>
                        <div class="col-md-12"  style="margin-bottom:20px;">
                            <i style="font-size:40px; text-align: center" class="fa fa-file-pdf text-info"></i>
                            <span style="font-size:17px; " class="text-info">PDF Kimlik Fotoğrafı</span>
                        </div>
                    </div>
                </div>
                  @endif
            </div>
            
            
            </div>
        </div>
    </div>
@endsection
@push('style')
<style>
    .zoom{
         transition: transform .2s;
         text-align: center;
    }
    .zoom:hover {
      -ms-transform: scale(2.1); /* IE 9 */
      -webkit-transform: scale(2.1); /* Safari 3-8 */
      transform: scale(2.1); 
      text-align: center;
      position:relative;
      z-index:99999999999;
    }
</style>

@endpush
