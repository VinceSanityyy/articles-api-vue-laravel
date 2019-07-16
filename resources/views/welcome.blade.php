<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script>
        window.Laravel = {csrfToken: '{{ csrf_token() }}'}
    </script>
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <title>Articles</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <div id="app">

<navbar></navbar>


            <div class="container">
                    <articles></articles>
            </div>

        </div>
    <script src="{{asset('js/app.js')}}">
        </script>
           <script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </body>
</html>
