<?php

namespace App\Http\Controllers\admin;

use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\Project;
use App\Http\Controllers\Controller;
use App\Models\admin\KategoriProject;

class KategoriProjectController extends Controller
{
    private static $module = "kategori_project";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.kategori_project.index');
    }
    
    public function getData(Request $request){
        $data = KategoriProject::query();

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
                    $btn .= '<a href="'.route('admin.kategori_project.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailKategoriProject">
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

        return view('administrator.kategori_project.add');
    }
    
    public function save(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $rules = [
            'nama' => 'required|unique:kategori_project',
        ];

        $request->validate($rules);

        $slug = Str::slug($request->nama);
        $cekSlugCount = KategoriProject::where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }

        $data = KategoriProject::create([
            'nama' => $request->nama,
            'slug' => $slug,
            'created_by' => auth()->user()->id,
        ]);

        // Log the data
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => $data]);

        return redirect()->route('admin.kategori_project')->with('success', 'Data berhasil disimpan.');
    }
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = KategoriProject::find($id);

        return view('administrator.kategori_project.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = KategoriProject::find($id);

        $rules = [
            'nama' => 'required|unique:kategori_project,nama,'.$id,
        ];

        $request->validate($rules);

        // Simpan data sebelum diupdate
        $previousData = $data->toArray();

        $slug = Str::slug($request->nama);
        $cekSlugCount = KategoriProject::where('id','!=',$id)->where('slug', $slug)->count();

        // Handle duplicate slug
        if ($cekSlugCount > 0) {
            $slug = $slug . '-' . ($cekSlugCount + 1);
        }

        $updates = [
            'nama' => $request->nama,
            'slug' => $slug,
            'updated_by' => auth()->user()->id,
        ];
        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data sebelum diupdate' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.kategori_project')->with('success', 'Data berhasil diupdate.');
    }
    
    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->id;

        // Find the data based on the provided ID or throw a 404 exception.
        $data = KategoriProject::findOrFail($id);

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        // Delete the data.
        $data->delete();

        $projects = Project::where('kategori_project_id', $data->id)->get();

        // Delete related projects if any
        if ($projects->isNotEmpty()) {
            $projects->each(function ($project) {
                $project->delete();
            });
        }

        // Write logs for soft delete
        createLog(static::$module, __FUNCTION__, $id, ['Data yang diarsip' => ['Kategori' => $deletedData, 'Project' => $projects]]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah diarsipkan.',
        ]);
    }


    
    
    public function getDetail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = KategoriProject::with('project')->find($id);

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Sukses memuat detail data.',
        ]);
    }
    
    public function checkNama(Request $request){
        if($request->ajax()){
            $users = KategoriProject::where('nama', $request->nama)->withTrashed();
            
            if(isset($request->id)){
                $users->where('id', '!=', $request->id);
            }
    
            if($users->exists()){
                return response()->json([
                    'message' => 'Nama sudah dipakai',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }

    public function arsip(){
        //Check permission
        if (!isAllowed(static::$module, "arsip")) {
            abort(403);
        }

        return view('administrator.kategori_project.arsip');
    }

    public function getDataArsip(Request $request){
        $data = KategoriProject::query()
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

        $data = KategoriProject::onlyTrashed()->find($id);

        // Check if data exists in the trash
        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $projects = Project::onlyTrashed()->where('kategori_project_id', $data->id)->get();

        // Restore the category
        $data->restore();

        // Restore related projects if any
        if ($projects->isNotEmpty()) {
            $projects->each(function ($project) {
                $project->restore();
            });
        }

        $updated = [
            'kategori_project' => $data,
            'project' => $projects,
        ];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dipulihkan' => $updated]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dipulihkan.'
        ]);
    }



    public function forceDelete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
        
        $id = $request->id;

        $data = KategoriProject::onlyTrashed()->find($id);

        // Check if data exists in the trash
        if (!$data) {
            return redirect()->route('admin.kategori_project.arsip')->with('error', 'Data tidak ditemukan.');
        }

        $projects = Project::onlyTrashed()->where('kategori_project_id', $data->id)->get();

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
            'kategori_project' => $data,
            'project' => $dataJsonProject,
        ];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, $dataJson);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dihapus secara permanent.',
        ]);
    }

}
