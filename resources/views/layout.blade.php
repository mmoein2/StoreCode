<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">پنل</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>کنترل پنل مدیریت</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>



            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                    <!-- Notifications: style can be found in dropdown.less -->

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user" style="font-size: 30px"></i>
                            <span class="hidden-xs">{{auth()->user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <i class="fa fa-user" style="font-size: 50px"></i>

                                <p>
                                    {{auth()->user()->name}}

                                </p>
                            </li>

                            <li class="user-footer">

                                <div class="pull-left">
                                    <form method="post" action="/logout">
                                        {{{csrf_field()}}}
                                        <button type="submit" class="btn btn-default btn-flat">خروج</button>

                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->

                </ul>
            </div>
        </nav>
    </header>
    <!-- right side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-right image">
                    <i class="fa fa-user" style="font-size: 50px;color: white"></i>
                </div>
                <div class="pull-right info">
                    <p>{{auth()->user()->name}}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="جستجو">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">منو</li>
                @can('subcode')
                <li @if(strpos(request()->route()->uri,"subcode")!==false) class="active" @endif>
                    <a href="/subcode">
                        <i class="fa fa-code"></i> <span>کدهای فرعی</span>
                    </a>
                </li>
                @endcan
                @can('maincode')

                <li @if(strpos(request()->route()->uri,"maincode")!==false) class="active" @endif>
                    <a href="/maincode">
                        <i class="fa fa-users"></i> <span>کدهای اصلی</span>
                    </a>
                </li>
                @endcan
                @can('shop')
                <li @if(strpos(request()->route()->uri,"shop")!==false) class="active" @endif>
                    <a href="/shop">
                        <i class="fa fa-shopping-cart"></i> <span>فروشگاه</span>
                    </a>
                </li>
                @endcan
                @can('customer')

                <li @if(strpos(request()->route()->uri,"customer")!==false) class="active" @endif>
                    <a href="/customer">
                        <i class="fa fa-user"></i> <span>مشتریان</span>
                    </a>
                </li>
                @endcan

                @can('prize')

                <li @if(strpos(request()->route()->uri,"prize")!==false) class="active" @endif>
                    <a href="/prize">
                        <i class="fa fa-star"></i> <span>جوایز</span>
                    </a>
                </li>
                @endcan
                @can('chart')

                    <li @if(strpos(request()->route()->uri,"chart")!==false) class="active" @endif>
                        <a href="/chart">
                            <i class="fa fa-area-chart"></i> <span>نمودار</span>
                        </a>
                    </li>
                @endcan
                @can('shop-support')

                <li class="header">پیام ها</li>

                <li @if(strpos(request()->route()->uri,"message")!==false) class="active" @endif>
                    <a href="/message">
                        <i class="fa fa-paper-plane"></i> <span>پیام های فروشگاه</span>
                        @if($message_count>0)
                            <span class="pull-left-container">
                        <small style="font-size: 14px" class="label pull-left bg-yellow">
                            <b> {{$message_count}}</b>
                            </span>
                        </small>
                        @endif
                    </a>
                </li>
                @endcan
                @can('customer-support')

                <li @if(strpos(request()->route()->uri,"customersupport")!==false) class="active" @endif>
                    <a href="/customersupport">
                        <i class="fa fa-hand-paper-o"></i> <span>پشتیبانی کاربران</span>
                        @if($customersupport_count>0)
                            <span class="pull-left-container">

                            <small style="font-size: 14px" class="label pull-left bg-yellow">
                                <b> {{$customersupport_count}}</b>
                            </small>
                            </span>
                        @endif
                    </a>
                </li>
                @endcan

                <li class="header">تنظیمات اپلیکیشن</li>
                @can('slider')

                <li @if(strpos(request()->route()->uri,"slider")!==false) class="active" @endif>
                <a href="/slider">
                    <i class="fa fa-list"></i> <span>اسلایدر</span>

                </a>
                </li>
                @endcan
                @can('special-post')

                    <li @if(strpos(request()->route()->uri,"post/amount")!==false) class="active" @endif>
                        <a href="/post/amount">
                            <i class="fa fa-dollar"></i> <span>مبلغ پست ویژه</span>

                        </a>
                    </li>
                @endcan

                <li class="header">کاربران</li>
                @can('change-password')

                <li @if(strpos(request()->route()->uri,"user/change/password")!==false) class="active" @endif>
                    <a href="/user/change/password">
                        <i class="fa fa-user"></i> <span>تغییر رمز عبور سایت</span>

                    </a>
                </li>
                @endcan
                @can('insert-user')

                <li @if(request()->route()->uri=="user") class="active" @endif>
                    <a href="/user">
                        <i class="fa fa-user"></i> <span>ایجاد کاربر سایت</span>

                    </a>
                </li>
                @endcan


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">

                @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper
    <footer class="main-footer text-left">

    </footer>
-->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">فعالیت ها</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">تولد غلوم</h4>

                                <p>۲۴ مرداد</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">آپدیت پروفایل سجاد</h4>

                                <p>تلفن جدید (800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">نورا به خبرنامه پیوست</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">کرون جابز اجرا شد</h4>

                                <p>۵ ثانیه پیش</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">پیشرفت کارها</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                ساخت پوستر های تبلیغاتی
                                <span class="label label-danger pull-left">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                آپدیت رزومه
                                <span class="label label-success pull-left">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                آپدیت لاراول
                                <span class="label label-warning pull-left">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                بخش پشتیبانی سایت
                                <span class="label label-primary pull-left">68%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">وضعیت</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">تنظیمات عمومی</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            گزارش کنترلر پنل
                            <input type="checkbox" class="pull-left" checked>
                        </label>

                        <p>
                            ثبت تمامی فعالیت های مدیران
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            ایمیل مارکتینگ
                            <input type="checkbox" class="pull-left" checked>
                        </label>

                        <p>
                            اجازه به کاربران برای ارسال ایمیل
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            در دست تعمیرات
                            <input type="checkbox" class="pull-left" checked>
                        </label>

                        <p>
                            قرار دادن سایت در حالت در دست تعمیرات
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">تنظیمات گفتگوها</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            آنلاین بودن من را نشان نده
                            <input type="checkbox" class="pull-left" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            اعلان ها
                            <input type="checkbox" class="pull-left">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            حذف تاریخته گفتگوهای من
                            <a href="javascript:void(0)" class="text-red pull-left"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>


<script src="/js/app.js"></script>
@yield('js')

</body>
</html>
