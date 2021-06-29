<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    	//Validar datos
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Si la solicitud no es valida enviar respuesta de error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Si la solicitud es valida crear el usuario
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        //returnar success response
        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'data' => $user
        ],201);
    }
 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //validar credenciales de la BD
        $validator = Validator::make($credentials, [
            'email' => 'required|email|min:2|max:50',
            'password' => 'required|string|min:8|max:16'
        ]);

        //Si las credenciales no son validas enviar respuesta de error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        //Si las credenciales son validas crear token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                $user = User::where('email',$request->get('email'))->first();
                if(!$user){
                    return response()->json([
                        'succes' =>false,
                        'message' =>'El email no existe o no coincide con nuestros datos'
                    ],422);
                }else{
                    return response()->json([
                        'succes' =>false,
                        'message' =>'La contraseña es incorrecta'
                    ],422);
                }
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Error al crear el token.',
                ], 500);
        }
        
        $user = User::where('email',$request->get('email'))->first();
 		//Si no hay errores crear token y una respuesta de creado exitosamente 
        return response()->json([
            'success' => true,
            'token' => $token,
            'id' => $user->id,
            'role_id' => $user->role_id,
        ]);
    }
 
    public function logout(Request $request)
    {
        //validar credenciales
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Si la solicitud no es valida enviar respuesta de error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Si la solicitud es valida cerrar sesion        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'El usuario ha cerrado sesion'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'El usuario no puede cerrar sesion'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user],200);
    }
}