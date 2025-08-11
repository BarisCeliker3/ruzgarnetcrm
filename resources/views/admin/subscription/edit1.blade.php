@extends('admin.layout.main')

@section('title', meta_title('tables.subscription.edit'))

@section('content')
    <div class="row">
        <div class="col-12"><br><br><br>
           
                <div class="col-md-12 form-row">
                    <div class="form-group col-md-4">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">Ad Soyad</label>
                      <input value="{{$subscription->customer->first_name}} {{$subscription->customer->last_name}}" type="text" class="form-control" disabled>
                    </div>
                    
                    <div class="form-group col-md-4">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">TC Kimlik No</label>
                      <input value="{{$subscription->customer->identification_number}}"  type="text" class="form-control" disabled>
                    </div>
                    <div class="form-group col-md-4">
                      <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">Telefon</label>
                      <input value="{{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $subscription->customer->telephone) }}"  type="text" class="form-control" disabled>
                    </div>
                </div> 
                
            <form method="POST" action="{{ relative_route('admin.subscription.edit1.put1', $subscription) }}">
                @csrf
           
                <div class="card form">
                    <div class="card-header">
                        <h4>@lang('tables.subscription.edit') [{{ $subscription->id }}]</h4>
                        <div class="card-header-buttons">
                            <a href="{{ route('admin.subscriptions') }}" class="btn btn-primary"><i
                                    class="fas fa-sm fa-list-ul"></i> @lang('tables.subscription.title')</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($subscription->approved_at)
                            <div class="alert alert-danger">
                                @lang('warnings.approved.subscription')
                            </div>
                        @endif
                            <div class="col-lg-12">
                                <div class="form-group">
                                   
                                    <input type="hidden" name="service_id" id="service_id" class="form-control"
                                        value="{{ $subscription->service_id }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                   
                                    <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                        value="{{ $subscription->customer_id }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                  
                                    <input type="hidden" name="start_date" id="start_date" class="form-control"
                                        value="{{ $subscription->start_date }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    
                                    <input type="hidden" name="price" id="price" class="form-control"
                                        value="{{ $subscription->price }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                 
                                    <input type="hidden" name="payment" id="payment" class="form-control"
                                        value="{{ $subscription->payment }}">
                                </div>
                            </div>

                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">Verici İşletmeci</label>
                                    <input type="text" name="verici" id="verici" class="form-control"
                                        value="{{ $subscription->verici }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">Alıcı İşletmeci</label>
                                    <input type="text" name="alici" id="alici" class="form-control"
                                        value="{{ $subscription->alici }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">xDSL / Paylaşımlı Erişim Hizmeti Alınan Tel. No.(**)</label>
                                    <input type="text" name="xdsl_tel" id="xdsl_tel" class="form-control"
                                        value="{{ $subscription->xdsl_tel }}">
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label style="color:#304FFE; font-weight: bold;font-size:15px;" for="inputEmail4">xDSL Hizmet Numarası</label>
                                    <input type="text" name="xdsl_hizmet" id="xdsl_hizmet" class="form-control"
                                        value="{{ $subscription->xdsl_hizmet }}">
                                </div>
                            </div>
                        
                    </div>
                    <div class="card-footer text-right">
                        @if ($subscription->approved_at == null)
                            <button type="submit" class="btn btn-primary">Düzenle</button>
                        @endif
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
    <script src="/assets/admin/vendor/slugify/slugify.js"></script>
    <script src="/assets/admin/vendor/select2/js/select2.min.js"></script>
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
                modem_price: {{ $subscription->options['modem_price'] ?? 0 }},
                price: {{ $subscription->price }},
                service: {{ $subscription->service_id }},
                services: @json($service_props),
                customer: {{ $subscription->customer_id }},
                fields: @json($option_fields),
                options: @json($subscription->service->category->option_fields),
                category: '{{ $subscription->service->category->key }}',
                startDate: '{{ convert_date($subscription->start_date, 'mask') }}',
                duration: {{ $subscription->commitment }},
                modem: {{ $subscription->options['modem'] ?? 1 }},
                setup_payment: {{ $subscription->options['setup_payment'] ?? 0 }},
                modem_serial: '{{ $subscription->options['modem_serial'] ?? '' }}',
                pre_payment: {{ $subscription->options['pre_payment'] ?? 0 }},
                il_disi: {{ $subscription->options['il_disi'] ?? 0 }},
                modem_model: {{ $subscription->options['modem_model'] ?? 0 }},
                address: '{{ $subscription->options['address'] ?? '' }}'
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
                        this.modem = this.options.modem_model[0].value;
                    }
                },
                hasOption: function(key) {
                    for (let option in this.options) {
                        if (option == key) {
                            return true;
                        }
                    }
                    return false;
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
            },
            mounted: function() {
                let selects = document.querySelectorAll("select");
                if (selects) {
                    selects.forEach(function(select, index) {
                        let selectedIndex = select.selectedIndex;
                        for (let option in select.options) {
                            select.options.item(option).removeAttribute("selected");
                        }
                        if (select.options.item(selectedIndex)) {
                            select.options
                                .item(selectedIndex)
                                .setAttribute("selected", true);
                        }
                    })
                }

                // Change selected options and trigger event
                $('#slcService').val({{ $subscription->service_id }});
                $('#slcService').trigger('change');

                // Change selected options and trigger event
                $('#slcCustomer').val({{ $subscription->customer_id }});
                $('#slcCustomer').trigger('change');
            }
        })
    </script>
@endpush
