<?php

namespace App\Http\Controllers\admin;

use DataTables;
use App\Models\admin\User;
use Illuminate\Http\Request;
use App\Models\admin\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    private static $module = "profile";

    public function index() {
        $user_id = auth()->user()->id;
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        
        $data = Profile::with('user')
        ->where('user_id',$user_id)
        ->first();
        if (!$data) {
            $socialMediaData = [
                'linkedin' => '',
                'twitter' => '',
                'instagram' => '',
                'facebook' => '',
            ];
            $socialMediaJson = json_encode($socialMediaData);
            $profile = Profile::create([
                'user_id' => auth()->user() ? auth()->user()->id : '',
                'social_media' => $socialMediaJson,
            ]);

            $profile->save();
            $socialMedia = json_decode($socialMediaJson, true); 
        }else{
            $socialMedia = json_decode($data->social_media, true);
        }
        if (!$data) {
            return redirect()->route('admin.dashboard')->with('error', 'Data User not found.');
        }
    
        return view('administrator.profile.index', compact('data','socialMedia'));
    }
    

    public function getData(Request $request){
        $data = Profile::with('user')->get();

        return DataTables::of($data)
            ->make(true);
    }
    
    public function update(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = Profile::where('user_id',$user_id)->with('user')->first();

        if (!$data) {
            return redirect()->route('admin.profile',$user_id)->with('error', 'Data not found.');
        }

        $request->validate([
            'email' => 'unique:users,email,' . $data->user->id,
        ]);

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
        if ($request->filled('socialMedia_linkedin') || $request->filled('social_media') || $request->filled('social_media') || $request->filled('social_media')) {
            $socialMediaData = [
                'linkedin' => $request->socialMedia_linkedin,
                'twitter' => $request->socialMedia_twitter,
                'instagram' => $request->socialMedia_instagram,
                'facebook' => $request->socialMedia_facebook,
            ];
            $socialMediaJson = json_encode($socialMediaData);

            $updates['social_media'] = $socialMediaJson;
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
                return redirect()->route('admin.profile',$user_id)->with('error', 'User not found.');
            }
        }

        $data->update($updates);
        $updatedData = [];
        foreach ($updates as $key => $value) {
            $updatedData[$key] = $data->$key;
        }
        createLog(static::$module, __FUNCTION__, $user_id, ['Data before updating' => $previousData, 'Data after updating' => ['data' => $updatedData, 'user' => $user]]);

        return redirect()->route('admin.profile',$user_id)->with('success', 'Data updated successfully.');
    }

    public function getDetail($user_id){

        $data = Profile::with('user')->find($user_id);
        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Successfully loaded user details.',
        ]);
    }

    public function checkEmail(Request $request){
        if($request->ajax()){
            $users = User::where('email', $request->email);
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
}
