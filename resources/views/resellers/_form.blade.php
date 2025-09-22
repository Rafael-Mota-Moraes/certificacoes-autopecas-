@php
    $isEdit = isset($reseller) && $reseller->id;
    $action = $isEdit ? route('resellers.update', $reseller) : route('resellers.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<form action="{{ $action }}" method="POST" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method($method)

    <div class="flex flex-col lg:flex-row lg:space-x-12">
        <div class="w-full lg:w-1/2 space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">*Nome:</label>
                <input type="text" name="name" value="{{ old('name', $reseller->name ?? '') }}" required class="...">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="cnpj" class="block text-sm font-medium text-gray-700">*CNPJ:</label>
                <input type="text" name="cnpj" value="{{ old('cnpj', $reseller->cnpj ?? '') }}" required class="...">
                @error('cnpj') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

             <div>
                <label for="street" class="block text-sm font-medium text-gray-700">Rua:</label>
                <input type="text" id="street" name="street" value="{{ old('street', $reseller->address->street ?? '') }}" class="...">
            </div>

        </div>

        <div class="w-full lg:w-1/2 mt-8 lg:mt-0">
                 for simplicity we'll focus on the main fields first. --}}
        </div>
    </div>

    <div class="flex items-center justify-center space-x-6 pt-6 border-t border-gray-200">
        <button type="button" class="text-gray-600 font-medium hover:text-gray-900 transition-colors close-modal-btn">
            Cancelar
        </button>
        <button type="submit" class="bg-[#840032] rounded-md text-white font-bold ...">
            {{ $isEdit ? 'Atualizar' : 'Cadastrar' }}
        </button>
    </div>
</form>
