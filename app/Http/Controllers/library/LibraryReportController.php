<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AssignBook;
use Illuminate\Http\Request;

class LibraryReportController extends Controller
{
    public function index($date){
        $n['assigned_info'] = AssignBook::where('deleted_by',null)
                                        ->where('assign_date',$date)
                                        ->get();

        $n['returned_info'] = AssignBook::where('deleted_by',null)
                                        ->where('returned_date',$date)
                                        ->get();

        $n['return_info'] = AssignBook::where('deleted_by',null)
                                        ->where('return_date',$date)
                                        ->where('returned_date',null)
                                        ->get();
        $n['date'] = $date;
      return view('pages.library.report.index',$n);
    }
}
