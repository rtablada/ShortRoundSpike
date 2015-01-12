@extends('admin.layouts.sb-base')

@section('content')
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            @gadget('App\\Gadgets\\Menus', 'admin-top')
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    @gadget('App\\Gadgets\\Menus', 'admin', ['template' => 'admin.gadgets.side-menu'])
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $title or 'Dashboard'}}</h1>
            </div>
        </div>
        @include('admin._partials.alerts')
        @yield('page')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
@endsection

@section('scripts')
<script src="/js/metis.js"></script>
<script src="/js/admin-morris.js"></script>
<script>
(function(){

    $('#side-menu').metisMenu();
})();
</script>
@append
