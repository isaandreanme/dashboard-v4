<!-- resources/views/errors/403.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: url("{{ asset('images/backgrounds/login-bg.jpg') }}") no-repeat center center fixed;
            color: #2d3748;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem; /* Add padding to avoid edge cut-off */
        }

        .btn-custom {
            background: linear-gradient(90deg, rgba(255,165,0,1) 0%, rgba(34,197,94,1) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-transform: uppercase;
            width: 100%; /* Make buttons full-width on small screens */
            max-width: 300px; /* Limit the maximum width */
            white-space: nowrap; /* <== TAMBAHKAN INI */
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, rgba(34,197,94,1) 0%, rgba(255,165,0,1) 100%);
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-container {
            display: flex;
            flex-direction: column; /* Stack buttons vertically by default */
            gap: 1rem;
            width: 100%; /* Make container full width */
            align-items: center; /* Center buttons horizontally */
        }

        @media (min-width: 640px) {
            .btn-container {
                flex-direction: row; /* Align buttons horizontally on larger screens */
            }
        }
    </style>
</head>
<body>
    <div class="flex flex-col items-center space-y-6 text-center max-w-full px-4">
        <h1 class="text-9xl font-extrabold text-red-600 uppercase">403</h1>
        <h2 class="text-4xl font-semibold mt-4 uppercase">Forbidden</h2>

        <!-- Buttons container with responsive flex layout -->
        <div class="btn-container">
            <a href="{{ url('/') }}" class="btn-custom hover:shadow-lg transition">Back to Home</a>
            <a href="{{ url('/admin/workers') }}" class="btn-custom hover:shadow-lg transition">Back to Agency</a>
            <!-- Tombol Logout -->
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn-custom hover:shadow-lg transition">Logout</a>
        </div>

        <!-- Form Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</body>
</html>
