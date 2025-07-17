<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row">
        <div class="col">
            <button class="btn btn-success btnCadPlot" id="btnCad">Cadastrar</button>
        </div>
    </div>
    <div class="row g-4 justify-content-center">
        @if ($plots->isEmpty())
          <p>Nenhuma Área Cadastrada</p>
        @else
          <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Área</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plots as $plot)
                  <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                      <td>{{ $plot->name }}</td>
                      <td>{{ $plot->area }}</td>

                      <td class="text-center">
                          <button class="btn btn-outline-primary btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#viewPlotModal"
                      data-id="{{ $plot->id }}"
                      data-name="{{ $plot->name }}"
                      data-area="{{ $plot->area }}">
                      Visualizar
                    </button>

                    <button class="btn btn-outline-warning btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#editPlotModal"
                      data-id="{{ $plot->id }}"
                      data-name="{{ $plot->name }}"
                      data-area="{{ $plot->area }}">
                      Atualizar
                    </button>

                    <button class="btn btn-outline-danger btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#deletePlotModal"
                      data-id="{{ $plot->id }}"
                      data-name="{{ $plot->name }}"
                      data-area="{{ $plot->area }}">
                      Deletar
                    </button>
                      </td>
                  </tr>  
                @endforeach
            </tbody>
          </table>  
        @endif
    </div>

    <!-- Modal de CREATE -->
    <div class="modal fade" id="createPlotModal" tabindex="-1" aria-labelledby="createPlotModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('plot.register') }}">
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
                        <label for="name" class="w-32 font-medium text-gray-700">Nome</label>
                        <div class="flex-1">
                            <x-text-input id="name" class="w-full form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        </div>
                    </div>

                    <!-- Área -->
                    <div class="flex items-center">
                        <label for="area" class="w-32 font-medium text-gray-700">Área</label>
                        <div class="flex-1">
                            <x-text-input id="area" class="w-full form-control" type="text" name="area" :value="old('area')" required autocomplete="area" />
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
    <div class="modal fade" id="viewPlotModal" tabindex="-1" aria-labelledby="viewPlotModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Detalhes da área</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- PLOT NAME -->
              <div class="flex items-center">
                  <label for="modal-plot-name" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="modal-plot-name" class="w-full form-control" type="text" name="modal-plot-name" :value="old('modal-plot-name')" required autofocus autocomplete="modal-plot-name" disabled />
                      <x-input-error :messages="$errors->get('modal-plot-name')" class="mt-1" />
                  </div>
              </div>
              <!-- PLOT Area -->
              <div class="flex items-center">
                  <label for="modal-plot-area" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="modal-plot-area" class="w-full form-control" type="text" name="modal-plot-area" :value="old('modal-plot-area')" required autofocus autocomplete="modal-plot-area" disabled />
                      <x-input-error :messages="$errors->get('modal-plot-area')" class="mt-1" />
                  </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editPlotModal" tabindex="-1" aria-labelledby="editPlotModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('plot.update', 0) }}" id="editPlotForm">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editPlotModalLabel">Editar área</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="edit-plot-id">

              <div class="mb-3">
                <label for="edit-plot-name" class="form-label">Nome</label>
                <input type="text" class="form-control" name="name" id="edit-plot-name" required>
              </div>

              <div class="mb-3">
                <label for="edit-plot-area" class="form-label">Área</label>
                <input type="number" class="form-control" name="area" id="edit-plot-area" step="0.01" required>
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
    <div class="modal fade" id="deletePlotModal" tabindex="-1" aria-labelledby="deletePlotModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('plot.delete', 0) }}" id="deletePlotForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Deseja realmente deletar esta área ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              {{-- <p><strong>Nome:</strong> <span id="modal-delete-name"></span></p>
              <p><strong>Área:</strong> <span id="modal-delete-area"></span></p> --}}

              <!-- PLOT NAME -->
              <div class="flex items-center">
                  <label for="modal-delete-name" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="modal-delete-name" class="w-full form-control" type="text" name="modal-delete-name" :value="old('modal-delete-name')" required autofocus autocomplete="modal-delete-name" disabled />
                      <x-input-error :messages="$errors->get('modal-plot-name')" class="mt-1" />
                  </div>
              </div>
              <!-- PLOT Area -->
              <div class="flex items-center">
                  <label for="modal-delete-area" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="modal-delete-area" class="w-full form-control" type="text" name="modal-delete-area" :value="old('modal-delete-area')" required autofocus autocomplete="modal-delete-area" disabled />
                      <x-input-error :messages="$errors->get('modal-delete-area')" class="mt-1" />
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

    <!-- Modal de Alerta -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-warning-subtle">
        <div class="modal-header">
            <h5 class="modal-title" style=" color: #000;"id="alertModalLabel">Atenção</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body text-dark">
            Por favor, selecione uma fazenda antes de continuar.
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Entendi</button>
        </div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnCad = document.getElementById('btnCad');
            const farmSelect = document.getElementById('farm_id');

            btnCad.addEventListener('click', function (event) {
                if (!farmSelect.value) {
                    const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                    alertModal.show();
                } else {
                    // Abre o modal manualmente
                    const modal = new bootstrap.Modal(document.getElementById('createPlotModal'));
                    modal.show();
                }
            });
        });
    </script>



<script>
  const createPlotModal = document.getElementById('createPlotModal');
  createPlotModal.addEventListener('show.bs.modal', function (event) {

  });

  //View
  const viewModal = document.getElementById('viewPlotModal');
  viewPlotModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const area = button.getAttribute('data-area');

    document.getElementById('modal-plot-name').value = name;
    document.getElementById('modal-plot-area').value = area;
  });

  const editModal = document.getElementById('editPlotModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const area = button.getAttribute('data-area');

    document.getElementById('edit-plot-id').value = id;
    document.getElementById('edit-plot-name').value = name;
    document.getElementById('edit-plot-area').value = area;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('editPlotForm');
    form.action = `/plot/${id}`;
  });


  //DELETE
  const deletePlotModal = document.getElementById('deletePlotModal');

  deletePlotModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const area = button.getAttribute('data-area');

    document.getElementById('modal-delete-name').value = name;
    document.getElementById('modal-delete-area').value = area;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('deletePlotForm');
    form.action = `/plot/${id}`; // Certifique-se que essa rota DELETE existe
  });
</script>
    <!-- FIM CARDS-->
</x-layout>
