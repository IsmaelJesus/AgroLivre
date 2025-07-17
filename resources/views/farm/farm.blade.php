<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row">
        <div class="col">
            <button class="btn btn-success btnCadPlot" data-bs-toggle="modal" data-bs-target="#creatFarmModal">Cadastrar</button>
        </div>
    </div>
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            @if ($farms->isEmpty())
              <p>Nenhuma Fazenda Cadastrada</p>
            @else
              @foreach ($farms as $farm)
                <!-- Expert -->
                <div class="col-md-3">
                  <div class="pricing-card">
                      <svg class="plot-icon" id="fi_12119142" enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m496.2 199.72c-1.07-1.86-3.05-3-5.2-3h-200.99c-.02 0-.04 0-.06 0l-55.86.56c5.52-8.73 9.81-18.19 9.81-28.49 0-25.84-21.02-46.86-46.86-46.86s-46.86 21.02-46.86 46.86c0 10.64 4.58 20.38 10.35 29.34-1.41.27-2.68 1.03-3.58 2.17l-75.16 95.54c-.22.24-.43.5-.61.78l-64.89 82.48c-1.41 1.8-1.68 4.24-.69 6.31.99 2.06 3.07 3.38 5.35 3.4l136.7 1.26h.06 228.12c2.14 0 4.12-1.14 5.19-2.99l105.17-181.36c1.08-1.85 1.08-4.14.01-6zm-299.16-65.79c19.22 0 34.86 15.64 34.86 34.86 0 12.12-8.82 23.94-17.35 35.37-2.79 3.73-5.67 7.59-8.19 11.41l-9.31 14.07-9.31-14.08c-2.53-3.82-5.41-7.68-8.19-11.41-8.53-11.43-17.35-23.25-17.35-35.37-.02-19.22 15.62-34.85 34.84-34.85zm-32.44 76.05 4.28-.04c.35.46.69.93 1.04 1.39 2.81 3.77 5.46 7.32 7.8 10.86l14.32 21.64c1.11 1.68 2.99 2.69 5 2.69s3.89-1.01 5-2.69l14.32-21.64c2.34-3.54 4.99-7.09 7.8-10.86.48-.65.97-1.3 1.46-1.96l52.49-.53-63.16 86.58-116.49-1.36zm-75.49 95.96 117.17 1.37-51.6 70.73-121.41-1.12zm293.26 72.13h-212.86l82.89-113.62c.14.01.28.02.42.02h19.79c.62 15.65 10.86 29.37 19.93 41.53 2.85 3.81 5.53 7.41 7.9 10.99l14.49 21.9c1.11 1.68 2.99 2.69 5 2.69s3.89-1.01 5-2.69l14.49-21.9c2.37-3.58 5.06-7.18 7.9-10.99 9.07-12.15 19.31-25.87 19.93-41.53h80.99zm-27.08-115.09c0 12.29-8.94 24.26-17.58 35.84-2.82 3.78-5.74 7.69-8.29 11.55l-9.49 14.34-9.49-14.34c-2.56-3.86-5.47-7.77-8.29-11.55-8.64-11.58-17.58-23.55-17.58-35.84 0-19.5 15.86-35.36 35.36-35.36s35.36 15.87 35.36 35.36zm99.92-10.5h-89.1c-4.79-21.07-23.67-36.85-46.17-36.85s-41.38 15.78-46.17 36.85h-12.63l31.93-43.76h187.52zm-258.17-60.52c12.78 0 23.18-10.4 23.18-23.18s-10.4-23.18-23.18-23.18-23.18 10.4-23.18 23.18 10.4 23.18 23.18 23.18zm0-34.35c6.16 0 11.18 5.01 11.18 11.18s-5.01 11.18-11.18 11.18c-6.16 0-11.18-5.01-11.18-11.18s5.02-11.18 11.18-11.18zm122.89 81.83c-12.98 0-23.54 10.56-23.54 23.54s10.56 23.54 23.54 23.54 23.54-10.56 23.54-23.54-10.56-23.54-23.54-23.54zm0 35.08c-6.36 0-11.54-5.18-11.54-11.54s5.18-11.54 11.54-11.54 11.54 5.18 11.54 11.54-5.18 11.54-11.54 11.54z"></path></svg>
                      <h5>{{ $farm->name }}</h5>
                      <ul>
                          <li>{{ $farm->location }}</li>
                      </ul>
                    <div class="row">
                      <div class="d-flex justify-content-between gap-2 mt-3">
                          <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewFarmModal"
                          data-id="{{ $farm->id }}"
                          data-name="{{ $farm->name }}"
                          data-location="{{ $farm->location }}"
                          >Visualizar</button>
                          <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editFarmModal"
                          data-id="{{ $farm->id }}"
                          data-name="{{ $farm->name }}"
                          data-location="{{ $farm->location }}" >
                          Atualizar
                          </button>
                          <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFarmModal"
                          data-id="{{ $farm->id }}"
                          data-name="{{ $farm->name }}"
                          data-location="{{ $farm->location }}">Deletar</button>
                      </div>
                    </div>
                  </div>
                </div>
                
              @endforeach
            @endif

        </div>
    </div>

    

    <!-- Modal de CREATE -->
    <div class="modal fade" id="creatFarmModal" tabindex="-1" aria-labelledby="createFarmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('farm.register') }}">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editPlotModalLabel">Cadastrar Área</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <div class="space-y-4">
                    <!-- Nome -->
                    <div class="flex items-center">
                      <label for="name" class="w-32 font-medium text-gray-700">Nome da Propriedade</label>
                      <div class="flex-1">
                          <x-text-input id="name" class="w-full form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="culture" />
                          <x-input-error :messages="$errors->get('culture')" class="mt-1" />
                      </div>
                  </div>

                  <!-- Localizacao -->
                  <div class="flex items-center">
                    <label for="name" class="w-32 font-medium text-gray-700">Localizacao</label>
                    <div class="flex-1">
                        <x-text-input id="culture" class="w-full form-control" type="text" name="location" :value="old('culture')" required autofocus autocomplete="culture" />
                        <x-input-error :messages="$errors->get('culture')" class="mt-1" />
                    </div>
                </div>
                    <div class="modal-footer">
                      <!-- Botão -->
                      <div class="flex justify-end pt-4">
                            <button type="submit" class="btn btn-registrar">Enviar</button>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- MODAL VIEW -->
    <div class="modal fade" id="viewFarmModal" tabindex="-1" aria-labelledby="viewFarmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Detalhes da área</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- FARM NAME -->
              <div class="flex items-center">
                  <label for="view-farm-name" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="view-farm-name" class="w-full form-control" type="text" name="view-farm-name" :value="old('view-farm-name')" required autofocus autocomplete="view-farm-name" disabled />
                      <x-input-error :messages="$errors->get('view-farm-name')" class="mt-1" />
                  </div>
              </div>

              <!-- FARM LOCATION -->
              <div class="flex items-center">
                  <label for="view-farm-location" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="view-farm-location" class="w-full form-control" type="text" name="view-farm-location" :value="old('view-farm-location')" required autofocus autocomplete="view-farm-location" disabled />
                      <x-input-error :messages="$errors->get('view-farm-location')" class="mt-1" />
                  </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editFarmModal" tabindex="-1" aria-labelledby="editFarmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('plot.update', 0) }}" id="editFarmForm">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editPlotModalLabel">Editar área</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="edit-farm-id">

              <div class="mb-3">
                <label for="edit-farm-name" class="form-label">Nome</label>
                <input type="text" class="form-control" name="name" id="edit-farm-name" required>
              </div>

              <div class="mb-3">
                <label for="edit-farm-location" class="form-label">Localização</label>
                <input type="text" class="form-control" name="location" id="edit-farm-location" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <!-- MODAL DELETE -->
    <div class="modal fade" id="deleteFarmModal" tabindex="-1" aria-labelledby="deleteFarmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('farm.delete', 0) }}" id="deleteFarmForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Deseja realmente deletar esta área ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- FARM NAME -->
              <div class="flex items-center">
                  <label for="delete-farm-name" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="delete-farm-name" class="w-full form-control" type="text" name="delete-farm-name" :value="old('delete-farm-name')" required autofocus autocomplete="delete-farm-name" disabled />
                      <x-input-error :messages="$errors->get('delete-farm-name')" class="mt-1" />
                  </div>
              </div>

              <!-- FARM LOCATION -->
              <div class="flex items-center">
                  <label for="delete-farm-location" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="delete-farm-location" class="w-full form-control" type="text" name="delete-farm-location" :value="old('delete-farm-location')" required autofocus autocomplete="delete-farm-location" disabled />
                      <x-input-error :messages="$errors->get('delete-farm-location')" class="mt-1" />
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Deletar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

<script>
  const createPlotModal = document.getElementById('creatFarmModal');
  createPlotModal.addEventListener('show.bs.modal', function (event) {

  });

  //View
  const viewModal = document.getElementById('viewFarmModal');
  viewFarmModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const location = button.getAttribute('data-location');
    
    document.getElementById('view-farm-name').value = name;
    document.getElementById('view-farm-location').value = location;
  });


  //EDICAO
  const editModal = document.getElementById('editFarmModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const location = button.getAttribute('data-location');

    document.getElementById('edit-farm-id').value = id;
    document.getElementById('edit-farm-name').value = name;
    document.getElementById('edit-farm-location').value = location;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('editFarmForm');
    form.action = `/farm/${id}`;
  });


  //DELETE
  const deleteFarmModal = document.getElementById('deleteFarmModal');
  deleteFarmModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const location = button.getAttribute('data-location');

    document.getElementById('delete-farm-name').value = name;
    document.getElementById('delete-farm-location').value = location;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('deleteFarmForm');
    form.action = `/farm/${id}`; // Certifique-se que essa rota DELETE existe
  });
</script>
    <!-- FIM CARDS-->
</x-layout>
