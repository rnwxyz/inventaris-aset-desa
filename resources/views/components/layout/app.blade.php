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
    <!-- sidebar-->
    <div class="main-content">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-white">
            <div class="container ps-5 pb-4 pe-4 pt-4">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Bangli" class="img-fluid" width="150">
            </div>
            <ul class="list-unstyled border-top pt-4 ps-3 pe-3">
                <li><a href="#" class="d-block text-white rounded p-2 fw-bold bg-primary mt-2" style="text-decoration: none; font-size: small;">PERALATAN DAN MESIN</a></li>
                <li><a href="#" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">BANGUNAN LAINNYA</a></li>
                <li><a href="#" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">KENDARAAN BERMOTOR</a></li>
                <li><a href="#" class="d-block text-dark p-2 fw-bold mt-2 hover-effect" style="text-decoration: none; font-size: small;">REKAPITULASI ASET</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <!-- headers -->
        <div class="main-container">
            <header class="m-2">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container d-flex">
                        <a class="navbar-brand flex-fill fs-2" href="#">{{ config('app.name', 'Laravel') }}</a>
                    </div>
                </nav>
            </header>
            <div id="slot" class="pb-4">
                {{ $slot }}
            </div>
        </div>
    </div>



</body>

</html>