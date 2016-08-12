<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.site_title') }} - @yield('page_title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="A dating app admin dashboard" name="description" />
    <meta content="Rosemale-John II" name="author" />

    <meta content="{{ csrf_token() }}" name="csrf-token" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.3.2/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Uniform.js/3.0.0/css/default.css" rel="stylesheet" type="text/css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap2/bootstrap-switch.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    @yield('stylesheets')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css" rel="stylesheet" type="text/css"/>

    <link href="/assets/css/global.css" id="style_components" rel="stylesheet" type="text/css" />
    <link href="/css/themes.css" rel="stylesheet" type="text/css" />

    <link rel="icon" href="http://n8core.com/wp-content/uploads/2015/10/favicon.png" type="image/png">
</head>

<body id="body" class="page-md page-boxed page-header-fixed page-container-bg-solid page-sidebar-closed-hide-logo ">

    @include('_partials.header')

    <div class="clearfix">
    </div>
    <div class="container">

        <div class="page-container">
            @include('_partials.sidebar')

            <div class="page-content-wrapper">
                <div class="page-content">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('_partials.footer')

        <website-form-modal title="Website" target="websiteFormModal">
            <website-form slot="content"></website-form>
            <div slot="modal-footer" class="modal-footer">
                <button @click="saveWebsite()" type="submit" class="btn btn-default ladda-button"><span class="ladda-label">Save</span></button>
            </div>
        </website-form-modal>

        <user-form-modal title="User" target="userFormModal">
            <user-form slot="content"></user-form>
            <div slot="modal-footer" class="modal-footer">
                <button @click="saveUser()" type="submit" class="btn btn-default ladda-button" data-style="expand-right"><span class="ladda-label">Save</span></button>
            </div>
        </user-form-modal>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.4.1/jquery-migrate.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
    <!-- END CORE PLUGINS -->

    <script src="/assets/globals/js/metronic.js" type="text/javascript"></script>
    <script src="/assets/admin/js/layout.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://spin.js.org/spin.min.js"></script>
    <script type="text/javascript" src="/js/offline.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            Metronic.init();
            Layout.init();

            var currentPath = window.location.pathname;

            $('.page-sidebar-menu li').each(function(index, elem) {
                var link = $(this).children('a').attr('href');
                if (link == currentPath) {
                    $(this).addClass('active');
                }
            });
        });
    </script>

    @yield('scripts')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>

    <script src="/js/app.js" type="text/javascript"></script>

</body>

</html>
