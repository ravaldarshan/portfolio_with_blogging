<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    private static $module = "banner";

    public function edit(){
        
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $data = Banner::get()->toArray();
        
        $data = array_column($data, 'value', 'name');

        return view('administrator.banner.index', compact('data'));
    }
    
    public function update(Request $request)
    {
        
        
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $banner = Banner::get()->toArray();
        $banner = array_column($banner, 'value', 'name');

        
        
        $data_banner = [];
        for ($i = 0; $i < 3; $i++) {
            $title = $request->input('title_' . $i);
            $body = $request->input('body_' . $i);
        
            if ($request->hasFile('icon_' . $i)) {
                
                if (!empty($data_banner["icon_" . $i])) {
                    $image_path = "./administrator/assets/media/banner/" . $data_banner["icon_" . $i];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
        
                
                $image = $request->file('icon_' . $i);
                $fileName = 'icon_' . $i . '.' . $image->getClientOriginalExtension();
                $path = upload_path('banner') . $fileName;

                
                
                
                
                
                
                
                try {
                    Image::make($image->getRealPath())->save($path, 100);
                    $img_url = $fileName;
                } catch (\Exception $e) {
                    
                    
                    
                    return response()->json(['error' => 'File upload failed'], 500);
                }
            }

            $data_banner['banner_'.$i] = json_encode(['title' => $title, 'body' => $body, 'img_url' => ($request->hasFile('icon_' . $i) ? $img_url : (array_key_exists('banner_'.$i, $banner) ? (json_decode($banner['banner_'.$i])->img_url) : ''))]);
        }

        $logs = [];

        foreach ($data_banner as $key => $value) {
            $data = [];

            if (array_key_exists($key, $banner)) {
                $data["value"] = $value;
                $set = Banner::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Previous Data' => ['value' => $banner[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Banner::create($data);

                $logs[] = $set;
            }
        }

        

        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.banner'))->with(['success' => 'Data updated successfully.']);

    }
}
