<?php

namespace App\Http\Controllers\setup;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Credit;
use DataTables;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->check_access('view credit');
        if ($request->ajax()) {
            $credits = Credit::with(['created_user'])->where('deleted_at', null)->latest()->get();
            return Datatables::of($credits)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data){ $formatedDate = date('d-m-Y', strtotime($data->created_at)); return $formatedDate; })
                    ->editColumn('credit_number', function($data){ $format_number = number_format((float)$data->credit_number, 2, '.', ''); return $format_number; })
                    ->editColumn('class_hour', function($data){ $format_class_hour = $data->class_hour.  $data->class_hour_type(); return $format_class_hour; })
                    ->addColumn('created_user', function ($data) {
                        return $data->created_user->name ?? 'system';
                    })
                    ->addColumn('action', function($data){
                        $btn = '<div class="btn-group">';
                        $btn .= '<a href="javascript:void(0)" class="btn btn-info btnView" data-id="' .$data->id. '"><i class="fas fa-eye"></i></a>';
                        if(Auth::user()->can('edit credit') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("credit.edit", $data->id).'" class="btn btn-dark btnEdit"><i class="fas fa-edit"></i></a>';
                        }
                        if(Auth::user()->can('delete credit') || Auth::user()->role->id == 1){
                            $btn .= '<a href="'.route("credit.destroy", $data->id).'" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></a>';
                        }
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $n['db_data'] = Credit::where('deleted_at', null)->latest()->get();
        return view('pages.setup.credit.index',$n);
    }

    public function create()
    {
        $this->check_access('add credit');
        return view('pages.setup.credit.create');
    }

    public function store(Request $request)
    {
        $this->check_access('add credit');
        $this->validate($request, [
            'credit_number' => 'required|unique:credits,credit_number|numeric',
            'marks' => 'required|numeric',
            'class_hour' => 'required|numeric',
            'hour_minute' => 'required|numeric',
            'total_class' => 'required|numeric',
        ]);

        $insert = new Credit;
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
        $this->check_access('edit credit');
        $n['db_data'] = Credit::findOrFail($id);
        return view('pages.setup.credit.edit',$n);


    }

    public function update(Request $request)
    {
        $this->check_access('edit credit');
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
        $this->check_access('delete credit');
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
