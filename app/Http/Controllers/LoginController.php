<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\UserDetailModel;
use Auth;
use Validator;


class LoginController extends Controller
{
    
	public function Login(Request $request){

	  	try{
            $rules = [
                'email' => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()){

                $error = array( 
                    'status' => false, 
                    'status_code' => '400',
                    'message' => $validator->errors(), 
                    'c_code' =>2                    
                );
                return response()->json($error,400,[],JSON_UNESCAPED_UNICODE);
            }

	      	$get_user=UserModel::where('email',$request->input('email'))->first();

	      	if(!$get_user){
	      		$error=[
                	'status'=>'error',
                	'status_code'=>'400',
                	'message'=>[
                    	'email'=>'Please Enter the valid Email Address'
                	]
            	];

            	return response()->json($error,400,[],JSON_UNESCAPED_UNICODE);
	      	}
      	 	
      	 	$userdata=[
               'email'=>$request->input('email'),
               'password'=>$request->input('password')
           	];
	       	if(Auth::attempt($userdata)){
                $user = Auth::user();
                $token=  $user->createToken('Access Token');

       		   	$success = array(
                    'status'=>'success',
                    'status_code'=> 200,
                    'message'=> [
                        'login'=>['successfully login'],
                    ],
                    'data'=>[
                        'token'=>$token->accessToken
                    ]
                );

             	return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);       	 		
	       	}else{
	       		$error=[
                	'status'=>'error',
                	'status_code'=>'400',
                	'message'=>[
                    	'email'=>['Please Enter the valid password']

                	]
            	];

            	return response()->json($error,400,[],JSON_UNESCAPED_UNICODE);
	       	}

        }catch(Exception $e){   

            $result = array(
                'status'  => false,
                'message' => "Exception". $e->getMessage(),
                'c_code'  =>2
            );
        } 
        return response()->json($result,400,[], JSON_UNESCAPED_UNICODE); 
	}

    public function Logout(){
        $accessToken = Auth::user()->token();

        $accessToken->revoke();

        $success = array(
            'status'=>'success',
            'status_code'=> 200,
            'message'=> [
                'logout'=>['successfully logout'],
            ]
        );

        return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);
    }

    public function get_all_user(){

        try{
            $get_user = UserDetailModel::where('created_by',1)->get();

            $success = array(
                'status'=>'success',
                'data'=>$get_user,
                'status_code'=> 200,
                'message'=> [
                    'user list'=>['user list shown successfully'],
              ]
            );

            return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);

        }catch(Exception $e){   

            $result = array(
                'status'  => false,
                'message' => "Exception". $e->getMessage(),
                'c_code'  =>2
            );
        } 
        return response()->json($result,400,[], JSON_UNESCAPED_UNICODE); 
    }

    public function userlistagainstid($id){

        try{
            $get_user = UserDetailModel::where('id',$id)->first();

            $success = array(
                'status'=>'success',
                'data'=>$get_user,
                'status_code'=> 200,
                'message'=> [
                    'user list'=>['user list shown successfully'],
              ]
            );

            return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);

        }catch(Exception $e){   

            $result = array(
                'status'  => false,
                'message' => "Exception". $e->getMessage(),
                'c_code'  =>2
            );
        } 
        return response()->json($result,400,[], JSON_UNESCAPED_UNICODE); 
    }

    public function deleteuser($id){
        try{
            $get_user = UserDetailModel::where('id',$id)->delete();

            $success = array(
                'status'=>'success',
                'status_code'=> 200,
                'message'=> [
                    'delete user'=>['user deleted successfully'],
              ]
            );

            return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);

        }catch(Exception $e){   

            $result = array(
                'status'  => false,
                'message' => "Exception". $e->getMessage(),
                'c_code'  =>2
            );
        } 
        return response()->json($result,400,[], JSON_UNESCAPED_UNICODE); 
    }


    public function create_user(Request $request){

        try{
            $rules = [
                'user_name' => 'required',
                'user_email' => 'required',
                'phone' => 'required',
                'user_company_name' => 'required',
                'user_address' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()){

                $error = array( 
                    'status' => false, 
                    'status_code' => '400',
                    'message' => $validator->errors(), 
                    'c_code' =>2                    
                );
                return response()->json($error,400,[],JSON_UNESCAPED_UNICODE);
            }


            $insert=new UserDetailModel;
            $insert->user_name=$request->input('user_name');
            $insert->email=$request->input('email');
            $insert->phone=$request->input('phone');
            $insert->company_name=$request->input('company_name');
            $insert->address=$request->input('address');
            $insert->created_by=1;
            $insert->save();


            $success = array(
                'status'=>'success',
                'status_code'=> 200,
                'message'=> [
                    'update user'=>['user saved successfully'],
                ]
            );

            return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);

        }catch(Exception $e){   

            $result = array(
                'status'  => false,
                'message' => "Exception". $e->getMessage(),
                'c_code'  =>2
            );
        } 
        return response()->json($result,400,[], JSON_UNESCAPED_UNICODE); 
    }



    public function updateuser(Request $request){
        try{
            $rules = [
                'id' => 'required',
                'user_name' => 'required',
                'user_email' => 'required',
                'phone' => 'required',
                'user_company_name' => 'required',
                'user_address' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()){

                $error = array( 
                    'status' => false, 
                    'status_code' => '400',
                    'message' => $validator->errors(), 
                    'c_code' =>2                    
                );
                return response()->json($error,400,[],JSON_UNESCAPED_UNICODE);
            }



            $update_user=UserDetailModel::where('id',$request->input('id'))
                                            ->update([
                                                    'user_name'=>$request->input('user_name'),
                                                    'email'=>$request->input('email'),
                                                    'phone'=>$request->input('phone'),
                                                    'company_name'=>$request->input('company_name'),
                                                    'address'=>$request->input('address'),
                                                ]);

            $success = array(
                'status'=>'success',
                'status_code'=> 200,
                'message'=> [
                    'update user'=>['user updated successfully'],
                ]
            );

            return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);

        }catch(Exception $e){   

            $result = array(
                'status'  => false,
                'message' => "Exception". $e->getMessage(),
                'c_code'  =>2
            );
        } 
        return response()->json($result,400,[], JSON_UNESCAPED_UNICODE); 
    }


    public function search_user($data){

        try{

            $get_user = UserDetailModel::where('created_by',1)->where('user_name','like',$data."%")->get();

            $success = array(
                'status'=>'success',
                'data'=>$get_user,
                'status_code'=> 200,
                'message'=> [
                    'user list'=>['user list shown successfully'],
              ]
            );

            return response()->json($success,200 ,[], JSON_UNESCAPED_UNICODE);

        }catch(Exception $e){   

            $result = array(
                'status'  => false,
                'message' => "Exception". $e->getMessage(),
                'c_code'  =>2
            );
        } 
        return response()->json($result,400,[], JSON_UNESCAPED_UNICODE); 
    }
}
