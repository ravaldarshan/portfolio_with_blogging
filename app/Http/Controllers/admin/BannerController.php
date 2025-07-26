<?php

namespace App\Http\Controllers\admin;

use File;
use App\Models\admin\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    private static $module = "banner";

    public function edit(){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $data = Banner::get()->toArray();
        
        $data = array_column($data, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.banner.index', compact('data'));
    }
    
    public function update(Request $request)
    {
        // dd($request);
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $banner = Banner::get()->toArray();
        $banner = array_column($banner, 'value', 'name');

        // dd($request);
        
        $data_banner = [];
        for ($i = 0; $i < 3; $i++) {
            $title = $request->input('title_' . $i);
            $body = $request->input('body_' . $i);
        
            if ($request->hasFile('icon_' . $i)) {
                // Check and delete the existing file
                if (!empty($data_banner["icon_" . $i])) {
                    $image_path = "./administrator/assets/media/banner/" . $data_banner["icon_" . $i];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
        
                // Handle file upload
                $image = $request->file('icon_' . $i);
                $fileName = 'icon_' . $i . '.' . $image->getClientOriginalExtension();
                $path = upload_path('banner') . $fileName;
                
                // Save the uploaded file
                try {
                    Image::make($image->getRealPath())->save($path, 100);
                    $img_url = $fileName;
                } catch (\Exception $e) {
                    // Handle file upload error
                    // Log or return an error response
                    return response()->json(['error' => 'File upload failed'], 500);
                }
            }

            $data_banner['banner_'.$i] = json_encode(['title' => $title, 'body' => $body, 'img_url' => ($request->hasFile('icon_' . $i) ? $img_url : (array_key_exists('banner_'.$i, $banner) ? (json_decode($banner['banner_'.$i])->img_url) : ''))]);
        }
        
        

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_banner as $key => $value) {
            $data = [];

            if (array_key_exists($key, $banner)) {
                $data["value"] = $value;
                $set = Banner::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $banner[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Banner::create($data);

                $logs[] = $set;
            }
        }

        

        // Setelah perulangan selesai, $logs akan berisi semua log untuk setiap data yang diproses.


        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.banner'))->with(['success' => 'Data berhasil di update.']);

    }
}
