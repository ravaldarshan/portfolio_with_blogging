<?php

namespace App\Http\Controllers\admin;

use File;
use Illuminate\Http\Request;
use App\Models\admin\Service;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{
    private static $module = "service";

    public function edit(){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $service = Service::get()->toArray();
        
        $service = array_column($service, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.service.index', compact('service'));
    }
    
    public function update(Request $request)
    {
        // dd($request);
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $service = Service::get()->toArray();
        $service = array_column($service, 'value', 'name');

        // dd($request);
        
        $data_service = [];
        for ($i = 0; $i < 6; $i++) {
            $title = $request->input('title_' . $i);
            $body = $request->input('body_' . $i);
        
            if ($request->hasFile('icon_' . $i)) {
                // Check and delete the existing file
                if (!empty($data_service["icon_" . $i])) {
                    $image_path = "./administrator/assets/media/service/" . $data_service["icon_" . $i];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
        
                // Handle file upload
                $image = $request->file('icon_' . $i);
                $fileName = 'icon_' . $i . '.' . $image->getClientOriginalExtension();
                $path = upload_path('service') . $fileName;
                
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

            $data_service['service_'.$i] = json_encode(['title' => $title, 'body' => $body, 'img_url' => ($request->hasFile('icon_' . $i) ? $img_url : (array_key_exists('service_'.$i, $service) ? (json_decode($service['service_'.$i])->img_url) : ''))]);
        }

        $data_service["title_section_other"] = $request->title_section_other;
        $data_service["body_section_other"] = $request->body_section_other;
        $data_service["text_button_section_other"] = $request->text_button_section_other;
        $data_service["url_button_section_other"] = $request->url_button_section_other;
        
        

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_service as $key => $value) {
            $data = [];

            if (array_key_exists($key, $service)) {
                $data["value"] = $value;
                $set = Service::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $service[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Service::create($data);

                $logs[] = $set;
            }
        }

        

        // Setelah perulangan selesai, $logs akan berisi semua log untuk setiap data yang diproses.


        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.service'))->with(['success' => 'Data berhasil di update.']);

    }
}
