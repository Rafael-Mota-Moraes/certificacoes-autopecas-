<x-layout>
    <div class="min-h-screen bg-[#575654] flex justify-center items-center py-10">
        <div class="w-[90%] md:max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-[0px_0px_100px_rgba(0,0,0,0.3)]">

            <div class="text-center">
                <h1 class="text-black text-2xl md:text-3xl font-bold mb-6">REPORTAR ERRO</h1>

            </div>
            <form action="{{ route('user_report.store') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="email" class="text-gray-700 font-medium">E-mail:</label>
                    <input name="email" id="email" type="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"/>
                </div>
                <div class="mb-6">
                    <label for="report" class="text-gray-700 font-medium">Descreva o problema:</label>
                    <textarea name="report" id="report" required rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 resize-none"></textarea>
                </div>
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-1">
                            <strong class="font-bold">Enviado!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                <div class="text-center">
                    <button type="submit" class="bg-[#8b0000] hover:bg-[#a02c2c] text-white font-bold py-2 px-6 rounded-md shadow-md transition duration-300">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
