<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row">
        <div class="col">
            <button class="btn btn-success btnCadPlot" id="btnCad">Cadastrar</button>
        </div>
    </div>
    <div class="row g-4 justify-content-center">
        @if ($crops->isEmpty())
          <p>Nenhuma Safra Cadastrada</p>
        @else
          <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Data Plantio</th>
                    <th scope="col">Data Colheita</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($crops as $crop)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $crop->name }}</td>
                  <td>{{ $crop->planting_date->format('d/m/Y') }}</td>
                  <td>{{ $crop->harvest_date->format('d/m/Y') }}</td>

                  <td class="text-center">
                      <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewCropModal"
                      data-id="{{ $crop->id }}"
                      data-name="{{ $crop->name }}"
                      data-planting="{{ $crop->planting_date }}"
                      data-harvest="{{ $crop->harvest_date }}"
                      {{-- data-plot="{{ $crop->plot_id }}" --}}
                      >Visualizar</button>
                      <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCropModal"
                      data-id="{{ $crop->id }}"
                      data-name="{{ $crop->name }}"
                      data-planting="{{ $crop->planting_date }}"
                      data-harvest="{{ $crop->harvest_date }}"
                      {{-- data-plot="{{ $crop->plot_id }}"  --}}
                      >Atualizar
                      </button>
                      <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCropModal"
                      data-id="{{ $crop->id }}"
                      data-name="{{ $crop->name }}"
                      data-planting="{{ $crop->planting_date }}"
                      data-harvest="{{ $crop->harvest_date }}"
                      {{-- data-plot="{{ $crop->plot_id }}" --}}
                      >Deletar</button>
                      </button>
                      <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reportModal"
                      data-id="{{ $crop->id }}"
                      >Relatório Safra</button>
                  </td>
                </tr>  
              @endforeach
          @endif
        </tbody>
      </table>
    </div>

    

    <!-- Modal de CREATE -->
    <div class="modal fade" id="createCropModal" tabindex="-1" aria-labelledby="createCropModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('crop.register') }}">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editCropModalLabel">Cadastrar Safra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <div class="space-y-4">
                    <!-- Nome -->
                    <div class="flex items-center">
                        <label for="name" class="w-32 font-medium text-gray-700">Cultura</label>
                        <div class="flex-1">
                            <x-text-input id="name" class="w-full form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Data Plantio -->
                    <div class="flex items-center">
                        <label for="location" class="w-32 font-medium text-gray-700">Data Plantio</label>
                        <div class="flex-1">
                            <input id="planting" class="w-full form-control" type="date" name="plantingDate" :value="old('plantingDate')" required autocomplete="location" />
                            <x-input-error :messages="$errors->get('plantingDate')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Data Colheita -->
                    <div class="flex items-center">
                        <label for="location" class="w-32 font-medium text-gray-700">Data Colheita</label>
                        <div class="flex-1">
                            <input id="haverstDate" class="w-full form-control" type="date" name="harvestDate" :value="old('harvestDate')" required autocomplete="location" />
                            <x-input-error :messages="$errors->get('harvestDate')" class="mt-1" />
                        </div>
                    </div>

                    {{-- <!-- Área -->
                    <div class="flex items-center">
                        <div class="flex-1">
                            <label for="area" class="w-32 font-medium text-gray-700">Área</label>
                            <select class="form-select" id="inputGroupSelect01" name="plot">
                                <option selected>Escolha uma área</option>
                                @foreach ($plots as $plot)
                                    <option value="{{ $plot->id }}">{{ $plot->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
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
    <div class="modal fade" id="viewCropModal" tabindex="-1" aria-labelledby="viewCropModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cropModalLabel">Detalhes da Safra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- CROP NAME -->
              <div class="flex items-center">
                  <label for="view-crop-name" class="w-32 font-medium text-gray-700">Safra</label>
                  <div class="flex-1">
                      <x-text-input id="view-crop-name" class="w-full form-control" type="text" name="view-crop-name" :value="old('view-crop-name')" required autofocus autocomplete="view-crop-name" disabled />
                      <x-input-error :messages="$errors->get('view-crop-name')" class="mt-1" />
                  </div>
              </div>

              <!-- CROP PLANTING DATE -->
              <div class="flex items-center">
                  <label for="view-crop-planting" class="w-32 font-medium text-gray-700">Data Inicio</label>
                  <div class="flex-1">
                      <x-text-input id="view-crop-planting" class="w-full form-control" type="date" name="view-crop-planting" :value="old('view-crop-planting')" required autofocus autocomplete="view-crop--planting" disabled />
                      <x-input-error :messages="$errors->get('view-crop-planting')" class="mt-1" />
                  </div>
              </div>

              <!-- CROP HARVESTING DATE -->
              <div class="flex items-center">
                  <label for="view-crop-harvest" class="w-32 font-medium text-gray-700">Data Final</label>
                  <div class="flex-1">
                      <x-text-input id="view-crop-harvest" class="w-full form-control" type="date" name="view-crop-harvest" :value="old('view-crop-harvest')" required autofocus autocomplete="view-crop-harvest" disabled />
                      <x-input-error :messages="$errors->get('view-crop-harvest')" class="mt-1" />
                  </div>
              </div>

              {{-- <!-- CROP PLOT -->
              <div class="flex items-center">
                  <label for="view-crop-plot" class="w-32 font-medium text-gray-700">Safra</label>
                  <div class="flex-1">
                      <x-text-input id="view-crop-plot" class="w-full form-control" type="text" name="view-crop-plot" :value="old('view-crop-plot')" required autofocus autocomplete="view-crop-plot" disabled />
                      <x-input-error :messages="$errors->get('view-crop-plot')" class="mt-1" />
                  </div>
              </div>--}}
            </div> 
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editCropModal" tabindex="-1" aria-labelledby="editCropModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('crop.update', 0) }}" id="editCropForm">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editPlotModalLabel">Editar Safra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="edit-crop-id">

              <div class="mb-3">
                <label for="edit-plot-name" class="form-label">Cultura</label>
                <input type="text" class="form-control" name="name" id="edit-crop-name" required>
              </div>

              <div class="mb-3">
                <label for="edit-plot-area" class="form-label">Data Inicio</label>
                <input type="date" class="form-control" name="planting" id="edit-crop-plantingDate" step="0.01" required>
              </div>

              <div class="mb-3">
                <label for="edit-plot-area" class="form-label">Data Final</label>
                <input type="date" class="form-control" name="harvest" id="edit-crop-harvestDate" step="0.01" required>
              </div>

              <!-- Área -->
              {{-- <div class="flex items-center">
                <label for="area" class="w-32 font-medium text-gray-700">Área</label>
                <div class="flex-1">
                    <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    <select class="form-select" id="edit-crop-plot" name="plot">
                        <option selected>Escolha uma área</option>
                        @foreach ($plots as $plot)
                            <option value="{{ $plot->id }}">{{ $plot->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div> --}}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Atualizar</button>
            </div>
          </div>
        </form>
      </div>
    </div>


    <!-- MODAL DELETE -->
    <div class="modal fade" id="deleteCropModal" tabindex="-1" aria-labelledby="deleteCropModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('crop.delete', 0) }}" id="deleteCropForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Deseja realmente deletar esta safra ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- CROP NAME -->
              <div class="flex items-center">
                  <label for="delete-crop-name" class="w-32 font-medium text-gray-700">Safra</label>
                  <div class="flex-1">
                      <x-text-input id="delete-crop-name" class="w-full form-control" type="text" name="delete-crop-name" :value="old('delete-crop-name')" required autofocus autocomplete="delete-crop-name" disabled />
                      <x-input-error :messages="$errors->get('delete-crop-name')" class="mt-1" />
                  </div>
              </div>

              <!-- CROP PLANTING DATE -->
              <div class="flex items-center">
                  <label for="delete-crop-planting" class="w-32 font-medium text-gray-700">Data Inicio</label>
                  <div class="flex-1">
                      <x-text-input id="delete-crop-planting" class="w-full form-control" type="date" name="delete-crop-planting" :value="old('delete-crop-planting')" required autofocus autocomplete="delete-crop--planting" disabled />
                      <x-input-error :messages="$errors->get('delete-crop-planting')" class="mt-1" />
                  </div>
              </div>

              <!-- CROP HARVESTING DATE -->
              <div class="flex items-center">
                  <label for="delete-crop-harvest" class="w-32 font-medium text-gray-700">Data Fim</label>
                  <div class="flex-1">
                      <x-text-input id="delete-crop-harvest" class="w-full form-control" type="date" name="delete-crop-harvest" :value="old('delete-crop-harvest')" required autofocus autocomplete="delete-crop-harvest" disabled />
                      <x-input-error :messages="$errors->get('delete-crop-harvest')" class="mt-1" />
                  </div>
              </div>
              
              {{-- <!-- CROP PLOT -->
              <div class="flex items-center">
                  <label for="delete-crop-plot" class="w-32 font-medium text-gray-700">Safra</label>
                  <div class="flex-1">
                      <x-text-input id="delete-crop-plot" class="w-full form-control" type="text" name="delete-crop-plot" :value="old('delete-crop-plot')" required autofocus autocomplete="delete-crop-plot" disabled />
                      <x-input-error :messages="$errors->get('delete-crop-plot')" class="mt-1" />
                  </div>
              </div> --}}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Deletar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- MODAL Report -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="viewReportModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="reportModalLabel">Detalhes da Safra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- CROP NAME -->
              <div class="flex items-center">
                  <label for="dieselTotal" class="w-32 font-medium text-gray-700">Valor Total Diesel</label>
                  <div class="flex-1">
                      <x-text-input id="dieselTotal" class="w-full form-control" type="text" name="dieselTotal" readOnly />
                  </div>
              </div>

              <!-- SPEND ADUBADAÇÃO -->
              <div class="flex items-center">
                  <label for="spendFertilization" class="w-32 font-medium text-gray-700">Gastos Adubação</label>
                  <div class="flex-1">
                      <x-text-input id="spendFertilization" class="w-full form-control" type="text" name="spendFertilization" readOnly />
                  </div>
              </div>

              <!-- CROP NAME -->
              <div class="flex items-center">
                  <label for="spendHarvest" class="w-32 font-medium text-gray-700">Gastos Colheita</label>
                  <div class="flex-1">
                      <x-text-input id="spendHarvest" class="w-full form-control" type="text" name="spendHarvest" readOnly />
                  </div>
              </div>

              <!-- CROP NAME -->
              <div class="flex items-center">
                  <label for="spendPlanting" class="w-32 font-medium text-gray-700">Gastos Plantio</label>
                  <div class="flex-1">
                      <x-text-input id="spendPlanting" class="w-full form-control" type="text" name="spendPlanting" readOnly />
                  </div>
              </div>

              <!-- CROP NAME -->
              <div class="flex items-center">
                  <label for="spendPulverization" class="w-32 font-medium text-gray-700">Gastos Pulverização</label>
                  <div class="flex-1">
                      <x-text-input id="spendPulverization" class="w-full form-control" type="text" name="spendPulverization" readOnly />
                  </div>
              </div>
            </div> 
            <div class="modal-footer">
            </div>
          </div>
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
                    const modal = new bootstrap.Modal(document.getElementById('createCropModal'));
                    modal.show();
                }
            });
        });
    </script>

