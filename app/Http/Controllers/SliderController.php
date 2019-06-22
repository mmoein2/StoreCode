<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();
        return view('slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->file('image');

        $image = $request->file('image');
        $postfix = $image->getClientOriginalExtension();

        $name= uniqid().'.'.$postfix;
        $url = "/upload/slider/";

        Image::make($image)->resize(380,150)->save(public_path($url.$name));

        $slider = new Slider();
        $slider->image_address = $url.$name;
        $slider->link = $request->link;

        $slider->save();
        return redirect('/slider');
    }

    public function delete($id)
    {
        $s = Slider::find($id);
        File::delete(public_path($s->image_address));
        Slider::destroy($id);
        return back();
    }

}
