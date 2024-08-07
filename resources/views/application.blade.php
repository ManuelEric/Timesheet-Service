<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="{{ asset('favicon.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>External Timesheet - EduALL</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('loader.css') }}" />
    @vite(['resources/js/main.js'])

    <style>
        /* Untuk Chrome, Safari, Opera */
        *::-webkit-scrollbar {
            height: 3px;
            width: 5px;
            /* tinggi scrollbar */
        }

        *::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* warna latar belakang track */
        }

        *::-webkit-scrollbar-thumb {
            background-color: #6363e7;
            /* warna thumb scrollbar */
            border-radius: 10px;
            /* sudut bulat thumb */
        }

        *::-webkit-scrollbar-thumb:hover {
            background-color: #0000FF;
            /* warna thumb saat dihover */
        }
    </style>
</head>

<body>
    <div id="app">
        <div id="loading-bg">
            <div class="loading-logo">
                <div class="loading-logo">
                    <!-- SVG Logo -->
                    <div class="d-flex justify-center mb-10 mt-5">
                        <img src="{{ asset('eduall.png') }}" alt="EduALL Assessment" width="100px">
                    </div>
                </div>
            </div>
            <div class="loading">
                <div class="effect-1 effects"></div>
                <div class="effect-2 effects"></div>
                <div class="effect-3 effects"></div>
            </div>
        </div>
    </div>

    <script>
        const loaderColor = localStorage.getItem('materio-initial-loader-bg') || '#FFFFFF'
        const primaryColor = localStorage.getItem('materio-initial-loader-color') || '#9155FD'

        if (loaderColor)
            document.documentElement.style.setProperty('--initial-loader-bg', loaderColor)

        if (primaryColor)
            document.documentElement.style.setProperty('--initial-loader-color', primaryColor)
    </script>
</body>

</html>
