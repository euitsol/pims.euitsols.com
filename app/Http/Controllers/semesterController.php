<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Requests\MyClass\ClassCreate;
use App\Http\Requests\MyClass\ClassUpdate;
use App\Repositories\MyClassRepo;
use App\Repositories\UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\semester;

class semesterController extends Controller
{
    protected $my_class, $user;

    public function __construct(MyClassRepo $my_class, UserRepo $user)
    {
        $this->middleware('teamSA', ['except' => ['destroy',] ]);
        $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->my_class = $my_class;
        $this->user = $user;
    }

    public function index()
    {
        $d['semester'] = semester::all();
        // $d['class_types'] = $this->my_class->getTypes();

    // dd($d);

        return view('pages.support_team.semester.index', $d);
    }

    public function store(Request $req)
    {
        // $data = $req->all();
        // $mc = $this->my_class->create($data);

        // Create Default Section
        // $s = ['my_class_id' => $mc->id,
        //     'name' => 'A',
        //     'active' => 1,
        //     'teacher_id' => NULL,
        // ];

        // $this->my_class->createSection($s);

        $insert = new semester; 
        $insert->name = $req->name;
        $insert->save();

        return Qs::jsonStoreOk();
    }

    public function edit($id)
    {
        $d['c'] = $c = semester::find($id);

        return is_null($c) ? Qs::goWithDanger('semester.index') : view('pages.support_team.semester.edit', $d) ;
    }

    public function update(Request $req, $id)
    {
        // $data = $req->only(['name']);
        // $this->my_class->update($id, $data);
        $update = semester::find($id);
      $update->name =  $req->name;
      $update->save();  
      
        return Qs::jsonUpdateOk();
    }

    public function destroy($id)
    {
        $this->my_class->delete($id);
        return back()->with('flash_success', __('msg.del_ok'));
    }

}