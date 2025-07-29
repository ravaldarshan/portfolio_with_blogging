<?php

namespace App\Http\Controllers\admin;

use App\Models\Team;
use App\Models\admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    private static $module = "team";

    public function index($user_id) {
        //Check permission
        if (auth()->user()->id != 'daysf-01' && $user_id != auth()->user()->id) {
            abort(403);
        }

        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        
        $data = Team::with('user')
        ->where('user_id',$user_id)
        ->first();

        if (!$data) {
            $sosmedData = [
                'linkedin' => '',
                'twitter' => '',
                'instagram' => '',
                'facebook' => '',
            ];
            $sosmedJson = json_encode($sosmedData);
            $profile = Team::create([
                'user_id' => auth()->user() ? auth()->user()->id : '',
                'social_media' => $sosmedJson,
            ]);

            $profile->save();
            $sosmed = json_decode($sosmedJson, true); // Mengubah JSON menjadi array
        }else{
            $sosmed = json_decode($data->social_media, true); // Mengubah JSON menjadi array
        }
        if (!$data) {
            return redirect()->route('admin.dashboard')->with('error', 'Data User not found.');
        }
    
        return view('administrator.profile.index', compact('data','sosmed'));
    }
    

    public function getData(Request $request){
        $data = Team::with('user')->get();

        return DataTables::of($data)
            ->make(true);
    }
    
    public function update(Request $request)
    {
        $user_id = $request->user_id;

        // Check permission
        if ($user_id != auth()->user()->id) {
            abort(403);
        }

        $data = Team::where('user_id',$user_id)->with('user')->first();

        if (!$data) {
            return redirect()->route('admin.profile',$user_id)->with('error', 'Data not found.');
        }

        $request->validate([
            'email' => 'unique:users,email,' . $data->user->id,
        ]);

        // Simpan Data before updating
        $previousData = $data->toArray();

        $updates = [];

        if ($request->filled('full_name')) {
            $updates['full_name'] = $request->full_name;
        }
        if ($request->filled('phone_number')) {
            $updates['phone_number'] = $request->phone_number;
        }
        if ($request->filled('last_education')) {
            $updates['last_education'] = $request->last_education;
        }
        if ($request->filled('place_of_birth')) {
            $updates['place_of_birth'] = $request->place_of_birth;
        }
        if ($request->filled('date_of_birth')) {
            $updates['date_of_birth'] = $request->date_of_birth;
        }
        if ($request->filled('address')) {
            $updates['address'] = $request->address;
        }
        if ($request->filled('sosmed_linkedin') || $request->filled('social_media') || $request->filled('social_media') || $request->filled('social_media')) {
            $sosmedData = [
                'linkedin' => $request->sosmed_linkedin,
                'twitter' => $request->sosmed_twitter,
                'instagram' => $request->sosmed_instagram,
                'facebook' => $request->sosmed_facebook,
            ];
            $sosmedJson = json_encode($sosmedData);

            $updates['social_media'] = $sosmedJson;
        }
        if ($request->hasFile('photo_user_profile')) {

            if (!empty($data->photo)) {
                $image_path = "./administrator/assets/media/profile/" . $data->photo;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $image = $request->file('photo_user_profile');
            $fileName = 'photo-profile_' . $data->user->name . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('profile') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $updates['photo'] = $fileName;
        }
        
        if ($request->filled('email')) {
            $user = User::where('id', $user_id)->first();
            if ($user) {
                $user->update(['email' => $request->email]);
            } else {
                return redirect()->route('admin.profile',$user_id)->with('error', 'User tidak ditemukan.');
            }
        }

        $data->update($updates);

        // Kumpulkan data yang diperbarui dalam array
        $updatedData = [];
        foreach ($updates as $key => $value) {
            $updatedData[$key] = $data->$key;
        }

        // Kirim data yang diperbarui ke fungsi createLog
        createLog(static::$module, __FUNCTION__, $user_id, ['Data before updating' => $previousData, 'Data sesudah diupdate' => ['data' => $updatedData, 'user' => $user]]);

        return redirect()->route('admin.profile',$user_id)->with('success', 'Data updated successfully.');
    }
    
    public function getDetail($user_id){
        $data = Team::with('user')->find($user_id);
        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Successfully loaded user details.',
        ]);
    }

    public function checkEmail(Request $request){
        if($request->ajax()){
            $users = User::where('email', $request->email);
            
            if(isset($request->code)){
                $users->where('code', '!=', $request->code);
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
}
