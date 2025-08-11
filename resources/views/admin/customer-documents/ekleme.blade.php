@extends('admin.layout.main')

@section('title', meta_title('tables.customer.document.add'))

@section('content')


    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ relative_route('admin.customer.document.ekleme.post',$customer) }}" enctype="multipart/form-data">
                @csrf
                <div class="card form">
                    <div class="card-header">
                        <h4></h4>


                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slcExpense_name">@lang('fields.document_name')</label>
                            <select name="document_name" id="slcdocument_name" class="custom-select selectpicker">
                                <option selected disabled>@lang('fields.document_name')</option>
                                <option value="PDF İmzasız Sözleşme">PDF İmzasız Sözleşme</option>
                                <option value="PDF Kimlik Fotoğrafı">PDF Kimlik Fotoğrafı</option>
                                <option value="PDF İmzalı Sözleşme">PDF İmzalı Sözleşme</option>
                                <option value="Kimlik Fotoğrafı">Kimlik Fotoğrafı</option>
                                <option value="Nakil Formu">Nakil Formu</option>
                                <option value="İmza Sirküleri">İmza Sirküleri</option>
                                <option value="Vergi Levhası">Vergi Levhası</option>
                                <option value="Abonelik İptal Formları">Abonelik İptal Formları</option>
                                <option value="Diğer Evraklar">Diğer Evraklar</option>
                            <!--    <option value="Taahhüt Sözleşmesi">Taahhüt Sözleşmesi</option> 
                                <option value="Ticaret Sicil Tastiknamesi">Ticaret Sicil Tastiknamesi</option>
                               
                                <option value="Taşıma Formları">Taşıma Formları</option>
                                <option value="Engelli Durum Evrağı">Engelli Durum Evrağı</option>
                                <option value="İkametgah / Yerleşim Belgesi">İkametgah / Yerleşim Belgesi</option>
                                <option value="İndirim Taaahhütnamesi">İndirim Taaahhütnamesi</option>
                                <option value="Abonelik Sözleşmesi">Abonelik Sözleşmesi</option>
                                <option value="Cihaz Taahhütnamesi">Cihaz Taahhütnamesi</option>
                                <option value="Kredi Kartı Sözleşmesi">Kredi Kartı Sözleşmesi</option>
                                <option value="Öğrenci Belgesi">Öğrenci Belgesi</option>
                                <option value="Memur Kimliği">Memur Kimliği</option>
                                <option value="SGK Hizmet Dökümanı">SGK Hizmet Dökümanı</option>
                                <option value="KVKK Onay Formu">KVKK Onay Formu</option> -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtNote">@lang('fields.note')</label>
                            <textarea name="note" id="txtNote" class="form-control"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="files">Evrak Yükle</label>
                            <input type="file" name="image" class="form-control" multiple required>
                            <input type="hidden" name="staff_id" class="form-control" value=" {{ isset(request()->user()->staff) ? request()->user()->staff->id : request()->user()->username }}" multiple>
                            <input type="hidden" name="customer_id" class="form-control" value=" {{ $customer -> id }}" multiple>
                        
                        </div>
                        
                            

                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Evrak Yükleme</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/admin/vendor/select2/css/select2.min.css">
@endpush

@push('script')
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
@endpush
