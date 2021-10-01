<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Exception;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        try{
            $data = $request->validated();
            /**@var User $user*/
            $user = User::query()->where('email', $data['email'])->first();

            if (! $user || ! Hash::check($data['password'], $user->password)) {
                return response()->error([
                    'message' => 'Credenciales invalidas.',
                ], HttpResponse::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken($user->email)->plainTextToken;

        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error en el servidor.',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Login exitoso!',
            'token' => $token,
        ]);
    }
}
