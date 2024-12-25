<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AOS Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <title>KoperasiKu</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('components.landingpage')

    <!-- AOS Script -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                AOS.init({
                    duration: 1000,  // Durasi animasi (opsional)
                    once: false      // Aktifkan animasi setiap kali elemen terlihat
                });
            });
    </script>

</body>
</html>