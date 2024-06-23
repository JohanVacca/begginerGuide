<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //* Crear un nuevo estudiante sin asignarle cursos
    public function createStudent(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'age' => 'required|integer',
                'career' => 'required|string|max:255',
            ]);

            $student = Student::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Estudiante creado con éxito',
                'data' => $student,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Asignar un curso a un estudiante
    public function assignCourse(Request $request, $student_id)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
            ]);

            $student = Student::findOrFail($student_id);
            $student->courses()->attach($request->course_id);

            return response()->json([
                'success' => true,
                'message' => 'Curso asignado con éxito',
                'data' => $student,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Asignar más de un curso a un estudiante
    public function assignCourses(Request $request, $student_id)
    {
        try {
            $request->validate([
                'course_ids' => 'required|array',
                'course_ids.*' => 'exists:courses,id',
            ]);

            $student = Student::findOrFail($student_id);
            $student->courses()->attach($request->course_ids);

            return response()->json([
                'success' => true,
                'message' => 'Cursos asignados con éxito',
                'data' => $student,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Eliminar un estudiante
    public function deleteStudent($student_id)
    {
        try {
            $student = Student::findOrFail($student_id);
            $student->delete();

            return response()->json([
                'success' => true,
                'message' => 'Estudiante eliminado con éxito',
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

    //* Ver un solo estudiante junto con sus cursos
    public function getStudent($student_id)
    {
        try {
            $student = Student::with('courses')->findOrFail($student_id);

            return response()->json([
                'success' => true,
                'message' => 'Estudiante recuperado con éxito',
                'data' => $student,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Ver todos los estudiantes junto con sus cursos
    public function getAllStudents()
    {
        try {
            $students = Student::with('courses')->get();

            return response()->json([
                'success' => true,
                'message' => 'Estudiantes recuperados con éxito',
                'data' => $students,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Editar un estudiante y actualizar sus cursos asociados, sin informacion adicional
    public function updateStudent(Request $request, $student_id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'age' => 'sometimes|required|integer',
                'career' => 'sometimes|required|string|max:255',
                'course_ids' => 'sometimes|required|array',
                'course_ids.*' => 'exists:courses,id',
            ]);

            $student = Student::findOrFail($student_id);

            // Actualizar los datos del estudiante
            $student->update($request->only(['name', 'age', 'career']));

            // Actualizar los cursos asociados si se proporciona
            if ($request->has('course_ids')) {
                $student->courses()->sync($request->course_ids);
            }

            return response()->json([
                'success' => true,
                'message' => 'Estudiante actualizado con éxito',
                'data' => $student,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    //* Editar un estudiante y actualizar sus cursos asociados, con informacion adicional
    public function updateStudentWithPivot(Request $request, $student_id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'age' => 'sometimes|required|integer',
                'career' => 'sometimes|required|string|max:255',
                'courses' => 'sometimes|required|array',
                'courses.*.course_id' => 'exists:courses,id',
                'courses.*.additional_info' => 'nullable|string'
            ]);

            $student = Student::findOrFail($student_id);

            // Actualizar los datos del estudiante
            $student->update($request->only(['name', 'age', 'career']));

            // Actualizar los cursos asociados si se proporciona
            if ($request->has('courses')) {
                $courses = collect($request->courses)->mapWithKeys(function ($course) {
                    return [$course['course_id'] => ['additional_info' => $course['additional_info']]];
                });
                $student->courses()->sync($courses);
            }

            return response()->json([
                'success' => true,
                'message' => 'Estudiante actualizado con éxito',
                'data' => $student,
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
