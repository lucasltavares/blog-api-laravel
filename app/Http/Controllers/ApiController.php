<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getAllStudents() {
        $students = Student::get();
        return response()->json($students, 200);
    }

    public function createStudent(Request $request) {
        $student = new Student;
        $student->name = $request->name;
        $student->curso = $request->curso;
        $student->save(); // add Try catch

        return response()->json([
            "message" => "student record created successfully."
        ], 201);
    }

    public function getStudent($id) {
        if (Student::where('id', $id)->exists()) {
            $student = Student::where('id', $id)->get();
            return response()->json($student, 200);
        } else {
            return response()->json([
                "message" => "Student not found."
            ], 404);
        }
    }

    //corrigir all nullable false positive
    public function updateStudent(Request $request, $id) {
        if(Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->name = is_null($request->name) ? $student->name : $request->name; // Verifica nulidade para atualizar parâmetros únicos.
            $student->curso = is_null($request->curso) ? $student->curso : $request->curso;
            $student->save();

            return response()->json([
                "message" => "records updated successfully."
            ], 200);
        } else {
            return response()->json([
                "message" => "Student not found."
            ], 404);
        }
    }

    public function deleteStudent ($id) {
        if(Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->delete();

            return response()->json([
                "message" => "records deleted successfully."
            ], 202);
        } else {
            return response()->json([
                "message" => "Student not found."
            ], 404);
        }
    }
}
