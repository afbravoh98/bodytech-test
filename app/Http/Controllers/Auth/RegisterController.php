<?php

namespace App\Http\Controllers\Auth;

use App\bodytech\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Exception;

class RegisterController extends Controller
{
    private $users;
    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    /**
     * Handle the incoming request.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try{
            $data = $request->validated();
            $user = $this->users->create($data);
        }catch (Exception $exception){
            return response()->error([
                'message' => 'Error en el servidor.',
                'error' => $exception->getMessage(),
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        return response()->success([
            'message' => 'Registro exitoso!',
            'user' => $user,
        ]);
    }
}
