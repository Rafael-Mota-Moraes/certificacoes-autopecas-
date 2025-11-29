<x-layout>
    <x-slot:title>
        Cadastro
    </x-slot:title>

    <div class="container mx-auto px-4 py-8 sm:py-12">
        <div class="flex flex-col lg:flex-row items-center justify-center lg:space-x-16">

            <!-- Left Side: Illustration -->
            <div class="hidden lg:flex flex-col items-center justify-center w-1/2">
                <img src="{{ asset('images/Car.svg') }}" alt="Car Illustration" class="max-w-md mb-8">
                <img src="{{ asset('images/CertifiCar.svg') }}" alt="CertifiCar Logo" class="h-20 w-auto">
            </div>

            <!-- Right Side: Form Card -->
            <div class="w-full max-w-md">
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">CADASTRO</h1>

                    <x-form action="{{ route('user.register') }}" method="POST" class="space-y-4">

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">*Nome:</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">*E-mail:</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                             @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cpf" class="block text-sm font-medium text-gray-700">*CPF:</label>
                            <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                             @error('cpf')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">*Senha:</label>
                            <input type="password" id="password" name="password" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                             @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">*Confirmar a senha:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('login') }}" class="bg-white text-[#840032] border border-[#840032] font-semibold py-2 px-6 rounded-md hover:bg-gray-100 transition-colors">Voltar</a>
                            <button type="submit"
                                    class="bg-[#840032] text-white font-semibold py-2 px-6 rounded-md hover:bg-[#6a0028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032] transition-colors">
                                Cadastrar
                            </button>
                        </div>

                    </x-form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
