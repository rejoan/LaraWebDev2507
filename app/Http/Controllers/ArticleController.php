<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller {

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    try {
      $user = $request->user();
      $articles = Article::where(['created_by' => $user->id])->get();
      $this->apiArray['data'] = $articles;
      $this->apiArray['message'] = 'Articles created by you';
      $this->apiArray['errorCode'] = 0;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = $e->getMessage();
      $this->apiArray['errorCode'] = 1;
      $this->apiArray['error'] = true;
      $this->apiArray['data'] = null;
      return response()->json($this->apiArray, 200);
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    try {
      $inputs = $request->all();
      $validator = Validator::make(
              $inputs,
              [
                  'title' => 'required',
                  'body' => 'required',
                  'category_id' => 'required',
              ]
      );
      if ($validator->fails()) {
        $this->apiArray['message'] = $validator->messages()->first();
        $this->apiArray['errorCode'] = 1;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 200);
      }
      $article = new Article;
      $article->title = $request->title;
      $article->slug = str_replace([' ', '-', ','], '_', $request->title);
      $article->body = $request->body;
      $article->category_id = $request->category_id;
      $user = $request->user();
      $article->created_by = $user->id;
      $article->save();
      $this->apiArray['message'] = 'Article created';
      $this->apiArray['errorCode'] = 2;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = 'Something is wrong, please try after some time' . $e->getMessage();
      $this->apiArray['errorCode'] = 3;
      $this->apiArray['error'] = true;
      return response()->json($this->apiArray, 200);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id, Request $request) {
    try {
      if (!ctype_digit($id)) {
        $this->apiArray['message'] = 'Please provide id';
        $this->apiArray['errorCode'] = 1;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 200);
      }

      $user = $request->user();
      $article = Article::where(['created_by' => $user->id, 'id' => $id])->first();
      if (empty($article)) {
        $this->apiArray['message'] = 'Not article found';
        $this->apiArray['errorCode'] = 2;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 401);
      }
      $this->apiArray['data'] = $article;
      $this->apiArray['message'] = 'Requested article';
      $this->apiArray['errorCode'] = 3;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = $e->getMessage();
      $this->apiArray['errorCode'] = 4;
      $this->apiArray['error'] = true;
      $this->apiArray['data'] = null;
      return response()->json($this->apiArray, 200);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(string $id, Request $request) {
    try {
      $inputs = $request->all();
      $validator = Validator::make(
              $inputs,
              [
                  'title' => 'required',
                  'body' => 'required',
                  'category_id' => 'required',
              ]
      );
      if ($validator->fails()) {
        $this->apiArray['message'] = $validator->messages()->first();
        $this->apiArray['errorCode'] = 1;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 200);
      }
      if (!ctype_digit($id) || !ctype_digit($request->category_id)) {
        $this->apiArray['message'] = 'id & category id should be integer';
        $this->apiArray['errorCode'] = 2;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 200);
      }
      $user = $request->user();
      $r = ['title' => $request->title, 'slug' => str_replace([' ', '-', ','], '_', $request->title), 'body' => $request->body, 'category_id' => $request->category_id];
      Article::where(['id' => $id, 'created_by' => $user->id])->update($r);
      $this->apiArray['message'] = 'Article updated';
      $this->apiArray['errorCode'] = 3;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = $e->getMessage();
      $this->apiArray['errorCode'] = 4;
      $this->apiArray['error'] = true;
      return response()->json($this->apiArray, 200);
    }
  }

  /**
   * Remove the specified resource.
   */
  public function destroy(string $id, Request $request) {
    try {
      if (!ctype_digit($id)) {
        $this->apiArray['message'] = 'id should be integer';
        $this->apiArray['errorCode'] = 1;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 200);
      }

      $user = $request->user();
      $article = Article::where(['created_by' => $user->id, 'id' => $id])->first();
      if (empty($article)) {
        $this->apiArray['message'] = 'Not article found';
        $this->apiArray['errorCode'] = 2;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 401);
      }
      $article->delete();
      $this->apiArray['message'] = 'Article deleted';
      $this->apiArray['errorCode'] = 3;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = $e->getMessage();
      $this->apiArray['errorCode'] = 4;
      $this->apiArray['error'] = true;
      $this->apiArray['data'] = null;
      return response()->json($this->apiArray, 200);
    }
  }
}
