@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card list">

                <div class="card-header">
                    <h4 style="font-size:20px;" class="text-primary">{{$customer->full_name}}</h4>
                </div>
<div id="container">
   <h4 id="h4"> Manuel Giden SMS</h4>
</div>
  <style>
      #h4 {position: relative; 
  	margin: 0 0px 0 -25px;
  	padding:1px 0;
  	font-size: 23px; 
  	background: #0088AA; 
  	color: #FFFFFF; 
  	text-shadow: 1px 1px 0px #1A5D6E; 
  	box-shadow: 0 0 10px #AAA;
  }

  #h4:before {content: ""; display: block; position: absolute; bottom: -25px; width: 0; height: 0; border-style: solid; border-color: #1A5D6E transparent;border-width: 25px 0 0 25px; left: 0;}
  </style>
                <div class="card-body">
                    <div class="activities">
                    @foreach ( $customerSms as $customersms )
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-detail">
                                <h4>Müşteri Gönderilen Smsler </h4>
                                <div class="mb-2">
                                <span class="text-job text-primary">{{$customersms->created_at}}</span>
                                </div>
                                <p>{{$customersms->message}}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>

                </div>

            </div>
        </div>
        
        <div class="col-md-6 col-sm-12">
            <div class="card list">
                <div class="card-header">
                    <h4 style="font-size:20px;" class="text-primary">{{$customer->full_name}}</h4>
                </div>
            <div id="container">
               <h4 id="h4"> Otomatik Giden SMS</h4>
            </div>

                <div class="card-body">
                    <div class="activities">
                    @foreach ( $customerSms3 as $customersm )
                        <div class="activity">
                            <div class="activity-icon bg-success text-white shadow-success">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-detail">
                                <h4>Müşteri Gönderilen Smsler </h4>
                                <div class="mb-2">
                                <span class="text-job text-primary">{{$customersm->created_at}} </span><br>
                                <span class="text-job text-danger">{{$customersm->title}} </span>
                                </div>
                                <p>{{$customersm->message}}</p>
                            </div>
                        </div>
                    @endforeach
                    @foreach ( $customerSms2 as $customers )
                        <div class="activity">
                            <div class="activity-icon bg-success text-white shadow-success">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-detail">
                                <h4>Müşteri Gönderilen Smsler </h4>
                                <div class="mb-2">
                                <span class="text-job text-primary">{{$customers->created_at}} </span><br>
                                <span class="text-job text-danger">{{$customers->title}} </span>
                                </div>
                                <p>{{$customers->message}}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>

                </div>

            </div>
        </div>
        
    </div>
@endsection

