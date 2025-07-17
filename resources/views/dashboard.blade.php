<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    @php
      $farms = auth()->user()->farms; // ou o método que você usa

      // Se quiser selecionar automaticamente a primeira fazenda:
      if ($farms->isNotEmpty() && !session()->has('selected_farm_id')) {
          session(['selected_farm_id' => $farms->first()->id]);
      }
    @endphp

    <!-- FIM CARDS-->
</x-layout>
            