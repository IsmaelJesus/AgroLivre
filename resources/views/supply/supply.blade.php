
@section('page-title', 'Insumos')

<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row">
        <div class="col">
            <button class="btn btn-success btnCadPlot" id="btnCad">Cadastrar</button>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        @if ($supplies->isEmpty())
          <p>Nenhum Insumo Cadastrado</p>
        @else
          <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantidade em Estoque</th>
                    <th scope="col">Valor</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($supplies as $supply)
                <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $supply->name }}</td>
                        <td>{{ $supply->type }}</td>
                        <td>{{ number_format($supply->initial_stock_quantity, 2, ',', '.') . ' ' . ucfirst($supply->measure_unity) }}</td>
                        <td>{{ "R$ " . number_format($supply->value, 2, ',', '.') }}</td>
                        
                        <td class="text-center">
                          <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewSupplyModal"
                          data-id="{{ $supply->id }}"
                          data-name="{{ $supply->name }}"
                          data-type="{{ $supply->type }}"
                          data-stock_quantity="{{ $supply->initial_stock_quantity }}"
                          data-measure_unity="{{ $supply->measure_unity }}"
                          data-value="{{ number_format($supply->value,2,',','.') }}"
                          data-farm_name="{{ $supply->farm->name }}"
                          >Visualizar</button>
                          <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSupplyModal"
                          data-id="{{ $supply->id }}"
                          data-name="{{ $supply->name }}"
                          data-type="{{ $supply->type }}"
                          data-stock_quantity="{{ $supply->initial_stock_quantity }}"
                          data-measure_unity="{{ $supply->measure_unity }}"
                          data-value="{{ number_format($supply->value,2,',','.') }}"
                          data-farm_id="{{ $supply->farm_id }}" >
                          Atualizar</button>
                          <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSupplyModal"
                          data-id="{{ $supply->id }}"
                          data-name="{{ $supply->name }}"
                          data-type="{{ $supply->type }}"
                          data-stock_quantity="{{ $supply->initial_stock_quantity }}"
                          data-measure_unity="{{ $supply->measure_unity }}"
                          data-value="{{ number_format($supply->value,2,',','.') }}"
                          data-farm_id="{{ $supply->farm_id }}">
                          Deletar</button>
                        </td>
                    </tr>
              @endforeach
            </tbody>
          </table>
        @endif

    </div>

    

    <!-- Modal de CREATE -->
    <div class="modal fade" id="createCropModal" tabindex="-1" aria-labelledby="createCropModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('supply.register') }}">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editCropModalLabel">Cadastrar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <div class="space-y-4">
                    <!-- Nome -->
                    <div class="flex items-center">
                        <label for="name" class="w-32 font-medium text-gray-700">Insumo</label>
                        <div class="flex-1">
                            <x-text-input id="name" class="w-full form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('culture')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Tipo -->
                    <div class="flex items-center">
                      <label for="type" class="w-32 font-medium text-gray-700">Tipo</label>
                      <div class="flex-1">
                          <select class="w-full form-select form-control" id="type" name="type" required>
                            <option value="" disabled selected>Selecione o tipo do insumo</option>
                            @foreach(\App\Enums\TypeSupplyEnum::cases() as $type)
                              <option value="{{ $type->value }}">{{ ucfirst($type->value) }}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>

                    <!-- Quantidade em Stock -->
                    <div class="flex items-center">
                      <label for="stock_quantity" class="w-32 font-medium text-gray-700">Quantidade em Estoque</label>
                      <div class="flex-1">
                          <x-text-input id="stock_quantity" class="w-full form-control" type="text" name="stock_quantity" :value="old('stock_quantity')" required autofocus autocomplete="stock_quantity" />
                          <x-input-error :messages="$errors->get('stock_quantity')" class="mt-1" />
                      </div>
                    </div>

                    <!-- Unity -->
                    <div class="flex items-center">
                      <label for="unity" class="w-32 font-medium text-gray-700">Unidade</label>
                      <div class="flex-1">
                          <x-input-error :messages="$errors->get('unity')" class="mt-1" />
                          <select class="w-full form-select form-control" id="unity" name="unity" required>
                          <option value="" disabled selected>Selecione a unidade de medida</option>
                            @foreach(\App\Enums\SupplyUnityEnum::cases() as $type)
                              <option value="{{ $type->value }}">{{ ucfirst($type->value) }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <!-- Value -->
                    <div class="flex items-center">
                      <label for="value" class="w-32 font-medium text-gray-700">Valor</label>
                      <div class="flex-1">
                          <x-text-input id="value" class="w-full form-control" type="text" name="value" :value="old('value')" required autofocus autocomplete="value" />
                          <x-input-error :messages="$errors->get('value')" class="mt-1" />
                      </div>
                    </div>

                    <div class="modal-footer">
                      <!-- Botão -->
                      <div class="flex justify-end pt-4">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- MODAL VIEW -->
    <div class="modal fade" id="viewSupplyModal" tabindex="-1" aria-labelledby="viewCropModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cropModalLabel">Detalhes do Insumo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- Nome -->
              <div class="flex items-center">
                  <label for="name" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="modal-supply-name" class="w-full form-control" type="text" name="modal-supply-name" :value="old('modal-supply-name')" required autofocus autocomplete="modal-supply-name" disabled />
                      <x-input-error :messages="$errors->get('modal-supply-name')" class="mt-1" />
                  </div>
              </div>
              <!-- Tipo -->
              <div class="flex items-center">
                  <label for="modal-supply-type" class="w-32 font-medium text-gray-700">Tipo</label>
                  <div class="flex-1">
                      <x-text-input id="modal-supply-type" class="w-full form-control" type="text" name="modal-supply-type" :value="old('modal-supply-type')" required autofocus autocomplete="modal-supply-type" disabled />
                      <x-input-error :messages="$errors->get('modal-supply-name')" class="mt-1" />
                  </div>
              </div>
              <!-- Quantidade Estoque -->
              <div class="flex items-center">
                  <label for="modal-supply-stockQuantity" class="w-32 font-medium text-gray-700">Quantidade em estoque</label>
                  <div class="flex-1">
                      <x-text-input id="modal-supply-stockQuantity" class="w-full form-control" type="text" name="modal-supply-stockQuantity" :value="old('modal-supply-stockQuantity')" required autofocus autocomplete="modal-supply-stockQuantity" disabled />
                      <x-input-error :messages="$errors->get('modal-supply-stockQuantity')" class="mt-1" />
                  </div>
              </div>
              <!-- Unity -->
              <div class="flex items-center">
                  <label for="modal-supply-unity" class="w-32 font-medium text-gray-700">Unidade</label>
                  <div class="flex-1">
                      <x-text-input id="modal-supply-unity" class="w-full form-control" type="text" name="modal-supply-unity" :value="old('modal-supply-unity')" required autofocus autocomplete="modal-supply-unity" disabled />
                      <x-input-error :messages="$errors->get('modal-supply-unity')" class="mt-1" />
                  </div>
              </div>
              <!-- value -->
              <div class="flex items-center">
                  <label for="modal-supply-value" class="w-32 font-medium text-gray-700">Valor</label>
                  <div class="flex-1">
                      <x-text-input id="modal-supply-value" class="w-full form-control" type="text" name="modal-supply-value" :value="old('modal-supply-value')" required autofocus autocomplete="modal-supply-value" disabled />
                      <x-input-error :messages="$errors->get('modal-supply-value')" class="mt-1" />
                  </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editSupplyModal" tabindex="-1" aria-labelledby="editSupplyModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('supply.update', 0) }}" id="editSupplyForm">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editPlotModalLabel">Editar Insumo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="edit-supply-id">

              <!-- Nome -->
              <div class="flex items-center">
                <label for="name" class="w-32 font-medium text-gray-700">Insumo</label>
                <div class="flex-1">
                    <x-text-input id="edit-supply-name" class="w-full form-control" type="text" name="edit-supply-name" :value="old('edit-supply-name')" required autofocus autocomplete="edit-supply-name" />
                    <x-input-error :messages="$errors->get('supply_name')" class="mt-1" />
                </div>
            </div>

            <!-- Tipo -->
            <div class="flex items-center">
              <label for="type" class="w-32 font-medium text-gray-700">Tipo</label>
              <div class="flex-1">
                  {{-- <x-text-input id="edit-supply-type" class="w-full form-control" type="text" name="edit-supply-type" :value="old('edit-supply-type')" required autofocus autocomplete="edit-supply-type" /> --}}
                  <select class="w-full form-select form-control" id="edit-supply-type" name="edit-supply-type" required>
                    <option value="" disabled selected>Selecione o tipo do insumo</option>
                    @foreach(\App\Enums\TypeSupplyEnum::cases() as $type)
                      <option value="{{ $type->value }}">{{ ucfirst($type->value) }}</option>
                    @endforeach
                  </select>
                  <x-input-error :messages="$errors->get('type')" class="mt-1" />
              </div>
          </div>

            <!-- Quantidade em Stock -->
            <div class="flex items-center">
              <label for="stock_quantity" class="w-32 font-medium text-gray-700">Quantidade em Estoque</label>
              <div class="flex-1">
                  <x-text-input id="edit-supply-stockQuantity" class="w-full form-control" type="text" name="edit-supply-stockQuantity" :value="old('edit-supply-stockQuantity')" required autofocus autocomplete="edit-supply-stockQuantity" />
                  <x-input-error :messages="$errors->get('edit-supply-stockQuantity')" class="mt-1" />
              </div>
            </div>

            <!-- Unity -->
            <div class="flex items-center">
              <label for="unity" class="w-32 font-medium text-gray-700">Unidade</label>
              <div class="flex-1">
                  {{-- <x-text-input id="edit-supply-unity" class="w-full form-control" type="text" name="edit-supply-unity" :value="old('edit-supply-unity')" required autofocus autocomplete="edit-supply-unity" /> --}}
                  <x-input-error :messages="$errors->get('unity')" class="mt-1" />
                    <select class="w-full form-select form-control" id="edit-supply-unity" name="edit-supply-unity" required>
                      <option value="" disabled selected>Selecione a unidade de medida</option>
                        @foreach(\App\Enums\SupplyUnityEnum::cases() as $type)
                          <option value="{{ $type->value }}">{{ ucfirst($type->value) }}</option>
                        @endforeach
                    </select>
              </div>
            </div>

            <!-- Value -->
            <div class="flex items-center">
              <label for="edit-supply_value" class="w-32 font-medium text-gray-700">Valor</label>
              <div class="flex-1">
                  <x-text-input id="edit-supply_value" class="w-full form-control" type="text" name="edit-supply_value" :value="old('edit-supply_')" required autofocus autocomplete="edit-supply_" />
                  <x-input-error :messages="$errors->get('edit-supply_')" class="mt-1" />
              </div>
            </div>

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
    <div class="modal fade" id="deleteSupplyModal" tabindex="-1" aria-labelledby="deleteSupplyModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('supply.delete', 0) }}" id="deleteSupplyForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Deseja realmente deletar este insumo ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- Nome -->
              <div class="flex items-center">
                  <label for="name" class="w-32 font-medium text-gray-700">Insumo</label>
                  <div class="flex-1">
                      <x-text-input id="delete-supply-name" class="w-full form-control" type="text" name="delete-supply-name" :value="old('delete-supply-name')" required autofocus autocomplete="delete-supply-name" disabled />
                      <x-input-error :messages="$errors->get('delete-supply-name')" class="mt-1" />
                  </div>
              </div>
              <!-- Tipo -->
              <div class="flex items-center">
                  <label for="delete-supply-type" class="w-32 font-medium text-gray-700">Tipo</label>
                  <div class="flex-1">
                      <x-text-input id="delete-supply-type" class="w-full form-control" type="text" name="delete-supply-type" :value="old('delete-supply-type')" required autofocus autocomplete="delete-supply-type" disabled />
                      <x-input-error :messages="$errors->get('delete-supply-name')" class="mt-1" />
                  </div>
              </div>
              <!-- Quantidade Estoque -->
              <div class="flex items-center">
                  <label for="delete-supply-stockQuantity" class="w-32 font-medium text-gray-700">Quantidade em estoque</label>
                  <div class="flex-1">
                      <x-text-input id="delete-supply-stockQuantity" class="w-full form-control" type="text" name="delete-supply-stockQuantity" :value="old('delete-supply-stockQuantity')" required autofocus autocomplete="delete-supply-stockQuantity" disabled />
                      <x-input-error :messages="$errors->get('delete-supply-stockQuantity')" class="mt-1" />
                  </div>
              </div>
              <!-- Unity -->
              <div class="flex items-center">
                  <label for="delete-supply-unity" class="w-32 font-medium text-gray-700">Unidade</label>
                  <div class="flex-1">
                      <x-text-input id="delete-supply-unity" class="w-full form-control" type="text" name="delete-supply-unity" :value="old('delete-supply-unity')" required autofocus autocomplete="delete-supply-unity" disabled />
                      <x-input-error :messages="$errors->get('delete-supply-unity')" class="mt-1" />
                  </div>
              </div>
              <!-- Unity -->
              <div class="flex items-center">
                  <label for="delete-supply-value" class="w-32 font-medium text-gray-700">Valor</label>
                  <div class="flex-1">
                      <x-text-input id="delete-supply-value" class="w-full form-control" type="text" name="delete-supply-value" :value="old('delete-supply-value')" required autofocus autocomplete="delete-supply-value" disabled />
                      <x-input-error :messages="$errors->get('delete-supply-value')" class="mt-1" />
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
                    const modal = new bootstrap.Modal(document.getElementById('createCropModal'));
                    modal.show();
                }
            });
        });
    </script>

