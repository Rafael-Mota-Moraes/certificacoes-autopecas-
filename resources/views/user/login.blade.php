<x-layout>
    <x-slot:title>
        Login
    </x-slot:title>

    {{-- 1. O 'x-data' foi MOVIDO para este novo 'div' que envolve TUDO --}}
    <div x-data="{ showPasswordModal: false }">

        {{-- O 'x-data' foi REMOVIDO desta linha --}}
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-center min-h-[80vh] gap-16">

            <div class="hidden md:flex flex-col items-center justify-center gap-4">
                <img src="/images/Car.svg" alt="Carro vermelho da logo" class="w-full max-w-sm">
                <img src="/images/CertifiCar.svg" alt="Logo CertifiCar" class="w-50 max-w-xs">
            </div>

            <div class="w-full max-w-md">
                <div class="bg-white p-8 rounded-xl border-2 border-[#840032]">

                    <h1 class="text-3xl font-bold text-center text-black mb-8 uppercase tracking-widest">
                        Entrar
                    </h1>

                    @if (session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <x-form action="{{ route('user.auth') }}" method="POST" class="space-y-4">
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 text-left">E-mail:</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                        </div>

                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 text-left">Senha:</label>
                            <input type="password" id="password" name="password" required
                                class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                        </div>

                        <div class="text-left">
                            <button type="button" @click="showPasswordModal = true"
                                class="text-sm text-[#840032] hover:underline transition-colors focus:outline-none">
                                Esqueci minha senha
                            </button>
                        </div>

                        <div class="pt-6 flex justify-end items-center">
                            <a href="{{ url()->previous() }}"
                                class="text-[#840032] font-semibold transition-colors mx-4">
                                Voltar
                            </a>
                            <button type="submit"
                                class="bg-[#840032] text-white font-semibold py-2 px-10 rounded-md hover:bg-[#6a0028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032] transition-colors">
                                Entrar
                            </button>
                        </div>
                    </x-form>
                </div>
            </div>
        </div>

        {{-- 4. Agora o modal está DENTRO do 'div' que tem o 'x-data' --}}
        <div x-show="showPasswordModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0, 0, 0, 0.7); display: none;">

            <div @click.outside="showPasswordModal = false"
                class="bg-white rounded-xl border-2 border-[#840032] shadow-xl p-8 max-w-md w-full mx-4">

                <h2 class="text-2xl font-bold text-center text-black mb-4 uppercase tracking-wider">
                    Recuperar Senha
                </h2>
                <p class="text-center text-gray-600 text-sm mb-6">
                    Digite seu e-mail e enviaremos um link para você redefinir sua senha.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div>
                        <label for="password_email"
                            class="block text-sm font-medium text-gray-700 text-left">E-mail:</label>
                        <input type="email" id="password_email" name="email" required value="{{ old('email') }}"
                            class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-[#840032] focus:border-[#840032] sm:text-sm">
                    </div>

                    <div class="pt-6 flex justify-end items-center">
                        <button type="button" @click="showPasswordModal = false"
                            class="text-[#840032] font-semibold transition-colors mx-4">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-[#840032] text-white font-semibold py-2 px-10 rounded-md hover:bg-[#6a0028] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#840032] transition-colors">
                            Enviar Link
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div> {{-- 5. Este é o 'div' de fechamento do 'x-data' que adicionamos --}}
</x-layout>
