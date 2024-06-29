<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario en el sistema.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|string|exists:roles,name', // Validar que el rol exista
            ]);

            // Encriptamos la contraseña
            $validatedData['password'] = bcrypt($request->password);

            // Creamos el usuario
            $user = User::create($validatedData);

            // Asignar el rol al usuario
            $user->assignRole($request->input('role'));

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'data' => null,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Actualiza la información de un usuario en el sistema.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:6',
                'role' => 'sometimes|required|string|exists:roles,name', // Validar que el rol exista
            ]);

            // Encontrar el usuario
            $user = User::findOrFail($id);

            // Actualizar los campos del usuario
            if (isset($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }
            $user->update($validatedData);

            // Asignar el rol al usuario si se proporciona
            if ($request->has('role')) {
                $user->syncRoles($request->input('role'));
            }

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
                'data' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Inicia sesión para un usuario existente.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Así se valida con Sanctum que el Usuario haga Login correctamente, lo que se hace es verificar que
            // las credenciales ingresadas coincidan con 'email', 'password' del Usuario.
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'email' => ['Las credenciales proporcionadas son incorrectas.'],
                ]);
            }

            // Si las credenciales están bien, obtenemos el usuario logeado de esta manera
            $user = Auth::user();

            // Se le crea un 'Token' a este Usuario, con éste token podrá acceder a las APIs que estén protegidas
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'token' => $token,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 401);
        }
    }

    /**
     * Cierra sesión para el usuario autenticado actualmente.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Así se le elimina el 'Token' al usuario ya que está cerrando sesión.
            $request->user()->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cierre de sesión exitoso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Probar autenticación
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function tryAuth(Request $request): JsonResponse
    {
        try {
            dd($request->user());
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Probar RolesyPermisos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function tryRoleAdmin(Request $request): JsonResponse
    {
        try {
            dd("Hola, esta api es sólo para Admins.");
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Probar RolesyPermisos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function tryRoleUser(Request $request): JsonResponse
    {
        try {
            dd("Hola, esta api es para cualquier usuario en general.");
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
