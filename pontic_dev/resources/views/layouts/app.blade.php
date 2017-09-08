<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pontic</title>
        <link rel="icon" href="{{ secure_url('images/favicon.ico') }}" type="image/x-icon">
            <meta content="width=device-width, initial-scale=1" name="viewport" />
            <meta content="Pontic" name="description" />
            <meta content="Pontic" name="author" />
			<meta name="csrf-token" content="{{ csrf_token() }}">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link rel="stylesheet" href="{{ secure_url('css/materialize.min.css') }}" media="screen,projection">
                    <link href="{{ secure_url('css/style.css?v=0.1') }}" rel="stylesheet" type="text/css" />

                    <!-- Owl Carousel Assets -->
                    <link href="{{ secure_url('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
                    <link href="{{ secure_url('css/owl.theme.css') }}" rel="stylesheet" type="text/css" />
                    <link href="{{ secure_url('css/jquery.classybox.min.css') }}" rel="stylesheet" type="text/css" />

                    <link href="{{ secure_url('css/materialize.clockpicker.css') }}" rel="stylesheet" type="text/css" />
                    <link href="{{ secure_url('css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
					
                    @if(! empty($data['title']) && $data['title'] == 'Settings')
                    <meta name="_token" content="{!! csrf_token() !!}"/>
                    @endif

                    </head>
                    <body>
                        @yield('content')
                        <script src="{{ secure_url('js/jquery-2.1.1.min.js') }}"></script>
                        <script src="{{ secure_url('js/materialize.min.js') }}"></script>
                        <script  src="{{ secure_url('js/init.js') }}" type="text/javascript"></script>
                        <!-- Need to update id for tracking in production version-->
                        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90763789-1', 'auto');
  ga('send', 'pageview');

</script>
                                                  @yield('script')

                    </body>
                    </html>
