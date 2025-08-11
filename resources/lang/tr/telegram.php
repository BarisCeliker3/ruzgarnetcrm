<?php

return [
    'delete_payment' => ":full_name - :id_no \nMüşterimizin :payment_id numaralı ödemesi silindi. \nSilme Nedeni : :description \nİşlemi Gerçekleştiren Kullanıcı : :username",
    'cancel_subscription' => ":full_name - :id_no kimlik numaralı müşterimizin kaydı silindi. \nSilme Nedeni : :description \nİşlemi Gerçekleştiren Kullanıcı : :username",
    'delete_subscription' => ":full_name adlı abonenin :tarife tarifesi silinimştir.  \nİşlemi gerçekleştiren kullanıcı: :user_name",
    'add_subscription' => ":id_no - :full_name \nİşlemi gerçekleştiren kullanıcı : :username \nMüşteri Temsilcisi : :customer_staff\n Tarife : :service.",
    'add_application' => ":full_name adlı bir kullanıcı RüzgarNET hakkında bilgi almak istiyor. \nTelefon Numarası : :telephone \nİlgilenecek Kişi : :username",
    'add_fault_record' => ":id_no - :full_name adlı müşterimiz tarafından bir arıza kaydı oluşturuldu.  \nTelefon Numarası : :telephone \nMüşteri Temsilcisi : :customer_staff",
    'add_fault_record_description' => "Arıza İçeriği Aşağıdaki Şekildedir \n\":description\"",
    'edit_fault_record' => ":serial_number [:status] \nAbone : :id_no - :full_name \nDetay : :description \nKullanıcı : :username",
    'infrastructure' => ":message \nAdı Soyadı : :full_name \nTelefon Numarası : :telephone \nİl : :city \nBBK : :bbk",
    'application_cancel' => "Yeni bir iptal başvurusu oluşturuldu. \nAdı Soyadı : :full_name \nTelefon Numarası : :telephone \n Müşteri Temsilcisi: :staff_name",
    'hizmet_numrasi_tlg' => "Yeni bir hizmet numarası başvurusu oluşturuldu. \nAdı Soyadı : :full_name \nTelefon Numarası : :telephone \n Müşteri Temsilcisi: :staff_name",
    'application_cancel_update' => "Bir iptal başvurusunda düzenleme yapıldı. \nAdı Soyadı : :full_name \nTelefon Numarası : :telephone \n Müşteri Temsilcisi: :staff_name \nDurumu: :status olarak ayarlandı. \n Açıklama : :description",
    'application_subscription' => "Adı Soyadı :full_name \nTelefon Numarası : :telephone \n:username",
    'add_freeze' => "Yeni bir dondurma işlemi gerçekleştirildi. \nMüşteri : :full_name \nTarife : :subscription \nPersonel : :username",
    'unfreeze' => "Dondurulan abonelik aktif edildi. \nMüşteri : :full_name \nTarife : :subscription \nPersonel : :username",
    'add_promotion' => ":username tarafından :customer adlı müşteri için :promotion promosyonu oluşturuldu.\n Müşteri Temsilcisi : :staff \n Açıklama: :description \nDurumu : :status",
    'edit_promotion' => ":username tarafından :customer adlı müşteri için :promotion promosyonunda düzenleme yapıldı.\n Müşteri Temsilcisi : :staff \n Açıklama: :description \nDurumu : :status",
    'add_request_message' => " :username adlı kullanıcı tarafından :role yetkili kişiler için bir talep oluşturuldu.\n İçerik: :description \nDurumu : :status \n Talep: :talep",
    'edit_request_message' => " :username adlı kullanıcı tarafından açılan talepde :user adlı kişi işlem yaptı. \n İçerik: :description \nDurumu : :status \n Talep: :talep",
    'edit_subscription_upgrade' => ":username adlı kullanıcı tarafından tarife yükseltme de işlem yapıldı.\nMüşteri adı :customer . \nTemsilci: :staff. \nGüncel Tarife: :tarife \nAçıklama: :description \nDurumu : :status",
    'edit_fault' => ":full_name adlı müşterimiz tarafından oluşturulan :serial_number seri numaralı arıza kaydının durumu :status olarak değiştirildi. \nDetay : :detail \nİşlemi Gerçekleştiren Kullanıcı : :username",
    'payment_received' => "Başarılı bir ödeme gerçekleştirildi. \nT.C. Kimlik Numarası : :id_no \nAdı Soyadı : :full_name \nTutar : :price TL \nMarka : :category",
    'subscription_ending_day' => "Abonemiz : :full_name - :id_no \n:subscription - :price TL tarifesinin bitmesine :day gün vardır. \n İlgilenecek kişi: :staff.",
    'subscription_renewaled' => "Abonemiz : :full_name - :id_no \n:subscription tarifesi :month ay uzatılmış olup yeni ücreti :price TL'dir.",
    'subscription_renewal_price' => "Abonemiz : :full_name - :id_no \n:subscription tarifesinin uzatılma ücreti :staff tarafından :price TL olarak belirlenmiştir.",
    'subscription_end_commitment' => "Abonemiz : :full_name - :id_no \n:subscription tarifesinin sözleşmesi bitmiştir ve uzatma işlemi gerçekleştirmemiştir \nİşlemi gerçekleştiren kullanıcı : :staff.",
    'freezecontrolet' => " :staff_id.",
    'new_subscribers_sms' => "Müşteri Adı : :full_name \n İlgilenecek kişi: :staff :destek.",
    'subscribercounter' => "Müşteri Adı: :customer_name \n :companys Firmasındaki Taahhütünün bitmesine :day gün var. \n İlgilenecek Kişi :staff",
    'subscription_ending_day_pdf' => "Abonemiz : :name \n- :ad_soyad \n   :sozlesme .",
    'internetsetupadd' => "Yeni Abone Kaydı: \n Müşteri Adı: :name \n Telefon: :telephone \n Yeni Müşteri İnternet kurulu Yapılacak.",
    'internetsetupedit' => "İnternet Kurulumu: :status \n Müşteri Adı: :name \n Telefon: :telephone ."


];
