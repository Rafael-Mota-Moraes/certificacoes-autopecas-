<x-layout>
    <x-slot:title>
        Perfil de {{auth()->user()->name}}
    </x-slot:title>


    <span class="text-center">
        <h1>Dados da conta</h1>
    </span>

    <div class="mt-8 bg-white m-auto min-w-200 max-w-200 min-h-70 flex rounded-2xl border-2 divide-x divide-gray-300">
        <div class="flex-1 flex-col p-10 text-left min-w-65">
            <p class="ml-4 mb-6">
                Nome: {{auth()->user()->name}}
            </p>
            <hr>
            <p class="ml-4 my-6">
                Email: {{auth()->user()->email}}
            </p>
            <hr>

            <p class="ml-4 my-6">
                CPF: {{auth()->user()->cpf}}m
            </p>

            <button style="background-color: #840032" class="p-1.5 text-white rounded-sm mb-8 ml-4">Atualizar dados
            </button>
        </div>
        {{-- DENTRO DO SEU ARQUIVO BLADE --}}
        <div class="flex-1 p-8 flex flex-col items-center justify-center">

            <form id="photo-form" method="POST" action="{{ route('user.updatePhoto') }}" enctype="multipart/form-data">
                @method("PATCH")
                @csrf

                <input type="file" name="photo" id="photo" class="hidden">

                <label for="photo" class="cursor-pointer group flex flex-col items-center">

                    <img class="rounded-full h-32 w-32 object-cover border-4 border-gray-200 group-hover:opacity-80 transition-opacity"
                         src="{{ auth()->user()->profile_photo_url }}"
                         alt="Foto de Perfil">

                    <span class="mt-4 text-sm hover:underline" style="color: #840032;">
                Trocar foto de perfil
            </span>

                </label>

                <button type="submit" class="hidden">Enviar</button>
            </form>

        </div>

    </div>
</x-layout>

<script>
    const photoInput = document.getElementById('photo');

    const photoForm = document.getElementById('photo-form');

    photoInput.addEventListener('change', function () {
        if (photoInput.files.length > 0) {
            photoForm.submit();
        }
    });
</script>
