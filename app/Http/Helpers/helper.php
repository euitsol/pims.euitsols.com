<?php

use App\Models\ExamCreate;
use App\Models\ExamSearch;
use App\Models\ExamSubject;
use App\Models\ExamSchedule;
use App\Models\Subject;
use App\Models\Credit;

function calculate_sub_total_mark($subject_id, $create_id){
    $total = 0;
    $subject = ExamSubject::with(['subject'])->where('create_id', $create_id)->where('subject_id', $subject_id)->first();
    $create = ExamCreate::find($create_id);
    if($subject != null){
        $credit = $subject->subject->credit->credit_number;
        $exam_mark = $create->total_mark;
        $total = $credit*$exam_mark;
    }
    return $total;
}

//Get remaining mark for per credit exam
function get_remaining_mark($search_id){
    $sum = ExamCreate::where('search_id', $search_id)->where('deleted_at', null)->sum('total_mark');
    $credit = Credit::where('deleted_at', null)->latest()->first();
    if($credit != null){
        $credit_number = $credit->credit_number;
        $marks = $credit->marks;
        $per_credit_mark = $marks/$credit_number;
        $result = $sum - $per_credit_mark;
    }else{
        $result = 0;
    }

    return $result ?? 0;
}

function get_exam_shift($create_id, $group_id, $shift_id){
    $exam_schedule = ExamSchedule::where('shift_id', $shift_id)->where('group_id', $group_id)->where('create_id', $create_id)->where('deleted_at', null)->latest()->first();
    return $exam_schedule->exam_shift_id ?? '';
}

function get_exam_subject($create_id, $subject_id){
    $exam_subject = ExamSubject::where('subject_id', $subject_id)->where('create_id', $create_id)->where('deleted_at', null)->latest()->first();
    return $exam_subject ?? '';
}
