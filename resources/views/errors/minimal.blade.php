<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        <link href="{{asset('dist/css/style.css')}}" rel="stylesheet">
    </head>
    <body>
        <div id="main-wrapper">
            <div class="content-page">
                <div class="content">
                    <div class="page-wrapper d-block">
                        <div class="error-box">
                            <div class="error-body text-center">
                                <h1 class="error-title">@yield('code')</h1>
                                <h3 class="text-uppercase error-subtitle">@yield('message')</h3>
                                <p class="h5 text-muted mt-4 mb-4">You Should talk to your admin for further information about this Message</p>
                                <a href="{{url()->previous()}}" class="btn btn-info btn-rounded waves-effect waves-light mb-5"><i class="ti-back-left mr-2"></i> Go Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>
