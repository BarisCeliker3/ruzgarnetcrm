<?php



use Illuminate\Support\Facades\Route;




/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::middleware('admin.middleware')->name('admin.')->group(function () {

    // Auth Routes

    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');

    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');

    Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    // Auth Routes End



    // Main Routes

    Route::get('/', [App\Http\Controllers\Admin\MainController::class, 'index'])->name('dashboard');

    Route::get('search', [App\Http\Controllers\Admin\MainController::class, 'search'])->name('search');

    Route::get('infrastructure', [App\Http\Controllers\Admin\MainController::class, 'infrastructure'])->name('infrastructure');

    Route::get('/cant', [App\Http\Controllers\Admin\MainController::class, 'cant'])->name('cant');

    Route::match(['get', 'post'], '/report', [App\Http\Controllers\Admin\MainController::class, 'report'])->name('report');

    Route::get('excel', [App\Http\Controllers\Admin\MainController::class, 'excel'])->name('excel');

    Route::get('/cayma_bedeli/{subscription}', [App\Http\Controllers\Admin\MainController::class, 'cayma_bedeli'])->name('cayma_bedeli');

    // Main Routes End



    // Dealer Routes

    Route::get('dealers', [App\Http\Controllers\Admin\DealerController::class, 'index'])->name('dealers');

    Route::get('dealer/add', [App\Http\Controllers\Admin\DealerController::class, 'create'])->name('dealer.add');

    Route::post('dealer/add', [App\Http\Controllers\Admin\DealerController::class, 'store'])->name('dealer.add.post');

    Route::get('dealer/edit/{dealer}', [App\Http\Controllers\Admin\DealerController::class, 'edit'])->name('dealer.edit');

    Route::put('dealer/edit/{dealer}', [App\Http\Controllers\Admin\DealerController::class, 'update'])->name('dealer.edit.put');

    // Dealer Routes End



    // Staff Routes

    Route::get('staffs', [App\Http\Controllers\Admin\StaffController::class, 'index'])->name('staffs');

    Route::get('staff/add', [App\Http\Controllers\Admin\StaffController::class, 'create'])->name('staff.add');

    Route::post('staff/add', [App\Http\Controllers\Admin\StaffController::class, 'store'])->name('staff.add.post');

    Route::get('staff/edit/{staff}', [App\Http\Controllers\Admin\StaffController::class, 'edit'])->name('staff.edit');

    Route::put('staff/edit/{staff}', [App\Http\Controllers\Admin\StaffController::class, 'update'])->name('staff.edit.put');

    // Staff Routes End



    // User Routes

    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');

    Route::get('user/add', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('user.add');

    Route::post('user/add', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('user.add.post');

    Route::get('user/edit/{user}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.edit');

    Route::put('user/edit/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('user.edit.put');

    Route::delete('user/delete/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('user.delete');

    // User Routes End



    //  Customer Routes

    Route::get('customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers');

    Route::get('customer/list', [App\Http\Controllers\Admin\CustomerController::class, 'list'])->name('list');

    Route::get('customer/add', [App\Http\Controllers\Admin\CustomerController::class, 'create'])->name('customer.add');

    Route::post('customer/add', [App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('customer.add.post');

    Route::get('customer/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customer.show');

    Route::get('customer/edit/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('customer.edit');

    Route::put('customer/edit/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('customer.edit.put');

    Route::put('customer/approve/{customer}', [App\Http\Controllers\Admin\CustomerController::class, 'approve'])->name('customer.approve.post');

    Route::get('activities/{customer}', [App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activities');

    Route::get('customer-sms/{customer}', [App\Http\Controllers\Admin\CustomerNoteControler::class, 'sms_list'])->name('customer.sms');

    Route::get('customer-notes/{customer}', [App\Http\Controllers\Admin\CustomerNoteControler::class, 'index'])->name('customer.notes');

    Route::get('customer-note/add/{customer}', [App\Http\Controllers\Admin\CustomerNoteControler::class, 'create'])->name('customer.note.add');

    Route::post('customer-note/add/{customer}', [App\Http\Controllers\Admin\CustomerNoteControler::class, 'store'])->name('customer.note.add.post');

    //

    Route::get('customer-documents/{customer}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'index'])->name('customer.documents');

  //  Route::get('customer-document/add/{customer}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'create'])->name('customer.document.add');

  //  Route::post('customer-document/add/{customer}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'store'])->name('customer.document.add.post');





  //customer-document

    Route::get('customer-document/ekle/{customer}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'create'])->name('customer.document.ekle');

    Route::post('customer-document/ekle/{customer}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'ekle'])->name('customer.document.ekle.post');



    Route::get('customer-document/file-upload/{customer}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'createUpload'])->name('customer.document.ekleme');

    Route::post('customer-document/file-upload/{customer}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'ekleme'])->name('customer.document.ekleme.post');

    Route::get('customer-document/edit/{id}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'edit'])->name('customer.document.edit');

    Route::post('customer-document/file-upload-edit/{id}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'postedit'])->name('customer.document.postedit');



    Route::get('customer-document', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'pdfdocument'])->name('pdfdocuments');

         Route::get('subsentercompany',[App\Http\Controllers\Admin\CustomerApplicationController::class,'subsentercompany'])->name('new.subsentercompany');



    Route::post('customer-documents/{id}', [App\Http\Controllers\Admin\CustomerDocumentControler::class, 'delete'])->name('customer.delete');

  //  customer-document



    // Contract Type Routes

    Route::get('contract-types', [App\Http\Controllers\Admin\ContractTypeController::class, 'index'])->name('contract.types');

    Route::get('contract-type/add', [App\Http\Controllers\Admin\ContractTypeController::class, 'create'])->name('contract.type.add');

    Route::post('contract-type/add', [App\Http\Controllers\Admin\ContractTypeController::class, 'store'])->name('contract.type.add.post');

    Route::get('contract-type/edit/{contractType}', [App\Http\Controllers\Admin\ContractTypeController::class, 'edit'])->name('contract.type.edit');

    Route::put('contract-type/edit/{contractType}', [App\Http\Controllers\Admin\ContractTypeController::class, 'update'])->name('contract.type.edit.put');

    // Contract Type Routes End



    // Category Routes

    Route::get('categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories');

    Route::get('category/add', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('category.add');

    Route::post('category/add', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('category.add.post');

    Route::get('category/edit/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('category.edit');

    Route::put('category/edit/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('category.edit.put');

    // Category Routes End



    // Product Routes

    Route::get('products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products');

    Route::get('product/add', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('product.add');

    Route::post('product/add', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('product.add.post');

    Route::get('product/edit/{product}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('product.edit');

    Route::put('product/edit/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('product.edit.put');

    Route::delete('product/delete/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.delete');

    // Product Routes End



    // Service Routes

    Route::get('services', [App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('services');

    Route::get('service/add', [App\Http\Controllers\Admin\ServiceController::class, 'create'])->name('service.add');

    Route::post('service/add', [App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('service.add.post');

    Route::get('service/edit/{service}', [App\Http\Controllers\Admin\ServiceController::class, 'edit'])->name('service.edit');

    Route::put('service/edit/{service}', [App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('service.edit.put');

    // Service Routes End



    // Message Routes

    Route::get('messages', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages');

    Route::get('message/add', [App\Http\Controllers\Admin\MessageController::class, 'create'])->name('message.add');

    Route::post('message/add', [App\Http\Controllers\Admin\MessageController::class, 'store'])->name('message.add.post');

    Route::get('message/edit/{message}', [App\Http\Controllers\Admin\MessageController::class, 'edit'])->name('message.edit');

    Route::put('message/edit/{message}', [App\Http\Controllers\Admin\MessageController::class, 'update'])->name('message.edit.put');

    Route::get('message/send', [App\Http\Controllers\Admin\MessageController::class, 'send'])->name('message.send');

    Route::post('message/send', [App\Http\Controllers\Admin\MessageController::class, 'submit'])->name('message.send.post');

    Route::post('message/send/spesific', [App\Http\Controllers\Admin\MessageController::class, 'send_sms_spesific'])->name('message.send.spesific');

    Route::post('message/send/cancel_payment', [App\Http\Controllers\Admin\MessageController::class, 'send_sms_cancel_payment'])->name('message.send.cancel_payment');

    Route::post('message/send/manuel', [App\Http\Controllers\Admin\MessageController::class, 'send_sms_manuel'])->name('message.send.manuel');

    Route::get('message/send/{payment}', [App\Http\Controllers\Admin\MessageController::class, 'send_sms_payment'])->name('message.send.payment');

    // Message Routes End



    // Subscription Routes

    Route::get('subscriptions/{status?}', [App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('subscriptions')->where('status', '[0-9]+');

    

    Route::get('subscriptionList', [App\Http\Controllers\Admin\SubscriptionController::class, 'testof'])->name('subscriptionlists'); 

    

    Route::get('subscription/list', [App\Http\Controllers\Admin\SubscriptionController::class, 'list'])->name('subscription.list');

    Route::get('subscription/add', [App\Http\Controllers\Admin\SubscriptionController::class, 'create'])->name('subscription.add');

    Route::post('subscription/add', [App\Http\Controllers\Admin\SubscriptionController::class, 'store'])->name('subscription.add.post');

    Route::get('subscription/edit/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'edit'])->name('subscription.edit');

    Route::match(['get', 'post'], 'subscription/extend_subscribers_end_date', [App\Http\Controllers\Admin\SubscriptionController::class, 'extendSubscribersEndDate'])->name('subscription.extend_subscribers_end_date');

    Route::match(['get', 'post'], 'subscription/subscriber_statistics', [App\Http\Controllers\Admin\SubscriptionController::class, 'subscriberStatistics'])->name('subscription.subscriber_statistics');

    Route::post('subscription/finish_extend', [App\Http\Controllers\Admin\SubscriptionController::class, 'updateSubscribersEndDate'])->name('subscription.finish_extend_transaction');

    //Route::post('subscription/add', [App\Http\Controllers\Admin\SubscriptionController::class, 'store'])->name('subscription.add.post');





    //Hediye

    Route::get('Akıllı-Bileklik-Hediye', [App\Http\Controllers\Admin\PaymentController::class, 'hediye'])->name('hediyes');

    

      Route::get('fineresult', [App\Http\Controllers\Admin\PaymentController::class, 'fineresult'])->name('fineresult');

    Route::get('Akıllı-Bileklik-Hediye/{id}', [App\Http\Controllers\Admin\PaymentController::class, 'hediyeGonder'])->name('hediyeGonder');

    Route::post('Akıllı-Bileklik-Hediye', [App\Http\Controllers\Admin\PaymentController::class, 'hediyeGonderPost'])->name('hediyeGonderPost');

    

    //mokacontrol

    Route::get('moka-kontrol', [App\Http\Controllers\Admin\CustomerController::class, 'mochacontrols'])->name('mochacontrols');

    

    //İnternet setup kurulum istanbul

     Route::get('İnternet-Kurulumu', [App\Http\Controllers\Admin\InternetsetupController::class, 'index'])->name('internetsetups');

     Route::get('İnternet-Kurulumu/Ekle', [App\Http\Controllers\Admin\InternetsetupController::class, 'add'])->name('internetsetup');

     Route::post('İnternet-Kurulumu/Ekle', [App\Http\Controllers\Admin\InternetsetupController::class, 'addPost'])->name('addPost');

     

     Route::get('İnternet-Kurulumu/edit/{id}', [App\Http\Controllers\Admin\InternetsetupController::class, 'edit'])->name('internetsetup.edit');

     Route::post('İnternet-Kurulumu/edit/{id}', [App\Http\Controllers\Admin\InternetsetupController::class, 'postedit'])->name('internetsetup.postedit');

     

     

     Route::get('İnternet-Kurulumu/kurulum', [App\Http\Controllers\Admin\InternetsetupController::class, 'kurulum'])->name('kurulums');



     

     



    // hazırlık aşaması

    Route::get('Hazırlık-Aşaması', [App\Http\Controllers\Admin\SubscriptionController::class, 'hazirlik'])->name('hazirliks');



    Route::get('subscription/edit1/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'edit1'])->name('subscription.edit1');



    Route::get('subscription/edit2/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'edit2'])->name('subscription.edit2');

    Route::get('subscription/edit3/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'hizmetno'])->name('subscription.hizmetno');

    Route::post('subscription/edit3/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'hizmetnoupdate'])->name('subscription.hizmetnoupdate.put2');





    Route::put('subscription/edit/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'update'])->name('subscription.edit.put');



    Route::post('subscription/edit1/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'update1'])->name('subscription.edit1.put1');



    Route::post('subscription/edit2/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'update2'])->name('subscription.edit2.put2');



    



    Route::delete('subscription/delete/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'destroy'])->name('subscription.delete');

    Route::put('subscription/approve/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'approve'])->name('subscription.approve.post');

    Route::put('subscription/unapprove/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'unApprove'])->name('subscription.unapprove.post');

    Route::get('subscription/{subscription}/payments', [App\Http\Controllers\Admin\SubscriptionController::class, 'payments'])->name('subscription.payments');

    Route::put('subscription/price/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'price'])->name('subscription.price');

    Route::get('subscription/change/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'change'])->name('subscription.change');

    Route::put('subscription/change/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'upgrade'])->name('subscription.change.put');

    Route::put('subscription/cancel/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'cancel'])->name('subscription.cancel.put');



    Route::get('subscription/contract/preview/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'preview'])->name('subscription.contract');



    Route::get('subscription/contract/preview1/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'generatePDF'])->name('subscription.contract1');



    Route::get('subscription/contract/preview2/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'generatePDF2'])->name('subscription.contract2');



    Route::put('subscription/freeze/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'freeze'])->name('subscription.freeze.put');

    Route::put('subscription/unfreeze/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'unFreeze'])->name('subscription.unfreeze.put');

    Route::put('subscription/cancel_auto_payment/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'cancel_auto_payment'])->name('subscription.cancel.auto.payment');

    Route::get('subscription/payments/{payment}', [App\Http\Controllers\Admin\SubscriptionController::class, 'get_payments'])->name('subscription.get_payments');

    Route::put('subscription/renewal/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'renewal'])->name('subscription.renewal.put');

    Route::put('subscription/end/commitment/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'end_commitment'])->name('subscription.end.commitment.put');

    // Subscription Routes End



    // Payment Routes

    Route::get('payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments');

    Route::match(['get', 'post'], 'payment/penalties', [App\Http\Controllers\Admin\PaymentController::class, 'listPenalties'])->name('payment.penalties');

    Route::get('payment/paid', [App\Http\Controllers\Admin\PaymentController::class, 'listPaid'])->name('payment.paid');

    Route::get('payment/notpaid', [App\Http\Controllers\Admin\PaymentController::class, 'listNotPaid'])->name('payment.notpaid');

    Route::match(['get', 'post'], 'payment/monthly', [App\Http\Controllers\Admin\PaymentController::class, 'listMonthly'])->name('payment.monthly');

    Route::match(['get', 'post'], 'payment/daily', [App\Http\Controllers\Admin\PaymentController::class, 'listDaily'])->name('payment.daily');

    Route::match(['get', 'post'], 'payment/invoice', [App\Http\Controllers\Admin\PaymentController::class, 'listInvoice'])->name('payment.invoice');

    Route::get('payment/list', [App\Http\Controllers\Admin\PaymentController::class, 'list'])->name('payment.list');

    Route::post('payment/received/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'received'])->name('payment.received.post');

    Route::post('payment/test/received/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'test_received'])->name('payment.test.received.post');

    Route::put('payment/price/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'price'])->name('payment.price.put');

    Route::post('payment/add/{subscription}', [App\Http\Controllers\Admin\PaymentController::class, 'store'])->name('subscription.payment.add');

    Route::post('payment/cancel/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'cancel'])->name('subscription.payment.cancel');

    Route::delete('payment/delete/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'destroy'])->name('subscription.payment.delete');

    // Payment Routes End



    // Reference Routes

    Route::get('references', [App\Http\Controllers\Admin\ReferenceController::class, 'index'])->name('references');

    Route::get('reference/{subscription}', [App\Http\Controllers\Admin\ReferenceController::class, 'create'])->name('reference.add');

    Route::post('reference/{subscription}', [App\Http\Controllers\Admin\ReferenceController::class, 'store'])->name('reference.add.post');

    Route::put('reference/edit/{reference}', [App\Http\Controllers\Admin\ReferenceController::class, 'update'])->name('reference.edit.put');

    // Reference Routes



     // task Routes

    Route::get('assignments', [App\Http\Controllers\Admin\TaskController::class, 'assignments'])->name('assignments');

   // Route::get('assignments/edit/{id}', [App\Http\Controllers\Admin\TaskController::class, 'assignment'])->name('assignment.edit');

   Route::get('assigadds/create', [App\Http\Controllers\Admin\TaskController::class, 'create'])->name('assigadds');

   Route::post('assigadds/create',[App\Http\Controllers\Admin\TaskController::class, 'postadd'])->name('assigadds.post');

   Route::get('assigadds/{id}', [App\Http\Controllers\Admin\TaskController::class,  'getupdate'])->name('assigadds.update');

   Route::post('assigadds/edit/{id}', [App\Http\Controllers\Admin\TaskController::class,  'postupdate'])->name('assigadds.update.post');



   Route::get('servicesraport', [App\Http\Controllers\Admin\TaskController::class, 'servicesraport'])->name('servicesraports');



   Route::get('satisraports', [App\Http\Controllers\Admin\TaskController::class, 'satisraports'])->name('satisraports');



    Route::get('task', [App\Http\Controllers\Admin\TaskController::class, 'index'])->name('task');

   // Route::get('task/edit/{task}', [App\Http\Controllers\Admin\TaskController::class,  'edit'])->name('task.edit');

    //Route::put('task/edit/{task}', [App\Http\Controllers\Admin\TaskController::class, 'update'])->name('task.edit.put');

   Route::get('task/edit/{id}', [App\Http\Controllers\Admin\TaskController::class,  'update'])->name('task.edit');

   Route::post('task/edit/{id}', [App\Http\Controllers\Admin\TaskController::class,  'updatePost'])->name('task.edit.post');

   Route::post('task/ekleme/{id}', [App\Http\Controllers\Admin\TaskController::class, 'ekleme'])->name('task.ekleme');

  





    Route::post('task', [App\Http\Controllers\Admin\TaskController::class, 'store'])->name('task.store');

   // Route::get('isscontrols', [App\Http\Controllers\Admin\ContractEndingsController::class, 'isscontrols'])->name('isscontrols');





   // Route::get('reference/{subscription}', [App\Http\Controllers\Admin\ReferenceController::class, 'create'])->name('reference.add');

   // Route::post('reference/{subscription}', [App\Http\Controllers\Admin\ReferenceController::class, 'store'])->name('reference.add.post');



    // task Routes





    //RCB

     Route::get('rcbs', [App\Http\Controllers\Admin\RcbController::class, 'index'])->name('rcbs');

     Route::post('rcb/add', [App\Http\Controllers\Admin\RcbController::class,      'store'])->name('rcb.store');

     Route::get('rcb/add/{id}', [App\Http\Controllers\Admin\RcbController::class, 'ekleme'])->name('rcb.ekleme');



     Route::get('rcb/edit/{id}', [App\Http\Controllers\Admin\RcbController::class, 'edit'])->name('rcb.edit');

     Route::post('rcb/edit/{id}', [App\Http\Controllers\Admin\RcbController::class, 'editPost'])->name('rcb.edit.post');



     Route::get('rcbadmins', [App\Http\Controllers\Admin\RcbController::class, 'rapor'])->name('rcbadmins');

     //Route::post('task/ekleme/{id}', [App\Http\Controllers\Admin\TaskController::class, 'ekleme'])->name('task.ekleme');

    //RCB



    //STOK TAKIP

    Route::get('stok-takip', [App\Http\Controllers\Admin\StokTakipController::class, 'index'])->name('stoktakips');



    Route::get('stok-ekle', [App\Http\Controllers\Admin\StokTakipController::class, 'stokekle'])->name('stokekle');

    Route::post('stok-ekle', [App\Http\Controllers\Admin\StokTakipController::class, 'stokekleme'])->name('stokekleme');



    Route::get('stok-müşteri', [App\Http\Controllers\Admin\StokTakipController::class, 'stokCustomersEkle'])->name('stokCustomersEkle');

    Route::post('stok-müşteri/ekle', [App\Http\Controllers\Admin\StokTakipController::class, 'stokCustomersEkleme'])->name('stokCustomersEkleme');



    Route::get('stok-müşteri/liste', [App\Http\Controllers\Admin\StokTakipController::class, 'stoklistes'])->name('stoklistes');

    Route::get('stok-müşteri-güncelle/{id}', [App\Http\Controllers\Admin\StokTakipController::class, 'stoklistedit'])->name('stoklistedit');

    Route::post('stok-müşteri-güncelle/{id}', [App\Http\Controllers\Admin\StokTakipController::class, 'stoklistPost'])->name('stoklistPost');



    Route::get('stok-müşteri-iade/{id}', [App\Http\Controllers\Admin\StokTakipController::class, 'stoklistedit2'])->name('stoklistedit2');

    Route::post('stok-müşteri-iade/{id}', [App\Http\Controllers\Admin\StokTakipController::class, 'stoklistPost2'])->name('stoklistPost2');



    Route::get('stok-güncelle/{id}', [App\Http\Controllers\Admin\StokTakipController::class, 'stokedit'])->name('stokedit');

    Route::post('stok-güncelle/{id}', [App\Http\Controllers\Admin\StokTakipController::class, 'stokPost'])->name('stokPost');

    

    Route::get('eski-iade/{id}', [App\Http\Controllers\Admin\StokTakipController::class, 'eskiiade'])->name('eskiiade');

    

    Route::get('eski-iade', [App\Http\Controllers\Admin\StokTakipController::class, 'eskiiade'])->name('eskiiade');

    Route::post('eski-iade/ekle', [App\Http\Controllers\Admin\StokTakipController::class, 'eskiiadeEkle'])->name('eskiiadeEkle');

    //STOK TAKIP



    // Expense Report - Gider Raporu

    Route::get('expensereport', [App\Http\Controllers\Admin\ExpenController::class, 'index'])->name('expensereports');

    Route::get('mutfak', [App\Http\Controllers\Admin\ExpenController::class, 'mutfak'])->name('mutfak');

    Route::get('pos', [App\Http\Controllers\Admin\ExpenController::class, 'pos'])->name('pos');

    Route::get('yakit', [App\Http\Controllers\Admin\ExpenController::class, 'yakit'])->name('yakit');

    Route::get('kasa', [App\Http\Controllers\Admin\ExpenController::class, 'kasa'])->name('kasa');

    Route::get('digerGiderler', [App\Http\Controllers\Admin\ExpenController::class, 'digerGiderler'])->name('digerGiderler');

    Route::get('dekonts', [App\Http\Controllers\Admin\ExpenController::class, 'dekont'])->name('dekont');

    Route::get('expenselist', [App\Http\Controllers\Admin\ExpenController::class, 'expenselist'])->name('expenselists');

    

    Route::get('gider-ekle', [App\Http\Controllers\Admin\ExpenController::class, 'giderekle'])->name('giderekle');

    Route::post('gider-ekle/dekont', [App\Http\Controllers\Admin\ExpenController::class, 'gidereklePost'])->name('gidereklePost');

    // -- Expense Report - Gider Raporu



    // city list - Şehir Lİstesi

    Route::get('citylist', [App\Http\Controllers\Admin\CityListController::class, 'index'])->name('citylists');

    // -- city list - Şehir Listesi

    // Fault Record Routes

    Route::get('active/fault/records', [App\Http\Controllers\Admin\FaultRecordController::class, 'actives'])->name('active.fault.records');

    Route::get('fault/records', [App\Http\Controllers\Admin\FaultRecordController::class, 'index'])->name('fault.records');

    Route::get('fault/record/add', [App\Http\Controllers\Admin\FaultRecordController::class, 'create'])->name('fault.record.add');

    Route::post('fault/record/add', [App\Http\Controllers\Admin\FaultRecordController::class, 'store'])->name('fault.record.add.post');

    Route::get('fault/record/edit/{faultRecord}', [App\Http\Controllers\Admin\FaultRecordController::class, 'edit'])->name('fault.record.edit');

    Route::put('fault/record/edit/{faultRecord}', [App\Http\Controllers\Admin\FaultRecordController::class, 'update'])->name('fault.record.edit.put');

    // Fault Record Routes End

    // iptal edilenler

    Route::get('iptal-edilenler',[App\Http\Controllers\Admin\CustomerApplicationController::class,'cancelapp'])->name('cancel.iptal');

    Route::get('yeni-abonelikler',[App\Http\Controllers\Admin\SubscriptionController::class,'newsubs'])->name('new.subs');





    // Fault Type Routes

    Route::get('fault/types', [App\Http\Controllers\Admin\FaultTypeController::class, 'index'])->name('fault.types');

    Route::get('fault/type/add', [App\Http\Controllers\Admin\FaultTypeController::class, 'create'])->name('fault.type.add');

    Route::post('fault/type/add', [App\Http\Controllers\Admin\FaultTypeController::class, 'store'])->name('fault.type.add.post');

    Route::get('fault/type/edit/{faultType}', [App\Http\Controllers\Admin\FaultTypeController::class, 'edit'])->name('fault.type.edit');

    Route::put('fault/type/edit/{faultType}', [App\Http\Controllers\Admin\FaultTypeController::class, 'update'])->name('fault.type.edit.put');

    // Fault Type Routes End

    // Frozenones

    Route::get('frozenones', [App\Http\Controllers\Admin\FrozenonesController::class, 'index'])->name('frozenones');

    // --Frozenones

    // Customer Application Routes

    Route::get('customer_applications', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'index'])->name('customer.applications');

    Route::get('customer_application/add', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'create'])->name('customer.application.add');

    Route::post('customer_application/add', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'store'])->name('customer.application.add.post');

    Route::get('customer_application/edit/{customer_application}', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'edit'])->name('customer.application.edit');

    Route::post('customer_application/edit/{customer_application}', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'update'])->name('customer.application.edit.post');



    Route::get('rzgcancels', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'index1'])->name('rzgcancels');

   // Route::get('rzgcancels', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'index4'])->name('rzgcancels');

    Route::get('rzgcancels/yonlendirme', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'index2'])->name('canceldirections');

    Route::get('rzgcancels/yonlendirme2', [App\Http\Controllers\Admin\CustomerApplicationController::class, 'index3'])->name('canceldirection2s');

    // Customer Application Routes End



    // Customer Application Routes

    Route::get('customer_application_types', [App\Http\Controllers\Admin\CustomerApplicationTypeController::class, 'index'])->name('customer.application.types');

    Route::get('customer_application_type/add', [App\Http\Controllers\Admin\CustomerApplicationTypeController::class, 'create'])->name('customer.application.type.add');

    Route::post('customer_application_type/add', [App\Http\Controllers\Admin\CustomerApplicationTypeController::class, 'store'])->name('customer.application.type.add.post');

    Route::get('customer_application_type/edit/{customer_application_type}', [App\Http\Controllers\Admin\CustomerApplicationTypeController::class, 'edit'])->name('customer.application.type.edit');

    Route::put('customer_application_type/edit/{customer_application_type}', [App\Http\Controllers\Admin\CustomerApplicationTypeController::class, 'update'])->name('customer.application.type.edit.put');

    // Customer Application Routes End



    // Role Routes

    Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles');

    Route::get('role/add', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('role.add');

    Route::post('role/add', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('role.add.post');

    Route::get('role/edit/{role}', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('role.edit');

    Route::put('role/edit/{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('role.edit.put');

    // Role Routes End



    // RequestMessage Routes

    Route::get('request_messages', [App\Http\Controllers\Admin\RequestMessageController::class, 'index'])->name('request.messages');

    Route::get('request_message/add', [App\Http\Controllers\Admin\RequestMessageController::class, 'create'])->name('request.message.add');

    Route::post('request_message/add', [App\Http\Controllers\Admin\RequestMessageController::class, 'store'])->name('request.message.add.post');

    Route::get('request_message/edit/{request_message}', [App\Http\Controllers\Admin\RequestMessageController::class, 'edit'])->name('request.message.edit');

    Route::put('request_message/edit/{request_message}', [App\Http\Controllers\Admin\RequestMessageController::class, 'update'])->name('request.message.edit.put');

    Route::delete('request_message/delete/{request_message}', [App\Http\Controllers\Admin\RequestMessageController::class, 'destroy'])->name('request.message.delete');

    // RequestMessage Routes End



    // Promotion Routes

    Route::get('promotions', [App\Http\Controllers\Admin\PromotionController::class, 'index'])->name('promotions');

    Route::get('promotion/add', [App\Http\Controllers\Admin\PromotionController::class, 'create'])->name('promotion.add');

    Route::post('promotion/add', [App\Http\Controllers\Admin\PromotionController::class, 'store'])->name('promotion.add.post');

    Route::get('promotion/edit/{promotion}', [App\Http\Controllers\Admin\PromotionController::class, 'edit'])->name('promotion.edit');

    Route::put('promotion/edit/{promotion}', [App\Http\Controllers\Admin\PromotionController::class, 'update'])->name('promotion.edit.put');

    Route::delete('promotion/delete/{promotion}', [App\Http\Controllers\Admin\PromotionController::class, 'destroy'])->name('promotion.delete');

    // Promotion Routes End



    // Code Routes

    Route::get('codes', [App\Http\Controllers\Admin\CodeController::class, 'index'])->name('codes');

    Route::get('code/add', [App\Http\Controllers\Admin\CodeController::class, 'create'])->name('code.add');

    Route::post('code/add', [App\Http\Controllers\Admin\CodeController::class, 'store'])->name('code.add.post');

    Route::get('code/message_edit', [App\Http\Controllers\Admin\CodeController::class, 'message_edit'])->name('code.message_edit');

    Route::put('code/message_edit', [App\Http\Controllers\Admin\CodeController::class, 'message_update'])->name('code.message_edit.put');

    // Code Routes End



    // OtherSales Routes

    Route::get('othersales', [App\Http\Controllers\Admin\OtherSalesController::class, 'index'])->name('othersales');

    Route::get('othersale/add', [App\Http\Controllers\Admin\OtherSalesController::class, 'create'])->name('othersale.add');

    Route::post('othersale/add', [App\Http\Controllers\Admin\OtherSalesController::class, 'store'])->name('othersale.add.post');

    Route::get('othersale/edit/{othersale}', [App\Http\Controllers\Admin\OtherSalesController::class, 'edit'])->name('othersale.edit');

    Route::put('othersale/edit/{othersale}', [App\Http\Controllers\Admin\OtherSalesController::class, 'update'])->name('othersale.edit.put');

    Route::match(['get', 'post'], 'othersale/report', [App\Http\Controllers\Admin\OtherSalesController::class, 'report'])->name('othersale.report');

   // OtherSales Routes End



    // Other Expenses Ways of Expenditure

    Route::get('/get-services/{categoryId}', [App\Http\Controllers\Admin\UpdateServicesController::class, 'getServicesByCategory'])->name('get.services');

    Route::get('/admin/update-services', [App\Http\Controllers\Admin\UpdateServicesController::class, 'index'])->name('updateServices.index');

    Route::post('/admin/update-service', [App\Http\Controllers\Admin\UpdateServicesController::class, 'updateService'])->name('updateService');

    Route::delete('/admin/delete-service/{id}', [App\Http\Controllers\Admin\UpdateServicesController::class, 'delete'])->name('deleteservice');



    Route::get('updateServices', [App\Http\Controllers\Admin\UpdateServicesController::class, 'index'])->name('updateservices');

    Route::post('updateServicesPost', [App\Http\Controllers\Admin\UpdateServicesController::class, 'update'])->name('updateservicespost');

    Route::get('otherexpenses', [App\Http\Controllers\Admin\OtherExpensesController::class, 'index'])->name('otherexpenses');

    Route::get('otherexpense/add', [App\Http\Controllers\Admin\OtherExpensesController::class, 'create'])->name('otherexpense.add');

    Route::post('otherexpense/add', [App\Http\Controllers\Admin\OtherExpensesController::class, 'store'])->name('otherexpense.add.post');

    Route::get('otherexpense/edit/{otherexpense}', [App\Http\Controllers\Admin\OtherExpensesController::class, 'edit'])->name('otherexpense.edit');

    Route::put('otherexpense/edit/{otherexpense}', [App\Http\Controllers\Admin\OtherExpensesController::class, 'update'])->name('otherexpense.edit.put');

    Route::match(['get', 'post'], 'otherexpense/report', [App\Http\Controllers\Admin\OtherExpensesController::class, 'report'])->name('otherexpense.report');

    Route::match(['get', 'post'],'otherexpense/expenselist', [App\Http\Controllers\Admin\OtherExpensesController::class, 'expenselist'])->name('otherexpense.expenselist');

    // Other Expenses Ways of Expenditure



    // Accounting Ways of Expenditure

    Route::get('accountings', [App\Http\Controllers\Admin\AccountingController::class, 'index'])->name('accountings');

    Route::get('accounting/add', [App\Http\Controllers\Admin\AccountingController::class, 'create'])->name('accounting.add');

    Route::post('accounting/add', [App\Http\Controllers\Admin\AccountingController::class, 'store'])->name('accounting.add.post');

    Route::get('accounting/report', [App\Http\Controllers\Admin\AccountingController::class, 'report'])->name('accountingreports');

    // Accounting Ways of Expenditure



// Fault Records



    // Spending Routes

    Route::match(['get', 'post'],'spending', [App\Http\Controllers\Admin\SpendingController::class, 'index'])->name('spendings');

    Route::get('spending/add', [App\Http\Controllers\Admin\SpendingController::class, 'create'])->name('spending.add');

    Route::post('spending/add', [App\Http\Controllers\Admin\SpendingController::class, 'store'])->name('spending.add.post');

    Route::get('spending/edit/{spending}', [App\Http\Controllers\Admin\SpendingController::class, 'edit'])->name('spending.edit');

    Route::put('spending/edit/{spending}', [App\Http\Controllers\Admin\SpendingController::class, 'update'])->name('spending.edit.put');

    // Spending Routes End



    //SubscriptionUpgrade Routes

    Route::get('subscriptionupgrades', [App\Http\Controllers\Admin\SubscriptionUpgradeController::class, 'index'])->name('subscriptionupgrades');

    Route::get('subscriptionupgrade/edit/{subscriptionupgrade}', [App\Http\Controllers\Admin\SubscriptionUpgradeController::class, 'edit'])->name('subscriptionupgrade.edit');

    Route::put('subscriptionupgrade/edit/{subscriptionupgrade}', [App\Http\Controllers\Admin\SubscriptionUpgradeController::class, 'update'])->name('subscriptionupgrade.edit.put');

    //SubscriptionUpgrade Routes End



    //commit control Routes

    // Route::get('commitcontrols', [App\Http\Controllers\Admin\CommitControlController::class, 'index'])->name('commitcontrols');

    //commit control Routes End



    //Contract Endings Routes

     Route::get('contractendings', [App\Http\Controllers\Admin\ContractEndingsController::class, 'index'])->name('contractendings');

     Route::get('contractending/edit/{contractending}', [App\Http\Controllers\Admin\ContractEndingsController::class, 'edit'])->name('contractending.edit');

     Route::put('contractending/edit/{contractending}', [App\Http\Controllers\Admin\ContractEndingsController::class, 'update'])->name('contractending.edit.put');

     Route::get('contractending/add', [App\Http\Controllers\Admin\ContractEndingsController::class, 'create'])->name('contractending.add');

     Route::post('contractending/post', [App\Http\Controllers\Admin\ContractEndingsController::class, 'updateExpiringSubscriptions'])->name('update.subscriptions');



    //contractendings

     Route::post('contractending/ekleme', [App\Http\Controllers\Admin\ContractEndingsController::class, 'store'])->name('contractending.store');

     Route::get('contractending/ekleme/{id}', [App\Http\Controllers\Admin\ContractEndingsController::class, 'ekleme'])->name('contractending.ekleme');

     Route::get('isscontrols', [App\Http\Controllers\Admin\ContractEndingsController::class, 'isscontrols'])->name('isscontrols');









    Route::post('contractending/add', [App\Http\Controllers\Admin\ContractEndingsController::class, 'store'])->name('contractending.add.post');

    Route::get('contract-notes/{contractending}', [App\Http\Controllers\Admin\ContractEndingNoteControler::class, 'index'])->name('contractending.notes');

    Route::get('contract-notes/add/{contractending}', [App\Http\Controllers\Admin\ContractEndingNoteControler::class, 'create'])->name('contractending.note.add');

    Route::post('contract-notes/add/{contractending}', [App\Http\Controllers\Admin\ContractEndingNoteControler::class, 'store'])->name('contractending.note.add.post');

    /*

     //Contract Endings Routes End

     /subscriber-counter Routes

     Route::get('subscriptioncounters', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'index'])->name('subscriptioncounters');

     Route::get('subscriptioncounter/add', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'create'])->name('subscriptioncounter.add');

    Route::post('subscriptioncounter/add', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'store'])->name('subscriptioncounter.add.post');

    Route::get('subscriptioncounter/edit/{subscriptioncounter}', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'edit'])->name('subscriptioncounter.edit');

    Route::put('subscriptioncounter/edit/{subscriptioncounter}', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'update'])->name('subscriptioncounter.edit.put');

    Route::match(['get', 'post'], 'subscriptioncounter/report', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'report'])->name('subscriptioncounter.report');

    Route::match(['get', 'post'],'subscriptioncounter/expenselist', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'expenselist'])->name('subscriptioncounter.expenselist');

    //Suscriber Counter Routes End */

    // subscriber-counter Ways of Expenditure

    Route::get('subscribercounters', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'index'])->name('subscribercounters');

    Route::get('subscribercounter/add', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'create'])->name('subscribercounter.add');

    Route::post('subscribercounter/add', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'store'])->name('subscribercounter.add.post');

    Route::get('subscribercounter/edit/{subscribercounter}', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'edit'])->name('subscribercounter.edit');

    Route::put('subscribercounter/edit/{subscribercounter}', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'update'])->name('subscribercounter.edit.put');

    Route::match(['get', 'post'], 'subscribercounter/report', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'report'])->name('subscribercounter.report');

    Route::match(['get', 'post'],'subscribercounter/expenselist', [App\Http\Controllers\Admin\SubscriberCounterController::class, 'expenselist'])->name('subscribercounter.expenselist');

    Route::get('commitment-notes/{subscribercounter}', [App\Http\Controllers\Admin\CommitmentNoteControler::class, 'index'])->name('subscribercounter.notes');

    Route::get('commitment-notes/add/{subscribercounter}', [App\Http\Controllers\Admin\CommitmentNoteControler::class, 'create'])->name('subscribercounter.note.add');

    Route::post('commitment-notes/add/{subscribercounter}', [App\Http\Controllers\Admin\CommitmentNoteControler::class, 'store'])->name('subscribercounter.note.add.post');

    // subscriber-counter Ways of Expenditure





    Route::get('test', [App\Http\Controllers\Admin\MainController::class, 'test'])->name('test');

    
     Route::get('/customer-app', [App\Http\Controllers\Admin\AppCustomerController::class, 'index'])->name('AppCustomerController.index');
   
     Route::get('/contents', [App\Http\Controllers\Admin\ContentCreatorController::class, 'index'])->name('content_creator.index');
    Route::get('/content/create', [App\Http\Controllers\Admin\ContentCreatorController::class, 'create'])->name('content_creator.create');
    Route::post('/contents', [App\Http\Controllers\Admin\ContentCreatorController::class, 'store'])->name('content_creator.store');
    Route::get('/contents/{id}/edit', [App\Http\Controllers\Admin\ContentCreatorController::class, 'edit'])->name('content_creator.edit');
    Route::put('/contents/{id}', [App\Http\Controllers\Admin\ContentCreatorController::class, 'update'])->name('content_creator.update');
    Route::delete('/contents/{id}', [App\Http\Controllers\Admin\ContentCreatorController::class, 'destroy'])->name('content_creator.destroy');

    Route::get('/appnotis', [App\Http\Controllers\Admin\AccountingController::class, 'Notiappindex'])->name('appnotis.index');

    Route::get('/appnotis/create', [App\Http\Controllers\Admin\AccountingController::class, 'Notiappcreate'])->name('appnotis.create');

    Route::post('/appnotis', [App\Http\Controllers\Admin\AccountingController::class, 'Notiappstore'])->name('appnotis.store');

    Route::get('/appnotis/{appnoti}/edit', [App\Http\Controllers\Admin\AccountingController::class, 'Notiappedit'])->name('appnotis.edit');

   

    Route::put('/appnotis/{appnoti}', [App\Http\Controllers\Admin\AccountingController::class, 'Notiappupdate'])->name('appnotis.update');



    Route::delete('/appnotis/{appnoti}', [App\Http\Controllers\Admin\AccountingController::class, 'Notiappdestroy'])->name('appnotis.destroy');

Route::get('/appnoti-form', [App\Http\Controllers\Admin\AppNotiController::class, 'showForm'])->name('appnoti.form');
Route::post('/appnoti-form', [App\Http\Controllers\Admin\AppNotiController::class, 'submitForm'])->name('appnoti.submit');


        Route::get('/content', [App\Http\Controllers\Admin\AccountingController::class, 'contentindex'])->name('content.index');

    Route::get('/contentcreate', [App\Http\Controllers\Admin\AccountingController::class, 'contentcreate'])->name('content.create');

    Route::post('/content', [App\Http\Controllers\Admin\AccountingController::class, 'contentstore'])->name('content.store');

    Route::get('content/{content}/edit', [App\Http\Controllers\Admin\AccountingController::class, 'contentedit'])->name('content.edit');

    Route::put('content/{content}', [App\Http\Controllers\Admin\AccountingController::class, 'contentupdate'])->name('content.update');

    Route::delete('content/{content}', [App\Http\Controllers\Admin\AccountingController::class, 'contentdestroy'])->name('content.destroy');

});



// Request Routes

// Get district by city id

Route::get('getDistricts/{id}', [App\Http\Controllers\CityController::class, 'districts'])->name('get.district')->where('id', '[0-9]+');



// Infrastructure Routes

Route::post('infrastructure/load', [App\Http\Controllers\InfrastructureController::class, 'load'])->name('infrastructure.load');

Route::any('infrastructure/submit', [App\Http\Controllers\InfrastructureController::class, 'submit'])->name('infrastructure.post');

// Infrastructure Routes End



// Payment Routes

Route::post('payment/pre/auth/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'create_pre_auth'])->name('payment.pre.auth.create');

Route::post('payment/pre/auth/result/{moka_log}', [App\Http\Controllers\Admin\PaymentController::class, 'payment_pre_auth_result'])->name('payment.pre.auth.result');

Route::post('payment/result/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'payment_result'])->name('payment.result');

Route::match(['get', 'post'], 'payment/auto/result', [App\Http\Controllers\Admin\PaymentController::class, 'payment_auto_result'])->name('payment.auto.result');

// Payment Routes End



