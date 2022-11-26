<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AssignBook;
use App\Models\Book;
use App\Models\Category;
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
        // dd($n['delay']);
      return view('pages.library.report.daily',$n);
    }

    public function allReport(Request $req){

        $n['str_date'] = $req->str_date;
        $n['end_date'] = $req->end_date;
        $n['department_id'] = $req->department_id;
        $category = Category::where('departments_id',$req->department_id)
                            ->where('deleted_by',null)
                            ->first();
        if(isset($category->id)){
            $book = Book::where('category_id',$category->id)
                            ->where('deleted_by',null)
                            ->first();
        }


        $a = DB::table('assign_books as a')
                ->join('books as b','b.id','=','a.book_id')
                ->join('categories as c','b.category_id','=','c.id')
                ->join('departments as d','c.departments_id','=','d.id')
                ->where('a.deleted_by',null)
                ->whereBetween('a.assign_date',[$n['str_date'],$n['end_date']])
                ->where('a.status','0')
                ->where('a.return_date','>', Carbon::now());
                // dd($a);
                if($req->department_id){
                    $a = $a->where('d.id',$req->department_id);
                }
           $n['assigned_info_all'] = $a->get();
        //    dd($n);

        // dd($assign_books);
        // $assigned = AssignBook::with(['book.category.department'])->where('deleted_by',null)
        //                         ->whereBetween('assign_date',[$n['str_date'],$n['end_date']])
        //                         ->where('status','0')
        //                         ->where('return_date','>', Carbon::now())
        //                         ->where('book.category.department.id',1);

        // if(isset($book->id)){
        //     $assigned->where('book_id',$book->id);
        // }

        // $n['assigned_info_all'] =  $assigned->get();

         $returned= AssignBook::where('deleted_by',null)
                               ->whereBetween('returned_date',[$n['str_date'],$n['end_date']])->where('status','!=','0');
                               if(isset($book->id)){
                                $returned->where('book_id',$book->id);
                            }
        $n['returned_info_all'] = $returned->get();

       $delay  = AssignBook::where('deleted_by',null)
                               ->whereBetween('return_date',[$n['str_date'],$n['end_date']])
                               ->where('status','0')
                               ->where('return_date','<', Carbon::now());
       if(isset($book->id)){
          $delay->where('book_id',$book->id);
        }
        $n['delay_info_all'] = $delay->get();
        $n['departments'] = Department::where('deleted_by',null)->get();

        return view('pages.library.report.all',$n);
    }



}
