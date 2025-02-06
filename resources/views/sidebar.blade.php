<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/grup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <title>VibeFour</title>

</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">Vibe<span style="color:blueviolet;">Four</span></div>
        <hr>
        <a href="#" class="menu-item active"><i class="bi bi-house-door"></i> Beranda</a>

        <div onclick="dropdownVote()" class="menu-item ">
            <i class="bi bi-check-circle"></i> Voting
        </div>

        <div id="menu_vote" class="hidden">
            <a href="/vote" class="menu-sub-item">Vote Saya</a>
        </div>

        <div onclick="dropdownPenjadwalan()" class="menu-item">
            <i class="bi bi-calendar-event"></i> Penjadwalan<i id="icon_jadwal" class=" tanda bi bi-chevron-right"></i>
        </div>

        <div id="menu_penjadwalan" class="hidden">
            <a href="/grup" class="menu-sub-item">Grup</a>
        </div>
        <div id="menu_penjadwalan_pertemuan" class="hidden">
            <a href="#" class="menu-sub-item">Pertemuanmu</a>
        </div>
        <hr>
        <a href="/logout" class="menu-item"><i class="bi bi-box-arrow-right"></i> Keluar Akun</a>
    </div>

    <div class="content" id="content">
        {{-- <div class="navbar"> --}}
        <i class="bi bi-list toggle-btn" id="toggleSidebar"></i>
        {{-- </div> --}}

        <div class="container mt-4">

            @yield('content')

        </div>
    </div>

    <script>
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("sidebar-hidden");
            document.getElementById("content").classList.toggle("content-expanded");
        });

        function dropdownVote() {
            document.getElementById("menu_vote").classList.toggle("hidden");
        }

        function dropdownPenjadwalan() {
            document.getElementById("menu_penjadwalan").classList.toggle("hidden");
            document.getElementById("menu_penjadwalan_pertemuan").classList.toggle("hidden");
            const menuGrup = document.getElementById("menu_penjadwalan");
            const menuPertemuan = document.getElementById("menu_penjadwalan_pertemuan");
            const icon = document.getElementById("icon_jadwal");

            if (menuGrup.classList.contains("hidden") && menuPertemuan.classList.contains("hidden")) {
                icon.style.transform = "rotate(0deg)";
            } else {
                icon.style.transform = "rotate(90deg)";
            }
        }
    </script>

</body>

</html>
