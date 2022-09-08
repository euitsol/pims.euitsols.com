<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\board;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $n['db_data'] = board::where('deleted_at', null)->latest()->get();
        return view('pages.setup.board.index',$n);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.setup.board.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:boards,name|string|max:255',
        ]);

        $insert = new board;
        $insert->name = $request->name;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Board Created Successfullly');
        return redirect()->route('board.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {
        if($id!=null){
            $board = board::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($board, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $n['db_data'] = board::findOrFail($id);
        return view('pages.setup.board.edit',$n);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:boards,id',
        ]);

        $update = board::findOrFail($request->id);
        if($update->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:boards,name|string|max:255']);
        }

        $update->name = $request->name;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Board Updated Successfully');
        return redirect()->route('board.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id != null){
            $user = board::findOrFail($id);
            $user->deleted_at = Carbon::now()->toDateTimeString();
            $user->deleted_by = auth()->user()->id;
            $user->save();
            $this->message('success', 'Board '.$user->name.' deleted successfully');
            return redirect()->route('board.index');
        }

    }

}
