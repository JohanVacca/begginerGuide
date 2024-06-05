<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgeRequest;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use Illuminate\Http\Request;
use Exception;

class PeopleController extends Controller
{

    public function __construct()
    {
    }

    public function ageCalculator(AgeRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $year = $validatedData['year'];
            $currentYear = date('Y');
            $age = $currentYear - $year;

            return response()->json([
                'success' => true,
                'message' => 'Age calculated successfully',
                'data' => ['age' => $age],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //TODO: Apis para CRUD personas:
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $people = Person::paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'People retrieved successfully',
                'data' => $people
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function store(CreatePersonRequest $request)
    {
        try {
            $person = Person::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Person created successfully',
                'data' => $person
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $person = Person::find($id);

            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Person retrieved successfully',
                'data' => $person
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function update(UpdatePersonRequest $request, $id)
    {
        try {
            $person = Person::find($id);

            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found',
                    'data' => null
                ], 404);
            }

            $person->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Person updated successfully',
                'data' => $person
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $person = Person::find($id);

            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found',
                    'data' => null
                ], 404);
            }

            $person->delete();

            return response()->json([
                'success' => true,
                'message' => 'Person deleted successfully',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    //TODO: FIN Apis para CRUD personas.
}
