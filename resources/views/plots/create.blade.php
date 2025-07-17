<x-layout>
    <form method="POST" action="{{ route('plot.register') }}">
    @csrf

    <div class="space-y-4">
        <!-- Nome -->
        <div class="flex items-center">
            <label for="name" class="w-32 font-medium text-gray-700">Nome</label>
            <div class="flex-1">
                <x-text-input id="name" class="w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
        </div>

        <!-- Localização -->
        <div class="flex items-center">
            <label for="location" class="w-32 font-medium text-gray-700">Localização</label>
            <div class="flex-1">
                <x-text-input id="location" class="w-full" type="text" name="location" :value="old('location')" required autocomplete="location" />
                <x-input-error :messages="$errors->get('location')" class="mt-1" />
            </div>
        </div>

        <!-- Área -->
        <div class="flex items-center">
            <label for="area" class="w-32 font-medium text-gray-700">Área</label>
            <div class="flex-1">
                <x-text-input id="area" class="w-full" type="text" name="area" :value="old('area')" required autocomplete="area" />
                <x-input-error :messages="$errors->get('area')" class="mt-1" />
            </div>
        </div>

        <!-- Botão -->
        <div class="flex justify-end pt-4">
               <button type="submit" class="btn btn-registrar">Enviar</button>
        </div>
    </div>
</form>
</x-layout>