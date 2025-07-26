<?php

namespace App\Http\Controllers\admin;

use File;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\Gallery;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    private static $module = "gallery";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        $data = Gallery::all();

        return view('administrator.gallery.index', compact('data'));
    }
    
    public function add(){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.gallery.add');
    }
    
    public function save(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        // dd($request->img);

        $rules = [
            'img' => 'required|array',
            'img.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Adjust the allowed image types and maximum file size as needed
        ];
        
        $request->validate($rules);
        

        $data = Gallery::create([
            'img_url' => '-',
        ]);
        if ($request->hasFile('img')) {
            $dataImgJson = [];
            foreach ($request->file('img') as $image) {
                $fileName = 'image_' . Str::random(10) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
                $path = upload_path('gallery') . $fileName;
                Image::make($image->getRealPath())->save($path, 100);
                $dataImgJson[] = $fileName;
            }
    
            $data->img_url = json_encode($dataImgJson);
            $data->update();
        }

        // Log the data
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => $data]);

        return redirect()->route('admin.gallery')->with('success', 'Data berhasil disimpan.');
    }

    public function deleteImage(Request $request){
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
    
        $id = $request->id;
        $img = $request->img;
    
        $data = Gallery::find($id);
    
        if ($data) {
            $dataimgdecode = json_decode($data->img_url);
            $imgJson = [];
    
            foreach ($dataimgdecode as $row) {
                if ($row != $img) {
                    array_push($imgJson, $row);
                } else {
                    $image_path = "./administrator/assets/media/gallery/" . $row;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
    
            // Update the img_url field with the modified array
            $data->img_url = json_encode($imgJson);
            $data->update();
    
            // If the imgJson array is empty, you may want to delete the entire gallery entry
            if (empty($imgJson)) {
                $data->delete();
            }
        }
    }

    public function getGalleryData(Request $request)
    {
        $data = Gallery::all();

        return view('administrator.gallery.fetchData', compact('data'));
    }
    
}
