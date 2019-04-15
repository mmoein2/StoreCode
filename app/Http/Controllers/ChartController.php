<?php

namespace App\Http\Controllers;

use App\MainCode;
use App\Prize;
use App\SubCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(){
        
        //bar chart
        $bar_lables = SubCode::groupBy('score')->select('score')->orderBy('score','asc')->get()->pluck('score');
        $bar_chartlable=[];

        $used_score = [];
        $unused_score = [];
        $shop_score = [];

        foreach ($bar_lables as $d)
        {
            $used_score[] = SubCode::where('score',$d)->where('status',2)->count();
            $bar_chartlable[]='کد '.$d.' امتیازی ';

        }
        foreach ($bar_lables as $d)
        {
            $unused_score[] = SubCode::where('score',$d)->where('status',0)->count();
        }
        foreach ($bar_lables as $d)
        {
            $shop_score[] = SubCode::where('score',$d)->where('status',1)->count();
        }

        //pie chart
        $prizes = Prize::orderBy('id','desc')->get();

        $pie_lable=[];
        $pie_data=[];
        for ($k=0;$k<count($prizes);$k++)
        {
            $pie_lable[]=$prizes[$k]->name;

            $id = $prizes[$k]->id;
            $pie_data[] = MainCode::where('prize_id',$id)->where('status',true)->count();

        }

        //table
        $table_data=[];
        for ($k=0;$k<count($prizes);$k++)
        {
            $id = $prizes[$k]->id;
            $table_data[] = MainCode::where('prize_id',$id)->where('status',false)->count();

        }


        return view('chart.index',compact('bar_chartlable','used_score','unused_score','shop_score','pie_lable','pie_data','table_data'));
    }
}
