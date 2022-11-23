<?php

namespace App\Http\Controllers\library;

use App\Http\Controllers\Controller;
use App\Models\AssignBook;
use App\Models\User;
use Illuminate\Http\Request;

class LibraryReportController extends Controller
{
    public function dailyReport($date){
        $n['assigned_info'] = AssignBook::where('deleted_by',null)
                                        ->where('assign_date',$date)
                                        ->get();

        $n['returned_info'] = AssignBook::where('deleted_by',null)
                                        ->where('returned_date',$date)
                                        ->get();

        $n['delay'] = AssignBook::where('deleted_by',null)
                                        ->where('return_date',$date)
                                        ->where('returned_date','>',$date)
                                        ->get();
        $n['date'] = $date;
        // dd($n['delay']);
      return view('pages.library.report.daily',$n);
    }

    public function allReport(Request $req){

        $n['str_date'] = $req->str_date;
        $n['end_date'] = $req->end_date;
        $n['user_id'] = $req->user_id;

        $assigned = AssignBook::where('deleted_by',null)
                                ->whereBetween('assign_date',[$n['str_date'],$n['end_date']])->where('status','0');
                                if($n['user_id']){
                                    $assigned->where('created_by',$n['user_id']);
                                }
        $n['assigned_info_all'] =  $assigned->get();

         $returned= AssignBook::where('deleted_by',null)
                               ->whereBetween('returned_date',[$n['str_date'],$n['end_date']])->where('status','1');
                               if($n['user_id']){
                                $returned->where('created_by',$n['user_id']);
                            }
        $n['returned_info_all'] = $returned->get();

       $delay  = AssignBook::where('deleted_by',null)
                               ->whereBetween('return_date',[$n['str_date'],$n['end_date']])->where('status','-1');
                               if($n['user_id']){
                                    $delay->where('created_by',$n['user_id']);
                                }
        $n['delay_info_all'] = $delay->get();
        $n['users'] = User::where('deleted_by',null)->get();
        
        return view('pages.library.report.all',$n);
    }
}
