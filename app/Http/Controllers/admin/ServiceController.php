<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\admin\Service;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{
    private static $module = "service";

    public function edit(){
        
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $service = Service::get()->toArray();
        
        $service = array_column($service, 'value', 'name');
        return view('administrator.service.index', compact('service'));
    }
    
    public function update(Request $request)
    {
        
        
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $service = Service::get()->toArray();
        $service = array_column($service, 'value', 'name');

        
        
        $data_service = [];
        for ($i = 0; $i < 6; $i++) {
            $title = $request->input('title_' . $i);
            $body = $request->input('body_' . $i);
        
            if ($request->hasFile('icon_' . $i)) {
                
                if (!empty($data_service["icon_" . $i])) {
                    $image_path = "./administrator/assets/media/service/" . $data_service["icon_" . $i];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
        
                
                $image = $request->file('icon_' . $i);
                $fileName = 'icon_' . $i . '.' . $image->getClientOriginalExtension();
                $path = upload_path('service') . $fileName;
                
                
                try {
                    Image::make($image->getRealPath())->save($path, 100);
                    $img_url = $fileName;
                } catch (\Exception $e) {
                    
                    
                    return response()->json(['error' => 'File upload failed'], 500);
                }
            }

            $data_service['service_'.$i] = json_encode(['title' => $title, 'body' => $body, 'img_url' => ($request->hasFile('icon_' . $i) ? $img_url : (array_key_exists('service_'.$i, $service) ? (json_decode($service['service_'.$i])->img_url) : ''))]);
        }

        $data_service["title_section_other"] = $request->title_section_other;
        $data_service["body_section_other"] = $request->body_section_other;
        $data_service["text_button_section_other"] = $request->text_button_section_other;
        $data_service["url_button_section_other"] = $request->url_button_section_other;
        
        

        $logs = [];

        foreach ($data_service as $key => $value) {
            $data = [];

            if (array_key_exists($key, $service)) {
                $data["value"] = $value;
                $set = Service::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Previous Data' => ['value' => $service[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Service::create($data);

                $logs[] = $set;
            }
        }
        
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.service'))->with(['success' => 'Data updated successfully.']);

    }
}
