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
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    
    public function register(Request $request)
    {
        //Validar datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users|min:2|max:50',
            'password' => 'required|string|min:8|max:16'
        ]);
        
        //Si la solicitud no es valida enviar respuesta de error
        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->messages()
            ), 400);
        }

        //Si la solicitud es valida crear el usuario
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'user' => $user
        ], 201);
    }
 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //validar credenciales de la BD
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        //Si las validaciones fallan enviar mensaje de error
        if ($validator->fails()) {
            return response()->json(
                $validator->messages(), 422);
        }

        //Si las credenciales no son validas enviar mensaje de error
        try {
            if (!$token = auth()->attempt($validator->validated())) {
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
        return $this->createNewToken($token);
    }
 
    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json(['message' => 'El usuario ha cerrado sesion']);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
 
    public function get_user(Request $request)
    {
        return response()->json(auth()->user());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'success' => true,
            'token' => $token,
            'expira_en' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}