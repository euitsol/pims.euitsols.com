<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Credit;

class CreditController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index()
    {
        $n['db_data'] = Credit::where('deleted_at', null)->latest()->get();
        return view('pages.setup.credit.index',$n);
    }

    public function create()
    {
        return view('pages.setup.credit.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'credit_number' => 'required|unique:credits,credit_number|numeric',
            'marks' => 'required|numeric',
            'class_hour' => 'required|numeric',
            'hour_minute' => 'required|numeric',
            'total_class' => 'required|numeric',
        ]);

        $insert = new credit;
        $insert->credit_number = $request->credit_number;
        $insert->marks = $request->marks;
        $insert->class_hour = $request->class_hour;
        $insert->hour_minute = $request->hour_minute;
        $insert->total_class = $request->total_class;
        $insert->created_at = Carbon::now()->toDateTimeString();
        $insert->created_by = auth()->user()->id;
        $insert->save();

        $this->message('success', 'Credit Created Successfullly');
        return redirect()->route('credit.index');
    }

    public function show($id=null)
    {
        if($id!=null){
            $credit = Credit::with(['created_user', 'updated_user', 'deleted_user'])->where('deleted_at', null)->where('id', $id)->first();
            return Response::json($credit, 200);
        }
    }

    public function edit($id)
    {
        $n['db_data'] = Credit::findOrFail($id);
        return view('pages.setup.credit.edit',$n);


    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:credits,id',
        ]);

        $update = Credit::findOrFail($request->id);
        if($update->credit_number != $request->credit_number){
            $this->validate($request, ['credit_number' => 'required|unique:credits,credit_number|numeric|between:0,99.99']);
        }

        $update->credit_number = $request->credit_number;
        $update->marks = $request->marks;
        $update->class_hour = $request->class_hour;
        $update->hour_minute = $request->hour_minute;
        $update->total_class = $request->total_class;
        $update->updated_at = Carbon::now()->toDateTimeString();
        $update->updated_by = auth()->user()->id;
        $update->save();

        $this->message('success', 'Credit Updated Successfully');
        return redirect()->route('credit.index');
    }

    public function destroy($id)
    {
        if($id != null){
            $credit = Credit::findOrFail($id);
            $credit->deleted_at = Carbon::now()->toDateTimeString();
            $credit->deleted_by = auth()->user()->id;
            $credit->save();
            $this->message('success','Credit Deleted successfully');
            return redirect()->route('credit.index');
        }

    }
}
