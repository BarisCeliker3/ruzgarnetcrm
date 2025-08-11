<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceUpdater;


use Illuminate\Http\Request;

class UpdateServicesController extends Controller
{
    public function index(Request $request)
    {
        $date = Carbon::parse('now');
        $categories = Category::all();  // Kategorileri alıyoruz
        
        // 'fiberNetVip' kategorisini array'e ekliyoruz
        $categoriesArray = $categories->toArray();
        
        // Filtreleme yapmak için, yalnızca id'leri 1, 2, 5, 6 ve 'fiberNetVip' olan kategorileri alıyoruz
        $filteredCategories = collect($categoriesArray)->whereIn('id', [1, 2, 5, 6, 999]);  // 999 id'li 'fiberNetVip' kategorisini ekliyoruz
        
        $services = Service::all();  // Tüm servisleri alıyoruz
        
        $search = $request->input('search');  // Arama parametresi
        $categoryId = $request->input('category_id');  // Kategori parametresi
        
        // ServiceUpdater ile ilişkili verileri alıyoruz ve filtreleme yapıyoruz
        $serviceUpdaters = DB::table('service_updaters')
            ->join('services', 'service_updaters.service_id', '=', 'services.id')
            ->select('services.name AS service_name', 'services.id AS service_id', 'service_updaters.new_price', 'service_updaters.new_commitment')
            ->when($search, function ($query, $search) {
                return $query->where('services.name', 'like', '%' . $search . '%');  // Arama fonksiyonu
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('services.category_id', $categoryId);  // Kategori filtresi
            })
            ->paginate(8);  // Sayfalama işlemi
        
        // Eğer AJAX talebi gelirse, veriyi JSON olarak döndür
        if ($request->ajax()) {
            return response()->json([
                'table' => view('admin.updateServices.table', compact('serviceUpdaters'))->render(),  // Tablo kısmı
                'pagination' => view('admin.updateServices.pagination', compact('serviceUpdaters'))->render(),  // Sayfalama kısmı
            ]);
        }
        
        // Sayfa render etme
        
        
        // Sayfa render etme
        return view('admin.updateServices.updateservice', compact('serviceUpdaters', 'categoriesArray','filteredCategories', 'services'));
    }
    public function updateService(Request $request) {
        $validated = $request->validate([
            'new_price' => 'required|numeric|min:0',  // Yeni fiyat zorunlu, sayısal ve negatif olamaz
            'new_commitment' => 'required|string|max:255',  // Yeni taahhüt zorunlu, string ve maksimum 255 karakter
        ]);
    // Servis ID'sine göre servisi bul ve güncelle
    $serviceUpdater = ServiceUpdater::where('service_id', $request->services_id)->first();
  
    if ($serviceUpdater) {
        $updated = false;
        
        if (isset($request->new_price) && $serviceUpdater->new_price !== $request->new_price) {
            $serviceUpdater->new_price = $request->new_price;
            $updated = true;
        }
   
        if (isset($request->new_commitment) && $serviceUpdater->new_commitment !== $request->new_commitment) {
            $serviceUpdater->new_commitment = $request->new_commitment;
            $updated = true;
        }
        if ($updated) {
            $serviceUpdater->save();
   
            return redirect()->back()->with('toastr', [
                'type' => 'success',
                'title' => 'Abonelikler',
                'message' => 'Abonelik başarıyla güncellendi.'
            ]);
        } else {
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'title' => 'Abonelikler',
                'message' => 'Değişiklik yapılmadı.'
            ]);
        }
    }
   
    }
    
    public function search(Request $request)
{
    $search = $request->input('search');
    
    $serviceUpdaters = DB::table('service_updaters')
        ->join('services', 'service_updaters.service_id', '=', 'services.id')
        ->select('services.name AS service_name', 'service_updaters.new_price', 'service_updaters.new_commitment')
        ->when($search, function ($query, $search) {
            return $query->where('services.name', 'like', '%' . $search . '%');
        })
        ->get();

    $output = '';
    foreach ($serviceUpdaters as $serviceUpdater) {
        $output .= '<p>' . $serviceUpdater->service_name . ' - ' . $serviceUpdater->new_price . ' - ' . $serviceUpdater->new_commitment . '</p>';
    }

    return response()->json($output);
}

    
    public function update(Request $request){

        $staffId = $request->user()->staff_id;
        $categoryId = $request->category_id;
        $new_price = $request->new_price;

        $newCommitment = $request->new_comminent;
        if ((int)$categoryId === 6) {
            $new_price += 300;
        }
        // Eğer kategori ID'ye sahip tüm servisleri bul
        $services = Service::where('category_id', $categoryId)->get();
        foreach ($services as $srv) {
            ServiceUpdater::updateOrCreate(
                ['service_id' => $srv->id], // Her servis için ayrı
                [
                    'staff_id' => $staffId,
                    'new_price' => $new_price,
                    'new_commitment' => $newCommitment,
                    'status' => 1,
                ]
            );
        }
        
        $staffId = $request->user()->staff_id;
        $categoryId = $request->category_id;
        $new_price = $request->new_price;
        
        $newCommitment = $request->new_comminent;
        
        // Eğer kategori ID 6 ise, fiyatı artır
        
        // Eğer kategori ID 999 ise, özel bir servis ekle
        if ((int)$categoryId === 999) {
            ServiceUpdater::updateOrCreate(
                ['service_id' => 0], // Service ID 999
                [
                    'staff_id' => $staffId,
                    'new_price' => $new_price,
                    'new_commitment' => $newCommitment,
                    'status' => 1,
                ]
            );
        } else {
            // Eğer kategori ID 999 değilse, diğer servisleri güncelle
            $services = Service::where('category_id', $categoryId)->get();
            foreach ($services as $srv) {
                ServiceUpdater::updateOrCreate(
                    ['service_id' => $srv->id], // Her servis için ayrı
                    [
                        'staff_id' => $staffId,
                        'new_price' => $new_price,
                        'new_commitment' => $newCommitment,
                        'status' => 1,
                    ]
                );
            }
        }
        
        // Başarılı işlem mesajı
        return response()->json([ 
            'success' => true,
            'toastr' => [
                'type' => 'success',
                'title' => 'Abonelikler',
                'message' => 'Kategoriye ait tüm abonelikler başarıyla güncellendi.'
            ],
        ]);
        
        
}
public function delete($id)
{
    $service = ServiceUpdater::where('service_id', $id)->first();

    
    if (!$service) {
        return redirect()->back()->with('toastr', [
            'type' => 'error',
            'title' => 'Servis',
            'message' => 'Servis bulunamadı.'
        ]);
    }

    $service->delete();

    return redirect()->back()->with('toastr', [
        'type' => 'success',
        'title' => 'Servis',
        'message' => 'Servis başarıyla silindi.'
    ]);
}

public function getServicesByCategory($categoryId)
{
    // İlgili kategorideki servisleri al
    $services = Service::where('category_id', $categoryId)->get();

    return response()->json([
        'services' => $services
    ]);
}
}
