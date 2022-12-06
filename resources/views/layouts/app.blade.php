<html>
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    />
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    />
    <title>
        Laravel App
    </title>

    @include('layouts.header')
</head>
<body class="w-full h-full bg-gray-100">

    @include('layouts.partials.topSection')

    {{-- Content --}}
    @yield('content')

    
</body>
</html>