<?php

namespace App\Http\Controllers\admin;

use File;
use DataTables;
use App\Models\admin\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\CategoryBlog;
use App\Http\Controllers\Controller;

class CategoryBlogController extends Controller
{
    private static $module = "category_blog";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.category_blog.index');
    }
    
    public function getData(Request $request){
        $data = CategoryBlog::query();

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
                    $btn .= '<a href="'.route('admin.category_blog.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailCategoryBlog">
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

        return view('administrator.category_blog.add');
    }
    
    public function save(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $rules = [
            'nama' => 'required|unique:category_blog',
            'status' => 'required',
        ];

        $request->validate($rules);

        $slug = Str::slug($request->nama);
        $cekSlugCount = CategoryBlog::where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }

        $data = CategoryBlog::create([
            'nama' => $request->nama,
            'slug' => $slug,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
        ]);

        // Log the data
        createLog(static::$module, __FUNCTION__, $data->id, ['Saved data' => $data]);

        return redirect()->route('admin.category_blog')->with('success', 'Data saved successfully.');
    }
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = CategoryBlog::find($id);

        return view('administrator.category_blog.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = CategoryBlog::find($id);

        $rules = [
            'nama' => 'required|unique:category_blog,nama,'.$id,
            'status' => 'required',
        ];

        $request->validate($rules);

        // Simpan Data before updating
        $previousData = $data->toArray();

        $slug = Str::slug($request->nama);
        $cekSlugCount = CategoryBlog::where('id','!=',$id)->where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }

        $updates = [
            'nama' => $request->nama,
            'slug' => $slug,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
        ];
        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data before updating' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.category_blog')->with('success', 'Data updated successfully.');
    }
    
    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->id;

        // Find the data based on the provided ID or throw a 404 exception.
        $data = CategoryBlog::findOrFail($id);
        $data->update(['deleted_by' => auth()->user()->id]);
        
        // Store the data to be logged before deletion
        $deletedData = $data->toArray();
        
        $projects = Blog::where('category_id', $data->id)->get();
        
        // Delete related projects if any
        if ($projects->isNotEmpty()) {
            $projects->each(function ($project) {
                $project->update(['deleted_by' => auth()->user()->id]);
                $project->delete();
            });
        }

        // Delete the data.
        $data->delete();

        // Write logs for soft delete
        createLog(static::$module, __FUNCTION__, $id, ['Archived data' => ['Category' => $deletedData, 'Project' => $projects]]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been archived.',
        ]);
    }


    
    
    public function getDetail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = CategoryBlog::with('blog')->find($id);

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Successfully loaded detailed data.',
        ]);
    }
    
    public function checkNama(Request $request){
        if($request->ajax()){
            $users = CategoryBlog::where('nama', $request->nama)->withTrashed();
            
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

        return view('administrator.category_blog.archives');
    }

    public function getDataArchives(Request $request){
        $data = CategoryBlog::query()
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

        $data = CategoryBlog::onlyTrashed()->find($id);

        // Check if data exists in the trash
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found.'
            ], 404);
        }

        $projects = Blog::onlyTrashed()->where('category_id', $data->id)->get();

        // Restore the category
        $data->restore();

        // Restore related projects if any
        if ($projects->isNotEmpty()) {
            $projects->each(function ($project) {
                $project->restore();
            });
        }

        $updated = [
            'category_blog' => $data,
            'project' => $projects,
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

        $data = CategoryBlog::onlyTrashed()->find($id);

        // Check if data exists in the trash
        if (!$data) {
            return redirect()->route('admin.category_blog.archives')->with('error', 'Data not found.');
        }

        $projects = Blog::onlyTrashed()->where('category_id', $data->id)->get();

        // Force delete the category
        $data->forceDelete();

        // Force delete related projects if any
        if ($projects->isNotEmpty()) {
            $projects->each(function ($project) {
                $project->forceDelete();
            });
            $dataJsonProject = $projects;
        } else {
            $dataJsonProject = null;
        }

        $dataJson = [
            'category_blog' => $data,
            'project' => $dataJsonProject,
        ];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, $dataJson);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been permanently deleted.',
        ]);
    }
}
