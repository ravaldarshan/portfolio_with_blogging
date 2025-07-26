<?php

namespace App\Http\Controllers\admin;

use DB;
use File;
use DataTables;
use Illuminate\Http\Request;
use App\Models\admin\Setting;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    private static $module = "settings";

    public function main(){
        //Check permission
        if (!isAllowed(static::$module, "main")) {
            abort(403);
        }

        return view('administrator.settings.main');
    }

    public function frontpage(){
        //Check permission
        if (!isAllowed(static::$module, "frontpage")) {
            abort(403);
        }

        return view('administrator.settings.frontpage');
    }

    public function admin(){
        //Check permission
        if (!isAllowed(static::$module, "admin")) {
            abort(403);
        }

        return view('administrator.settings.administrator');
    }

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "admin_general")) {
            abort(403);
        }
        $settings = Setting::get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.settings.admin.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "admin_general")) {
            abort(403);
        }

        

        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        
        $data_settings = [];
        $data_settings["nama_app_admin"] = $request->nama_app_admin;

        if (!empty($request->footer_app_admin)) {
            $data_settings["footer_app_admin"] = $request->footer_app_admin;
        }

        if (!empty($request->admin_main_background_color)) {
            $data_settings["admin_main_background_color"] = $request->admin_main_background_color;
        }
        

        if ($request->hasFile('logo_app_admin')) {
            if (array_key_exists("logo_app_admin", $settings)) {
                $imageBefore = $settings["logo_app_admin"];
                if (!empty($settings["logo_app_admin"])) {
                    $image_path = "./administrator/assets/media/settings/" . $settings["logo_app_admin"];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $image = $request->file('logo_app_admin');
            $fileName  =  'logo_app_admin.' . $image->getClientOriginalExtension();
            $path = upload_path('settings') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $data_settings['logo_app_admin'] = $fileName;
        }

        if ($request->hasFile('favicon')) {
            if (array_key_exists("favicon", $settings)) {
                $imageBefore = $settings["favicon"];
                if (!empty($settings["favicon"])) {
                    $image_path = "./administrator/assets/media/settings/" . $settings["favicon"];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $image = $request->file('favicon');
            $fileName  =  'favicon.' . $image->getClientOriginalExtension();
            $path = upload_path('settings') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $data_settings['favicon'] = $fileName;
        }
        

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_settings as $key => $value) {
            $data = [];

            if (array_key_exists($key, $settings)) {
                $data["value"] = $value;
                $set = Setting::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $settings[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Setting::create($data);

                $logs[] = $set;
            }
        }

        

        // Setelah perulangan selesai, $logs akan berisi semua log untuk setiap data yang diproses.


        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.settings.admin.general'))->with(['success' => 'Data berhasil di update.']);

    }
    
    public function frontpage_footer_index()
    {
        //Check permission
        if (!isAllowed(static::$module, "frontpage_footer")) {
            abort(403);
        }
        $settings = Setting::get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.settings.frontpage.footer', compact('settings'));
    }

    public function frontpage_footer_update(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "frontpage_footer")) {
            abort(403);
        }

        

        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        
        $data_settings = [];
        if (!empty($request->text_frontpage_footer)) {
            $data_settings["text_frontpage_footer"] = $request->text_frontpage_footer;
        }
        $data_settings["about_frontpage_footer"] = $request->about_frontpage_footer;

        $dataLink = [];
        for ($i = 0; $i < $request->jumlah_link; $i++) {
            $dataLink[] = [
                'nama_link' => $request->{'nama_link_' . $i},
                'url_link' => $request->{'url_link_' . $i},
            ];
        }

        // Encode the array to JSON
        $json_encoded_link = json_encode($dataLink);

        if (!empty($dataLink)) {
            $data_settings["link_frontpage_footer"] = $json_encoded_link;
        }

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_settings as $key => $value) {
            $data = [];

            if (array_key_exists($key, $settings)) {
                $data["value"] = $value;
                $set = Setting::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $settings[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Setting::create($data);

                $logs[] = $set;
            }
        }

        

        // Setelah perulangan selesai, $logs akan berisi semua log untuk setiap data yang diproses.


        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.settings.frontpage.footer'))->with(['success' => 'Data berhasil di update.']);

    }

    public function frontpage_footer_deleteLink(Request $request)
    {
        $nama_link = $request->nama_link;
        $index = $request->index;

        // Get the settings
        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        $jsonParse = json_decode($settings['link_frontpage_footer']);
        $dataLink = [];

        foreach ($jsonParse as $key => $value) {
            if ($key != intVal($index)) {
                $dataLink[] = [
                    'nama_link' => $value->nama_link,
                    'url_link' => $value->url_link,
                ];
            }
        }

        // Encode the array to JSON
        $jsonEncodedData = json_encode($dataLink);

        // Update the database record
        $set = Setting::where('name', 'link_frontpage_footer')->first();
        $set->update(['value' => $jsonEncodedData]);
    }
    
    public function frontpage_general_index()
    {
        //Check permission
        if (!isAllowed(static::$module, "frontpage_general")) {
            abort(403);
        }
        $settings = Setting::get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.settings.frontpage.general', compact('settings'));
    }

    public function frontpage_general_update(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "frontpage_general")) {
            abort(403);
        }

        

        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');
        
        // dd($request);
        $data_settings = [];
        $data_settings["general_nama_app"] = $request->general_nama_app;
        $data_settings["general_main_text_color"] = $request->general_main_text_color;
        $data_settings["general_breadcrumb_color"] = $request->general_breadcrumb_color;
        $data_settings["general_primary_color"] = $request->general_primary_color;
        $data_settings["general_background_color"] = $request->general_background_color;
        $data_settings["general_counter_color"] = $request->general_counter_color;
        $data_settings["general_service_item_icon_color"] = $request->general_service_item_icon_color;

        $data_sosmed = [];
        for ($i = 0; $i < $request->jumlah_sosmed; $i++) {
            if ($request->{'nama_sosmed_' . $i} || $request->{'icon_sosmed_' . $i}) {
                $data_sosmed[] = [
                    'nama_sosmed' => $request->{'nama_sosmed_' . $i},
                    'icon_sosmed' => $request->{'icon_sosmed_' . $i},
                ];
            }
        }

        // Encode the array to JSON
        $json_encoded_sosmed = json_encode($data_sosmed);

        if (!empty($data_sosmed)) {
            $data_settings["general_sosmed"] = $json_encoded_sosmed;
        }



        if ($request->hasFile('general_frontpage_favicon')) {
            if (array_key_exists("general_frontpage_favicon", $settings)) {
                $imageBefore = $settings["general_frontpage_favicon"];
                if (!empty($settings["general_frontpage_favicon"])) {
                    $image_path = "./administrator/assets/media/settings/" . $settings["general_frontpage_favicon"];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $image = $request->file('general_frontpage_favicon');
            $fileName  =  'general_frontpage_favicon.' . $image->getClientOriginalExtension();
            $path = upload_path('settings') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $data_settings['general_frontpage_favicon'] = $fileName;
        }

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_settings as $key => $value) {
            $data = [];

            if (array_key_exists($key, $settings)) {
                $data["value"] = $value;
                $set = Setting::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $settings[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Setting::create($data);

                $logs[] = $set;
            }
        }

        

        // Setelah perulangan selesai, $logs akan berisi semua log untuk setiap data yang diproses.


        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.settings.frontpage.general'))->with(['success' => 'Data berhasil di update.']);

    }

    public function frontpage_general_deleteSosmed(Request $request)
    {
        $nama_sosmed = $request->nama_sosmed;
        $index = $request->index;

        // Get the settings
        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        $jsonParse = json_decode($settings['general_sosmed']);
        $dataSosmed = [];

        foreach ($jsonParse as $key => $value) {
            if ($key != intVal($index)) {
                $dataSosmed[] = [
                    'nama_sosmed' => $value->nama_sosmed,
                    'icon_sosmed' => $value->icon_sosmed,
                ];
            }
        }

        // Encode the array to JSON
        $jsonEncodedData = json_encode($dataSosmed);

        // Update the database record
        $set = Setting::where('name', 'general_sosmed')->first();
        $set->update(['value' => $jsonEncodedData]);
    }

    public function frontpage_homepage_index()
    {
        //Check permission
        if (!isAllowed(static::$module, "frontpage_homepage")) {
            abort(403);
        }
        $settings = Setting::get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.settings.frontpage.homepage', compact('settings'));
    }

    public function frontpage_homepage_update(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "frontpage_homepage")) {
            abort(403);
        }

        

        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        
        $data_settings = [];
        $data_settings["title_promosi_frontpage_homepage"] = $request->title_promosi_frontpage_homepage;
        $data_settings["body_promosi_frontpage_homepage"] = $request->body_promosi_frontpage_homepage;
        $data_settings["text_button_promosi_frontpage_homepage"] = $request->text_button_promosi_frontpage_homepage;
        $data_settings["url_button_promosi_frontpage_homepage"] = $request->url_button_promosi_frontpage_homepage;
        $data_settings["body_service_frontpage_homepage"] = $request->body_service_frontpage_homepage;

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_settings as $key => $value) {
            $data = [];

            if (array_key_exists($key, $settings)) {
                $data["value"] = $value;
                $set = Setting::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $settings[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Setting::create($data);

                $logs[] = $set;
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.settings.frontpage.homepage'))->with(['success' => 'Data berhasil di update.']);

    }

}