<script src="https://unpkg.com/imask"></script>
<script>
  const createPlotModal = document.getElementById('createCropModal');
  createPlotModal.addEventListener('show.bs.modal', function (event) {
    var inputValue = document.getElementById('value');  
    var inputQuantity = document.getElementById('stock_quantity')
    
    inputValue.addEventListener('input', () =>{
      formatarMoeda(inputValue);
    });


    inputQuantity.addEventListener('input', () =>{
      formataCampo(inputQuantity);
    });
  });

  // Modal VIEW
  const viewCropModal = document.getElementById('viewSupplyModal');
  viewCropModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const stock_quantity = button.getAttribute('data-stock_quantity');
    const unity = button.getAttribute('data-measure_unity');
    const value = button.getAttribute('data-value');
    const farm = button.getAttribute('data-farm_name');

    document.getElementById('modal-supply-name').value = name;
    document.getElementById('modal-supply-type').value = type;
    document.getElementById('modal-supply-stockQuantity').value = stock_quantity;
    document.getElementById('modal-supply-unity').value = unity;
    document.getElementById('modal-supply-value').value = 'R$ '+value;
    document.getElementById('modal-supply-farmName').textContent = farm;
  });

  //Editar
  const editModal = document.getElementById('editSupplyModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const stockQuantity = button.getAttribute('data-stock_quantity');
    const unity = button.getAttribute('data-measure_unity');
    const value = button.getAttribute('data-value');

    document.getElementById('edit-supply-id').value = id;
    document.getElementById('edit-supply-name').value = name;
    document.getElementById('edit-supply-type').value = type;
    document.getElementById('edit-supply-stockQuantity').value = stockQuantity;
    document.getElementById('edit-supply-unity').value = unity;
    document.getElementById('edit-supply_value').value = value;

    var inputValue = document.getElementById('edit-supply_value');  
    var inputQuantity = document.getElementById('edit-supply-stockQuantity')
    
    inputValue.addEventListener('input', () =>{
      formatarMoeda(inputValue);
    });


    inputQuantity.addEventListener('input', () =>{
      formataCampo(inputQuantity);
    });


    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('editSupplyForm');
    form.action = `/supply/${id}`;
  });


  //DELETE
  const deleteCropModal = document.getElementById('deleteSupplyModal');
  deleteCropModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const stockQuantity = button.getAttribute('data-stock_quantity');
    const measureUnity = button.getAttribute('data-measure_unity');
    const value = button.getAttribute('data-value');
    const farmId = button.getAttribute('data-farm-id');

    document.getElementById('delete-supply-name').value = name;
    document.getElementById('delete-supply-type').value = type;
    document.getElementById('delete-supply-stockQuantity').value = stockQuantity;
    document.getElementById('delete-supply-unity').value = measureUnity;
    document.getElementById('delete-supply-value').value = value;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('deleteSupplyForm');
    form.action = `/supply/${id}`; // Certifique-se que essa rota DELETE existe
  });

  function formatarMoeda(campo){
        // Remove tudo que não é número
      let valor = campo.value.replace(/\D/g, '');

      // Adiciona zeros à direita para os centavos
      valor = (Number(valor) / 100).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
      });

      campo.value = valor;
    }

    function formataCampo(campo){
        // Remove tudo que não é número
      let valor = campo.value.replace(/\D/g, '');

      // Adiciona zeros à direita para os centavos
      valor = (Number(valor) / 100).toLocaleString('pt-BR', {
        minimumFractionDigits: 2
      });

      campo.value = valor;
    }
</script>
    <!-- FIM CARDS-->
</x-layout>
