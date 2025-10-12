<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Jadwal Wawancara</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-10 p-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800">Notifikasi Jadwal Wawancara (No-Reply Adress)</h2>
            <p class="text-gray-600 mt-1">Berikut adalah jadwal wawancara Anda:</p>
        </div>

        <!-- Schedule Details -->
        <div class="mt-6">
            <div class="text-gray-700">
                <p class="font-semibold">Hari: {{ $hari }}</p>
            </div>
            <div class="mt-3 text-gray-700">
                <p class="font-semibold">Tanggal: {{ $tanggal }}</p>
            </div>
            <div class="mt-3 text-gray-700">
                <p class="font-semibold">Jam: {{ $jam }}</p>
            </div>
            <div class="mt-6 text-gray-700">
                <p class="font-semibold">Link Google Meet:</p>
                <a href="{{ $link_gmeet }}" class="text-blue-500 hover:underline" target="_blank">{{ $link_gmeet }}</a>
            </div>
        </div>

        <!-- Button to Join the Meeting -->
        <div class="mt-8 text-center">
            <a href="{{ $link_gmeet }}" target="_blank" class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-200">
                Bergabung ke Google Meet
            </a>
        </div>

        <!-- Footer Note -->
        <div class="mt-6 text-gray-500 text-sm text-center">
            <p>Jika ada perubahan atau kendala terkait jadwal, harap hubungi OA Line Battle Of Minds 2025.</p>
        </div>
    </div>
</body>
</html>