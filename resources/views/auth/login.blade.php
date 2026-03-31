<x-guest-layout>
    <div class="text-center mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
        <img src="{{ asset('img/logo-uptex.jpeg') }}" alt="Logo UPTex" class="mx-auto h-24 w-auto mb-4">
        
        <h1 class="text-3xl font-extrabold text-[#00602F] uppercase tracking-wider">
            Universidad Politécnica de Texcoco
        </h1>
        <p class="text-gray-600 font-medium mt-1">
            Sistemas Web | Práctica 13
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Correo Institucional" />
            <x-text-input id="email" class="block mt-1 w-full border-[#00602F] focus:border-[#C71C41] focus:ring-[#C71C41]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full border-[#00602F] focus:border-[#C71C41] focus:ring-[#C71C41]"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="ms-3 bg-[#C71C41] hover:bg-[#A31835] focus:bg-[#A31835] active:bg-[#C71C41]">
                Iniciar Sesión
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>