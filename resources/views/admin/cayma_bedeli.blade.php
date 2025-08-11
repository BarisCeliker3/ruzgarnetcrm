@extends('admin.layout.main')

@section('title', 'Cayma Bedeli')

@section('content')
    <div class="row">
        <div class="col-12">
            <form id="CancelForm" method="POST" action="{{ relative_route('admin.message.send.cancel_payment') }}">
                <div class="card form">
                    <div class="card-header">
                        <h4>Cayma Bedeli Hesapla</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="without_discount">Kampanyasız Tutar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="without_discount" id="without_discount"
                                            class="form-control money-input" value="0" min="0" step=".01">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="with_discount">Kampanyalı Tutar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="with_discount" id="with_discount"
                                            class="form-control money-input" value="0" min="0" step=".01">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="port_price">Port Bedeli</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="port_price" id="port_price"
                                            class="form-control money-input" value="0" min="0" step=".01">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="setup_price">Kurulum ve Bağlantı Ücreti</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="setup_price" id="setup_price"
                                            class="form-control money-input" value="0" min="0" step=".01">
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="device_price">Cihaz Ücretleri</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="device_price" id="device_price"
                                            class="form-control money-input" value="0" min="0" step=".01">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="setup_priceiki">Dijital Kurye Bedeli</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">₺</div>
                                        </div>
                                        <input type="number" v-model="price" name="setup_priceiki" id="setup_priceiki"
                                            class="form-control money-input" value="0" min="0" step=".01">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">

                                    <input v-model="number"  class="form-control" id="telephone" name="telephone" type="hidden" value="{{ $phone }}">
                                    <input v-model="number"  class="form-control" id="price" name="price" type="hidden" value="0">
                                </div>
                            </div>
                            <input id="used_time" type="hidden" value="{{ $used_time }}">
                            <input id="diff_time" type="hidden" value="{{ $diff_time }}">
                        </div>


                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6 text-left">
                                <p id="final_total"><b>Cayma Bedeli:</b>  </p>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a id="run" class="btn btn-primary">Hesapla</a>
                                <button type="submit" class="btn btn-primary">SMS GÖNDER</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')
    <script src="/assets/js/cayma_bedeli.js?v=1.6"></script>
@endpush

