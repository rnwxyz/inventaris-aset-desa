<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- link boostrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #F8F8F8;
        }

        input[type="checkbox"]:checked {
            background-color: green;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        #content {
            flex: 1;
            padding: 20px;
        }

        #slot {
            margin: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            display: flex;
            flex: 1;
        }

        .main-container {
            width: 100%;
            height: 100%;
        }

        .hover-effect:hover {
            background-color: #e9ecef;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div id="slot" class="main-content">
        {{ $slot }}
    </div>
</body>

</html>