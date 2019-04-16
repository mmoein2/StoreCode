<?php

namespace App\Http\Controllers\Api;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return [
            'message'=>'0',
            'data'=>$sliders
        ];
    }
}
