<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Limit;
use Illuminate\Support\Facades\Validator;

class HitController extends Controller {

  public function perMin(Request $request) {
    try {
      $inputs = $request->all();
      $validator = Validator::make(
              $inputs,
              [
                  'per_min' => 'required'
              ]
      );
      if ($validator->fails()) {
        $this->apiArray['message'] = $validator->messages()->first();
        $this->apiArray['errorCode'] = 1;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 200);
      }
      $limit = Limit::first();
      if (empty($limit)) {
        $lim = new Limit;
        $lim->per_min = $inputs['per_min'];
        $lim->save();
        $this->apiArray['message'] = 'Limit saved';
        $this->apiArray['errorCode'] = 2;
        $this->apiArray['error'] = false;
        return response()->json($this->apiArray, 200);
      }

      $r = ['per_min' => $inputs['per_min']];
      Limit::where(['id' => $limit->id])->update($r);
      $this->apiArray['message'] = 'Limit updated for per minute';
      $this->apiArray['errorCode'] = 2;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = $e->getMessage();
      $this->apiArray['errorCode'] = 3;
      $this->apiArray['error'] = true;
      return response()->json($this->apiArray, 200);
    }
  }
}
