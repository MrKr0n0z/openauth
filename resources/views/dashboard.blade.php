<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - OAuth App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full bg-white rounded-lg shadow-lg p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        Logout
                    </button>
                </form>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-50 rounded-lg p-6">
                <div class="flex items-center mb-6">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-20 h-20 rounded-full mr-4 border-4 border-indigo-500">
                    @else
                        <div class="w-20 h-20 rounded-full mr-4 bg-indigo-500 flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">{{ Auth::user()->name }}</h2>
                        @if(Auth::user()->email)
                            <p class="text-gray-600">{{ Auth::user()->email }}</p>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Provider</h3>
                        <p class="text-lg font-medium text-gray-800 capitalize">
                            @if(Auth::user()->provider === 'x-twitter')
                                X (Twitter)
                            @else
                                {{ Auth::user()->provider }}
                            @endif
                        </p>
                    </div>

                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Provider ID</h3>
                        <p class="text-lg font-mono text-gray-800 break-all">{{ Auth::user()->provider_id }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Member Since</h3>
                        <p class="text-lg font-medium text-gray-800">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Last Updated</h3>
                        <p class="text-lg font-medium text-gray-800">{{ Auth::user()->updated_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="text-sm font-semibold text-blue-800 mb-2">🎉 Authentication Successful!</h3>
                    <p class="text-sm text-blue-700">
                        You've successfully authenticated using {{ ucfirst(Auth::user()->provider) }}. 
                        Your session is now active and your OAuth tokens are securely stored.
                    </p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="/" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
