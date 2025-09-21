<x-layout>
    <x-slot:title>
        Login
    </x-slot:title>

    <div class="container mx-auto px-4 py-8 sm:py-12 flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/CertifiCar.svg') }}" alt="CertifiCar Logo" class="h-10 w-auto">
                </div>

                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Acesse sua conta</h1>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ $errors->first() }}</span>
                    </div>
                @endif


                <x-form action="{{ route('user.auth') }}" method="POST" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">E-mail:</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha:</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                    </div>

                    <div class="text-right">
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-gray-600 hover:text-[#840032] transition-colors">Esqueceu sua senha?</a>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-[#840032] text-white font-semibold py-2 px-6 rounded-md hover:bg-[#6a0028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032] transition-colors">
                            Entrar
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600">
                            Não tem uma conta? <a href="{{ route('register') }}"
                                class="font-medium text-[#840032] hover:underline">Cadastre-se</a>
                        </p>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-layout>