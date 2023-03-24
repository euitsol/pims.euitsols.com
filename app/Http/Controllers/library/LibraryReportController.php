<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AssignBook;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LibraryReportController extends Controller
{
    public function dailyReport($date){
        $n['assigned_info'] = AssignBook::where('deleted_by',null)
                                        ->where('assign_date',$date)
                                        ->where('status','0')
                                        ->get();

        $n['returned_info'] = AssignBook::where('deleted_by',null)
                                        ->where('returned_date',$date)
                                        ->where('status','!=','0')
                                        ->get();

        $n['delay'] = AssignBook::where('deleted_by',null)
                                        ->where('return_date',$date)
                                        ->where('status','0')
                                        ->where('return_date',$date)
                                        ->get();
        $n['date'] = $date;
      return view('pages.library.report.daily',$n);
    }

    public function allReport(Request $req){

        $n['str_date'] = $req->str_date;
        $n['end_date'] = $req->end_date;
        $n['department_id'] = $req->department_id;

        $a = DB::table('assign_books as a')
                ->join('books as b','b.id','=','a.book_id')
                ->join('library_members as s','s.id','=','a.std_id')
                ->join('categories as c','b.category_id','=','c.id')
                ->join('departments as d','c.departments_id','=','d.id')
                ->join('bookshelves as e','e.id','=','b.bookshelf_id')
                ->where('a.deleted_by',null)
                ->whereBetween('a.assign_date',[$n['str_date'],$n['end_date']])
                ->select('a.*','b.name as book_name',"c.name as category_name",'d.department_name as department_name','s.name as student_name','s.phone','e.name as bookshelf_name');

                if($req->department_id){
                    $a = $a->where('d.id',$req->department_id);
                }
                if($req->user_id){
                    $a = $a->where('a.created_by',$req->user_id);
                }

        $d  = clone $a;
        $r  = clone $a;

        $n['assigned_info_all'] = $a->where('a.status','0')
                                ->where('a.return_date','>', Carbon::now())
                                ->get();

        $n['delay_info_all'] = $d->where('a.status','0')
                                ->where('a.return_date','<', Carbon::now())
                                ->get();

        $n['returned_info_all'] = $r->where('status','!=','0')
                                ->get();

        $n['departments'] = Department::where('deleted_by',null)->get();
        $n['users'] = User::where('deleted_by',null)->get();

        return view('pages.library.report.all',$n);
    }



}
