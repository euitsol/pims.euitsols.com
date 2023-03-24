<?php

namespace App\Http\Controllers\asset;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(){
        $n['suppliers'] = Supplier::where('deleted_at',null)->latest()->get();
        return view('pages.asset.setup.supplier.index',$n);
    }

    public function create(){
        return view('pages.asset.setup.supplier.create');
    }

    public function store(Request $req){
        $this->validate($req,[
            'shop_name' => 'required|string|unique:suppliers',
            'owner_name' => 'required|string',
            'address' => "required|string",
            'phone' => "required|string",
            'details' => "required|string",
            'email' => "required|string",
        ]);
        $insert = new Supplier();
        $insert->shop_name = $req->shop_name;
        $insert->owner_name = $req->owner_name;
        $insert->address = $req->address;
        $insert->phone = $req->phone;
        $insert->email = $req->email;
        $insert->details = $req->details;
        $insert->created_by = Auth::user()->id;
        $insert->save();
        $this->message('success','Supplier added successfully');
        return redirect()->route('asset.setup.supplier.index');
    }

    public function edit($id){
        $n['supplier'] = Supplier::findOrFail($id);
        return view('pages.asset.setup.supplier.edit',$n);
    }

    public function update(Request $req){
        // dd($req->id);
        $this->validate($req,[
            'shop_name' => "required|string|unique:suppliers,shop_name,$req->id,id",
            'owner_name' => 'required|string',
            'address' => "required|string",
            'phone' => "required|string",
            'details' => "required|string",
            'email' => "required|string",
        ]);

        $update = Supplier::findOrFail($req->id);
        $update->shop_name = $req->shop_name;
        $update->owner_name = $req->owner_name;
        $update->address = $req->address;
        $update->phone = $req->phone;
        $update->email = $req->email;
        $update->details = $req->details;
        $update->updated_by = Auth::user()->id;
        $update->save();
        $this->message('success','Supplier updated successfully');
        return redirect()->route('asset.setup.supplier.index');
    }

    public function destroy($id =null){
        if($id != null){
            $delete = Supplier::find($id);
            $delete->deleted_at = Carbon::now()->toDateTimeString();
            $delete->deleted_by = Auth::user()->id;
            $delete->save();
            return back()->with('success','Supplier deleted successfully');
        }
    }

    public function show($id = null){
        if($id !=null){
            $supplier =Supplier::with(['created_user','updated_user','deleted_user'])->find($id);
            return response()->json($supplier);
        }
    }
}
