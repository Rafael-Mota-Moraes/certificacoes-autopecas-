@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-700">Edit Reseller</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('resellers.update', $reseller) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Reseller Info -->
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-600">Reseller Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('name', $reseller->name) }}">
                    </div>
                    <div>
                        <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ</label>
                        <input type="text" name="cnpj" id="cnpj" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('cnpj', $reseller->cnpj) }}">
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-600">Contact Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Whatsapp</label>
                        <input type="text" name="phone" id="phone" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('phone', $reseller->contact->phone ?? '') }}">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="text" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('email', $reseller->contact->email ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Address Info -->
            <div class="md:col-span-2">
                <h2 class="text-lg font-semibold mb-2 text-gray-600">Address</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="street" class="block text-sm font-medium text-gray-700">Street</label>
                        <input type="text" name="street" id="street" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('street', $reseller->address->street ?? '') }}">
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="city" id="city" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('city', $reseller->address->city ?? '') }}">
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                        <input type="text" name="state" id="state" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('state', $reseller->address->state ?? '') }}">
                    </div>
                    <div>
                        <label for="zip_code" class="block text-sm font-medium text-gray-700">Zip Code</label>
                        <input type="text" name="zip_code" id="zip_code" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('zip_code', $reseller->address->zip_code ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('resellers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">Update Reseller</button>
        </div>
    </form>
</div>
@endsection
