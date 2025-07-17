<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller {

  /**
   * 
   */
  public function __construct() {
    $this->apiArray = array();
    $this->apiArray['error'] = true;
    $this->apiArray['message'] = '';
    $this->apiArray['errorCode'] = 1;
  }

  /**
   * create access token for user.
   */
  public function createToken(Request $request) {
    try {
      $inputs = $request->all();
      $validator = Validator::make(
              $inputs,
              [
                  'email' => 'required',
                  'password' => 'required',
              ]
      );
      if ($validator->fails()) {
        $this->apiArray['message'] = $validator->messages()->first();
        $this->apiArray['errorCode'] = 2;
        $this->apiArray['error'] = true;
        return response()->json($this->apiArray, 200);
      }
      $user = User::where(['email' => $inputs['email']])->first();
      if (empty($user)) {
        $this->apiArray['message'] = 'User does not match with our record.';
        $this->apiArray['errorCode'] = 3;
        $this->apiArray['error'] = true;
        $this->apiArray['data'] = null;
        return response()->json($this->apiArray, 401);
      }
      $check = false;
      if (!empty($user)) {
        $check = Hash::check($inputs['password'], $user->password);
      }
      if ($check == false) {
        $this->apiArray['message'] = 'Password does not match with our record.';
        $this->apiArray['errorCode'] = 4;
        $this->apiArray['error'] = true;
        $this->apiArray['data'] = null;
        return response()->json($this->apiArray, 401);
      }

      $message = 'Login sucessfully';
      $user->tokens()->delete();
      $token = $user->createToken('api_token');
      $plainToken = explode('|', $token->plainTextToken);
      $data = array(
          'user_email' => $user->email,
          'token' => trim($plainToken[1]),
      );
      $this->apiArray['data'] = $data;
      $this->apiArray['message'] = $message;
      $this->apiArray['errorCode'] = 0;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = 'Something is wrong, please try after some time' . $e->getMessage();
      $this->apiArray['errorCode'] = 5;
      $this->apiArray['error'] = true;
      $this->apiArray['data'] = null;
      return response()->json($this->apiArray, 200);
    }
  }

  /**
   * authenticate user.
   */
  public function authUser(Request $request) {
    $this->apiArray['message'] = 'Auth Success';
    $this->apiArray['errorCode'] = 0;
    $this->apiArray['error'] = false;
    $this->apiArray['data'] = ['email' => $request->user()->email,'name' => $request->user()->name];
    return response()->json($this->apiArray, 200);
  }

  /**
   * revoke token.
   */
  public function signOut(Request $request) {
    try {
      $user = $request->user();
      $user->tokens()->delete();
      $this->apiArray['message'] = 'Logout Success & Token deleted';
      $this->apiArray['errorCode'] = 0;
      $this->apiArray['error'] = false;
      return response()->json($this->apiArray, 200);
    } catch (Exception $e) {
      $this->apiArray['message'] = $e->getMessage();
      $this->apiArray['errorCode'] = 3;
      $this->apiArray['error'] = true;
      $this->apiArray['data'] = null;
      return response()->json($this->apiArray, 200);
    }
  }
}
