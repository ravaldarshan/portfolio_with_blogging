<?php

namespace App\Http\Controllers\admin;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\KomentarProject;
use App\Models\admin\KomentarProjectReply;

class KomentarProjectController extends Controller
{
    private static $module = "komentar_blog";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.komentar_project.index');
    }
    
    public function getData(Request $request){
        $data = KomentarProject::query()
                                ->with('project')
                                ->where('komentar_id',0);

        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete mx-1">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="'.route('admin.komentar_project.detail',$row->id).'" data-id="' . $row->id . '" class="btn btn-secondary btn-sm mx-1">
                    Detail
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->id;

        // Find the data based on the provided ID or throw a 404 exception.
        $data = KomentarProject::with('reply')->findOrFail($id);
        if (!$data) {
            abort(404);
        }

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        if(!$data->reply->isEmpty()){
            $data->reply->each->delete();
        }

        $dataJson = [
            'data' => $deletedData,
            'reply' => $data->reply
        ];
        // Delete the data.
        $data->delete();

        // Write logs for soft delete
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => $dataJson]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dihapus.',
        ]);
    }

    public function detail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = KomentarProject::where('id', $id)->first();
        if (!$data) {
            abort(404);
        }

        return view('administrator.komentar_project.detail',compact('data'));
    }

    public function getDataDetail(Request $request, $id){
        $data = KomentarProjectReply::query()
                                ->with('project')
                                ->where('komentar_id', $id);

        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete mx-1">
                    Delete
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function deleteDetail(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->id;

        // Find the data based on the provided ID or throw a 404 exception.
        $data = KomentarProjectReply::findOrFail($id);
        if (!$data) {
            abort(404);
        }
        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        $dataJson = [
            'data' => $deletedData,
        ];
        // Delete the data.
        $data->delete();

        // Write logs for soft delete
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => $dataJson]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dihapus.',
        ]);
    }
}
