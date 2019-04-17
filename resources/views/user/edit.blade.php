@extends('layout')
@section('content')
    <style>
        .pure-material-checkbox {
            z-index: 0;
            position: relative;
            display: inline-block;
            color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.87);
            font-size: 16px;
            line-height: 1.5;
        }

        /* Input */
        .pure-material-checkbox > input {
            appearance: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            z-index: -1;
            position: absolute;
            left: -10px;
            top: -8px;
            display: block;
            margin: 0;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
            box-shadow: none;
            outline: none;
            opacity: 0;
            transform: scale(1);
            pointer-events: none;
            transition: opacity 0.3s, transform 0.2s;
        }

        /* Span */
        .pure-material-checkbox > span {
            display: inline-block;
            width: 100%;
            cursor: pointer;
        }

        /* Box */
        .pure-material-checkbox > span::before {
            content: "";
            display: inline-block;
            box-sizing: border-box;
            margin: 3px 11px 3px 1px;
            border: solid 2px; /* Safari */
            border-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
            border-radius: 2px;
            width: 18px;
            height: 18px;
            vertical-align: top;
            transition: border-color 0.2s, background-color 0.2s;
        }

        /* Checkmark */
        .pure-material-checkbox > span::after {
            content: "";
            display: block;
            position: absolute;
            top: 3px;
            left: 1px;
            width: 10px;
            height: 5px;
            border: solid 2px transparent;
            border-right: none;
            border-top: none;
            transform: translate(3px, 4px) rotate(-45deg);
        }

        /* Checked, Indeterminate */
        .pure-material-checkbox > input:checked,
        .pure-material-checkbox > input:indeterminate {
            background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        }

        .pure-material-checkbox > input:checked + span::before,
        .pure-material-checkbox > input:indeterminate + span::before {
            border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
            background-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        }

        .pure-material-checkbox > input:checked + span::after,
        .pure-material-checkbox > input:indeterminate + span::after {
            border-color: rgb(var(--pure-material-onprimary-rgb, 255, 255, 255));
        }

        .pure-material-checkbox > input:indeterminate + span::after {
            border-left: none;
            transform: translate(4px, 3px);
        }

        /* Hover, Focus */
        .pure-material-checkbox:hover > input {
            opacity: 0.04;
        }

        .pure-material-checkbox > input:focus {
            opacity: 0.12;
        }

        .pure-material-checkbox:hover > input:focus {
            opacity: 0.16;
        }

        /* Active */
        .pure-material-checkbox > input:active {
            opacity: 1;
            transform: scale(0);
            transition: transform 0s, opacity 0s;
        }

        .pure-material-checkbox > input:active + span::before {
            border-color: rgb(var(--pure-material-primary-rgb, 33, 150, 243));
        }

        .pure-material-checkbox > input:checked:active + span::before {
            border-color: transparent;
            background-color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.6);
        }

        /* Disabled */
        .pure-material-checkbox > input:disabled {
            opacity: 0;
        }

        .pure-material-checkbox > input:disabled + span {
            color: rgba(var(--pure-material-onsurface-rgb, 0, 0, 0), 0.38);
            cursor: initial;
        }

        .pure-material-checkbox > input:disabled + span::before {
            border-color: currentColor;
        }

        .pure-material-checkbox > input:checked:disabled + span::before,
        .pure-material-checkbox > input:indeterminate:disabled + span::before {
            border-color: transparent;
            background-color: currentColor;
        }

    </style>
    @include('error')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form action="/user/update" method="post">
                {{csrf_field()}}
                <input class="form-control" value="{{$user->id}}" type="hidden" name="id">

                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label>نام  کاربر</label>
                            <input class="form-control" value="{{$user->email}}" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label>رمز عبور</label>
                            <input class="form-control" type="text" name="password">
                        </div>
                        <div class="form-group">
                            <label>نام  و نام خانوادگی</label>
                            <input class="form-control" value="{{$user->name}}" type="text" name="name">
                        </div>
                        <label>سطوح دسترسی</label>

                        <div class="form-group">


                            @foreach($permissions as $key=>$p)
                                <div class="col-md-6" style="margin-top: 15px">

                                    <label class="pure-material-checkbox" style="direction: ltr">
                                        <?php $flag=false; ?>
                                        @foreach($user_permissions as $up)


                                            @if($p->name_en == $up->permission->name_en )
                                            <input type="checkbox" name="permissions[]" value="{{$p->name_en}}" checked>
                                                <?php  $flag=true; ?>
                                                @endif
                                        @endforeach
                                            @if(!$flag)
                                                <input type="checkbox" name="permissions[]" value="{{$p->name_en}}" >

                                            @endif

                                        <span>{{$p->name_fa}}</span>

                                    </label>
                                </div>

                            @endforeach



                        </div>



                    </div>
                    <div class="form-group">

                        <button class="btn btn-success" type="submit">ثبت</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection