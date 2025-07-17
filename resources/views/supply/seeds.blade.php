<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row">
        <div class="col">
            <button class="btn btn-success btnCadPlot" id="btnCad">Cadastrar</button>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        @if ($seeds->isEmpty())
          <p>Nenhuma semente cadastrada</p>
        @else
          <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Quantidade em Estoque</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Valor Total</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($seeds as $seed)
                <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $seed->name }}</td>
                        <td>{{ $seed->type }}</td>
                        <td>{{ number_format($seed->initial_stock_quantity, 2, ',', '.') . ' ' . ucfirst(\App\Enums\SeedUnityEnum::from($seed->measure_unity)->label()) }}</td>
                        <td>{{ "R$ " . number_format($seed->value, 2, ',', '.') }}</td>
                        <td id="totalValue">{{ 'R$ ' . number_format($seed->initial_stock_quantity * $seed->value,2,',','.') }}</td>
                        <td class="text-center">
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewSeedModal"
                            data-id="{{ $seed->id }}"
                            data-name="{{ $seed->name }}"
                            data-type="{{ $seed->type }}"
                            data-stock_quantity="{{ $seed->initial_stock_quantity }}"
                            data-measure_unity="{{ $seed->measure_unity }}"
                            data-value="{{ number_format($seed->value,2,',','.') }}"
                            data-pms="{{ $seed->pms }}"
                            data-germination="{{ $seed->germination }}"
                            data-vigor="{{ $seed->vigor }}"
                            >Visualizar</button>
                          <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSeedModal"
                            data-id="{{ $seed->id }}"
                            data-name="{{ $seed->name }}"
                            data-type="{{ $seed->type }}"
                            data-stock_quantity="{{ $seed->initial_stock_quantity }}"
                            data-measure_unity="{{ $seed->measure_unity }}"
                            data-value="{{ number_format($seed->value,2,',','.') }}"
                            data-pms="{{ $seed->pms }}"
                            data-germination="{{ $seed->germination }}"
                            data-vigor="{{ $seed->vigor }}"
                            data-farm_id="{{ $seed->farm_id }}" >
                            Atualizar</button>
                          <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteSeedModal"
                            data-id="{{ $seed->id }}"
                            data-name="{{ $seed->name }}"
                            data-type="{{ $seed->type }}"
                            data-stock_quantity="{{ $seed->initial_stock_quantity }}"
                            data-measure_unity="{{ $seed->measure_unity }}"
                            data-value="{{ number_format($seed->value,2,',','.') }}"
                            data-pms="{{ $seed->pms }}"
                            data-germination="{{ $seed->germination }}"
                            data-vigor="{{ $seed->vigor }}">
                            Deletar</button>
                        </td>
                    </tr>
              @endforeach
            </tbody>
          </table>
        @endif

    </div>

    <!-- Modal de CREATE -->
    <div class="modal fade" id="createSeedModal" tabindex="-1" aria-labelledby="createSeedModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('seed.register') }}">
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

                    <!-- Quantidade em Stock -->
                    <div class="flex items-center">
                      <label for="stock_quantity" class="w-32 font-medium text-gray-700">Quantidade em Estoque</label>
                      <div class="flex-1">
                          <x-text-input id="stock_quantity" class="w-full form-control" type="number" name="stock_quantity" :value="old('stock_quantity')" required autofocus autocomplete="stock_quantity" />
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
                            @foreach(\App\Enums\SeedUnityEnum::cases() as $type)
                              <option value="{{ $type->value }}">{{ ucfirst($type->value) }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <!-- Value -->
                    <div class="flex items-center">
                      <label for="value" class="w-32 font-medium text-gray-700">Valor Unitário</label>
                      <div class="flex-1">
                          <x-text-input id="value" class="w-full form-control" type="text" name="value" :value="old('value')" required autofocus autocomplete="value" />
                          <x-input-error :messages="$errors->get('value')" class="mt-1" />
                      </div>
                    </div>

                    <!-- PMS -->
                    <div class="flex items-center">
                      <label for="pms" class="w-32 font-medium text-gray-700">PMS (Peso mil sementes em g)</label>
                      <div class="flex-1">
                          <x-text-input id="pms" class="w-full form-control" type="text" name="pms" :value="old('pms')" required autofocus autocomplete="pms" />
                          <x-input-error :messages="$errors->get('pms')" class="mt-1" />
                      </div>
                    </div>

                    <!-- Germination -->
                    <div class="flex items-center">
                      <label for="germination" class="w-32 font-medium text-gray-700">Germinação</label>
                      <div class="flex-1">
                          <x-text-input id="germination" class="w-full form-control" type="text" name="germination" :value="old('germination')" required autofocus autocomplete="germination" />
                          <x-input-error :messages="$errors->get('germination')" class="mt-1" />
                      </div>
                    </div>

                    <!-- Vigor -->
                    <div class="flex items-center">
                      <label for="vigor" class="w-32 font-medium text-gray-700">Vigor</label>
                      <div class="flex-1">
                          <x-text-input id="vigor" class="w-full form-control" type="text" name="vigor" :value="old('vigor')" required autofocus autocomplete="vigor" />
                          <x-input-error :messages="$errors->get('vigor')" class="mt-1" />
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
    <div class="modal fade" id="viewSeedModal" tabindex="-1" aria-labelledby="viewSeedModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cropModalLabel">Detalhes do Insumo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <!-- Nome -->
                <div class="flex items-center">
                    <label for="view-seed-name" class="w-32 font-medium text-gray-700">Insumo</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-name" class="w-full form-control" type="text" name="view-seed-name" :value="old('view-seed-name')" required autofocus autocomplete="view-seed-name" disabled />
                        <x-input-error :messages="$errors->get('view-seed-name')" class="mt-1" />
                    </div>
                </div>
                <!-- Tipo -->
                <div class="flex items-center">
                    <label for="view-seed-type" class="w-32 font-medium text-gray-700">Tipo</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-type" class="w-full form-control" type="text" name="view-seed-type" :value="old('view-seed-type')" required autofocus autocomplete="view-seed-type" disabled />
                        <x-input-error :messages="$errors->get('view-seed-name')" class="mt-1" />
                    </div>
                </div>
                <!-- Quantidade Estoque -->
                <div class="flex items-center">
                    <label for="view-seed-stockQuantity" class="w-32 font-medium text-gray-700">Quantidade em estoque</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-stockQuantity" class="w-full form-control" type="text" name="view-seed-stockQuantity" :value="old('modal-seed-stockQuantity')" required autofocus autocomplete="modal-seed-stockQuantity" disabled />
                        <x-input-error :messages="$errors->get('modal-seed-stockQuantity')" class="mt-1" />
                    </div>
                </div>
                <!-- Unity -->
                <div class="flex items-center">
                    <label for="view-seed-unity" class="w-32 font-medium text-gray-700">Unidade</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-unity" class="w-full form-control" type="text" name="modal-seed-unity" :value="old('modal-seed-unity')" required autofocus autocomplete="view-seed-unity" disabled />
                        <x-input-error :messages="$errors->get('modal-seed-unity')" class="mt-1" />
                    </div>
                </div>

                <!-- value -->
                <div class="flex items-center">
                    <label for="view-seed-value" class="w-32 font-medium text-gray-700">Valor Unitário</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-value" class="w-full form-control" type="text" name="view-seed-value" required autofocus autocomplete="view-seed-value" disabled />
                        <x-input-error :messages="$errors->get('modal-seed-value')" class="mt-1" />
                    </div>
                </div>

                <!-- PMS -->
                <div class="flex items-center">
                    <label for="view-seed-pms" class="w-32 font-medium text-gray-700">PMS (Peso mil sementes em g)</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-pms" class="w-full form-control" type="text" name="view-seed-pms" :value="old('view-seed-pms')" required autofocus autocomplete="view-seed-pms"  readonly/>
                        <x-input-error :messages="$errors->get('pms')" class="mt-1" />
                    </div>
                </div>

                <!-- Germination -->
                <div class="flex items-center">
                    <label for="view-seed-germination" class="w-32 font-medium text-gray-700">Germinação</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-germination" class="w-full form-control" type="text" name="view-seed-germination" :value="old('view-seed-germination')" required autofocus autocomplete="view-seed-germination" readonly/>
                        <x-input-error :messages="$errors->get('view-germination')" class="mt-1" />
                    </div>
                </div>

                <!-- Vigor -->
                <div class="flex items-center">
                    <label for="view-seed-vigor" class="w-32 font-medium text-gray-700">Vigor</label>
                    <div class="flex-1">
                        <x-text-input id="view-seed-vigor" class="w-full form-control" type="text" name="view-seed-vigor" :value="old('view-seed-vigor')" required autofocus autocomplete="view-seed-vigor" readonly/>
                        <x-input-error :messages="$errors->get('view-seed-vigor')" class="mt-1" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editSeedModal" tabindex="-1" aria-labelledby="editSeedModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('seed.update', 0) }}" id="editseedForm">
          @csrf
          @method('PUT')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editPlotModalLabel">Editar Insumo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="edit-seed-id">

              <!-- Nome -->
              <div class="flex items-center">
                <label for="name" class="w-32 font-medium text-gray-700">Insumo</label>
                <div class="flex-1">
                    <x-text-input id="edit-seed-name" class="w-full form-control" type="text" name="edit-seed-name" :value="old('edit-seed-name')" required autofocus autocomplete="edit-seed-name" />
                    <x-input-error :messages="$errors->get('seed_name')" class="mt-1" />
                </div>
            </div>

            <!-- Quantidade em Stock -->
            <div class="flex items-center">
              <label for="stock_quantity" class="w-32 font-medium text-gray-700">Quantidade em Estoque</label>
              <div class="flex-1">
                  <x-text-input id="edit-seed-stockQuantity" class="w-full form-control" type="number" name="edit-seed-stockQuantity" :value="old('edit-seed-stockQuantity')" required autofocus autocomplete="edit-seed-stockQuantity" />
                  <x-input-error :messages="$errors->get('edit-seed-stockQuantity')" class="mt-1" />
              </div>
            </div>

            <!-- Unity -->
            <div class="flex items-center">
              <label for="unity" class="w-32 font-medium text-gray-700">Unidade</label>
              <div class="flex-1">
                  {{-- <x-text-input id="edit-seed-unity" class="w-full form-control" type="text" name="edit-seed-unity" :value="old('edit-seed-unity')" required autofocus autocomplete="edit-seed-unity" /> --}}
                  <x-input-error :messages="$errors->get('unity')" class="mt-1" />
                    <select class="w-full form-select form-control" id="edit-seed-unity" name="edit-seed-unity" required>
                      <option value="" disabled selected>Selecione a unidade de medida</option>
                        @foreach(\App\Enums\SeedUnityEnum::cases() as $type)
                          <option value="{{ $type->value }}">{{ ucfirst($type->value) }}</option>
                        @endforeach
                    </select>
              </div>
            </div>

            <!-- value -->
            <div class="flex items-center">
                <label for="edit-seed-value" class="w-32 font-medium text-gray-700">Valor Unitário</label>
                <div class="flex-1">
                    <x-text-input id="edit-seed-value" class="w-full form-control" type="text" name="edit-seed-value" :value="old('edit-seed-value')" required autofocus autocomplete="edit-seed-value" required />
                    <x-input-error :messages="$errors->get('edit-seed-value')" class="mt-1" />
                </div>
            </div>

            <!-- PMS -->
            <div class="flex items-center">
                <label for="edit-seed-pms" class="w-32 font-medium text-gray-700">PMS (Peso mil sementes em g)</label>
                <div class="flex-1">
                    <x-text-input id="edit-seed-pms" class="w-full form-control" type="text" name="edit-seed-pms" :value="old('edit-seed-pms')" required autofocus autocomplete="edit-seed-pms"  required/>
                    <x-input-error :messages="$errors->get('edit-seed-pms')" class="mt-1" />
                </div>
            </div>

            <!-- Germination -->
            <div class="flex items-center">
                <label for="view-seed-germination" class="w-32 font-medium text-gray-700">Germinação</label>
                <div class="flex-1">
                    <x-text-input id="edit-seed-germination" class="w-full form-control" type="text" name="edit-seed-germination" :value="old('edit-seed-germination')" required autofocus autocomplete="edit-seed-germination" required/>
                    <x-input-error :messages="$errors->get('edit-seed-germination')" class="mt-1" />
                </div>
            </div>

            <!-- Vigor -->
            <div class="flex items-center">
                <label for="edit-seed-vigor" class="w-32 font-medium text-gray-700">Vigor</label>
                <div class="flex-1">
                    <x-text-input id="edit-seed-vigor" class="w-full form-control" type="text" name="edit-seed-vigor" :value="old('edit-seed-vigor')" required autofocus autocomplete="edit-seed-vigor" required/>
                    <x-input-error :messages="$errors->get('edit-seed-vigor')" class="mt-1" />
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
    <div class="modal fade" id="deleteSeedModal" tabindex="-1" aria-labelledby="deleteSeedModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('seed.delete', 0) }}" id="deleteseedForm">
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
                      <x-text-input id="delete-seed-name" class="w-full form-control" type="text" name="delete-seed-name" :value="old('delete-seed-name')" required autofocus autocomplete="delete-seed-name" disabled />
                      <x-input-error :messages="$errors->get('delete-seed-name')" class="mt-1" />
                  </div>
              </div>
              <!-- Tipo -->
              <div class="flex items-center">
                  <label for="delete-seed-type" class="w-32 font-medium text-gray-700">Tipo</label>
                  <div class="flex-1">
                      <x-text-input id="delete-seed-type" class="w-full form-control" type="text" name="delete-seed-type" :value="old('delete-seed-type')" required autofocus autocomplete="delete-seed-type" disabled />
                      <x-input-error :messages="$errors->get('delete-seed-name')" class="mt-1" />
                  </div>
              </div>
              <!-- Quantidade Estoque -->
              <div class="flex items-center">
                  <label for="delete-seed-stockQuantity" class="w-32 font-medium text-gray-700">Quantidade em estoque</label>
                  <div class="flex-1">
                      <x-text-input id="delete-seed-stockQuantity" class="w-full form-control" type="text" name="delete-seed-stockQuantity" :value="old('delete-seed-stockQuantity')" required autofocus autocomplete="delete-seed-stockQuantity" disabled />
                      <x-input-error :messages="$errors->get('delete-seed-stockQuantity')" class="mt-1" />
                  </div>
              </div>
              <!-- Unity -->
              <div class="flex items-center">
                  <label for="delete-seed-unity" class="w-32 font-medium text-gray-700">Unidade</label>
                  <div class="flex-1">
                      <x-text-input id="delete-seed-unity" class="w-full form-control" type="text" name="delete-seed-unity" :value="old('delete-seed-unity')" required autofocus autocomplete="delete-seed-unity" disabled />
                      <x-input-error :messages="$errors->get('delete-seed-unity')" class="mt-1" />
                  </div>
              </div>
              <!-- Value -->
              <div class="flex items-center">
                  <label for="delete-seed-value" class="w-32 font-medium text-gray-700">Valor</label>
                  <div class="flex-1">
                      <x-text-input id="delete-seed-value" class="w-full form-control" type="text" name="delete-seed-value" :value="old('delete-seed-value')" required autofocus autocomplete="delete-seed-value" disabled />
                      <x-input-error :messages="$errors->get('delete-seed-value')" class="mt-1" />
                  </div>
              </div>

                <!-- PMS -->
                <div class="flex items-center">
                    <label for="delete-seed-pms" class="w-32 font-medium text-gray-700">PMS (Peso mil sementes em g)</label>
                    <div class="flex-1">
                        <x-text-input id="delete-seed-pms" class="w-full form-control" type="text" name="delete-seed-pms" :value="old('delete-seed-pms')" required autofocus autocomplete="delete-seed-pms"  readonly/>
                        <x-input-error :messages="$errors->get('delete-seed-pms')" class="mt-1" />
                    </div>
                </div>

                <!-- Germination -->
                <div class="flex items-center">
                    <label for="delete-seed-germination" class="w-32 font-medium text-gray-700">Germinação</label>
                    <div class="flex-1">
                        <x-text-input id="delete-seed-germination" class="w-full form-control" type="text" name="delete-seed-germination" :value="old('delete-seed-germination')" required autofocus autocomplete="delete-seed-germination" readonly/>
                        <x-input-error :messages="$errors->get('delete-germination')" class="mt-1" />
                    </div>
                </div>

                <!-- Vigor -->
                <div class="flex items-center">
                    <label for="delete-seed-vigor" class="w-32 font-medium text-gray-700">Vigor</label>
                    <div class="flex-1">
                        <x-text-input id="delete-seed-vigor" class="w-full form-control" type="text" name="delete-seed-vigor" :value="old('delete-seed-vigor')" required autofocus autocomplete="delete-seed-vigor" readonly/>
                        <x-input-error :messages="$errors->get('delete-seed-vigor')" class="mt-1" />
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
                    const modal = new bootstrap.Modal(document.getElementById('createSeedModal'));
                    modal.show();
                }
            });
        });
    </script>

<script src="https://unpkg.com/imask"></script>
<script>
  const createPlotModal = document.getElementById('createSeedModal');
  createPlotModal.addEventListener('show.bs.modal', function (event) {
    var inputValue = document.getElementById('value');  
    
    inputValue.addEventListener('input', () =>{
      formatarMoeda(inputValue);
    });
  });

  // Modal VIEW
  const viewCropModal = document.getElementById('viewSeedModal');
  viewCropModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const stockQuantity = button.getAttribute('data-stock_quantity');
    const measureUnity = button.getAttribute('data-measure_unity');
    const value = button.getAttribute('data-value');
    const farm = button.getAttribute('data-farm_name');
    const pms = button.getAttribute('data-pms');
    const germination = button.getAttribute('data-germination');
    const vigor = button.getAttribute('data-vigor');

    document.getElementById('view-seed-name').value = name;
    document.getElementById('view-seed-type').value = type;
    document.getElementById('view-seed-stockQuantity').value = stockQuantity;
    document.getElementById('view-seed-unity').value = measureUnity;
    document.getElementById('view-seed-value').value = value;
    document.getElementById('view-seed-pms').value = pms;
    document.getElementById('view-seed-germination').value = germination;
    document.getElementById('view-seed-vigor').value = vigor;

    maskValue('view-seed-value');
  });

  //Editar
  const editModal = document.getElementById('editSeedModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

   const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const stockQuantity = button.getAttribute('data-stock_quantity');
    const measureUnity = button.getAttribute('data-measure_unity');
    const value = button.getAttribute('data-value');
    const farm = button.getAttribute('data-farm_name');
    const pms = button.getAttribute('data-pms');
    const germination = button.getAttribute('data-germination');
    const vigor = button.getAttribute('data-vigor');

    document.getElementById('edit-seed-id').value = id;
    document.getElementById('edit-seed-name').value = name;
    document.getElementById('edit-seed-stockQuantity').value = stockQuantity;
    document.getElementById('edit-seed-unity').value = measureUnity;
    document.getElementById('edit-seed-value').value = value;
    document.getElementById('edit-seed-pms').value = pms;
    document.getElementById('edit-seed-germination').value = germination;
    document.getElementById('edit-seed-vigor').value = vigor;

    maskValue('edit-seed-value');

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('editseedForm');
    form.action = `/seed/${id}`;
  });


  //DELETE
  const deleteCropModal = document.getElementById('deleteSeedModal');
  deleteCropModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const stockQuantity = button.getAttribute('data-stock_quantity');
    const measureUnity = button.getAttribute('data-measure_unity');
    const value = button.getAttribute('data-value');
    const farm = button.getAttribute('data-farm_name');
    const pms = button.getAttribute('data-pms');
    const germination = button.getAttribute('data-germination');
    const vigor = button.getAttribute('data-vigor');

    document.getElementById('delete-seed-name').value = name;
    document.getElementById('delete-seed-type').value = type;
    document.getElementById('delete-seed-stockQuantity').value = stockQuantity;
    document.getElementById('delete-seed-unity').value = measureUnity;
    document.getElementById('delete-seed-value').value = value;
    document.getElementById('delete-seed-pms').value = pms;
    document.getElementById('delete-seed-germination').value = germination;
    document.getElementById('delete-seed-vigor').value = vigor;

    maskValue('delete-seed-value');

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('deleteseedForm');
    form.action = `/seed/${id}`; // Certifique-se que essa rota DELETE existe
});

    function maskValue(inputId) {
        const element = document.getElementById(inputId);

        // Remove máscara antiga se já existir
        if (element.maskRef) {
            element.maskRef.destroy();
        }

        const maskOptions = {
            mask: Number,
            scale: 2,
            signed: false,
            thousandsSeparator: '.',
            radix: ',',
            mapToRadix: ['.'],
            normalizeZeros: true,
            padFractionalZeros: true,
            prefix: 'R$ ',
        };

        // Cria a máscara
        const mask = IMask(element, maskOptions);

        // Salva referência para evitar múltiplas máscaras
        element.maskRef = mask;
    }
    
    formatarValorVisual('unityValue');
    formatarValorVisual('totalValue');

    function formatarValorVisual(divId) {
        const element = document.getElementById(divId);
        if (!element) return;

        const valor = parseFloat(element.textContent.replace(',', '.'));

        if (!isNaN(valor)) {
            const formatado = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL',
            }).format(valor);

            element.textContent = formatado;
        }
    }
  
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
    
  </script>

    <!-- FIM CARDS-->
</x-layout>
