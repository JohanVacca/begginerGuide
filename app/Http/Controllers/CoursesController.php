<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Exception;

class CoursesController extends Controller
{
    //* Crear un nuevo curso
    public function createCourse(Request $request)
    {
        try {
            $request->validate([
                'course_name' => 'required|string|max:255',
                'course_description' => 'nullable|string',
            ]);

            $course = Course::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Curso creado con éxito',
                'data' => $course,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Obtener un curso junto con sus estudiantes inscritos
    public function getCourse($course_id)
    {
        try {
            $course = Course::with('students')->findOrFail($course_id);

            return response()->json([
                'success' => true,
                'message' => 'Curso recuperado con éxito',
                'data' => $course,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Obtener todos los cursos junto con sus estudiantes inscritos
    public function getAllCourses()
    {
        try {
            $courses = Course::with('students')->get();

            return response()->json([
                'success' => true,
                'message' => 'Cursos recuperados con éxito',
                'data' => $courses,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Obtener todos los cursos existentes (sin estudiantes)
    public function getExistingCourses()
    {
        try {
            $courses = Course::all();

            return response()->json([
                'success' => true,
                'message' => 'Cursos existentes recuperados con éxito',
                'data' => $courses,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Actualizar un curso
    public function updateCourse(Request $request, $course_id)
    {
        try {
            $request->validate([
                'course_name' => 'sometimes|required|string|max:255',
                'course_description' => 'nullable|string',
            ]);

            $course = Course::findOrFail($course_id);
            $course->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Curso actualizado con éxito',
                'data' => $course,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Eliminar un curso
    public function deleteCourse($course_id)
    {
        try {
            $course = Course::findOrFail($course_id);
            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'Curso eliminado con éxito',
                'data' => null,
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
