<?php

namespace App\Http\Controllers\admin;

use File;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\Project;
use App\Http\Controllers\Controller;
use App\Models\admin\CategoryProject;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    private static $module = "project";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.project.index');
    }
    
    public function getData(Request $request){
        $data = Project::query()->with('category_project');

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
                    $btn .= '<a href="'.route('admin.project.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="'.route('admin.project.detail',$row->slug).'" data-id="' . $row->id . '" class="btn btn-secondary btn-sm ">
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

        return view('administrator.project.add');
    }
    
    public function save(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $rules = [
            'nama' => 'required|unique:project',
            'category_project' => 'required',
            'description' => 'required',
        ];

        $request->validate($rules);

        // dd($request);

        $slug = Str::slug($request->nama);
        $cekSlugCount = Project::where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }

        $description = $request->description;
        $dom = new \domdocument();
        $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            list($type, $datas) = explode(';', $datas);
            list(, $datas)      = explode(',', $datas);

            $datas = base64_decode($datas);
            $image_name= 'description_'.$slug.'-'.time().$k.'.png';
            $path = public_path() .'/administrator/assets/media/project/'. $image_name;
            file_put_contents($path, $datas);

            $img->removeattribute('src');
            $img->setattribute('src', '/administrator/assets/media/project/'.$image_name);
        }
        $description = $dom->saveHTML();

        $data = Project::create([
            'category_project_id' => $request->category_project,
            'nama' => $request->nama,
            'slug' => $slug,
            'description' => $description,
            'img_url' => '-',
            'created_by' => auth()->user()->id,
        ]);
        if ($request->hasFile('img')) {
            $dataImgJson = [];
            foreach ($request->file('img') as $image) {
                $fileName = 'image_' . Str::slug($data->nama) . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
                $path = upload_path('project') . $fileName;
                Image::make($image->getRealPath())->save($path, 100);
                $dataImgJson[] = $fileName;
            }
    
            $data->img_url = json_encode($dataImgJson);
            $data->update();
        }

        // Log the data
        createLog(static::$module, __FUNCTION__, $data->id, ['Saved data' => $data]);

        return redirect()->route('admin.project')->with('success', 'Data saved successfully.');
    }
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Project::find($id);
        if (!$data) {
            abort(404);
        }
        
        $decodeImg = json_decode($data->img_url);
        
        return view('administrator.project.edit',compact('data','decodeImg'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = Project::find($id);

        $rules = [
            'nama' => 'required|unique:category_project,nama,'.$id,
            'category_project' => 'required',
            'description' => 'required',
        ];

        $request->validate($rules);

        // Simpan Data before updating
        $previousData = $data->toArray();

        $data_description = $data->description;
        $dom = new \domdocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($data_description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            // Check if the image has base64 encoding
            $data_replace = str_replace('/administrator/assets/media/project/', '', $datas);
            $image_path = "./administrator/assets/media/project/" . $data_replace;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
        }

        $slug = Str::slug($request->nama);
        $cekSlugCount = Project::where('id','!=',$id)->where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . ($cekSlugCount + 1);
        }

        $description = $request->description;
        $dom = new \domdocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            if (strpos($datas, ';') !== false) {
                list($type, $datas) = explode(';', $datas);
                list(, $datas)      = explode(',', $datas);

                $datas = base64_decode($datas);
                $image_name= 'description_'.$slug.'-'.time().$k.'.png';
                $path = public_path() .'/administrator/assets/media/project/'. $image_name;
                file_put_contents($path, $datas);

                $img->removeattribute('src');
                $img->setattribute('src', '/administrator/assets/media/project/'.$image_name);
            }
        }
        $description = $dom->saveHTML();

        $updates = [
            'category_project_id' => $request->category_project,
            'nama' => $request->nama,
            'slug' => $slug,
            'description' => $description,
            'img_url' => '-',
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
                $path = upload_path('project') . $fileName;
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

        createLog(static::$module, __FUNCTION__, $data->id, ['Data before updating' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.project')->with('success', 'Data updated successfully.');
    }
    
    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->id;

        // Find the data based on the provided ID or throw a 404 exception.
        $data = Project::findOrFail($id);

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        // Delete the data.
        $data->delete();

        $projects = Project::where('category_project_id', $data->id)->get();

        // Delete related projects if any
        if ($projects->isNotEmpty()) {
            $projects->each(function ($project) {
                $project->delete();
            });
        }

        // Write logs for soft delete
        createLog(static::$module, __FUNCTION__, $id, ['Archived data' => ['Category' => $deletedData, 'Project' => $projects]]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been archived.',
        ]);
    }

    public function getDataCategoryProject(Request $request)
    {
        $data = CategoryProject::query();

        return DataTables::of($data)
            ->make(true);
    }
    
    
    public function getDetail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = Project::with('project')->find($id);
        
        if (!$data) {
            abort(404);
        }

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Successfully loaded detailed data.',
        ]);
    }
    
    public function checkNama(Request $request){
        if($request->ajax()){
            $users = Project::where('nama', $request->nama)->withTrashed();
            
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

        return view('administrator.project.archives');
    }

    public function getDataArchives(Request $request){
        $data = Project::query()
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

        $data = Project::onlyTrashed()->find($id);

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
            'data' => $data,
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

        $data = Project::onlyTrashed()->with('comment_project')->with('comment_project_reply')->find($id);

        // Check if data exists in the trash
        if (!$data) {
            return redirect()->route('admin.project.archives')->with('error', 'Data not found.');
        }

        $dataimgdecode = json_decode($data->img_url);
        if ($dataimgdecode != null) {
            foreach ($dataimgdecode as $row) {
                $image_path = "./administrator/assets/media/project/" . $row;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
            }
        }

        $description = $data->description;
        $dom = new \domdocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        
        $images = $dom->getelementsbytagname('img');
        foreach($images as $k => $img){
            $datas = $img->getattribute('src');
            // Check if the image has base64 encoding
            $data_replace = str_replace('/administrator/assets/media/project/', '', $datas);
            $image_path = "./administrator/assets/media/project/" . $data_replace;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
        }

        if (!$data->comment_project->isEmpty()) {
            $data->comment_project->each->delete();
        }
        
        if (!$data->comment_project_reply->isEmpty()) {
            $data->comment_project_reply->each->delete();
        }
        
        $data->forceDelete();
        


        $dataJson = [
            'data' => $data,
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

        $data = Project::find($id);

        $dataimgdecode = json_decode($data->img_url);
        $imgJson = [];
        foreach ($dataimgdecode as $row) {
            if ($row != $img) {
                array_push($imgJson, $row);
            }
            if ($row == $img) {
                $image_path = "./administrator/assets/media/project/" . $row;
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

        $data = Project::where('slug', $slug)->first();

        if (!$data) {
            abort(404);
        }

        $decodeImg = json_decode($data->img_url);
        
        return view('administrator.project.detail',compact('data','decodeImg'));
    }
}
