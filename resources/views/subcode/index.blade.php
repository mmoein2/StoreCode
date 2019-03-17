@extends('layout')

@section('content')
    @include('error')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-code"></i>
                <h3 class="box-title">مدیریت کدهای فرعی</h3>
                <div style="margin-top: 20px">
                    <form enctype="multipart/form-data" method="post" action="/subcode">
                        {{csrf_field()}}
                    <label >وارد گردن اطلاعات</label>
                    <button type="button" style="margin-right: 5px" id="btnUpload" class="btn btn-danger" onclick="fileUpload.click()"><i class="fa fa-upload"></i></button>
                    <input name="file" id="fileUpload" type="file" onchange="btnUpload.classList.remove('btn-danger')" style="display: none">
                    <button type="submit" style="margin-right: 2px" class="btn btn-primary">ارسال اطلاعات</button>
                    </form>
                </div>
                <!-- tools box -->
                <!-- <div class="pull-left box-tools">
                    <button type="button" class="btn bg-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                -->

            </div>
            <div class="box-body">


            </div>
        </div>
    </div>
</div>

@endsection