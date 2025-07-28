<?php

namespace App\Http\Controllers\admin;

use DataTables;
use Illuminate\Http\Request;
use App\Models\admin\CommentBlog;
use App\Http\Controllers\Controller;
use App\Models\admin\CommentBlogReply;

class CommentBlogController extends Controller
{
    private static $module = "blog_comments";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.blog_comments.index');
    }
    
    public function getData(Request $request){
        $data = CommentBlog::query()
                            ->with('blog')
                            ->where('comment_id',0);

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
                    $btn .= '<a href="'.route('admin.blog_comments.detail',$row->id).'" data-id="' . $row->id . '" class="btn btn-secondary btn-sm mx-1">
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
        $data = CommentBlog::with('reply')->findOrFail($id);

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
            'message' => 'Data has been deleted.',
        ]);
    }

    public function detail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = CommentBlog::where('id', $id)->first();

        if (!$data) {
            abort(404);
        }

        $data_detail = CommentBlog::where('comment_id', $id)->get();

        return view('administrator.blog_comments.detail',compact('data','data_detail'));
    }

    public function getDataDetail(Request $request, $id){
        $data = CommentBlogReply::query()
                                ->with('blog')
                                ->where('comment_id', $id);

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
        $data = CommentBlogReply::findOrFail($id);

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
            'message' => 'Data has been deleted.',
        ]);
    }
}
