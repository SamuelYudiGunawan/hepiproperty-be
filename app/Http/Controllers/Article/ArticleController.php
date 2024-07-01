<?php

namespace App\Http\Controllers\Article;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->messages(),
                'status' => 'error'
            ], 400);
        }

        $max_slug = Article::where('title', $request->title)->count();
        $slug = Str::slug($request->title . "-" . $max_slug, '-');

        $request->merge([
            'slug' => $slug
        ]);

        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = $image->hashName();
                $path = Storage::disk('public')->put('images/article', $image, 'public');

                $request->merge([
                    'image_url' => $path
                ]);

                Article::create($request->except('image'));
            }else{
                Article::create($request->except('image'));
            }

            DB::commit();

            return response()->json([
                'message' => 'success',
                'status' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'content' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->messages(),
                'status' => 'error'
            ], 400);
        }

        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found',
                'status' => 'error'
            ], 404);
        }

        if($request->title && $request->title != Article::find($id)->title){

        $max_slug = Article::where('title', $request->title)->count();
        $slug = Str::slug($request->title . "-" . $max_slug, '-');

        $request->merge([
            'slug' => $slug
        ]);
    }

   


        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {
                // delete image on storage
                if ($article->image_url != null){
                    Storage::disk('public')->delete($article->image_url);
                }
                $image = $request->file('image');
                $name = $image->hashName();
                $path = Storage::disk('public')->put('images/article', $image, 'public');
                $request->merge([
                    'image_url' => $path
                ]);

                $article->update($request->except('image'));
            }else{
                $article->update($request->except('image'));
            }

            DB::commit();

            return response()->json([
                'message' => 'success',
                'status' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    public function list(){
        $articles = Article::paginate(10, ['id', 'title', 'slug', 'image_url', 'created_at']);
        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $articles
        ], 200);
    }

    public function delete($id){
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found',
                'status' => 'error'
            ], 404);
        }

        try {
            DB::beginTransaction();
            if ($article->image_url != null){
                Storage::disk('public')->delete($article->image_url);
            }
            $article->delete();
            DB::commit();

            return response()->json([
                'message' => 'success',
                'status' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'error'
            ], 400);
        }
    }

    public function detail($slug){
        $article = Article::where('slug', $slug)->first();

        if (!$article) {
            return response()->json([
                'message' => 'Article not found',
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $article
        ], 200);
    }
}
