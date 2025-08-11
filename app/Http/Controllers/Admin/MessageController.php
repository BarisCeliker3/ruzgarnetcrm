<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Messages;
use App\Classes\Mutator;
use App\Classes\SMS_Api;
use App\Classes\SMS;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Payment;
use App\Models\PaymentPriceEdit;
use App\Models\SentMessage;
use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.message.list', [
            'messages' => Message::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.message.add');
    }

    /**
     * Show the form for sending messages.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function send()
    {
        return view("admin.message.send_sms", [
            "customers" => Customer::all(),
            "messages" => Message::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Send messages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|void|null
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:1,2,3,4,5',
            'message_id' => 'required|exists:messages,id'
        ]);

        $type = $validated["type"];

        if ($type == 1) {
            $validated = $request->validate([
                'customers' => 'required|array',
                'customers.*' => 'required|exists:customers,id'
            ]) + $validated;
        } else if ($type == 2) {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id'
            ]) + $validated;
        }

        $messages = [];
        $message = Message::find($validated["message_id"])->message;
        $message_formatter = new Messages();

        $sms = new SMS();

        if ($type == 1) {
            $customers = Customer::whereIn('id', $validated["customers"])->get();
            $numbers = [];
            foreach ($customers as $customer) {
                $messages[] = [
                    $customer->telephone,
                    $message_formatter->generate(
                        $message,
                        [
                            'ad_soyad' => $customer->full_name,
                            'ay' => date('m'),
                            'yil' => date('Y'),
                            'referans_kodu' => $customer->reference_code
                        ]
                    )
                ];
            }
        } else if ($type == 2) {
            $category = Category::find($validated["category_id"]);
            $subscriptions = Subscription::whereIn("service_id", $category->services->pluck('id'))->get();
            $numbers = [];
            foreach ($subscriptions as $subscription) {
                $messages[] = [
                    $subscription->customer->telephone,
                    $message_formatter->generate(
                        $message,
                        [
                            'ad_soyad' => $subscription->customer->full_name,
                            'ay' => date('m'),
                            'yil' => date('Y'),
                            'referans_kodu' => $subscription->customer->reference_code
                        ]
                    )
                ];
            }
        } else if ($type == 3) {
            $subscriptions = Subscription::all();
            $numbers = [];
            foreach ($subscriptions as $subscription) {
                $messages[] = [
                    $subscription->customer->telephone,
                    $message_formatter->generate(
                        $message,
                        [
                            'ad_soyad' => $subscription->customer->full_name,
                            'ay' => date('m'),
                            'yil' => date('Y'),
                            'referans_kodu' => $subscription->customer->reference_code
                        ]
                    )
                ];
            }
        } else if ($type == 4) {
            $numbers = [];
            $payments = Payment::where("status", "<>", 2)->where('date', date('Y-m-15'))->get();
            foreach ($payments as $payment) {
                $messages[] = [
                    $payment->subscription->customer->telephone,
                    $message_formatter->generate(
                        $message,
                        [
                            'ad_soyad' => $payment->subscription->customer->full_name,
                            'ay' => date('m'),
                            'yil' => date('Y'),
                            'referans_kodu' => $payment->subscription->customer->reference_code
                        ]
                    )
                ];
            }
        }
        $sms->submitMulti(
            'RUZGARNET',
            $messages
        );
//..
        return response()->json([
            'success' => true,
            'toastr' => [
                'type' => 'success',
                'title' => trans('response.title.success'),
                'message' => trans('response.insert.success')
            ],
            'redirect' => relative_route('admin.messages')
        ]);
    }

    /**
     * Send spesific message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_sms_spesific(Request $request)
    {
        $validated = $request->validate(
            [
                'telephone' => 'required',
                'message_id' => 'required'
            ]
        );

        $message_formatter = new Message();

        $message = Message::find($validated["message_id"]);
        $sms = new SMS();


        if($sms->submit('RUZGARNET',$message->message,[$validated["telephone"]])){
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'reload' => true

            ]);

        }
        else{
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('response.insert.error')
                ]
            ]);
        }


    }

    /**
     * Send spesific message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_sms_manuel(Request $request)
    {
        /*    return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'reload' => true
            ]);
    */
        $telephone = Mutator::phone($request["telephone"]);
        $validated = $request->validate(
            [
                'telephone' => 'required',
                'message' => 'required'
            ]
        );

        $message_formatter = new Message();

        $customer = Customer::where('telephone',$telephone)->first();

        $sms = new SMS();


        if($sms->submit('RUZGARNET',$validated["message"],[$validated["telephone"]])){
            if($customer != null){
                DB::table('customer_sms')->insert([
                    'customer_id' => $customer->id,
                    'message' => $request["message"]
                ]);
            }
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'reload' => true
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('response.insert.error')
                ]
            ]);
        }


    }

    public function send_sms_payment(Payment $payment)
    {
        $message_formatter = new Message();

        $name = $payment->subscription->customer->full_name;
        $phone = $payment->subscription->customer->telephone;
        $price = $payment->price;
        $date = date('10-m-Y');
        $sms = new SMS();

        if($sms->submit('RUZGARNET'
 ,'Değerli abonemiz '.$name.'; '.$price.'TL tutarındaki faturanız son ödeme tarihi '.$date.' dir.YASAL yaptırımlarla karşılaşmamak için lütfen ödemenizi bu ayın 1\'i ile 10\'u arasında gerçekleştiriniz.
 Ödemelerinizi https://www.ruzgardestek.com/fatura_ode.php link üzerinden, Havale yapmak için Hesap bilgilerimiz; GARANTİ BANKASI HESAP ADI: AKARNET TELEKOM Sanayi Ticaret Limited Şirketi İBAN NO: TR28 0006 2000 2560 0006 2891 93 ACIKLAMA: ABONE İSİM SOYİSİM VE TC YAZILMALIDIR.HESAP ADI DOĞRU VE EKSİKSİZ YAZILMALIDIR .'
        ,[$phone])
        ){
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'reload' => true
            ]);
        }
        else{
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('response.insert.error')
                ]
            ]);
        }
    }

    /**
     * Send spesific message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send_sms_cancel_payment(Request $request){
        $sms = new SMS();

        $cancel_price = $request["price"];
        $phone = $request["telephone"];
        $cancel_message = 'Talebiniz üzerine aboneliğinizi iptal etmeniz dahilinde cayma bedeli , tarifenize yapılan indirim tutarı, adınıza ödenen vergiler, yerinde kurulum bedeli bağlantı ücretleri, olmak üzere '.$cancel_price.' TL ödemeyi kabul etmeniz ödemeniz, tarafınıza var ise kiralık olarak verilen cihazları teslim etmeniz ve ıslak imza ile onay vermeniz halinde sözleşmeniz feshedilecektir. HALKBANK HESAP ADI: AKARNET TELEKOM Sanayi Ticaret Limited Şirketi İBAN NO: TR28 0006 2000 2560 0006 2891 93 ( açıklama bölümüne İSİM SOYİSİM YAZILMALIDIR) Bilginize';
        // $delivery_date = Carbon::now()->addDays(1)->format('dmY1400'); // SMS 1 gün sonra saat14:00 da gönderiyor
        $delivery_date = Carbon::now();

        if($sms->submit_in_time('RUZGARNET', $cancel_message , $phone, $delivery_date)){
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'reload' => true
            ]);
        }else{
            return response()->json([
                'error' => true,
                'toastr' => [
                    'type' => 'error',
                    'title' => trans('response.title.error'),
                    'message' => trans('response.insert.error')
                ]
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        if (Message::insert($validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.insert.success')
                ],
                'redirect' => relative_route('admin.messages')
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.insert.error')
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Message $message)
    {
        return view('admin.message.edit', ['message' => $message]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Message $message)
    {
        $rules = $this->rules();

        $rules['key']['unique'] = Rule::unique('messages', 'key')->ignore($message->id);

        $validated = $request->validate($rules);

        if ($message->update($validated)) {
            return response()->json([
                'success' => true,
                'toastr' => [
                    'type' => 'success',
                    'title' => trans('response.title.success'),
                    'message' => trans('response.edit.success')
                ],
                'redirect' => relative_route('admin.messages')
            ]);
        }

        return response()->json([
            'error' => true,
            'toastr' => [
                'type' => 'error',
                'title' => trans('response.title.error'),
                'message' => trans('response.edit.error')
            ]
        ]);
    }

    /**
     * Rules for validation
     *
     * @return array
     */
    private function rules()
    {
        return [
            'key' => [
                'required',
                'string',
                'max:255',
                'unique' => Rule::unique('messages', 'key')
            ],
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ];
    }
}
