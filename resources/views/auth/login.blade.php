<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - PIGENE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-pigene-800">PIGENE</h1>
            <p class="text-gray-500">Sistema de Gestión de Nómina</p>
        </div>
        
        <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
            @csrf
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $errors->first('email') }}</span>
                </div>
            @endif

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pigene-500 focus:border-pigene-500 sm:text-sm" placeholder="admin@pigene.com" value="{{ old('email') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pigene-500 focus:border-pigene-500 sm:text-sm" placeholder="********">
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ingresar
                </button>
            </div>
        </form>
    </div>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pigene: {
                            500: '#6366f1', // Indigo imitation
                            800: '#3730a3',
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>
