<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row">
        <div class="col">
            <button class="btn btn-success btnCadPlot" id="btnCad">Cadastrar</button>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        @if ($machinery->isEmpty())
          <p>Nenhum maquinario cadastrado</p>
        @else
          <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Horas de Uso</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($machinery as $mach)
            
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $mach->name }}</td>
                    <td>{{ $mach->type }}</td>
                    <td>{{ $mach->model }}</td>
                    <td>{{ $mach->hours_use }}</td>
                    <td id="status">{{ $mach->status == 'true' ? 'Ativo' : 'Desativado' }}</td>
                    <td class="text-center">
                      <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewMachineryModal"
                      data-id="{{ $mach->id }}"
                      data-name="{{ $mach->name }}"
                      data-type="{{ $mach->type }}"
                      data-brand="{{ $mach->brand }}"
                      data-model="{{ $mach->model }}"
                      data-acquisition="{{ $mach->acquisition_date }}"
                      data-hoursUse="{{ $mach->hours_use }}"
                      data-acquisitionValue="{{ $mach->acquisition_value }}"
                      data-usefulLife="{{ $mach->useful_life }}"
                      data-status="{{ $mach->status }}"
                      data-farm_name="{{ $mach->farm->name }}"
                      >Visualizar</button>
                      <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMachineryModal"
                      data-id="{{ $mach->id }}"
                      data-name="{{ $mach->name }}"
                      data-type="{{ $mach->type }}"
                      data-brand="{{ $mach->brand }}"
                      data-model="{{ $mach->model }}"
                      data-acquisition="{{ $mach->acquisition_date }}"
                      data-hoursUse="{{ $mach->hours_use }}"
                      data-acquisitionValue="{{ $mach->acquisition_value }}"
                      data-usefulLife="{{ $mach->useful_life }}"
                      data-status="{{ $mach->status }}"
                      data-farm_id="{{ $mach->farm_id }}" >
                      Atualizar</button>
                      <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteMachineryModal"
                      data-id="{{ $mach->id }}"
                      data-name="{{ $mach->name }}"
                      data-type="{{ $mach->type }}"
                      data-brand="{{ $mach->brand }}"
                      data-model="{{ $mach->model }}"
                      data-acquisition="{{ $mach->acquisition_date }}"
                      data-hoursUse="{{ $mach->hours_use }}"
                      data-acquisitionValue="{{ $mach->acquisition_value }}"
                      data-usefulLife="{{ $mach->useful_life }}"
                      data-status="{{ $mach->status }}"
                      data-farm_id="{{ $mach->farm_id }}">
                      Deletar</button>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
    </div>

    <!-- Modal de CREATE -->
    <div class="modal fade" id="createMachineryModal" tabindex="-1" aria-labelledby="createCropModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('machinery.register') }}">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editCropModalLabel">Cadastrar Maquinario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <div class="space-y-4">
                    <!-- Nome -->
                    <div class="flex items-center">
                        <label for="name" class="w-32 font-medium text-gray-700">Nome</label>
                        <div class="flex-1">
                            <x-text-input id="name" class="w-full form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('culture')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Tipo -->
                    <div class="flex items-center mt-2">
                      <label for="type" class="w-32 font-medium text-gray-700">Tipo</label>
                      <div class="flex-1">
                        <select class="form-select" id="type" name="type" required>
                            <option value="">Selecione um tipo de maquina</option>
                            @foreach(\App\Enums\TypeMachineryEnum::cases() as $type)
                              <option value="{{ ucfirst($type->value) }}">{{ ucfirst($type->value) }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-1" />
                      </div>
                  </div>

                    <!-- Model -->
                    <div class="flex items-center mt-2">
                      <label for="model" class="w-32 font-medium text-gray-700">Modelo</label>
                      <div class="flex-1">
                          <x-text-input id="model" class="w-full form-control" type="text" name="model" :value="old('model')" required autofocus autocomplete="model" />
                          <x-input-error :messages="$errors->get('model')" class="mt-1" />
                      </div>
                    </div>

                    <!-- Marca -->
                    <div class="flex items-center">
                        <label for="brand" class="w-32 font-medium text-gray-700">Marca</label>
                        <div class="flex-1">
                            <x-text-input id="brand" class="w-full form-control" type="text" name="brand" :value="old('brand')" required autofocus autocomplete="brand" />
                            <x-input-error :messages="$errors->get('brand')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Acquisition Date -->
                    <div class="flex items-center mt-2">
                        <label for="location" class="w-32 font-medium text-gray-700">Data Aquisição</label>
                        <div class="flex-1">
                            <input id="acquistionDate" class="w-full form-control" type="date" name="acquistionDate" :value="old('acquistionDate')" required autocomplete="acquistionDate" />
                            <x-input-error :messages="$errors->get('acquistionDate')" class="mt-1" />
                        </div>
                    </div>

                    <!-- MACHINERY Acquisition Value -->
                    <div class="flex items-center">
                        <label for="acquisitionValue" class="w-32 font-medium text-gray-700">Valor Aquisição</label>
                        <div class="flex-1">
                            <x-text-input id="acquisitionValue" class="w-full form-control" type="text" name="acquisitionValue" :value="old('acquisitionValue')" required autofocus autocomplete="acquisitionValue" />
                            <x-input-error :messages="$errors->get('acquisitionValue')" class="mt-1" />
                        </div>
                    </div>

                    <!-- MACHINERY Useful Life -->
                    <div class="flex items-center">
                        <label for="usefulLife" class="w-32 font-medium text-gray-700">Vida Útil</label>
                        <div class="flex-1">
                            <x-text-input id="usefulLife" class="w-full form-control" type="text" name="usefulLife" :value="old('usefulLife')" required autofocus autocomplete="usefulLife" />
                            <x-input-error :messages="$errors->get('usefulLife')" class="mt-1" />
                        </div>
                    </div>

                    <!-- Hours Use -->
                    <div class="flex items-center mt-2">
                      <label for="hoursUse" class="w-32 font-medium text-gray-700">Horas Trabalhadas</label>
                      <div class="flex-1">
                          <x-text-input id="hoursUse" class="w-full form-control" type="number" name="hoursUse" :value="old('hoursUse')" required autofocus autocomplete="hoursUse" />
                          <x-input-error :messages="$errors->get('hoursUse')" class="mt-1" />
                      </div>
                    </div>

                    <!-- Machinery Status -->
                    <div class="d-flex items-center mt-2">
                      <label class="w-32 font-medium text-gray-700">Status</label>
                      <div class="form-check me-3">
                        <input type="radio" name="status" id="status-true" value="true" checked>
                        <label class="form-check-label" for="status-true">
                          Ativo
                        </label>
                      </div>
                      <div class="form-check">
                        <input type="radio" name="status" id="radioCheckedDisabled" value="false">
                        <label class="form-check-label" for="radioCheckedDisabled">
                          Inativo
                        </label>
                      </div>
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
    <div class="modal fade" id="viewMachineryModal" tabindex="-1" aria-labelledby="viewMachineryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cropModalLabel">Detalhes da Safra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- FARM NAME -->
              <div class="flex items-center">
                  <label for="view-machinery-name" class="w-32 font-medium text-gray-700">Nome</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-name" class="w-full form-control" type="text" name="view-machinery-name" :value="old('view-machinery-name')" required autofocus autocomplete="view-machinery-name" disabled />
                      <x-input-error :messages="$errors->get('view-machinery-name')" class="mt-1" />
                  </div>
              </div>

              <!-- FARM TYPE -->
              <div class="flex items-center">
                  <label for="view-machinery-type" class="w-32 font-medium text-gray-700">Tipo</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-type" class="w-full form-control" type="text" name="view-machinery-type" :value="old('view-machinery-type')" required autofocus autocomplete="view-machinery-type" disabled />
                      <x-input-error :messages="$errors->get('view-machinery-type')" class="mt-1" />
                  </div>
              </div>
              
              <!-- MACHINERY BRAND -->
              <div class="flex items-center">
                  <label for="view-machinery-brand" class="w-32 font-medium text-gray-700">Marca</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-brand" class="w-full form-control" type="text" name="view-machinery-brand" :value="old('view-machinery-brand')" required autofocus autocomplete="view-machinery-brand" disabled />
                      <x-input-error :messages="$errors->get('view-machinery-brand')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY MODEL -->
              <div class="flex items-center">
                  <label for="view-machinery-model" class="w-32 font-medium text-gray-700">Modelo</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-model" class="w-full form-control" type="text" name="view-machinery-model" :value="old('view-machinery-model')" required autofocus autocomplete="view-machinery-model" disabled />
                      <x-input-error :messages="$errors->get('view-machinery-model')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY ACQUISTION DATE -->
              <div class="flex items-center">
                  <label for="view-machinery-acquisitionDate" class="w-32 font-medium text-gray-700">Data Aquisição</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-acquisitionDate" class="w-full form-control" type="date" name="view-machinery-acquisitionDate" :value="old('view-machinery-acquisitionDate')" required autofocus autocomplete="view-machinery-acquisitionDate" disabled />
                      <x-input-error :messages="$errors->get('view-machinery-acquisitionDate')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Hours Use -->
              <div class="flex items-center">
                  <label for="view-machinery-hoursUse" class="w-32 font-medium text-gray-700">Horas de Uso</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-hoursUse" class="w-full form-control" type="text" name="view-machinery-hoursUse" :value="old('view-machinery-hoursUse')" required autofocus autocomplete="view-machinery-hoursUse" disabled />
                      <x-input-error :messages="$errors->get('view-machinery-hoursUse')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Acquisition Value -->
              <div class="flex items-center">
                  <label for="view-machinery-acquisitionValue" class="w-32 font-medium text-gray-700">Valor Aquisição</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-acquisitionValue" class="w-full form-control" type="text" name="view-machinery-acquisitionValue" :value="old('view-machinery-acquisitionValue')" required autofocus autocomplete="view-machinery-acquisitionValue" readonly />
                      <x-input-error :messages="$errors->get('view-machinery-acquisitionValue')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Useful Life -->
              <div class="flex items-center">
                  <label for="view-machinery-usefulLife" class="w-32 font-medium text-gray-700">Vida Útil</label>
                  <div class="flex-1">
                      <x-text-input id="view-machinery-usefulLife" class="w-full form-control" type="text" name="view-machinery-usefulLife" :value="old('view-machinery-usefulLife')" required autofocus autocomplete="view-machinery-usefulLife" disabled />
                      <x-input-error :messages="$errors->get('view-machinery-usefulLife')" class="mt-1" />
                  </div>
              </div>

              <!-- Status -->
              <div class="d-flex items-center mt-2">
                  <label for="view-machinery-status" class="w-32 font-medium text-gray-700">Status</label>
                  <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="view-machinery-status" id="view-machinery-status-true" value="true" checked disabled>
                    <label class="form-check-label" for="view-machinery-status-true">Ativo</label>
                      Ativo
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="view-machinery-status" id="view-machinery-status-false" value="false" disabled>
                    <label class="form-check-label" for="view-machinery-status-false">
                      Desativado
                    </label>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editMachineryModal" tabindex="-1" aria-labelledby="editMachineryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form method="POST" action="{{ route('machinery.update', 0) }}" id="editMachineryForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editMachineryModalLabel">Editar Maquinario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
              <input type="hidden" name="id" id="edit-machinery-id"/>

              <!-- Nome -->
              <div class="flex items-center">
                  <label for="edit-machinery-name" class="w-32 font-medium text-gray-700">Nome</label>
                  <div class="flex-1">
                      <x-text-input id="edit-machinery-name" class="w-full form-control" type="text" name="edit-machinery-name" :value="old('edit-machinery-name')" required autofocus autocomplete="name" />
                      <x-input-error :messages="$errors->get('edit-machinery-name')" class="mt-1" />
                  </div>
              </div>

              <!-- Tipo -->
              <div class="flex items-center mt-2">
                <label for="edit-machinery-type" class="w-32 font-medium text-gray-700">Tipo</label>
                <div class="flex-1">
                    <x-text-input id="edit-machinery-type" class="w-full form-control" type="text" name="edit-machinery-type" :value="old('edit-machinery-type')" required autofocus autocomplete="type" />
                    <x-input-error :messages="$errors->get('edit-machinery-type')" class="mt-1" />
                </div>
              </div>

              <!-- Model -->
              <div class="flex items-center mt-2">
                <label for="edit-machinery-model" class="w-32 font-medium text-gray-700">Modelo</label>
                <div class="flex-1">
                    <x-text-input id="edit-machinery-model" class="w-full form-control" type="text" name="edit-machinery-model" :value="old('edit-machinery-model')" required autofocus autocomplete="model" />
                    <x-input-error :messages="$errors->get('edit-machinery-model')" class="mt-1" />
                </div>
              </div>

              <!-- Marca -->
              <div class="flex items-center">
                  <label for="edit-machinery-brand" class="w-32 font-medium text-gray-700">Marca</label>
                  <div class="flex-1">
                      <x-text-input id="edit-machinery-brand" class="w-full form-control" type="text" name="edit-machinery-brand" :value="old('edit-machinery-brand')" required autofocus autocomplete="brand" />
                      <x-input-error :messages="$errors->get('edit-machinery-brand')" class="mt-1" />
                  </div>
              </div>

              <!-- Acquisition Date -->
              <div class="flex items-center mt-2">
                  <label for="edit-machinery-location" class="w-32 font-medium text-gray-700">Data Aquisição</label>
                  <div class="flex-1">
                      <input id="edit-machinery-acquisitionDate" class="w-full form-control" type="date" name="edit-machinery-acquisitionDate" :value="old('edit-machinery-acquisitionDate')" required autocomplete="acquisitionDate" />
                      <x-input-error :messages="$errors->get('edit-machinery-acquisitionDate')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Acquisition Value -->
              <div class="flex items-center">
                  <label for="edit-machinery-acquisitionValue" class="w-32 font-medium text-gray-700">Valor Aquisição</label>
                  <div class="flex-1">
                      <x-text-input id="edit-machinery-acquisitionValue" class="w-full form-control" type="text" name="edit-machinery-acquisitionValue" :value="old('edit-machinery-acquisitionValue')" required autofocus autocomplete="edit-machinery-acquisitionValue" />
                      <x-input-error :messages="$errors->get('edit-machinery-acquisitionValue')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Useful Life -->
              <div class="flex items-center">
                  <label for="edit-machinery-usefulLife" class="w-32 font-medium text-gray-700">Vida Útil</label>
                  <div class="flex-1">
                      <x-text-input id="edit-machinery-usefulLife" class="w-full form-control" type="text" name="edit-machinery-usefulLife" :value="old('edit-machinery-usefulLife')" required autofocus autocomplete="edit-machinery-usefulLife" />
                      <x-input-error :messages="$errors->get('edit-machinery-usefulLife')" class="mt-1" />
                  </div>
              </div>

              <!-- Hours Use -->
              <div class="flex items-center mt-2">
                <label for="edit-machinery-hoursUse" class="w-32 font-medium text-gray-700">Horas trabalhadas</label>
                <div class="flex-1">
                    <x-text-input id="edit-machinery-hoursUse" class="w-full form-control" type="number" name="edit-machinery-hoursUse" :value="old('edit-machinery-hoursUse')" required autofocus autocomplete="hoursUse" />
                    <x-input-error :messages="$errors->get('edit-machinery-hoursUse')" class="mt-1" />
                </div>
              </div>

              <!-- Status -->
              <div class="d-flex items-center mt-2">
                <label for="edit-machinery-status" class="w-32 font-medium text-gray-700">Status</label>
                <div class="form-check me-3">
                  <input class="form-check-input" type="radio" name="edit-machinery-status" id="edit-machinery-status-true" value="true" checked>
                  <label class="form-check-label" for="status">
                    Ativo
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="edit-machinery-status" id="edit-machinery-status-false" value="false">
                  <label class="form-check-label" for="status">
                    Desativado
                  </label>
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
    </div>


    <!-- MODAL DELETE -->
    <div class="modal fade" id="deleteMachineryModal" tabindex="-1" aria-labelledby="deleteMachineryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('machinery.delete', 0) }}" id="deleteMachineryForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Deseja realmente deletar este maquinario ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- FARM NAME -->
              <div class="flex items-center">
                  <label for="delete-machinery-name" class="w-32 font-medium text-gray-700">Nome</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-name" class="w-full form-control" type="text" name="delete-machinery-name" :value="old('delete-machinery-name')" required autofocus autocomplete="delete-machinery-name" disabled />
                      <x-input-error :messages="$errors->get('delete-machinery-name')" class="mt-1" />
                  </div>
              </div>

              <!-- FARM TYPE -->
              <div class="flex items-center">
                  <label for="delete-machinery-type" class="w-32 font-medium text-gray-700">Tipo</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-type" class="w-full form-control" type="text" name="delete-machinery-type" :value="old('delete-machinery-type')" required autofocus autocomplete="delete-machinery-type" disabled />
                      <x-input-error :messages="$errors->get('delete-machinery-type')" class="mt-1" />
                  </div>
              </div>
              
              <!-- MACHINERY BRAND -->
              <div class="flex items-center">
                  <label for="delete-machinery-brand" class="w-32 font-medium text-gray-700">Marca</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-brand" class="w-full form-control" type="text" name="delete-machinery-brand" :value="old('delete-machinery-brand')" required autofocus autocomplete="delete-machinery-brand" disabled />
                      <x-input-error :messages="$errors->get('delete-machinery-brand')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY MODEL -->
              <div class="flex items-center">
                  <label for="delete-machinery-model" class="w-32 font-medium text-gray-700">Modelo</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-model" class="w-full form-control" type="text" name="delete-machinery-model" :value="old('delete-machinery-model')" required autofocus autocomplete="delete-machinery-model" disabled />
                      <x-input-error :messages="$errors->get('delete-machinery-model')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY ACQUISTION DATE -->
              <div class="flex items-center">
                  <label for="delete-machinery-acquisitionDate" class="w-32 font-medium text-gray-700">Data Aquisição</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-acquisitionDate" class="w-full form-control" type="date" name="delete-machinery-acquisitionDate" :value="old('delete-machinery-acquisitionDate')" required autofocus autocomplete="delete-machinery-acquisitionDate" disabled />
                      <x-input-error :messages="$errors->get('delete-machinery-acquisitionDate')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Acquisition Value -->
              <div class="flex items-center">
                  <label for="delete-machinery-acquisitionValue" class="w-32 font-medium text-gray-700">Valor Aquisição</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-acquisitionValue" class="w-full form-control" type="text" name="delete-machinery-acquisitionValue" :value="old('delete-machinery-acquisitionValue')" required autofocus autocomplete="delete-machinery-acquisitionValue" readonly />
                      <x-input-error :messages="$errors->get('delete-machinery-acquisitionValue')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Useful Life -->
              <div class="flex items-center">
                  <label for="delete-machinery-usefulLife" class="w-32 font-medium text-gray-700">Vida Útil</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-usefulLife" class="w-full form-control" type="text" name="delete-machinery-usefulLife" :value="old('delete-machinery-usefulLife')" required autofocus autocomplete="delete-machinery-usefulLife" disabled />
                      <x-input-error :messages="$errors->get('delete-machinery-usefulLife')" class="mt-1" />
                  </div>
              </div>

              <!-- MACHINERY Hours Use -->
              <div class="flex items-center">
                  <label for="delete-machinery-hoursUse" class="w-32 font-medium text-gray-700">Horas de Uso</label>
                  <div class="flex-1">
                      <x-text-input id="delete-machinery-hoursUse" class="w-full form-control" type="text" name="delete-machinery-hoursUse" :value="old('delete-machinery-hoursUse')" required autofocus autocomplete="delete-machinery-hoursUse" disabled />
                      <x-input-error :messages="$errors->get('delete-machinery-hoursUse')" class="mt-1" />
                  </div>
              </div>

              <!-- Status -->
              <div class="d-flex items-center mt-2">
                  <label for="delete-machinery-status" class="w-32 font-medium text-gray-700">Status</label>
                  <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="delete-machinery-status" id="delete-machinery-status-true" value="true" checked disabled>
                    <label class="form-check-label" for="status">
                      Ativo
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="delete-machinery-status" id="delete-machinery-status-false" value="false" disabled>
                    <label class="form-check-label" for="status">
                      Inativo
                    </label>
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
                    const modal = new bootstrap.Modal(document.getElementById('createMachineryModal'));
                    modal.show();
                }
            });
        });
    </script>

    <script src="https://unpkg.com/imask"></script>
    <script>
      const createPlotModal = document.getElementById('createMachineryModal');
      createMachineryModal.addEventListener('show.bs.modal', function (event) {
        maskValue('acquisitionValue');
      });

      // Modal VIEW
      const viewCropModal = document.getElementById('viewMachineryModal');
      viewCropModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const type = button.getAttribute('data-type');
        const brand = button.getAttribute('data-brand');
        const model = button.getAttribute('data-model');
        const acquisition = button.getAttribute('data-acquisition');
        const hoursUse = button.getAttribute('data-hoursUse');
        const acquisitionValue = button.getAttribute('data-acquisitionValue');
        const usefulLife = button.getAttribute('data-usefulLife');
        const status = button.getAttribute('data-status');
        const farm = button.getAttribute('data-farm_name');

        let formattedDateAcquisition = new Date(acquisition).toISOString().split('T')[0];

        document.getElementById('view-machinery-name').value = name;
        document.getElementById('view-machinery-type').value = type;
        document.getElementById('view-machinery-brand').value = brand;
        document.getElementById('view-machinery-model').value = model;
        document.getElementById('view-machinery-acquisitionDate').value = formattedDateAcquisition;
        document.getElementById('view-machinery-hoursUse').value = hoursUse;
        document.getElementById('view-machinery-acquisitionValue').value = acquisitionValue;
        document.getElementById('view-machinery-usefulLife').value = usefulLife;

        if (status === 'true' || status === '1') {
          document.getElementById('view-machinery-status-true').checked = true;
        } else {
          document.getElementById('view-machinery-status-false').checked = true;
        }

        maskValue('view-machinery-acquisitionValue');

      });

      //Editar
      const editModal = document.getElementById('editMachineryModal');
      editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const type = button.getAttribute('data-type');
        const brand = button.getAttribute('data-brand');
        const model = button.getAttribute('data-model');
         const acquisitionValue = button.getAttribute('data-acquisitionValue');
        const usefulLife = button.getAttribute('data-usefulLife');
        const acquisition = button.getAttribute('data-acquisition');
        const hoursUse = button.getAttribute('data-hoursUse');
        const status = button.getAttribute('data-status');

        let formattedDateAcquisition = new Date(acquisition).toISOString().split('T')[0];

        document.getElementById('edit-machinery-name').value = name;
        document.getElementById('edit-machinery-type').value = type;
        document.getElementById('edit-machinery-brand').value = brand;
        document.getElementById('edit-machinery-model').value = model;
        document.getElementById('edit-machinery-acquisitionValue').value = acquisitionValue;
        document.getElementById('edit-machinery-usefulLife').value = usefulLife;
        document.getElementById('edit-machinery-acquisitionDate').value = formattedDateAcquisition;
        document.getElementById('edit-machinery-hoursUse').value = hoursUse;
        
        if (status === 'true' || status === '1') {
          document.getElementById('edit-machinery-status-true').checked = true;
        } else {
          document.getElementById('edit-machinery-status-false').checked = true;
        }

        maskValue('edit-machinery-acquisitionValue');

        // Atualiza a action do form dinamicamente com o ID correto
        const form = document.getElementById('editMachineryForm');
        form.action = `/machinery/${id}`;
      });


      //DELETE
      const deleteModal = document.getElementById('deleteMachineryModal');
      deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const type = button.getAttribute('data-type');
        const brand = button.getAttribute('data-brand');
        const model = button.getAttribute('data-model');
        const acquisition = button.getAttribute('data-acquisition');
        const acquisitionValue = button.getAttribute('data-acquisitionValue');
        const usefulLife = button.getAttribute('data-usefulLife');
        const hoursUse = button.getAttribute('data-hoursUse');
        const status = button.getAttribute('data-status');

        // Formata a data para formato YYYY-MM-DD
        let formattedDateAcquisition = new Date(acquisition).toISOString().split('T')[0];

        document.getElementById('delete-machinery-name').value = name;
        document.getElementById('delete-machinery-type').value = type;
        document.getElementById('delete-machinery-brand').value = brand;
        document.getElementById('delete-machinery-model').value = model;
        document.getElementById('delete-machinery-acquisitionDate').value = formattedDateAcquisition;
        document.getElementById('delete-machinery-acquisitionValue').value = acquisitionValue;
        document.getElementById('delete-machinery-usefulLife').value = usefulLife;
        document.getElementById('delete-machinery-hoursUse').value = hoursUse;
        
        if (status === 'true' || status === '1') {
          document.getElementById('delete-machinery-status-true').checked = true;
        } else {
          document.getElementById('delete-machinery-status-false').checked = true;
        }

        maskValue('delete-machinery-acquisitionValue');

        // Atualiza a action do form com o id correto
        const form = document.getElementById('deleteMachineryForm');
        form.action = `/machinery/${id}`;
      });

      document.addEventListener('DOMContentLoaded', function () {
        const element = document.getElementById('view-machinery-acquisitionValue');

        
      });

      function maskValue(input){
        const element = document.getElementById(input);
        const maskOptions = {
            mask: 'R$ num',
            blocks: {
                num: {
                    mask: Number,
                    thousandsSeparator: '.',
                    radix: ',',
                    mapToRadix: ['.'],
                    scale: 2,
                    signed: false,
                    normalizeZeros: true,
                    padFractionalZeros: true,
                }
            }
        };

        const mask = IMask(element, maskOptions);
        mask.updateValue();
      }
    </script>
</x-layout>
