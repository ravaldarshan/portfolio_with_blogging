<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\Blog;
use Illuminate\Http\Request;
use App\Models\admin\KomentarBlog;
use App\Http\Controllers\Controller;
use App\Models\admin\KomentarBlogReply;

class BlogController extends Controller
{
    public function index()
    {
        $data = Blog::with('komentar_blog', 'komentar_blog_reply')->where('status', 1)->paginate(9);

        return view('frontpage.blog.index', compact('data'));
    }

    
    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('komentar_blog', 'komentar_blog_reply')->where('status', 1)->paginate(9);

            return view('frontpage.blog.fetchData.index', compact('data'))->render();
        }
    }

    public function detail($slug){
        $data = Blog::with('kategori')->where('slug', $slug)->first();

        if (!$data) {
            abort(404);
        }

        $decodeImg = json_decode($data->img_url);

        $previous = Blog::where('slug', '!=', $slug)->limit(2)->inRandomOrder()->get();

        $recent = Blog::where('slug', '!=', $slug)
                    ->whereNotIn('id', $previous->pluck('id'))
                    ->limit(3)
                    ->inRandomOrder()
                    ->get();

        $comment = KomentarBlog::with('reply')->where('blog_id', $data->id)->get();
        $reply = KomentarBlogReply::where('blog_id', $data->id)->get();

        $countComment = count($comment) + count($reply);

        return view('frontpage.blog.detail', compact('data','decodeImg','previous', 'recent', 'comment', 'countComment'));
    }

    public function fetchDataComment(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('kategori')->where('slug', $request->slug)->first();
            $comment = KomentarBlog::with('reply')->where('blog_id', $data->id)->get();

            return view('frontpage.blog.fetchData.comment', compact('comment','data'))->render();
        }
    }

    public function comment(Request $request,$slug){
        $project = Blog::with('kategori')->where('slug', $slug)->first();

        $data = KomentarBlog::create([
            'user_id' => 0,
            'komentar_id' => 0,
            'blog_id' => $project->id,
            'isi' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah disimpan.',
        ]);
    }

    public function reply(Request $request,$slug){
        $project = Blog::with('kategori')->where('slug', $slug)->first();

        $data = KomentarBlogReply::create([
            'user_id' => 0,
            'komentar_id' => $request->komentar_id,
            'blog_id' => $project->id,
            'isi' => $request->comment,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah disimpan.',
        ]);
    }
}
