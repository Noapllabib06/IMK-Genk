<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EduNOTES - Dashboard' }}</title>
    
    <!-- Font & Ikon -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Memanggil CSS & JS Dasbor dari Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--bg-dark); color: var(--text-main); font-family: 'Inter', sans-serif;">
    
    <!-- Tempat Konten Dasbor Disuntikkan -->
    {{ $slot }}

</body>
</html>