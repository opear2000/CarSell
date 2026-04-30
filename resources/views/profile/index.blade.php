<x-app-layout>
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Mi Perfil</h1>

        <form action="{{ route('profile.update') }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
             <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        </form>

        @php
            $user = auth()->user();
            $isSocial = $user->google_id || $user->facebook_id;
        @endphp
        @if (! $isSocial)
            <h2 class="text-xl font-semibold mb-4">Cambiar Contraseña</h2>
            <form action="{{ route('profile.updatePassword') }}" method="POST" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                @csrf
                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Contraseña Actual</label>
                    <div class="relative">
                        <input :type="showCurrent ? 'text' : 'password'" name="current_password" id="current_password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10">
                        <button type="button" @click="showCurrent = !showCurrent" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none text-xs font-medium">
                            <span x-show="!showCurrent">Mostrar</span>
                            <span x-show="showCurrent">Ocultar</span>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                    <div class="relative">
                        <input :type="showNew ? 'text' : 'password'" name="new_password" id="new_password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10">
                        <button type="button" @click="showNew = !showNew" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none text-xs font-medium">
                            <span x-show="!showNew">Mostrar</span>
                            <span x-show="showNew">Ocultar</span>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="new_password_confirmation" id="new_password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10">
                        <button type="button" @click="showConfirm = !showConfirm" tabindex="-1" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 focus:outline-none text-xs font-medium">
                            <span x-show="!showConfirm">Mostrar</span>
                            <span x-show="showConfirm">Ocultar</span>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
            </form>
        @endif
    </div>
</x-app-layout>