<script>
  const createPlotModal = document.getElementById('createCropModal');
  createPlotModal.addEventListener('show.bs.modal', function (event) {

  });

  // Modal VIEW
  const viewCropModal = document.getElementById('viewCropModal');
  viewCropModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const planting = button.getAttribute('data-planting');
    const harvest = button.getAttribute('data-harvest');
    const plot = button.getAttribute('data-plot');

    let formattedDatePlanting = new Date(planting).toISOString().split('T')[0];
    let formattedDateHarvest = new Date(harvest).toISOString().split('T')[0];

    document.getElementById('view-crop-name').value = name;
    document.getElementById('view-crop-planting').value = formattedDatePlanting;
    document.getElementById('view-crop-harvest').value = formattedDateHarvest;
    document.getElementById('view-crop-plot').value = plot;
  });

  //Editar
  const editModal = document.getElementById('editCropModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const planting = button.getAttribute('data-planting');
    const harvest = button.getAttribute('data-harvest');
    const plot = button.getAttribute('data-plot');

    let formattedDatePlanting = new Date(planting).toISOString().split('T')[0];
    let formattedDateHarvest = new Date(harvest).toISOString().split('T')[0];

    document.getElementById('edit-crop-id').value = id;
    document.getElementById('edit-crop-name').value = name;
    document.getElementById('edit-crop-plantingDate').value = formattedDatePlanting;
    document.getElementById('edit-crop-harvestDate').value = formattedDateHarvest;
    document.getElementById('edit-crop-plot').value = plot;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('editCropForm');
    form.action = `/crops/${id}`;
  });


  //DELETE
  const deleteCropModal = document.getElementById('deleteCropModal');
  deleteCropModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const planting = button.getAttribute('data-planting');
    const harvest = button.getAttribute('data-harvest');
    const plot = button.getAttribute('data-plot');

    let formattedDatePlanting = new Date(planting).toISOString().split('T')[0];
    let formattedDateHarvest = new Date(harvest).toISOString().split('T')[0];

    document.getElementById('delete-crop-name').value = name;
    document.getElementById('delete-crop-planting').value = formattedDatePlanting;
    document.getElementById('delete-crop-harvest').value = formattedDateHarvest;
    document.getElementById('delete-crop-plot').value = plot;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('deleteCropForm');
    form.action = `/crops/${id}`; // Certifique-se que essa rota DELETE existe
  });


  document.addEventListener('DOMContentLoaded', function () {
    const dieselModal = document.getElementById('reportModal');

    dieselModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const cropId = button.getAttribute('data-id');

        console.log(cropId);

        // Atualiza o modal antes de carregar
        document.getElementById('dieselTotal').value = 'Carregando...';

        // Faz a requisição AJAX
        fetch(`/crop/report/${cropId}`)
            .then(response => {
              console.log(response);
                if (!response.ok) {
                    throw new Error('Erro ao buscar relatório.');
                }
                
                return response.json();
            })
            .then(data => {
                document.getElementById('dieselTotal').value = 'R$ '+ data.total_diesel_cost;
                // Acessa o objeto spend_per_type
                const spendPerType = data.spend_per_type;

                for (const tipo in spendPerType) {
                  if (spendPerType.hasOwnProperty(tipo)) {
                    const valor = spendPerType[tipo];
                    console.log(`Tipo: ${tipo}, Gasto: R$ ${spendPerType[tipo]}`);
                    if (tipo === 'adubador') {
                      document.getElementById('spendFertilization').value = 'R$ '+valor;
                    } else if (tipo === 'colheitadeira') {
                      document.getElementById('spendHarvest').value = 'R$ '+valor;
                    } else if (tipo === 'plantadeira') {
                      document.getElementById('spendPlanting').value = 'R$ '+valor;
                    } else if (tipo === 'pulverizador') {
                      document.getElementById('spendPulverization').value = 'R$ '+valor;
                    }
                  }
                }

            })
            .catch(error => {
                document.getElementById('dieselTotal').textContent = 'Erro ao carregar.';
                console.error(error);
            });
        });
  });
</script>
    <!-- FIM CARDS-->
</x-layout>
