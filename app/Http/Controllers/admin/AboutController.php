<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\About;
use Illuminate\Http\Request;
use App\Models\admin\Gallery;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    private static $module = "about";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $settings = About::get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.about.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $settings = About::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        
        $data_settings = [];
        $data_settings["deskripsi"] = $request->deskripsi;
        $data_settings["image"] = $request->image;

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_settings as $key => $value) {
            $data = [];

            if (array_key_exists($key, $settings)) {
                $data["value"] = $value;
                $set = About::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $settings[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = About::create($data);

                $logs[] = $set;
            }
        }

        

        // Setelah perulangan selesai, $logs akan berisi semua log untuk setiap data yang diproses.


        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.about'))->with(['success' => 'Data berhasil di update.']);
    }

    public function getDataGallery(){
        $data = Gallery::all();

        return response()->json([
            'data' => $data,
        ], 200);
    }
}
