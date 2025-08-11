<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/**
 * View attributes for admin
 */
trait ViewAttributes
{
    /**
     * Returns items for sidebar navigation
     *
     * @return array
     */
    public static function sideNav()
    {
        $data = [
            // Main Fields
            [
                'title' => trans('titles.admin.dashboard'),
                'route' => 'admin.dashboard',
                'icon' => 'fas fa-home'
            ],
            [
                'title' => trans('titles.infrastructure'),
                'route' => 'admin.infrastructure',
                'icon' => 'fas fa-network-wired'
            ],

            // Main Fields End
            // START RAPOR
            [
                'header' =>  trans('titles.adminrapor'),
                'subRoutes' => ['servicesraport', 'satisraports','expensereports']
            ],
            // END RAPOR

            //START TARİFE RAPOR
            [
                'title' => trans('tables.servicesraport.title'),
                'route' => 'admin.servicesraports',
                'icon' => 'fas fa-chart-line',
            ],
            // END TARİFE RAPOR
             //START SATIŞ RAPOR
             /*
             [
                'title' => trans('tables.satisraport.title'),
                'route' => 'admin.satisraports',
                'icon' => 'fas fa-chart-line',
            ],
            */
            // END SATIŞ RAPOR
            [
                'title' => trans('tables.accountingreport.title'),
                'route' => 'admin.accountingreports',
                'icon' => 'fas fa-lira-sign',
            ],

            //START GİDER RAPOR
             [
                'title' => trans('tables.expensereport.title'),
                'route' => 'admin.expensereports',
                'icon' => 'fas fa-file-invoice-dollar',
            ],
            // END GİDER RAPOR

            // Customers and Orders Header
            [
                'header' =>  trans('titles.customers_and_orders'),
                'subRoutes' => ['customers','pdfdocuments','subscriptions','citylists','otherexpenses','othersales','subscription_upgrade','subscribercounters','frozenones']
            ],
            // Customers and Orders Header End

            // Customer Fields
            [
                'title' => trans('tables.customer.title'),
                'route' => 'admin.customers',
                'icon' => 'fas fa-users',
            ],
            [
                'title' => trans('tables.pdfdocument.title'),
                'route' => 'admin.pdfdocuments',
                'icon' => 'fas fa-file-image',
            ],

            [
                'title' => trans('tables.subscription.title'),
                'route' => 'admin.subscriptions',
                'icon' => 'fas fa-wifi',
            ],
            
            [
                'title' => trans('tables.subscription.extend_subscribers_end_date'),
                'route' => 'admin.subscription.extend_subscribers_end_date',
                'icon' => 'fas fa-ruler'
            ],
            
            [
                'title' => trans('tables.subscription.subscriber_statistics'),
                'route' => 'admin.subscription.subscriber_statistics',
                'icon' => 'fas fa-chart-bar'
            ],
              
            [
                'title' => trans('tables.citylist.title'),
                'route' => 'admin.citylists',
                'icon' => 'fas fa-city',
            ],
          
            [
                'title' => trans('tables.othersale.title'),
                'route' => 'admin.othersales',
                'icon' => 'fas fa-lira-sign',
            ],
              [
                'title' => trans('tables.update-service.title'),
                'route' => 'admin.updateservices',
                'icon' => 'fas fa-wrench',
            ],
            [
                'title' => trans('tables.otherexpense.title'),
                'route' => 'admin.otherexpenses',
                'icon' => 'fas fa-lira-sign',
            ],
            /*
            [
                'title' => trans('tables.subscription_upgrade.title'),
                'route' => 'admin.subscriptionupgrades',
                'icon' => 'fas fa-wifi',
            ],
            */
            [
                'title' => trans('tables.contractending.title'),
                'route' => 'admin.contractendings',
                'icon' => 'fas fa-file-contract',
            ],
            [
                'title' => trans('tables.isscontrol.title'),
                'route' => 'admin.isscontrols',
                'icon' => 'fas fa-file-contract',
            ],
            /*
            [
                'title' => trans('tables.subscribercounter.title'),
                'route' => 'admin.subscribercounters',
                'icon' => 'fas fa-clock',
            ],
            */
            /*
            [
                'title' => trans('tables.frozenones.title'),
                'route' => 'admin.frozenones',
                'icon' => 'fas fa-user-times text-danger',
            ],
            */
            [
                'title' => trans('tables.hazirlik.title'),
                'route' => 'admin.hazirliks',
                'icon' => 'fas fa-user',
            ],


            // Customer Field End subscriptioncounter

            // Support Header
            [
                'header' =>  trans('titles.support'),
                'subRoutes' => ['messages', 'customers_applications', 'fault_records']
            ],
            // Support Header End

            // Support Field End
            [
                'title' => trans('tables.message.send_sms'),
                'route' => 'admin.message.send',
                'icon' => 'fas fa-paper-plane'
            ],
            [
                'title' => trans('titles.customer_applications'),
                'route' => 'admin.customer.applications',
                'icon' => 'fas fa-clipboard'
            ],
            [
                'title' => trans('tables.fault.record.title'),
                'route' => 'admin.fault.records',
                'icon' => 'fas fa-tools',
            ],
            // Message Field End
             // Internet Setup Header
             /*
             [
                'header' =>  trans('tables.internetsetup.singular'),
                'subRoutes' => ['internetsetups','kurulums']
            ],
            // Internet Setup End

            // Internet Setup
            [
                'title' => trans('tables.internetsetup.title'),
                'route' => 'admin.internetsetups',
                'icon' => 'fas fa-wifi',
            ],
             // Kurulum Listesi
             [
                'title' => trans('tables.kurulum.title'),
                'route' => 'admin.kurulums',
                'icon' => 'fas fa-list',
            ],
            */

             // Internet Setup RCB
            [
                'header' =>  trans('titles.ruzgarcozumbirimi'),
                'subRoutes' => ['rcb', 'rcbadmins', 'canceldirections', 'canceldirection2s', 'rzgcancels', 'servicesraport']
            ],
            // END RCB
            // START RCB LİST
            /*

            [
                'title' => trans('tables.rcb.title'),
                'route' => 'admin.rcbs',
                'icon' => 'fas fa-headset'
            ],

            // END RCB LİST
            // START RCB RAPOR LİST
            [
                'title' => trans('tables.rcbadmin.title'),
                'route' => 'admin.rcbadmins',
                'icon' => 'fa fa-list',
            ],
            */
            // END RCB RAPOR LİST
            //START RCB İPTAL İKNA
            [
                'title' => trans('tables.rzgcancel.title'),
                'route' => 'admin.rzgcancels',
                'icon' => 'fas fa-file-invoice',
            ],
            // END RCB İPTAL İKNA

            //START RCB İPTAL İKNA YÖNLENDİRME PLATİNİUM
            [
                'title' => trans('tables.canceldirection.title'),
                'route' => 'admin.canceldirections',
                'icon' => 'fas fa-file-invoice',
            ],
            // END RCB İPTAL İKNA YÖNLENDİRME PLATİNİUM
            //START RCB İPTAL İKNA YÖNLENDİRME MUHASEBE
            [
                'title' => trans('tables.canceldirection2.title'),
                'route' => 'admin.canceldirection2s',
                'icon' => 'fas fa-file-invoice',
            ],
            // END RCB İPTAL İKNA YÖNLENDİRME MUHASEBE


            // Campaings Header
            [
                'header' =>  trans('titles.campaings'),
                'subRoutes' => ['promotions','references','codes','hediyes']
            ],
            // Campaings Header End

            // Campaing Field
            [
                'title' => trans('tables.reference.title'),
                'route' => 'admin.references',
                'icon' => 'fas fa-people-arrows'
            ],
            [
                'title' => trans('tables.promotion.title'),
                'route' => 'admin.promotions',
                'icon' => 'fas fa-gift'
            ],
           
           /* [
                'title' => trans('tables.code.title'),
                'route' => 'admin.codes',
                'icon' => 'fas fa-gift'
            ],
            [
                'title' => trans('tables.hediye.title'),
                'route' => 'admin.hediyes',
                'icon' => 'fas fa-gift'
            ],
            */
            // Campaing Field End

            // Payments Header
            [
                'header' =>  trans('tables.payment.singular'),
                'subRoutes' => ['payments', 'report','expenselists']
            ],
            // Payments Header End

            // Payments Fields
            [
                'title' => trans('tables.payment.plural'),
                'route' => 'admin.payments',
                'icon' => 'fas fa-lira-sign',
            ],
            [
                'title' => trans('tables.payment.monthly'),
                'route' => 'admin.payment.monthly',
                'icon' => 'fas fa-calendar-alt',
            ],
            [
                'title' => trans('tables.payment.daily'),
                'route' => 'admin.payment.daily',
                'icon' => 'fas fa-solid fa-sun',
            ],
            [
                'title' => trans('tables.payment.invoice'),
                'route' => 'admin.payment.invoice',
                'icon' => 'fas fa-calendar-alt',
            ],
            [
                'title' => trans('tables.payment.penalty'),
                'route' => 'admin.payment.penalties',
                'icon' => 'fas fa-calendar-times',
            ],
            [
                'title' => trans('tables.main.report'),
                'route' => 'admin.report',
                'icon' => 'fas fa-folder-open',
            ],
            [
                'title' => trans('tables.accounting.title'),
                'route' => 'admin.accountings',
                'icon' => 'fas fa-lira-sign',
            ],
            [
                'title' => trans('tables.expenselist.title'),
                'route' => 'admin.expenselists',
                'icon' => 'fas fa-lira-sign',
            ],

            // Payments Fields End


            // stok Header

            [
                'header' =>  trans('titles.stoktakips'),
                'subRoutes' => ['stoktakips','stoklistes']
            ],
            // stok End
            [
                'title' => trans('tables.stoktakip.title'),
                'route' => 'admin.stoktakips',
                'icon' => 'fas fa-file-signature',
            ],
            [
                'title' => trans('tables.stokliste.title'),
                'route' => 'admin.stoklistes',
                'icon' => 'fas fa-list',
            ],

            // Product and Service Header
            [
                'header' =>  trans('titles.services'),
                'subRoutes' => ['contract_types', 'categories', 'services']
            ],
            // Product and Service Header End

            // Product Fields
            [
                'title' => trans('tables.contract_type.title'),
                'route' => 'admin.contract.types',
                'icon' => 'fas fa-file-signature',
            ],

            [
                'title' => trans('tables.service.title'),
                'route' => 'admin.services',
                'icon' => 'fas fa-ethernet',
            ],
            // Product Fields End

            // System Header
            [
                'header' =>  trans('titles.system'),
                'subRoutes' => ['customer_application_types', 'fault_types', 'messages', 'request_messages']
            ],
            // System Header End

            // System Fields
            [
                'title' => trans('titles.request_messages'),
                'route' => 'admin.request.messages',
                'icon' => 'fas fa-level-up-alt'
            ],
            [
                'title' => trans('titles.customer_application_types'),
                'route' => 'admin.customer.application.types',
                'icon' => 'fas fa-clipboard'
            ],
            [
                'title' => trans('tables.fault.type.title'),
                'route' => 'admin.fault.types',
                'icon' => 'fas fa-toolbox',
            ],
            [
                'title' => trans('tables.message.alt_title'),
                'route' => 'admin.messages',
                'icon' => 'fas fa-sms'
            ],
            // System Fields End

            // Company Header
            [
                'header' =>  trans('titles.company.title'),
                'subRoutes' => ['commitcontrols', 'dealers', 'staffs', 'roles', 'users']
            ],
            // Company Header End

            // Company Fields
            //assignments start
            /*
            
            [
                'title' => trans('tables.assignment.title'),
                'route' => 'admin.assignments',
                'icon' => 'fas fa-list',
            ],
            */
            //assignments end

            //mochacontrols start
            [
                'title' => trans('tables.mochacontrol.title'),
                'route' => 'admin.mochacontrols',
                'icon' => 'fas fa-list',
            ],
            //mochacontrols end

            //assigadd start
            [
                'title' => trans('tables.assigadd.title'),
                'route' => 'admin.assigadds',
                'icon' => 'fas fa-file-signature',
            ],
            //assigadd end

            [
                'title' => trans('tables.commitcontrol.title'),
                'route' => 'admin.commitcontrols',
                'icon' => 'fas fa-store',
            ],
            [
                'title' => trans('tables.dealer.title'),
                'route' => 'admin.dealers',
                'icon' => 'fas fa-store',
            ],
            [
                'title' => trans('tables.staff.title'),
                'route' => 'admin.staffs',
                'icon' => 'fas fa-user-tie',
            ],
            [
                'title' => trans('tables.role.title'),
                'route' => 'admin.roles',
                'icon' => 'fas fa-key',
            ],
            [
                'title' => trans('tables.user.title'),
                'route' => 'admin.users',
                'icon' => 'fas fa-user',
            ]
            // Company Field End
        ];

        // Current route name
        $route = Route::currentRouteName();
        $user = Request::user();

        // Check abilities
        foreach ($data as $key => $item) {
            if (isset($item['subRoutes']) && is_array($item['subRoutes'])) {
                $data[$key]['can'] = $user->permissionGroup($item['subRoutes']);
            } else if (isset($item['route']) && $user->permission($item['route'])) {
                $data[$key]['can'] = true;
            } else {
                $data[$key]['can'] = false;
            }
        }

        // Find active class
        foreach ($data as $key => $item) {
            if (isset($item['submenu'])) {
                $active = false;
                foreach ($item['submenu'] as $subkey => $subnav) {
                    if (isset($subnav['route']) && $subnav['route'] == $route) {
                        $active = true;
                        $data[$key]['submenu'][$subkey]['active'] = true;
                    } else {
                        $data[$key]['submenu'][$subkey]['active'] = false;
                    }
                }
                $data[$key]['active'] = $active;
            } else if (isset($item['route']) && $item['route'] == $route) {
                $data[$key]['active'] = true;
            } else if (isset($item['route'])) {
                $data[$key]['active'] = false;
            }
        }

        return $data;
    }
}
