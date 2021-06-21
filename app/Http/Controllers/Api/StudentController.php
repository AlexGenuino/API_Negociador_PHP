<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Course;
use App\Models\Debt;
use App\Models\Student;
use App\Models\User;
use App\Utils\ValidadorCPF;
use Illuminate\Http\Request;
use DateTime;
use phpDocumentor\Reflection\Types\Float_;

class StudentController extends Controller
{
    /**
	 * @var Student
	 */
    private $student;
    private $debt;
    private $course;
    private $user;

    public function __construct(Student $student, Debt $debt, Course $course, User $user)
    {
        $this->student = $student;
        $this->debt = $debt;
        $this->course = $course;
        $this->user = $user;
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

    public function store(Request $request){
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password'))
        {
            $message = new ApiMessages('it is necessary to enter a password for the user');
            return response()->json($message->getMessage(), 401);
        }

        try{

            $validade = new ValidadorCPF();
            $validade = $validade->getcpf($data['CPF']);
            if($validade == false) {
                return response()->json([
                    'data' => [
                        'msg' => 'CPF Student não valido'
                    ]
                ], 200);
            }

            $cpf = $this->student->where($data['CPF']);
            if(empty($cpf)){
                return response()->json([
                    'data' => [
                        'CPF' => $cpf,
                        'message' => 'Ja cadastrado'
                    ]
                ], 200);
            }

            $data['password'] = bcrypt($data['password']);

            $student = $this->student->create($data);
            $this->user->create($data);


            $course = $this->course->findOrFail($data['course']);

            if(isset($data['course'])){
                $student->course()->sync($data['course']);
            }

            $value = $course['value_semester'];
            $valor_float = floatval($value);
            $valor_float = ($valor_float / 6);
            $datenow = new DateTime();

            for($i = 1; $i <=6 ; $i++){

                $datenow->modify("+1 month");
                $newdebt = [
                    'parcel' => $i,
                    'form_payment' => 'Boleto',
                    'value' => $valor_float,
                    'payment' => false,
                    'expiration_date' => $datenow
                ];

                $debt = $this->debt->create($newdebt);
                $debt->student()->sync($student['id']);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Aluno Cadastrado',
                    'nome' => $student['name'],
                    'cpf' => $student['CPF'],
                    'curso' => $course['name'],
                    'Semestre' => $course['semester'],
                    'id_student' => $student['id'],
                ]
            ], 200);

        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());

            return response()->json($message->getMessage(), 401);
        }
    }

    public function update($id, StudentRequest $request){
        $data = $request->all();

        if(!$request->has('password') && !$request->get('password'))
        {
            $data['password'] = bcrypt($data['password']);
        }else {unset($data['password']);}

        try{
            $student = $this->student->findOrFail($id);
            $student->update($data);

            return response()->json($student, 200);

        }catch(\Exception $e){
            $student->delete();
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
                    'msg' => 'Student removed'
                ]
            ], 200);
        }catch(\Exception $e){

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function debt($id)
    {
        try{
            $student = $this->student->findOrFail($id);
            return response()->json([
                'data' => $student->debt
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }





}
