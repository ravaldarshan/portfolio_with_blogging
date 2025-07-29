<?php

namespace App\Http\Controllers\admin;

use DataTables;
use App\Models\admin\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\Profile;
use App\Models\admin\UserGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private static $module = "user";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.users.index');
    }
    
    public function getData(Request $request){
        $data = User::query()
                    ->with('user_group')
                    ->where('email', '!=', 'dev@daysf.com');

        if ($request->status || $request->usergroup) {
            $data = $data->where(function ($query) use ($request) {
                if ($request->status != "") {
                    $status = $request->status == "Active" ? 1 : 0;
                    $query->where("status", $status);
                }

                if ($request->usergroup != "") {
                    $query->where("user_group_id", $request->usergroup);
                }
            });
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('status', function ($row) {
                if (isAllowed(static::$module, "status")) : //Check permission
                    if ($row->status) {
                        $status = '<div class="d-flex"><div>
                        <input class="tgl tgl-ios changeStatus" data-ix="' . $row->id . '" type="checkbox" value="1"
                            name="status" checked="checked"  id="status'.$row->id.'"/>
                        <label class="tgl-btn" for="status'.$row->id.'"></label>
                    </div>';
                        $status .= '<span class="badge bg-success">Active</span></div>';
                    } else {
                        $status = '<div class="d-flex"><div>
                        <input class="tgl tgl-ios changeStatus" data-ix="' . $row->id . '" type="checkbox" value="1"
                            name="status" id="status'.$row->id.'"/>
                            <label class="tgl-btn" for="status'.$row->id.'"></label>
                            </div>';
                        $status .= '<span class="badge bg-danger">Not Active</span></div>';
                    }
                    return $status;
                endif;
            })
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.users.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailUser">
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

        return view('administrator.users.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'konfirmasi_password' => 'required|min:8|same:password',
            'user_group' => 'required',
            'status' => 'required',
        ]);
    
        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_group_id' => $request->user_group,
            'status' => $request->status,
            'code' => $request->code,
            'remember_token' => Str::random(60),
        ]);

        $profile = Profile::create([
            'user_id' => $data['id'],
            'social_media' => '{
                "linkedin": "",
                "twitter": "",
                "instagram": "",
                "facebook": ""
              }',
        ]);
    
        createLog(static::$module, __FUNCTION__, $data->id, ['Saved data' => $data]);
        return redirect()->route('admin.users')->with('success', 'Data saved successfully.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = User::find($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        if ($id == 1) {
            if (auth()->user()->code != 'daysf') {
                // dd(auth()->user()->code);
                return view('administrator.users.index');
            }
        }

        return view('administrator.users.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = User::find($id);

        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'user_group' => 'required',
            'code' => 'required|unique:users,code,'.$id,
        ];

        if ($request->password) {
            $rules['password'] = 'required|min:8';
            $rules['konfirmasi_password'] = 'required|min:8|same:password';
        }

        $request->validate($rules);

        // Simpan Data before updating
        $previousData = $data->toArray();

        $updates = [
            'name' => $request->name,
            'email' => $request->email,
            'user_group_id' => $request->user_group,
            'status' => $request->status,
            'code' => $request->code,
            'remember_token' => Str::random(60),
        ];

        if ($request->password) {
            $updates['password'] = Hash::make($request->password);
        }

        // Check if a profile exists for the user
        $profile = Profile::where('user_id', $data->id)->firstOrNew([
            'user_id' => $data->id,
            'social_media' => '{"linkedin":"","twitter":"","instagram":"","facebook":""}',
        ]);

        // Update the profile data
        $profile->user_id = $updates['code'];
        $profile->save();

        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data before updating' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.users')->with('success', 'Data updated successfully.');
    }

    
    
    
    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
        $id = $request->id;

        // Find the user based on the provided ID.
        $user = User::findorfail($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        if ($id == 1) {
            if (auth()->user()->code != 'daysf') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
        }

        // Store the data to be logged before deletion
        $deletedData = $user->toArray();

        // Delete the user.
        $user->delete();

        $profile = Profile::where('user_id', $user->id)->first();

        if ($profile) {
            // Check if the profile is being force-deleted
            $profile->delete();
        }

        // Write logs only for soft delete (not force delete)
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => ['User' => $deletedData, 'User Profile' => $profile]]);

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

        $data = User::with('user_group')->with('profile')->find($id);

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Successfully loaded user details.',
        ]);
    }

    public function changeStatus(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "status")) {
            abort(403);
        }
        
        $data['status'] = $request->status == "Active" ? 1 : 0;
        $log = $request->status;
        $id = $request->ix;
        $updates = User::where(["id" => $id])->first();
        // Simpan Data before updating
        $previousData = $updates->toArray();
        $updates->update($data);

        //Write log
        createLog(static::$module, __FUNCTION__, $id, ['Data User' => $previousData,'Statusnya diubah menjadi' => $log]);
        return response()->json([
            'status' => 'success',
            'message' => 'Status has been changed.',
        ]);
    }
    
    public function getUserGroup(){
        $usergroup = UserGroup::all();

        return response()->json([
            'usergroup' => $usergroup,
        ]);
    }
    
    public function generateCode(){
        $generateCode = 'webits-' . substr(uniqid(), -5);

        return response()->json([
            'generateCode' => $generateCode,
        ]);
    }
    
    public function checkEmail(Request $request){
        if($request->ajax()){
            $users = User::where('email', $request->email)->withTrashed();
            
            if(isset($request->id)){
                $users->where('id', '!=', $request->id);
            }
    
            if($users->exists()){
                return response()->json([
                    'message' => 'Email is already in use',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    
    public function checkCode(Request $request){
        if($request->ajax()){
            $users = User::where('code', $request->code)->withTrashed();
            
            if(isset($request->id)){
                $users->where('id', '!=', $request->id);
            }
    
            if($users->exists()){
                return response()->json([
                    'message' => 'Code has been used',
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

        return view('administrator.users.archives');
    }

    public function getDataArchives(Request $request){
        $data = User::query()
                    ->with('user_group')
                    ->onlyTrashed()
                    ->where('email', '!=', 'dev@daysf.com');

        if ($request->status || $request->usergroup) {
            $data = $data->where(function ($query) use ($request) {
                if ($request->status != "") {
                    $status = $request->status == "Active" ? 1 : 0;
                    $query->where("status", $status);
                }

                if ($request->usergroup != "") {
                    $query->where("user_group_id", $request->usergroup);
                }
            });
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('status', function ($row) {
                if (isAllowed(static::$module, "status")) : //Check permission
                    if ($row->status) {
                        $status = '<div class="d-flex"><div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input h-20px w-30px changeStatus" data-ix="' . $row->id . '" type="checkbox" value="1"
                            name="status" checked="checked" />
                        <label class="form-check-label fw-bold text-gray-400"
                            for="status"></label>
                    </div>';
                        $status .= '<span class="badge bg-success">Active</span></div>';
                    } else {
                        $status = '<div class="d-flex"><div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input h-20px w-30px changeStatus" data-ix="' . $row->id . '" type="checkbox" value="1"
                            name="status"/>
                            <label class="form-check-label fw-bold text-gray-400"
                            for="status"></label>
                            </div>';
                        $status .= '<span class="badge bg-danger">Not Active</span></div>';
                    }
                    return $status;
                endif;
            })
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
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function restore(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "restore")) {
            abort(403);
        }
        
        $id = $request->id;
        $data = User::withTrashed()->find($id);
        $profile = Profile::withTrashed()->where('user_id', $data->id)->first();

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found.'
            ], 404);
        }

        if (!$profile) {
            $profile = Profile::create([
                'user_id' => $data->id,
            ]);
            $userProfiletoarray = '';
        } else {
            # code...
            $userProfiletoarray = "'User Profile' => $profile->toArray()";
        }
        // Simpan Data before updating
        $previousData = [
            'User' => $data->toArray(),
            $userProfiletoarray
        ];

        $data->restore();
        if (!empty($profile)) {
            $profile->restore();
        }

        $updated = ['User' => $data, 'User Profile' => $profile];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dipulihkan' => $updated]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been restored.'
        ]);
    }


    public function forceDelete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
        
        $id = $request->id;

        $data = User::withTrashed()->find($id);
        $profile = Profile::withTrashed()->where('user_id',$data->id)->first();

        if (!$data) {
            return redirect()->route('admin.users.archives')->with('error', 'Data not found.');
        }
        if ($id == 1) {
            if (auth()->user()->code != 'daysf') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }
        }

        $data->forceDelete();
        if (!empty($profile)) {
            $profile->forceDelete();
            $dataJsonProfile = $profile;
        } else {
            $dataJsonProfile = '';
        }

        $dataJson = [
            $data,$dataJsonProfile
        ];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, $dataJson);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data has been permanently deleted.',
        ]);
    }

}
