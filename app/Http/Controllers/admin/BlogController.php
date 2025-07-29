<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\File;
use DataTables;
use App\Models\admin\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\CategoryBlog;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class BlogController extends Controller
{
    private static $module = "blog";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.blog.index');
    }
    
    public function getData(Request $request){
        $data = Blog::query()->with('category');

        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.blog.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="'.route('admin.blog.detail',$row->slug).'" data-id="' . $row->id . '" class="btn btn-secondary btn-sm ">
                    Detail
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function add(){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.blog.add');
    }
    
    public function save(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $rules = [
            'title' => 'required',
            'category' => 'required',
            'contents' => 'required',
            'posting_date' => 'required',
            'status' => 'required',
        ];

        $request->validate($rules);

        // dd($request);

        $slug = Str::slug($request->title);
        $cekSlugCount = Blog::where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }

        $contents = $request->contents;
        $dom = new \domdocument();
        $dom->loadHtml($contents, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            list($type, $datas) = explode(';', $datas);
            list(, $datas)      = explode(',', $datas);

            $datas = base64_decode($datas);
            $image_name= 'contents_'.$slug.'-'.time().$k.'.png';
            $path = public_path() .'/administrator/assets/media/blog/'. $image_name;
            file_put_contents($path, $datas);

            $img->removeattribute('src');
            $img->setattribute('src', '/administrator/assets/media/blog/'.$image_name);
        }
        $contents = $dom->saveHTML();

        $data = Blog::create([
            'category_id' => $request->category,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'posting_date' => date('Y-m-d', strtotime($request->posting_date)),
            'slug' => $slug,
            'contents' => $contents,
            'status' => $request->status,
            'img_url' => '[]',
            'created_by' => auth()->user()->id,
        ]);
        if ($request->hasFile('img')) {
            $dataImgJson = [];
            foreach ($request->file('img') as $image) {
                $fileName = 'image_' . Str::slug($data->title) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
                $path = upload_path('blog') . $fileName;
                Image::make($image->getRealPath())->save($path, 100);
                $dataImgJson[] = $fileName;
            }
    
            $data->img_url = json_encode($dataImgJson);
            $data->update();
        }

        // Log the data
        createLog(static::$module, __FUNCTION__, $data->id, ['Saved data' => $data]);

        return redirect()->route('admin.blog')->with('success', 'Data saved successfully.');
    }
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Blog::find($id);
        if (!$data) {
            abort(404);
        }
        
        $decodeImg = json_decode($data->img_url);
        
        return view('administrator.blog.edit',compact('data','decodeImg'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = Blog::find($id);

        $rules = [
            'title' => 'required',
            'category' => 'required',
            'contents' => 'required',
            'posting_date' => 'required',
            'status' => 'required',
        ];

        $request->validate($rules);

        // Simpan Data before updating
        $previousData = $data->toArray();

        $img_contents = $data->contents;
        $dom = new \domdocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($img_contents, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            // Check if the image has base64 encoding
            $data_replace = str_replace('/administrator/assets/media/blog/', '', $datas);
            $image_path = "./administrator/assets/media/blog/" . $data_replace;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
        }

        $slug = Str::slug($request->title);
        $cekSlugCount = Blog::where('id','!=',$id)->where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . ($cekSlugCount + 1);
        }

        $contents = $request->contents;
        $dom = new \domdocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($contents, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            // Check if the image has base64 encoding
            if (strpos($datas, ';') !== false) {
                list($type, $datas) = explode(';', $datas);
                list(, $datas) = explode(',', $datas);

                $datas = base64_decode($datas);
                $image_name = 'contents_' . $slug . '-' . time() . $k . '.png';
                $path = public_path() . '/administrator/assets/media/blog/' . $image_name;
                file_put_contents($path, $datas);

                $img->removeAttribute('src');
                $img->setAttribute('src', '/administrator/assets/media/blog/' . $image_name);
            }
        }
        $contents = $dom->saveHTML();

        $updates = [
            'category_id' => $request->category,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'posting_date' => date('Y-m-d', strtotime($request->posting_date)),
            'slug' => $slug,
            'contents' => $contents,
            'status' => $request->status,
            'img_url' => '[]',
            'updated_by' => auth()->user()->id,
        ];

        $decodeImg = json_decode($data->img_url, true);

        if ($decodeImg === null && json_last_error() !== JSON_ERROR_NONE) {
            // Handle error decoding JSON
            $errorMessage = 'Error decoding JSON: ' . json_last_error_msg();
            error_log($errorMessage);
        }


        if ($request->hasFile('img')) {
            $dataImgJson = [];
            foreach ($request->file('img') as $image) {
                $fileName = 'image_' . Str::slug($data->nama) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
                $path = upload_path('blog') . $fileName;
                Image::make($image->getRealPath())->save($path, 100);
                $dataImgJson[] = $fileName;
            }

            // Menggabungkan array dari file gambar baru dengan array dari decodeImg
            $dataImgJson = array_merge($decodeImg, $dataImgJson);

            $updates['img_url'] = json_encode($dataImgJson);
        }else{
            $updates['img_url'] = $data->img_url;
        }

        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data before updating' => $previousData, 'Data after updating' => $updatedData]);
        return redirect()->route('admin.blog')->with('success', 'Data updated successfully.');
    }
    
    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->id;

        // Find the data based on the provided ID or throw a 404 exception.
        $data = Blog::findOrFail($id);

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        $dataJson = [
            'data' => $deletedData
        ];
        // Delete the data.
        $data->delete();

        // Write logs for soft delete
        createLog(static::$module, __FUNCTION__, $id, ['Archived data' => $dataJson]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been archived.',
        ]);
    }

    public function getDataCategory(Request $request)
    {
        $data = CategoryBlog::query();

        return DataTables::of($data)
            ->make(true);
    }
    
    
    public function checkNama(Request $request){
        if($request->ajax()){
            $users = Blog::where('nama', $request->nama)->withTrashed();
            
            if(isset($request->id)){
                $users->where('id', '!=', $request->id);
            }
    
            if($users->exists()){
                return response()->json([
                    'message' => 'Name is already in use',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }

    public function archives(){
        //Check permission
        if (!isAllowed(static::$module, "archives")) {
            abort(403);
        }

        return view('administrator.blog.archives');
    }

    public function getDataArchives(Request $request){
        $data = Blog::query()
                    ->with('category')
                    ->onlyTrashed()
                    ->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "restore")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-primary restore btn-sm mx-3 ">
                    Restore
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function restore(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "restore")) {
            abort(403);
        }
        
        $id = $request->id;

        $data = Blog::onlyTrashed()->find($id);

        // Check if data exists in the trash
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found.'
            ], 404);
        }

        // Restore the category
        $data->restore();


        $updated = [
            'Blog' => $data,
        ];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dipulihkan' => $updated]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been restored.'
        ]);
    }



    public function forceDelete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
        
        $id = $request->id;

        $data = Blog::onlyTrashed()->with('blog_comments')->with('blog_comments_reply')->find($id);

        // Check if data exists in the trash
        if (!$data) {
            return redirect()->route('admin.blog.archives')->with('error', 'Data not found.');
        }

        $dataimgdecode = json_decode($data->img_url);
        if ($dataimgdecode != null) {
            foreach ($dataimgdecode as $row) {
                $image_path = "./administrator/assets/media/blog/" . $row;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
            }
        }

        $contents = $data->contents;
        $dom = new \domdocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($contents, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            // Check if the image has base64 encoding
            $data_replace = str_replace('/administrator/assets/media/blog/', '', $datas);
            $image_path = "./administrator/assets/media/blog/" . $data_replace;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
        }
        
        if (!$data->blog_comments->isEmpty()) {
            $data->blog_comments->each->delete();
        }
        
        if (!$data->blog_comments_reply->isEmpty()) {
            $data->blog_comments_reply->each->delete();
        }
        
        $data->forceDelete();
        

        $dataJson = [
            'Data' => $data,
        ];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, $dataJson);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been permanently deleted.',
        ]);
    }

    public function deleteImage(Request $request){
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $img = $request->img;

        $data = Blog::find($id);

        $dataimgdecode = json_decode($data->img_url);
        $imgJson = [];
        foreach ($dataimgdecode as $row) {
            if ($row != $img) {
                array_push($imgJson, $row);
            }
            if ($row == $img) {
                $image_path = "./administrator/assets/media/blog/" . $row;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }

        $data->img_url = json_encode($imgJson);
        $data->update();
    }

    public function detail($slug){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = Blog::where('slug', $slug)->first();

        if (!$data) {
            abort(404);
        }

        $decodeImg = json_decode($data->img_url);
        
        return view('administrator.blog.detail',compact('data','decodeImg'));
    }
}
