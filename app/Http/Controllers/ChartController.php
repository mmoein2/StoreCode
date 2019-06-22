<?php

namespace App\Http\Controllers;

use App\Customer;
use App\MainCode;
use App\Prize;
use App\Shop;
use App\SubCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

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

        //
        $miladi = Carbon::now();
        $shamsi =  Jalalian::fromDateTime($miladi);

        $year = $shamsi->getYear();

        $subcode_series=[];
        $customer_series=[];
        $shop_series=[];
        for($i=1;$i<=12;$i++) {

            $length = (new Jalalian($year, $i, 1))->getMonthDays();

            $date = (new Jalalian($year, $i, 1))->toCarbon();

            $y = $date->year;
            $m = $date->month;
            $d = $date->day;

            $start = $datetime = \DateTime::createFromFormat('Y-m-d',$y . "-" . $m . "-" . $d);

            $date = (new Jalalian($year, $i, $length))->toCarbon();

            $y = $date->year;
            $m = $date->month;
            $d = $date->day;
            $end = $datetime = \DateTime::createFromFormat('Y-m-d',$y . "-" . $m . "-" . $d);
            $end=$end->setTime(23,59,59);

            $ct = SubCode::where('created_at','>=',$start)->where('created_at','<=',$end)->count();
            array_push($subcode_series,$ct);

            $ct = Customer::where('created_at','>=',$start)->where('created_at','<=',$end)->count();
            array_push($customer_series,$ct);

            $ct = Shop::where('created_at','>=',$start)->where('created_at','<=',$end)->count();
            array_push($shop_series,$ct);


        }


        return view('chart.index',compact('bar_chartlable','used_score','unused_score','shop_score','pie_lable','pie_data','table_data','shop_series','customer_series','subcode_series'));
    }
}
