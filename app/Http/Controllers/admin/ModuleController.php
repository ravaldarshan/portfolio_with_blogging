<?php

namespace App\Http\Controllers\admin;

use DataTables;
use Illuminate\Support\Str;
use App\Models\admin\Module;
use Illuminate\Http\Request;
use App\Models\admin\ModuleAccess;
use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    private static $module = "module_management";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.module.index');
    }
    
    public function getData(Request $request){
        $data = Module::query()->with('access');

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.module.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailModule">
                    Detail
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    
    public function add(){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.module.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        
        $request->validate([
            'name' => 'required|string',
            'identifiers' => 'required|string',
            'modul_access.*.tipe' => 'required|string',
            'modul_access.*.code_access' => 'required_if:modul_access.*.tipe,element|string',
            'modul_access.*.code_access' => 'required_if:modul_access.*.tipe,page|string',
        ]);

        
        $module = Module::Create([
            'name' => Str::ucfirst($request->name),
            'identifiers' => Str::lower($request->identifiers),
        ]);

        
        foreach ($request->input('modul_access') as $modulAkses) {
            $module->access()->create([
                'module_id' => $module->id,
                'name' => Str::ucfirst($modulAkses['code_access']),
                'identifiers' => Str::lower($modulAkses['code_access']),
            ]);
        }
    

        $module_access = ModuleAccess::where('module_id',$module->id)->get();

        createLog(static::$module, __FUNCTION__, $module->id, ['Saved data' => ['Modul' => $module, 'Modul Akses' => $module_access]]);
        return redirect()->route('admin.module')->with('success', 'Data saved successfully.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Module::find($id);

        return view('administrator.module.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        
        if (!isAllowed(static::$module, "update")) {
            abort(403);
        }

        
        $request->validate([
            'name' => 'required|string',
            'identifiers' => 'required|string',
            'modul_access.*.tipe' => 'required|string',
            'modul_access.*.code_access' => 'required_if:modul_access.*.tipe,element|string',
            'modul_access.*.code_access' => 'required_if:modul_access.*.tipe,page|string',
        ]);

        $id = $request->id;
        
        $module = Module::find($id);

        
        if (!$module) {
            return redirect()->route('admin.module')->with('error', 'Module not found!');
        }
        $log_module_before = $module;

        $module_access = ModuleAccess::where('module_id', $module->id)->get();

        $log_module_access_after = $module_access;

        
        $module->update([
            'name' => $request->name,
            'identifiers' => $request->identifiers,
        ]);

        
        $module->access()->delete();

        
        foreach ($request->input('modul_access') as $modulAkses) {
            $module->access()->create([
                'module_id' => $module->id,
                'name' => Str::ucfirst($modulAkses['code_access']),
                'identifiers' => Str::lower($modulAkses['code_access']),
            ]);
        }

        $log_module_access = ModuleAccess::where('module_id', $module->id)->get();

        createLog(static::$module, __FUNCTION__, $module->id, [
            'Data before updating' => ['Modul' => $log_module_before, 'Modul Akses' => $log_module_access_after],
            'Data after updating' => ['Modul' => $module, 'Modul Akses' => $log_module_access],
        ]);

        return redirect()->route('admin.module')->with('success', 'Data updated successfully.');
    }


    
    
    
    public function delete(Request $request)
    {
        
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        

        $id = $request->id;

        
        $data = Module::findorfail($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        
        $data->delete();

        $logAccess = ModuleAccess::where('module_id',$id)->get();

        if (!empty($data->access())) {
            
            $data->access()->delete();
        }

        
        createLog(static::$module, __FUNCTION__, $id, ['Deleted data' => ['Module' => $data, 'Module Access' => $logAccess]]);

        return response()->json([
            'status' => 'success',
            'message' => 'User has been deleted.',
        ]);
    }

    
    
    public function getDetail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = Module::findOrFail($id);
        $access = ModuleAccess::where('module_id',$id)->get();

        return response()->json([
            'data' => $data,
            'access' => $access,
            'status' => 'success',
            'message' => 'Successfully loaded module details.',
        ]);
    }
}
