<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Student;

class StudentController extends Controller
{
    /**
	 * @var Student
	 */
    private $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function index () {
        $student = $this->student->all();
        return response()->json($student, 200);
    }

    public function show($id){

        try{
            $student = $this->student->findOrFail($id);

            return response()->json($student, 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function store(StudentRequest $request){
        $data = $request->all();

        try{

            $student = $this->student->create($data);
            return response()->json($student, 200);

        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update($id, StudentRequest $request){
        $data = $request->all();

        try{
            $student = $this->student->findOrFail($id);
            $student->update($data);

            return response()->json($student, 200);

        }catch(\Exception $e){

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id){

        try{
            $student = $this->student->findOrFail($id);
            $student->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Estudante Removido '
                ]
            ], 200);
        }catch(\Exception $e){

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
