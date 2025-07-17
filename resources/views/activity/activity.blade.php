@php
    $role = Auth::user()->getRoleForSelectedFarm();
    $isOwner = auth()->user()->isOwner;
@endphp
<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row align-items-center">
        <!-- Botão Cadastrar -->
        <div class="col-auto">
            <button class="btn btn-success btnCadPlot" id="btnCad">
                Cadastrar
            </button>
        </div>
        <!-- Barra de Pesquisa -->
        <div class="col-6">
            <form id="searchForm" class="d-flex align-items-center">
                <div class="input-group" style="max-width: 100%;">
                    <span class="input-group-text">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="text" class="form-control" id="searchInput" name="findName" placeholder="Buscar pelo nome ..." />
                    <button type="submit" class="btn btn-green">Buscar</button>
                </div>
            </form>
        </div>
    </div>

        <div class="row g-4 justify-content-center">
            @if ($activities->isEmpty())
              <p>Nenhuma Atividade Cadastrada</p>
            @else
              <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Insumo</th>
                        <th scope="col">Data Inicio</th>
                        <th scope="col">Data Final</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="activitiesBody">
                    @foreach ($activities as $activity)
                        <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $activity->name }}</td>
                        <td>{{ \App\Enums\TypeEnum::tryFrom($activity->type)?->label() }}</td>
                        @if($activity->type == 'plantadeira')
                            <td>{{ $activity->seed->name ?? 'N/A' }}</td>
                        @else
                            <td>{{ $activity->supply->name ?? 'N/A' }}</td>
                        @endif
                        <td>{{ $activity->start_date->format('d/m/Y') }}</td>
                        <td>{{ $activity->finish_date->format('d/m/Y') }}</td>
                        
                        <td class="text-center">
                            <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewActivityModal"
                                    data-id="{{ $activity->id }}"
                                    data-name="{{ $activity->name }}"
                                    data-type="{{ \App\Enums\TypeEnum::tryFrom($activity->type)?->label() }}"
                                    data-farm="{{ $activity->farm->name }}"
                                    data-crop="{{ $activity->crop->name }}"
                                    data-plot="{{ $activity->plot->name }}"
                                    @if($activity->type == 'plantadeira')
                                        data-supply="{{ $activity->seed->name ?? 'N/A' }}"
                                    @else
                                        data-supply="{{ $activity->supply->name ?? 'N/A' }}"
                                    @endif
                                    data-estimatedSupplyValue=" {{ $activity->supply_estimated_value }}"
                                    data-user="{{ $activity->user->name }}"
                                    data-startDate="{{ $activity->start_date }}"
                                    data-finishDate="{{ $activity->finish_date }}"
                                    data-dieselValue="{{ $activity->diesel_value }}"
                                    data-observations="{{ $activity->observations }}">
                                Visualizar
                            </button>

                            <button class="btn btn-outline-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editActivityModal"
                                    data-id="{{ $activity->id }}"
                                    data-name="{{ $activity->name }}"
                                    data-type="{{ \App\Enums\TypeEnum::tryFrom($activity->type) }}"
                                    data-farm="{{ $activity->farm_id }}"
                                    data-crop="{{ $activity->crop_id }}"
                                    data-plot="{{ $activity->plot_id }}"
                                    data-user="{{ $activity->user_id }}"
                                    @if($activity->type == 'plantadeira')
                                        data-supply_name="{{ $activity->seed->name ?? 'N/A' }}"
                                        data-supply_id="{{ $activity->seed->id ?? 'N/A' }}"
                                    @else
                                        data-supply_name="{{ $activity->supply->name ?? 'N/A' }}"
                                        data-supply_id="{{ $activity->supply->id ?? 'N/A' }}"
                                    @endif
                                    data-estimatedSupplyValue=" {{ $activity->supply_estimated_value }}"
                                    data-user=" {{ $activity->supply_estimated_value }}"
                                    data-startDate="{{ $activity->start_date }}"
                                    data-finishDate="{{ $activity->finish_date }}"
                                    data-dieselValue="{{ $activity->diesel_value }}"
                                    data-observations="{{ $activity->observations }}">
                                Atualizar
                            </button>
                            @if( $role === 'admin' || $isOwner === true )
                            <button class="btn btn-outline-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteActivityModal"
                                    data-id="{{ $activity->id }}"
                                    data-name="{{ $activity->name }}"
                                    data-type="{{ \App\Enums\TypeEnum::tryFrom($activity->type)?->label() }}"
                                    data-farm="{{ $activity->farm->name }}"
                                    data-crop="{{ $activity->crop->name }}"
                                    data-plot="{{ $activity->plot->name }}"
                                    data-user="{{ $activity->user->name }}"
                                    @if($activity->type == 'plantadeira')
                                        data-supply="{{ $activity->seed->name ?? 'N/A' }}"
                                    @else
                                        data-supply="{{ $activity->supply->name ?? 'N/A' }}"
                                    @endif
                                    data-startDate="{{ $activity->start_date }}"
                                    data-finishDate="{{ $activity->finish_date }}"
                                    data-dieselValue="{{ $activity->diesel_value }}"
                                    data-observations="{{ $activity->observations }}">
                                Deletar
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          @endif
        </div>

    

    <!-- Modal de CREATE -->
    <form action="{{ route('activity.register') }}" method="POST">
    @csrf

    <!-- Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Nova Atividade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="atividade-tab" data-bs-toggle="tab" data-bs-target="#atividade" type="button" role="tab" aria-controls="atividade" aria-selected="true">
                                    Atividade
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="machinery1-tab" data-bs-toggle="tab" data-bs-target="#machinery1" type="button" role="tab" aria-controls="machinery1" aria-selected="false">
                                    Maquinário 1
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="machinery2-tab" data-bs-toggle="tab" data-bs-target="#machinery2" type="button" role="tab" aria-controls="machinery2" aria-selected="false">
                                    Maquinário 2
                                </button>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3" id="activityTabsContent">

                            <!-- Aba Atividade -->
                            <div class="tab-pane fade show active" id="atividade" role="tabpanel" aria-labelledby="atividade-tab">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <x-text-input type="text" class="form-control" id="name" name="name" required />
                                </div>

                                <div class="mb-3">
                                    <label for="plot_id" class="form-label">Area</label>
                                    <select class="form-select" id="plot_id" name="plot_id" required>
                                        @foreach($plots as $plot)
                                            <option value="{{ $plot->id }}">{{ $plot->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Tipo</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="" disabled selected>Selecione um tipo de atividade</option>
                                        @foreach(\App\Enums\TypeEnum::cases() as $type)
                                            <option value="{{ $type->value }}">{{ ucfirst($type->label()) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="crop_id" class="form-label">Safra</label>
                                    <select class="form-select" id="crop_id" name="crop_id" required>
                                        @foreach($crops as $crop)
                                            <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="supply" class="form-label">Insumo</label>
                                    <select class="form-select" id="supply_id" name="supply_id" required>
                                        <option value="" disabled selected>Selecione um insumo</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="supplyEstimatedValue" class="form-label">Valor Estimado Insumos</label>
                                    <x-text-input type="text" class="form-control" id="supplyEstimatedValue" name="supplyEstimatedValue" required />
                                </div>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Colaborador</label>
                                    <select class="form-select" id="user_id" name="user_id" required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-center">
                                    <label for="startDate" class="w-32 font-medium text-gray-700">Inicia em</label>
                                    <div class="flex-1">
                                        <input id="startDate" class="w-full form-control" type="date" name="startDate" :value="old('plantingDate')" required autocomplete="startDate" />
                                        <x-input-error :messages="$errors->get('plantingDate')" class="mt-1" />
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <label for="finalDate" class="w-32 font-medium text-gray-700">Finaliza em</label>
                                    <div class="flex-1">
                                        <input id="finishDate" class="w-full form-control" type="date" name="finishDate" :value="old('plantingDate')" required autocomplete="finishDate" />
                                        <x-input-error :messages="$errors->get('plantingDate')" class="mt-1" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="dieselValue" class="form-label">Valor do Diesel</label>
                                    <x-text-input type="text" class="form-control" id="dieselValue" name="dieselValue" required />
                                </div>

                                <div class="mb-3">
                                    <label for="observation" class="form-label">Observação</label>
                                    <x-text-input type="text" class="form-control" id="observation" name="observation" />
                                </div>
                            </div>

                            <!-- Aba Maquinário 1 -->
                            <div class="tab-pane fade" id="machinery1" role="tabpanel" aria-labelledby="machinery1-tab">
                                <div class="mb-3">
                                    <label for="machinery_id_1" class="form-label">Maquinário</label>
                                    <select class="form-select" id="machinery_id_1" name="machinery_id_1" required>
                                        <option value="" disabled selected>Selecione um maquinário</option>
                                        @foreach($machineries as $machinery)
                                            <option value="{{ $machinery->id }}" data-type="{{ $machinery->type }}">{{ $machinery->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="machinery_dieselConsumption_1" class="form-label">Consumo de Diesel</label>
                                    <x-text-input type="text" class="form-control" id="machinery_dieselConsumption_1" name="machinery_dieselConsumption_1" required />
                                </div>
                            </div>

                            <!-- Aba Maquinário 2 -->
                            <div class="tab-pane fade" id="machinery2" role="tabpanel" aria-labelledby="machinery2-tab">
                                <div class="mb-3">
                                    <label for="machinery_id_2" class="form-label">Maquinário</label>
                                    <select class="form-select" id="machinery_id_2" name="machinery_id_2">
                                        <option value="" disabled selected>Selecione um maquinário</option>
                                        @foreach($machineries as $machinery)
                                            <option value="{{ $machinery->id }}" data-type="{{ $machinery->type }}">{{ $machinery->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="machinery_dieselConsumption_2" class="form-label">Consumo de Diesel</label>
                                    <x-text-input type="text" class="form-control" id="machinery_dieselConsumption_2" name="machinery_dieselConsumption_2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>

                </div>
            </div>
        </div>
    </form>


    <!-- MODAL VIEW -->
    <div class="modal fade" id="viewActivityModal" tabindex="-1" aria-labelledby="viewActivityModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cropModalLabel">Detalhes da Safra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="atividade-tab" data-bs-toggle="tab" data-bs-target="#view-tab-atividade" type="button" role="tab" aria-controls="atividade" aria-selected="true">
                                    Atividade
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="btn-view-tab-machinery1" data-bs-toggle="tab" data-bs-target="#view-tab-machinery1" type="button" role="tab" aria-controls="view-tab-machinery1" aria-selected="false">
                                    Maquinário 1
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="btn-view-tab-machinery2" data-bs-toggle="tab" data-bs-target="#view-tab-machinery2" type="button" role="tab" aria-controls="view-tab-machinery2" aria-selected="false">
                                    Maquinário 2
                                </button>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3" id="activityTabsContent">
                            <!-- Aba Atividade -->
                            <div class="tab-pane fade show active" id="view-tab-atividade" role="tabpanel" aria-labelledby="atividade-tab">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome</label>
                                    <x-text-input type="text" class="form-control" id="view_name" name="name" disabled/>
                                </div>

                                <div class="mb-3">
                                    <label for="view_type" class="form-label">Tipo</label>
                                    <x-text-input type="text" class="form-control" id="view_type" name="view_type" disabled/>
                                </div>

                                <div class="mb-3">
                                    <label for="view_area" class="form-label">Area</label>
                                    <x-text-input type="text" class="form-control" id="view_plot" name="view_plot" disabled/>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Safra</label>
                                    <x-text-input type="text" class="form-control" id="view_crop" name="view_crop" disabled/>
                                </div>

                                <div class="mb-3">
                                    <label for="view_supply" class="form-label">Insumo</label>
                                    <x-text-input type="text" class="form-control" id="view_supply" name="view_supply" readonly/>
                                </div>

                                <div class="mb-3">
                                    <label for="view_supplyEstimatedValue" class="form-label">Valor Estimado Insumos</label>
                                    <x-text-input type="text" class="form-control" id="view_supplyEstimatedValue" name="view_supplyEstimatedValue" readOnly />
                                </div>

                                <div class="flex items-center">
                                    <label for="view_startDate" class="w-32 font-medium text-gray-700">Inicia em</label>
                                    <input id="view_startDate" class="w-full form-control" type="date" name="view_startDate" :value="old('plantingDate')" autocomplete="startDate" disabled/>
                                </div>

                                <div class="flex items-center">
                                    <label for="view_finishDate" class="w-32 font-medium text-gray-700">Finaliza em</label>
                                    <input id="view_finishDate" class="w-full form-control" type="date" name="finishDate" :value="old('plantingDate')" autocomplete="finishDate" disabled/>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Colaborador</label>
                                    <x-text-input type="text" class="form-control" id="view_user" name="view_user" disabled/>
                                </div>

                                <div class="mb-3">
                                    <label for="view_dieselValue" class="form-label">Valor do Diesel</label>
                                    <x-text-input type="text" class="form-control" id="view_dieselValue" name="view_dieselValue" readonly />
                                </div>
                                
                                <div class="mb-3">
                                    <label for="observation" class="form-label">Observação</label>
                                    <x-text-input type="text" class="form-control" id="view_observations" name="view_observations" disabled/>
                                </div>
                            </div>
                            <!-- Aba Maquinário 1 -->
                            <div class="tab-pane fade" id="view-tab-machinery1" role="tabpanel" aria-labelledby="view-tab-machinery1">
                                <div class="mb-3">
                                    <label for="view-machinery_name_1" class="form-label">Maquinário</label>
                                    <x-text-input type="text" class="form-control" id="view-machinery_name_1" name="view-machinery_name_1" readonly />
                                </div>

                                <div class="mb-3">
                                    <label for="view_machinery_dieselConsumption_1" class="form-label">Consumo de Diesel</label>
                                    <x-text-input type="text" class="form-control" id="view_machinery_dieselConsumption_1" name="machinery_dieselConsumption_1" readonly />
                                </div>
                            </div>

                            <!-- Aba Maquinário 2 -->
                            <div class="tab-pane fade" id="view-tab-machinery2" role="tabpanel" aria-labelledby="view-tab-machinery2">
                                <div class="mb-3">
                                    <label for="view-machinery_name_2" class="form-label">Maquinário</label>
                                    <x-text-input type="text" class="form-control" id="view-machinery_name_2" name="view-machinery_name_2" readonly />
                                </div>
                            </div>
                        </div>
            </div>
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form method="POST" action="{{ route('activity.update', 0) }}" id="editActivityForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Maquinario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
					<!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="activityTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="update_atividade-tab" data-bs-toggle="tab" data-bs-target="#update_atividade" type="button" role="tab" aria-controls="update_atividade" aria-selected="true">
                                Atividade
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="update_machinery1-tab" data-bs-toggle="tab" data-bs-target="#update_machinery1" type="button" role="tab" aria-controls="update_machinery1-tab" aria-selected="false">
                                Maquinário 1
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="update_machinery2-tab" data-bs-toggle="tab" data-bs-target="#update_machinery2" type="button" role="tab" aria-controls="update_machinery2-tab" aria-selected="false">
                                Maquinário 2
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-3" id="activityTabsContent">

                        <!-- Aba Atividade -->
                        <div class="tab-pane fade show active" id="update_atividade" role="tabpanel" aria-labelledby="atividade-tab">
                            <div class="mb-3">
                                <label for="update_name" class="form-label">Nome</label>
                                <x-text-input type="text" class="form-control" id="update_name" name="update_name" required />
                            </div>

                            <div class="mb-3">
                                <label for="update_plot_id" class="form-label">Area</label>
                                <select class="form-select" id="update_plot_id" name="update_plot_id" required>
                                    @foreach($plots as $plot)
                                        <option value="{{ $plot->id }}">{{ $plot->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="update_type" class="form-label">Tipo</label>
                                <select class="form-select" id="update_type" name="update_type" required>
                                    <option value="" disabled selected>Selecione um tipo de atividade</option>
                                    @foreach(\App\Enums\TypeEnum::cases() as $type)
                                        <option value="{{ $type->value }}">{{ ucfirst($type->label()) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="update_crop_id" class="form-label">Safra</label>
                                <select class="form-select" id="update_crop_id" name="update_crop_id" required>
                                    @foreach($crops as $crop)
                                        <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="update_supply_id" class="form-label">Insumo</label>
                                <select class="form-select" id="update_supply_id" name="update_supply_id" required>
                                    <option value="" selected>Selecione um insumo</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="update_supplyEstimatedValue" class="form-label">Valor Estimado Insumos</label>
                                <x-text-input type="text" class="form-control" id="update_supplyEstimatedValue" name="update_supplyEstimatedValue" required />
                            </div>

                            <div class="mb-3">
                                <label for="update_user_id" class="form-label">Colaborador</label>
                                <select class="form-select" id="update_user_id" name="update_user_id" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center">
                                <label for="update_startDate" class="w-32 font-medium text-gray-700">Inicia em</label>
                                <div class="flex-1">
                                    <input id="update_startDate" class="w-full form-control" type="date" name="update_startDate" :value="old('plantingDate')" required autocomplete="startDate" />
                                    <x-input-error :messages="$errors->get('plantingDate')" class="mt-1" />
                                </div>
                            </div>

                            <div class="flex items-center">
                                <label for="update_finalDate" class="w-32 font-medium text-gray-700">Finaliza em</label>
                                <div class="flex-1">
                                    <input id="update_finishDate" class="w-full form-control" type="date" name="update_finishDate" :value="old('plantingDate')" required autocomplete="finishDate" />
                                    <x-input-error :messages="$errors->get('plantingDate')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="update_machinery_dieselValue" class="form-label">Valor do Diesel</label>
                                <x-text-input type="text" class="form-control" id="update_machinery_dieselValue" name="update_machinery_dieselValue" required />
                            </div>

                            <div class="mb-3">
                                <label for="update_observations" class="form-label">Observação</label>
                                <x-text-input type="text" class="form-control" id="update_observations" name="update_observations" />
                            </div>
                        </div>

                        <!-- Aba Maquinário 1 -->
                        <div class="tab-pane fade" id="update_machinery1" role="tabpanel" aria-labelledby="update_machinery1-tab">
                            <input type="hidden" id="update_pivot_id_1" name="update_pivot_id_1" value="">
                            <div class="mb-3">
                                <label for="update_machinery_id_1" class="form-label">Maquinário</label>
                                <select class="form-select" id="update_machinery_id_1" name="update_machinery_id_1" required>
                                    <option value="" disabled selected>Selecione um maquinário</option>
                                    @foreach($machineries as $machinery)
                                        <option value="{{ $machinery->id }}" data-type="{{ $machinery->type }}">{{ $machinery->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="update_machinery_dieselConsumption_1" class="form-label">Consumo de Diesel</label>
                                <x-text-input type="text" class="form-control" id="update_machinery_dieselConsumption_1" name="update_machinery_dieselConsumption_1" required />
                            </div>
                        </div>

                        <!-- Aba Maquinário 2 -->
                        <div class="tab-pane fade" id="update_machinery2" role="tabpanel" aria-labelledby="update-machinery2-tab">
                            <input type="hidden" id="update_pivot_id_2" name="update_pivot_id_2" value="">
                            <div class="mb-3">
                                <label for="update_machinery_id_2" class="form-label">Maquinário</label>
                                <select class="form-select" id="update_machinery_id_2" name="update_machinery_id_2">
                                    <option value="" disabled selected>Selecione um maquinário</option>
                                    @foreach($machineries as $machinery)
                                        <option value="{{ $machinery->id }}" data-type="{{ $machinery->type }}">{{ $machinery->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="update_machinery_dieselConsumption_2" class="form-label">Consumo de Diesel</label>
                                <x-text-input type="text" class="form-control" id="update_machinery_dieselConsumption_2" name="update_machinery_dieselConsumption_2" />
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
    </div>


    <!-- MODAL DELETE -->
    <div class="modal fade" id="deleteActivityModal" tabindex="-1" aria-labelledby="deleteActivityrModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('activity.delete', 0) }}" id="deleteActivityForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Deseja realmente deletar este maquinario ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="delete_name" class="form-label">Nome</label>
                    <x-text-input type="text" class="form-control" id="delete_name" name="delete_name" required disabled/>
                </div>

                <div class="mb-3">
                    <label for="delete_type" class="form-label">Tipo</label>
                    <x-text-input type="text" class="form-control" id="delete_type" name="delete_type" required disabled/>
                </div>

                <div class="mb-3">
                    <label for="delete_area" class="form-label">Area</label>
                    <x-text-input type="text" class="form-control" id="delete_plot" name="delete_plot" required disabled/>
                </div>

                <div class="mb-3">
                    <label for="delete_crop" class="form-label">Safra</label>
                    <x-text-input type="text" class="form-control" id="delete_crop" name="delete_crop" required disabled/>
                </div>

                <div class="flex items-center">
                    <label for="delete_startDate" class="w-32 font-medium text-gray-700">Inicia em</label>
                    <input id="delete_startDate" class="w-full form-control" type="date" name="delete_startDate" :value="old('plantingDate')" required autocomplete="startDate" disabled/>
                </div>

                <div class="flex items-center">
                    <label for="delete_finishDate" class="w-32 font-medium text-gray-700">Finaliza em</label>
                    <input id="delete_finishDate" class="w-full form-control" type="date" name="delete_finishDate" :value="old('plantingDate')" required autocomplete="finishDate" disabled/>
                </div>

                <div class="mb-3">
                    <label for="delete_user" class="form-label">Colaborador</label>
                    <x-text-input type="text" class="form-control" id="delete_user" name="delete_user" required disabled/>
                </div>

                <div class="mb-3">
                    <label for="delete_observation" class="form-label">Observação</label>
                    <x-text-input type="text" class="form-control" id="delete_observations" name="delete_observations" disabled/>
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
                    const modal = new bootstrap.Modal(document.getElementById('createUserModal'));
                    modal.show();
                }
            });
        });
    </script>

    
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const supplySelect = document.getElementById('supply_id');

        typeSelect.addEventListener('change', function () {
            const selectedType = this.value;

            // Limpa o select
            supplySelect.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.text = 'Selecione um insumo';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            supplySelect.appendChild(defaultOption);

            if (selectedType === 'colheitadeira') {
                supplySelect.disabled = true;
                return;
            }

            if (selectedType === 'plantadeira') {
                supplySelect.setAttribute('name', 'seed_id');
            } else {
                supplySelect.setAttribute('name', 'supply_id');
            }

            fetch(`/activitySupply/${selectedType}/json`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = `${item.id}`; // tipo-id, ex: seed-1
                        option.textContent = item.name;
                        supplySelect.appendChild(option);
                    });
                    supplySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Erro ao carregar insumos:', error);
                    supplySelect.disabled = true;
                });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('update_type');
        const supplySelect = document.getElementById('update_supply_id');

        typeSelect.addEventListener('change', function () {
            const selectedType = this.value;

            supplySelect.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.text = 'Selecione um insumo';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            supplySelect.appendChild(defaultOption);

            if (selectedType === 'colheitadeira') {
                supplySelect.disabled = true;
                return;
            }

            if (selectedType === 'colheitadeira') {
                supplySelect.disabled = true;
                return;
            }

            if (selectedType === 'plantadeira') {
                supplySelect.setAttribute('name', 'update_seed_id');
            } else {
                supplySelect.setAttribute('name', 'update_supply_id');
            }

            fetch(`/activitySupply/${selectedType}/json`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = `${item.id}`;
                        option.textContent = item.name;
                        supplySelect.appendChild(option);
                    });
                    supplySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Erro ao carregar insumos:', error);
                    supplySelect.disabled = true;
                });
        });
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('type').addEventListener('change', function () {
            const selectedType = this.value.toLowerCase();
            const machinerySelect = document.getElementById('machinery_id_1');
            const machineryOptions = machinerySelect.querySelectorAll('option');

            machineryOptions.forEach(option => {
                const type = option.getAttribute('data-type');
                const typeLower = type ? type.toLowerCase() : '';
                const isTractor = typeLower === 'trator';
                const matchesSelected = typeLower === selectedType;

                let shouldShow = false;

                // Se for "plantadeira" ou "adubador", mostrar tratores e itens da categoria
                if (['plantadeira', 'adubador'].includes(selectedType)) {
                    shouldShow = isTractor || matchesSelected;
                } else {
                    // Senão, mostrar apenas itens da categoria
                    shouldShow = matchesSelected;
                }

                option.style.display = shouldShow ? 'block' : 'none';
            });

            // Limpa a seleção atual
            machinerySelect.value = '';
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('type').addEventListener('change', function () {
            const selectedType = this.value.toLowerCase();
            const machinerySelect = document.getElementById('machinery_id_2');
            const machineryOptions = machinerySelect.querySelectorAll('option');

            machineryOptions.forEach(option => {
                const type = option.getAttribute('data-type');
                const typeLower = type ? type.toLowerCase() : '';
                const isTractor = typeLower === 'trator';
                const matchesSelected = typeLower === selectedType;

                let shouldShow = false;

                // Se for "plantadeira" ou "adubador", mostrar tratores e itens da categoria
                if (['plantadeira', 'adubador'].includes(selectedType)) {
                    shouldShow = isTractor || matchesSelected;
                } else {
                    // Senão, mostrar apenas itens da categoria
                    shouldShow = matchesSelected;
                }

                option.style.display = shouldShow ? 'block' : 'none';
            });

            // Limpa a seleção atual
            machinerySelect.value = '';
        });
    });

  const createUserModal = document.getElementById('createUserModal');
  createUserModal.addEventListener('show.bs.modal', function (event) {
        estimatedValue = document.getElementById('supplyEstimatedValue');
        dieselValue = document.getElementById('dieselValue');
        dieselMachinery1 = document.getElementById('machinery_dieselConsumption_1');
        dieselMachinery2 = document.getElementById('machinery_dieselConsumption_2');

        dieselValue.addEventListener('input', () =>{
            formatarMoeda(dieselValue);
        });

        estimatedValue.addEventListener('input', () =>{
            formatarMoeda(estimatedValue);
        });

        dieselMachinery1.addEventListener('input', () =>{
            formataDiesel(dieselMachinery1);
        });

        dieselMachinery2.addEventListener('input', () =>{
            formataDiesel(dieselMachinery2);
        });
  });

  // Modal VIEW
  const viewActivityModal = document.getElementById('viewActivityModal');
  viewActivityModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const type = button.getAttribute('data-type');
    const crop = button.getAttribute('data-crop');
    const plot = button.getAttribute('data-plot');
    const user = button.getAttribute('data-user');
    const supply = button.getAttribute('data-supply');
    const estimatedSupplyValue = button.getAttribute('data-estimatedSupplyValue');
    const machinery = button.getAttribute('data-machinery');
    const startDate = button.getAttribute('data-startDate');
    const finishDate = button.getAttribute('data-finishDate');
    const diesel = button.getAttribute('data-dieselValue');
    const observations = button.getAttribute('data-observations');
    
    const formattedstartDate = new Date(startDate).toISOString().split('T')[0];
    const formattedfinishDate = new Date(finishDate).toISOString().split('T')[0];

    // Agora você pode fazer uma requisição AJAX se quiser:
    fetch(`/activity/${id}/json`)
    .then(res => res.json())
    .then(data => {
        data.machinery.forEach((machinery, index) => {
            const i = index + 1; // index começa em 0, queremos 1-based

            if(i == 1){
                document.getElementById(`view-machinery_name_${i}`).value = machinery.name;
                document.getElementById(`view_machinery_dieselConsumption_${i}`).value = machinery.pivot.diesel_consumption;
            }else{
                document.getElementById(`view-machinery_name_${i}`).value = machinery.name;
            }
        });
    })
    .catch(error => {
        console.error('Erro ao carregar dados da atividade:', error);
    });

    document.getElementById('view_name').value = name;
    document.getElementById('view_type').value = type;
    document.getElementById('view_startDate').value = formattedstartDate;
    document.getElementById('view_finishDate').value = formattedfinishDate;
    document.getElementById('view_crop').value = crop;
    document.getElementById('view_plot').value = plot;
    document.getElementById('view_user').value = user;
    document.getElementById('view_supply').value = supply;
    document.getElementById('view_supplyEstimatedValue').value = estimatedSupplyValue;
    document.getElementById('view_dieselValue').value = diesel;
    document.getElementById('view_observations').value = observations;

    maskValue('view_dieselValue');
    maskValue('view_supplyEstimatedValue');
  });

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('update_type').addEventListener('change', function () {
            const selectedType = this.value.toLowerCase();
            const machinerySelect = document.getElementById('update_machinery_id_1');
            const machineryOptions = machinerySelect.querySelectorAll('option');

            machineryOptions.forEach(option => {
                const type = option.getAttribute('data-type');
                const typeLower = type ? type.toLowerCase() : '';
                const isTractor = typeLower === 'trator';
                const matchesSelected = typeLower === selectedType;

                let shouldShow = false;

                // Se for "plantadeira" ou "adubador", mostrar tratores e itens da categoria
                if (['plantadeira', 'adubador'].includes(selectedType)) {
                    shouldShow = isTractor || matchesSelected;
                } else {
                    // Senão, mostrar apenas itens da categoria
                    shouldShow = matchesSelected;
                }

                option.style.display = shouldShow ? 'block' : 'none';
            });

            // Limpa a seleção atual
            machinerySelect.value = '';
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('update_type').addEventListener('change', function () {
            const selectedType = this.value.toLowerCase();
            const machinerySelect = document.getElementById('update_machinery_id_2');
            const machineryOptions = machinerySelect.querySelectorAll('option');

            machineryOptions.forEach(option => {
                const type = option.getAttribute('data-type');
                const typeLower = type ? type.toLowerCase() : '';
                const isTractor = typeLower === 'trator';
                const matchesSelected = typeLower === selectedType;

                let shouldShow = false;

                // Se for "plantadeira" ou "adubador", mostrar tratores e itens da categoria
                if (['plantadeira', 'adubador'].includes(selectedType)) {
                    shouldShow = isTractor || matchesSelected;
                } else {
                    // Senão, mostrar apenas itens da categoria
                    shouldShow = matchesSelected;
                }

                option.style.display = shouldShow ? 'block' : 'none';
            });

            // Limpa a seleção atual
            machinerySelect.value = '';
        });
    });

    //Editar
    const editModal = document.getElementById('editActivityModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const type = button.getAttribute('data-type');
        const crop = button.getAttribute('data-crop');
        const plot = button.getAttribute('data-plot');
        const user = button.getAttribute('data-user');
        const supplyId = button.getAttribute('data-supply_id');
        const supplyName = button.getAttribute('data-supply_name');
        const estimatedSupplyValue = button.getAttribute('data-estimatedSupplyValue');
        const startDate = button.getAttribute('data-startDate');
        const finishDate = button.getAttribute('data-finishDate');
        const dieselValue = button.getAttribute('data-dieselValue');
        const observations = button.getAttribute('data-observations');

        const formattedstartDate = new Date(startDate).toISOString().split('T')[0];
        const formattedfinishDate = new Date(finishDate).toISOString().split('T')[0];

        
        // Agora você pode fazer uma requisição AJAX se quiser:
        fetch(`/activity/${id}/json`)
        .then(res => res.json())
        .then(data => {
            data.machinery.forEach((machinery, index) => {
                const i = index + 1; // index começa em 0, queremos 1-based

                document.getElementById(`update_machinery_id_${i}`).value = machinery.id;
                document.getElementById(`update_machinery_dieselConsumption_${i}`).value = machinery.pivot.diesel_consumption;
                document.getElementById(`update_pivot_id_${i}`).value = machinery.pivot.id;
                
            });
        })
        .catch(error => {
            console.error('Erro ao carregar dados da atividade:', error);
        });

        document.getElementById('update_name').value = name;
        document.getElementById('update_type').value = type;
        document.getElementById('update_startDate').value = formattedstartDate;
        document.getElementById('update_finishDate').value = formattedfinishDate;
        document.getElementById('update_crop_id').value = crop;
        document.getElementById('update_machinery_dieselValue').value = dieselValue;
        document.getElementById('update_plot_id').value = plot;
        document.getElementById('update_user_id').value = user;
        document.getElementById('update_observations').value = observations;
        document.getElementById('update_supplyEstimatedValue').value = estimatedSupplyValue;

        preencheSelect(supplyId,supplyName);
        updateType('update_machinery_id_1');
        updateType('update_machinery_id_2');

        diesel = document.getElementById('update_machinery_dieselValue');
        supplyEstimatedValue = document.getElementById('update_supplyEstimatedValue');
        dieselMachinery1 = document.getElementById('update_machinery_dieselConsumption_1');
        dieselMachinery2 = document.getElementById('update_machinery_dieselConsumption_2');

        diesel.addEventListener('input', () =>{
            formatarMoeda(diesel);
        });

         supplyEstimatedValue.addEventListener('input', () =>{
            formatarMoeda(supplyEstimatedValue);
        });

        dieselMachinery1.addEventListener('input', () =>{
            formataDiesel(dieselMachinery1);
        });

        dieselMachinery2.addEventListener('input', () =>{
            formataDiesel(dieselMachinery2);
        });

        // Atualiza a action do form dinamicamente com o ID correto
        const form = document.getElementById('editActivityForm');
        form.action = `/activity/${id}`;
    });

    //DELETE
	const deleteModal = document.getElementById('deleteActivityModal');
	deleteModal.addEventListener('show.bs.modal', function (event) {
		const button = event.relatedTarget;

		const id = button.getAttribute('data-id');
		const name = button.getAttribute('data-name');
		const type = button.getAttribute('data-type');
		const crop = button.getAttribute('data-crop');
		const plot = button.getAttribute('data-plot');
		const user = button.getAttribute('data-user');
		const startDate = button.getAttribute('data-startDate');
		const finishDate = button.getAttribute('data-finishDate');
		const observations = button.getAttribute('data-observations');

        const formattedstartDate = new Date(startDate).toISOString().split('T')[0];
        const formattedfinishDate = new Date(finishDate).toISOString().split('T')[0];

		document.getElementById('delete_name').value = name;
		document.getElementById('delete_type').value = type;
		document.getElementById('delete_startDate').value = formattedstartDate;
		document.getElementById('delete_finishDate').value = formattedfinishDate;
		document.getElementById('delete_crop').value = crop;
		document.getElementById('delete_plot').value = plot;
		document.getElementById('delete_user').value = user;
		document.getElementById('delete_observations').value = observations;

		// Atualiza a action do form com o id correto
		const form = document.getElementById('deleteActivityForm');
		form.action = `/activity/${id}`;
	});

    
</script>
<script>
    function maskValue(inputId) {
        const element = document.getElementById(inputId);

        // Remove máscara antiga se já existir
        if (element.maskRef) {
            element.maskRef.destroy();
        }

        const maskOptions = {
            mask: 'R$ num',
            blocks: {
                num: {
                    mask: Number,
                    scale: 2,
                    signed: false,
                    thousandsSeparator: '.',
                    radix: ',',
                    mapToRadix: ['.'],
                    normalizeZeros: true,
                    padFractionalZeros: true,
                }
            }
        };
        
        // Cria a máscara
        const mask = IMask(element, maskOptions);

        // Salva referência para evitar múltiplas máscaras
        element.maskRef = mask;
    }

    function filterMachineryOptions() {
        const typeSelect = document.getElementById('update_type');
        const machinerySelect = document.getElementById('update_machinery_id');

        if (!typeSelect || !machinerySelect) return;

        const selectedType = typeSelect.value;
        const machineryOptions = machinerySelect.querySelectorAll('option');

        machineryOptions.forEach(option => {
            const type = option.getAttribute('data-type');
            const shouldShow = !type || type.toUpperCase() === selectedType.toUpperCase();
            option.style.display = shouldShow ? 'block' : 'none';
        });

        // Limpa a seleção se a opção atual não estiver visível
        const selectedOption = machinerySelect.options[machinerySelect.selectedIndex];
        if (selectedOption && selectedOption.style.display === 'none') {
            machinerySelect.value = '';
        }
    }

    function updateType (input) {
        
            const selectedType = document.getElementById('update_type').value;
            const machinerySelect = document.getElementById(input);
            const machineryOptions = machinerySelect.querySelectorAll('option');

            console.log(selectedType);

            machineryOptions.forEach(option => {
                const type = option.getAttribute('data-type');
                const typeLower = type ? type.toLowerCase() : '';
                const isTractor = typeLower === 'trator';
                const matchesSelected = typeLower === selectedType;

                let shouldShow = false;

                // Se for "plantadeira" ou "adubador", mostrar tratores e itens da categoria
                if (['plantadeira', 'adubador'].includes(selectedType)) {
                    shouldShow = isTractor || matchesSelected;
                } else {
                    // Senão, mostrar apenas itens da categoria
                    shouldShow = matchesSelected;
                }

                option.style.display = shouldShow ? 'block' : 'none';
            });
    };

    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('update_type');

        if (typeSelect) {
            // Atualiza a lista quando o tipo é alterado
            typeSelect.addEventListener('change', filterMachineryOptions);
        }

        // Detecta quando o modal é aberto
        const editModal = document.getElementById('editActivityModal');
        if (editModal) {
            editModal.addEventListener('shown.bs.modal', function () {
                console.log('bloqueando os machinery')
                filterMachineryOptions();
            });
        }
    });

    function preencheSelect(supplyId,supplyName){
        const select = document.getElementById('update_supply_id');

        // Limpa opções antigas
        select.innerHTML = '';

        // Cria a nova option
        const option = document.createElement('option');
        option.value = supplyId;
        option.text = supplyName;
        option.selected = true;

        // Adiciona no select
        select.appendChild(option);
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

    function formataDiesel(campo){
        // Remove tudo que não é número
      let valor = campo.value.replace(/\D/g, '');

      // Adiciona zeros à direita para os centavos
      valor = (Number(valor) / 100).toLocaleString('pt-BR', {
       
        minimumFractionDigits: 2
      });

      campo.value = valor;
    }

document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const searchTerm = document.getElementById('searchInput').value;

    fetch(`/activity/find?findName=${encodeURIComponent(searchTerm)}`)
        .then(response => {
            if (!response.ok) throw new Error('Erro na requisição');
            return response.json();
        })
        .then(data => {
            const tbody = document.getElementById('activitiesBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Nenhuma atividade encontrada.</td></tr>';
                return;
            }

            data.forEach((activity, index) => {
                // Label formatada
                const typeLabel = getTypeLabel(activity.type); // você pode trocar isso por função do backend se preferir
                // const isPlantio = activity.type === 'plantadeira';
                // const supplyName = isPlantio ? (activity.seed?.name ?? 'N/A') : (activity.supply?.name ?? 'N/A');
                //const supplyId = isPlantio ? (activity.seed?.id ?? 'N/A') : (activity.supply?.id ?? 'N/A');

                if(activity.type === 'plantadeira'){
                    supplyName = activity.seed?.name ?? 'N/A';
                    supplyId = activity.seed?.id ?? 'N/A';
                }else{
                    supplyName = activity.supply?.name ?? 'N/A';
                    supplyId = activity.supply?.id ?? 'N/A'
                }

                // Datas formatadas (ajuste se quiser usar uma lib)
                const formatDate = (dateStr) => {
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('pt-BR');
                };

                tbody.innerHTML += `
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>${activity.name}</td>
                        <td>${typeLabel}</td>
                        <td>${supplyName}</td>
                        <td>${formatDate(activity.start_date)}</td>
                        <td>${formatDate(activity.finish_date)}</td>
                        <td class="text-center">
                            <!-- Visualizar -->
                            <button class="btn btn-outline-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#viewActivityModal"
                                data-id="${activity.id}"
                                data-name="${activity.name}"
                                data-type="${typeLabel}"
                                data-farm="${activity.farm?.name ?? ''}"
                                data-crop="${activity.crop?.name ?? ''}"
                                data-plot="${activity.plot?.name ?? ''}"
                                data-supply="${supplyName}"
                                data-user="${activity.user?.name ?? ''}"
                                data-startdate="${activity.start_date}"
                                data-finishdate="${activity.finish_date}"
                                data-dieselvalue="${activity.diesel_value}"
                                data-estimatedSupplyValue="${activity.supply_estimated_value}"
                                data-observations="${activity.observations ?? ''}">
                                Visualizar
                            </button>

                            <!-- Editar -->
                            <button class="btn btn-outline-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editActivityModal"
                                data-id="${activity.id}"
                                data-name="${activity.name}"
                                data-type="${activity.type}"
                                data-farm="${activity.farm_id}"
                                data-crop="${activity.crop_id}"
                                data-plot="${activity.plot_id}"
                                data-user="${activity.user_id}"
                                data-supply_name="${supplyName}"
                                data-supply_id="${supplyId}"
                                data-startdate="${activity.start_date}"
                                data-finishdate="${activity.finish_date}"
                                data-dieselvalue="${activity.diesel_value}"
                                data-estimatedSupplyValue="${activity.supply_estimated_value}"
                                data-observations="${activity.observations ?? ''}">
                                Atualizar
                            </button>

                            <!-- Deletar -->
                            <button class="btn btn-outline-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteActivityModal"
                                data-id="${activity.id}"
                                data-name="${activity.name}"
                                data-type="${typeLabel}"
                                data-farm="${activity.farm?.name ?? ''}"
                                data-crop="${activity.crop?.name ?? ''}"
                                data-plot="${activity.plot?.name ?? ''}"
                                data-user="${activity.user?.name ?? ''}"
                                data-supply="${supplyName}"
                                data-startdate="${activity.start_date}"
                                data-finishdate="${activity.finish_date}"
                                data-dieselvalue="${activity.diesel_value}"
                                data-estimatedSupplyValue="${activity.supply_estimated_value}"
                                data-observations="${activity.observations ?? ''}">
                                Deletar
                            </button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Erro na requisição AJAX:', error);
        });

    // converte enums de tipo para label legível
    function getTypeLabel(type) {
        switch(type) {
            case 'plantadeira': return 'Plantio';
            case 'pulverizadora': return 'Pulverização';
            case 'colheitadeira': return 'Colheita';
            default: return type;
        }
    }
});
</script>
<script src="https://unpkg.com/imask"></script>

</x-layout>
