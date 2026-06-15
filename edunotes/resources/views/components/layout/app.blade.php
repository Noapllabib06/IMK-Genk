<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EduNOTES - Sat-set Task Management' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--bg-dark); color: #e0e0e0; font-family: 'Inter', sans-serif; margin: 0;">
    
    <!-- Panggil Navbar Berdasarkan Halaman -->
    @if(!request()->is('login') && !request()->is('register'))
        <x-layout.navbar />
    @else
        <!-- Navbar Sederhana khusus Login/Register (1:1 Original) -->
        <nav class="navbar navbar-expand-lg navbar-dark py-3 sticky-top">
          <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold fs-4" href="/">EduNOTES</a>
          </div>
        </nav>
    @endif

    <!-- INI DIA YANG HILANG: Tempat memunculkan isi form form Login/Register/Homepage -->
    <main>
        {{ $slot }}
    </main>

    <!-- Panggil Footer (Jika bukan di halaman login/register) -->
    @if(!request()->is('login') && !request()->is('register'))
        <x-layout.footer />
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>