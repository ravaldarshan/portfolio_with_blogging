<?php

namespace App\Http\Controllers\admin;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    private static $module = "team";

    public function index()
    {
        
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.team.index');
    }

    public function getData(Request $request)
    {
        $data = Team::where('user_id', auth()->user()->id);
        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : 
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : 
                    $btn .= '<a href="' . route('admin.teams.edit', $row->id) . '" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : 
                    $btn .= '<a href="' . route('admin.teams.detail', $row->id) . '" data-id="' . $row->id . '" class="btn btn-secondary btn-sm ">
                    Detail
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function add()
    {
        
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.team.add');
    }

    public function save(Request $request)
    {
        
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|unique:teams,email',
            'full_name' => 'required',
            'phone_number' => 'required',
            'designation' => 'required',
        ]);

        $updates = [];
        $updates['user_id'] = auth()->user()->id;
        $updates['updated_by'] = auth()->user()->id;
        $updates['created_by'] = auth()->user()->id;

        if ($request->filled('full_name')) {
            $updates['full_name'] = $request->full_name;
        }
        if ($request->filled('phone_number')) {
            $updates['phone_number'] = $request->phone_number;
        }
        if ($request->filled('designation')) {
            $updates['designation'] = $request->designation;
        }
         if ($request->filled('email')) {
            $updates['email'] = $request->email;
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
        if ($request->hasFile('photo')) {
            if (!empty($data->photo)) {
                $image_path = "./administrator/assets/media/profile/" . $data->photo;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $image = $request->file('photo');
            $fileName = 'photo-profile_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('profile') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $updates['photo'] = $fileName;
        }

       

        $data = Team::create($updates);

        // Log the data
        createLog(static::$module, __FUNCTION__, $data->id, ['Saved data' => $data]);

        return redirect()->route('admin.teams')->with('success', 'Data updated successfully.');
    }

    public function edit(Request $request, $id)
    {
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $data = Team::with('user')->find($id);
        // $socialMedia = json_decode($data->social_media, true);

        return view('administrator.team.edit', compact('data'));
    }

    public function update(Request $request)
    {
        
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|unique:teams,email,'. $request->id,
            'full_name' => 'required',
            'phone_number' => 'required',
            'designation' => 'required',
        ]);

        $data = Team::find($request->id);
        // Simpan Data before updating
        $previousData = $data->toArray();
        $updates = [];
        $updates['updated_by'] = auth()->user()->id;

        if ($request->filled('full_name')) {
            $updates['full_name'] = $request->full_name;
        }
        if ($request->filled('phone_number')) {
            $updates['phone_number'] = $request->phone_number;
        }
         if ($request->filled('designation')) {
            $updates['designation'] = $request->designation;
        }
         if ($request->filled('email')) {
            $updates['email'] = $request->email;
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
        if ($request->hasFile('photo')) {
            if (!empty($data->photo)) {
                $image_path = "./administrator/assets/media/profile/" . $data->photo;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $image = $request->file('photo');
            $fileName = 'photo-profile_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('profile') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $updates['photo'] = $fileName;
        }

        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());
        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data before updating' => $previousData, 'Data after updating' => $updatedData]);

        return redirect()->route('admin.teams')->with('success', 'Data updated successfully.');
    }

    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->id;

        // Find the data based on the provided ID or throw a 404 exception.
        $data = Team::findOrFail($id);

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        $image_path = "./administrator/assets/media/profile/" . $data->img_url;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        // Delete the data.
        $data->delete();

        // Write logs for soft delete
        createLog(static::$module, __FUNCTION__, $id, ['Deleted data' => $deletedData]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data has been deleted.',
        ]);
    }

    public function deleteImage(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $img = $request->img;

        $data = Team::find($id);

        $image_path = "./administrator/assets/media/profile/" . $img;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

        $data->photo = '-';
        $data->update();
    }

    public function detail($id)
    {
        
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }
        $data = Team::find($id);
        return view('administrator.team.detail', compact('data'));
    }
}
