<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function index(){
        $students=Student::all();

        //if($students->isEmpty()){
        //    $date =[
        //        'message'=>'no estudiantes', 'status'=>404
        //    ];
        //    return response()->json($date, 404);
        //}
        //return 'obteniendo lista estudiantes - controller';

        $data=[
            'students'=> $students,
            'status'=>200
        ];
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'email'=>'required|email|unique:student',
            'phone'=>'required|digits:10',
            'carrera'=>'required',
        ]);

        if($validator->fails()){
            $data = [
                'message'=>'Error de validacion',
                'error'=> $validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);
        }

        $student = Student::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'carrera'=> $request->carrera
        ]);

        if(!$student){
            $data = [
                'message'=> 'Error al crear estudiante',
                'status'=> 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student'=>$student,
            'status'=>201
        ];
        return response()->json($data, 201);
    }

    public function show($id){
        $student = Student::find($id);

        if(!$student){
            $data=[
                'message'=> 'No encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student'=> $student,
            'status'=> 200
        ];
        return response()->json($data, 200);

    }

    public function destroy($id){
        $student = Student::find($id);

        if(!$student){
            $data=[
                'message'=> 'No encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        $student->delete();

        $data = [
            'message'=> 'Eliminado',
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function update(request $request, $id){
        $student = Student::find($id);

        if(!$student){
            $data=[
                'message'=> 'No encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'required|max:255',
            'email'=>'required|email|unique:student',
            'phone'=>'required|digits:10',
            'carrera'=>'required',
        ]);

        if($validator->fails()){
            $data = [
                'message'=>'Error de validacion',
                'error'=> $validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->carrera = $request->carrera;

        $student->save();

        $data = [
            'message'=> 'datos Actualizado',
            'student'=> $student,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $student = Student::find($id);

        if(!$student){
            $data=[
                'message'=> 'No encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'max:255',
            'email'=>'email|unique:student',
            'phone'=>'digits:10',
            'carrera'=>'',
        ]);

        if($validator->fails()){
            $data = [
                'message'=>'Error de validacion',
                'error'=> $validator->errors(),
                'status'=>400
            ];
            return response()->json($data, 400);
        }

        if($request->has('name')){
            $student->name = $request->name;
        }
        if( $request->has('email')){
            $student->email = $request->email;
        }
        if( $request->has('phone')){
            $student->phone = $request->phone;
        }
        if( $request->has('carrera')){
            $student->carrera = $request->carrera;
        }
        $student->save();

        $data = [
            'message'=> 'datos Actualizado',
            'student'=> $student,
            'status'=> 200
        ];
        return response()->json($data, 200);
    }
}
