<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/grup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tambahvote.css') }}">
    <title>VibeFour</title>

</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">Vibe<span style="color:blueviolet;">Four</span></div>

        <a href="#" class="menu-item"><i class="bi bi-house-door"></i> Beranda</a>

        <!-- Dropdown Voting -->
        <a class="menu-item" data-bs-toggle="collapse" href="#menu_vote" role="button" aria-expanded="false"
            data-target="#menu_vote">
            <i class="bi bi-check-circle"></i> Voting
            <i class="bi bi-chevron-down ms-auto rotate" id="arrow_vote"></i>
        </a>
        <div class="collapse" id="menu_vote">
            <a href="/vote_saya" class="menu-sub-item">Vote Saya</a>
        </div>


        <!-- Dropdown Penjadwalan -->
        <a class="menu-item" data-bs-toggle="collapse" href="#menu_penjadwalan" role="button" aria-expanded="false"
            data-target="#menu_penjadwalan">
            <i class="bi bi-calendar-event"></i> Penjadwalan
            <i class="bi bi-chevron-down ms-auto rotate" id="arrow_penjadwalan"></i>
        </a>
        <div class="collapse" id="menu_penjadwalan">
            <a href="/grup" class="menu-sub-item">Grup</a>
            <a href="/pertemuan" class="menu-sub-item">Pertemuan</a>
        </div>

        <a href="/logout" class="menu-item"><i class="bi bi-box-arrow-right"></i> Keluar Akun</a>
    </div>

    <div class="content" id="content">


        @yield('content')

    </div>

    <script>
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("sidebar-hidden");
            document.getElementById("content").classList.toggle("content-expanded");
        });

        // document.getElementById("toggleSidebar").addEventListener("click", function() {
        //     document.getElementById("sidebar").classList.toggle("d-none");
        // });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".menu-item[data-bs-toggle='collapse']").forEach(function(item) {
                let arrow = item.querySelector(".rotate");
                let target = document.querySelector(item.dataset.target);

                target.addEventListener("show.bs.collapse", function() {
                    arrow.classList.add("open");
                });

                target.addEventListener("hide.bs.collapse", function() {
                    arrow.classList.remove("open");
                });
            });
        });
    </script>


</body>

</html>