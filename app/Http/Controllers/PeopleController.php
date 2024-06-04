<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgeRequest;
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
}
