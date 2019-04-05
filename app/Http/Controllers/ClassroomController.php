<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Input;
use Session;
use App\Classroom;
use App\Student;
use App\User;
use Auth;
use Intervention\Image\Facades\Image;

class ClassroomController extends Controller
{
    public function handleAddClassroom()
    {
    	$data = Input::all();

    	$rules = 
    			[
		            'title' => 'required|min:5',
		            'computers' => 'required',
        		];

        $messages = 
        		[
		            'title.required' => 'Votre titre est obligatoire',
		            'title.min' => 'Votre titre doit dépasser 5 caractères',
		            'computers.required' => 'Le champ computers est obligatoire'
        		];

        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) 
        {
            return redirect()->back()->withErrors($validation->errors());
        }


    	//dd($data);
    	$cl = Classroom::create(
    		[
    			'tables'    => $data['tables'],
    			'computers' => $data['computers'],
    			'title'     => $data['title']
    		]
    	);
    	return back();
    }

    public function handleDeleteClassroom($id)
    {
    	/*
    	$cl = Classroom::find($id);
	    $delete = $cl ? $cl->delete() : null;
	    return $delete? 'true' : 'false';
		*/


    	//dd($id);
    	Classroom::whereId($id)->delete();
    	//return back()->with('message','Suppression effectuée avec succès');

    	Session::flash('message', 'Suppression effectuée avec succès');
    	Session::flush();
		return back();

    	// ou bien 
    	//return redirect(route('showClassrooms'));
    }

 	public function showClassrooms()
 	{
 		$cl = Classroom::withCount('students')->get();
 		//$cl = Classroom::all();
 		if ($data = @file_get_contents("http://api.apixu.com/v1/current.json?key=fc8ed0be1ed24dcb885144051190404&q=Tunis"))
		{
	       $json = json_decode($data, true);
	       $a = $json['current']['condition']['icon'];
		}

 		return view('classrooms',['cl'=>$cl], ['a'=>$a]);
 	}

 	public function showClassroom($id)
 	{
 		//dd(Student::find($id)->with('classroom')->first());
 		//dd(Classroom::find($id)->withCount('students')->get());
 		$cl = Classroom::find($id);

 		return view('classroom',['cl'=>$cl]);
 	}

 	public function handleEditClassroom($id)
 	{
 		
 		
 		//$cl = Classroom::find($id);
 		//$data = Input::all();
 		//$cl->tables = $data['tables'];
 		//$cl->computers = $data['computers'];
 		//$cl->title = $data['title'];
 		//$cl->save();


 		$data = Input::all();
 		$cl = Classroom::where('id',$id)->update(
    		[
    			'tables'    => $data['tables'],
    			'computers' => $data['computers'],
    			'title'     => $data['title']
    		]
    	);

 		return redirect(route('showClassrooms'));

 	}

 	public function handleRegister()
 	{
 		$data = Input::all();
 		dd(bcrypt($data['password']));
 		$cl = User::create(
    		[
    			'name'              => $data['name'],
    			'email'             => $data['email'],
    			'password'          => bcrypt($data['password']),
    			'email_verified_at' => $data['email_verified_at']
    		]
    	);

 	}

 	public function showRegister()
 	{
 		return view('register');
 	}

 	public function handleLogin()
 	{
 		$data = Input::all();
 		$credentials = 
 			[
	           'email' => $data['email'],
	           'password' => $data['password']
       		];

   		if (Auth::attempt($credentials))
   		{
	      	Auth::user();
	      	return redirect(route('showClassrooms'));
	    } 
	    else 
	    { 
	    	return view('login'); 
	    }
 	}

 	public function showLogin()
 	{
 		return view('login');
 	}

 	public function handleLogout()
 	{
 		Auth::logout();
 		return redirect(route('showClassrooms'));
 	}

 	public function showStudents($id)
 	{
 		$cl = Classroom::find($id);
 		if($cl and $cl->students()->exists())
 		{
 			return view('students',['cl'=>$cl]);
 		}
 		else
 		{
 			return redirect(route('showClassrooms'));
 		}
 		
 	}

 	public function handleDeleteStudent($id)
 	{
 		Student::whereId($id)->delete();
    	Session::flash('message', 'Suppression effectuée avec succès');
    	return back();
 	}

 	public function showEditStudent($id)
 	{
 		$cl = Student::find($id);
 		return view('student',['cl'=>$cl]);
 	}

 	public function handleEditStudent($id)
 	{
 		$data = Input::all();
 		$cl = Student::whereId($id)->update(
    		[
    			'name' => $data['name'],
    			'age'  => $data['age']
    		]
    	);

 		return redirect(route('showClassrooms'));
 	}

 	public function showAddStudent()
 	{
 		$cl = Classroom::all();
 		return view('addStudent',['cl'=>$cl]);
 	}

 	public function handleAddStudent()
 	{

 		$data = Input::all();

 		$photo = 'photo-' . str_random(5) . time() . '.' . $data['photo']->getClientOriginalExtension();

        $fullImagePath = public_path('storage/' . $photo);
        Image::make($data['photo']->getRealPath())->blur(50)->save($fullImagePath);
        $photoPath = 'storage/' . $photo;


 		
 		$cl = Student::create(
    		[
    			'name' => $data['name'],
    			'age'  => $data['age'],
    			'classroom_id'=> $data['classrooms'],
    			'photo'=> $photoPath
    		]
    	);
 	}


}
