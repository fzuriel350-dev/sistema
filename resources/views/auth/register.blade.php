<x-guest-layout>
    <div class="text-center mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
        <img src="{{ asset('img/logo-uptex.jpeg') }}" alt="Logo UPTex" class="mx-auto h-24 w-auto mb-4">
        
        <h1 class="text-3xl font-extrabold text-[#00602F] uppercase tracking-wider">
            UPTex | Registro de Usuario
        </h1>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nombre Completo" />
            <x-text-input id="name" class="block mt-1 w-full border-[#00602F] focus:border-[#C71C41] focus:ring-[#C71C41]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Correo Institucional" />
            <x-text-input id="email" class="block mt-1 w-full border-[#00602F] focus:border-[#C71C41] focus:ring-[#C71C41]" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full border-[#00602F] focus:border-[#C71C41] focus:ring-[#C71C41]"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-[#00602F] focus:border-[#C71C41] focus:ring-[#C71C41]"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-[#00602F] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C71C41]" href="{{ route('login') }}">
                ¿Ya estás registrado?
            </a>

            <x-primary-button class="ms-4 bg-[#C71C41] hover:bg-[#A31835] focus:bg-[#A31835] active:bg-[#C71C41]">
                Registrar Cuenta
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>