@section('page-title', 'Usuários')

<x-layout>
    <!-- VOU COLOCAR A PARTE DE CONTEUDOS AQUI -->
    <!-- CARD  -->
    <div class="row">
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
            @if ($users->isEmpty())
              <p>Nenhum usuário cadastrado</p>
            @else
              <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody id="userBody">
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        @foreach ($user->farms as $farm)
                        <td>{{ ucfirst($farm->pivot->role) }}</td>  
                        @endforeach
                        
                        <td class="text-center">
                            <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewUserModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    @foreach ($user->farms as $farm)
                                      data-role="{{ $farm->pivot->role }}"
                                    @endforeach
                                    data-farms='@json($user->farms->pluck("id"))'>
                                Visualizar
                            </button>

                            <button class="btn btn-outline-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    @foreach ($user->farms as $farm)
                                      data-role="{{ $farm->pivot->role }}"
                                    @endforeach
                                    data-farms='@json($user->farms->pluck("id"))'>
                                Atualizar
                            </button>

                            <button class="btn btn-outline-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    @foreach ($user->farms as $farm)
                                      data-role="{{ $farm->pivot->role }}">
                                    @endforeach
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
    <form action="{{ route('user.register') }}" method="POST">
        @csrf

        <!-- Modal -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Novo Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="owner" id="owner" value="0">
                        <!-- Aba 1: Dados do Usuário -->
                        <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <x-text-input type="text" class="form-control" id="name" name="name" required/>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <x-text-input type="email" class="form-control" id="email" name="email" required/>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <x-text-input type="password" class="form-control" id="password" name="password" required autocomplete="new-password"/>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmação de Senha</label>
                                <x-text-input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"/>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Função</label>
                                <select class="form-select" id="role" name="role" required>
                                    @foreach(\App\Enums\RoleEnum::cases() as $role)
                                        <option value="{{ $role->value }}">{{ ucfirst($role->value) }}</option>
                                    @endforeach
                                </select>
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
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cropModalLabel">Detalhes da Safra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
              <div class="modal-body">
                    <!-- Aba 1: Dados do Usuário -->
                    <div class="tab-pane fade show active" id="user-view" role="tabpanel" aria-labelledby="user-view-tab">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <x-text-input type="text" class="form-control" id="user-view-name" name="user-view-name" required disabled/>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <x-text-input type="email" class="form-control" id="user-view-email" name="user-view-email" required disabled/>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Função</label>
                            <x-text-input type="text" class="form-control" id="user-view-role" name="user-view-role" required disabled/>
                        </div>
                    </div>
              </div>
            <div class="modal-footer">
            </div>
          </div>
      </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form method="POST" action="{{ route('user.update', 0) }}" id="editUserForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Maquinario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                  <!-- Aba 1: Dados do Usuário -->
                  <div class="tab-pane fade show active" id="user-update" role="tabpanel" aria-labelledby="user-tab">
                      <div class="mb-3">
                          <label for="name" class="form-label">Nome</label>
                          <x-text-input type="text" class="form-control" id="user-update-name" name="user-update-name" required/>
                      </div>

                      <div class="mb-3">
                          <label for="email" class="form-label">E-mail</label>
                          <x-text-input type="email" class="form-control" id="user-update-email" name="user-update-email" required/>
                      </div>

                      <div class="mb-3">
                          <label for="role" class="form-label">Função</label>
                          <select class="form-select" id="user-update-role" name="user-update-role" required>
                              @foreach(\App\Enums\RoleEnum::cases() as $role)
                                <option value="{{ $role->value }}">{{ ucfirst($role->value) }}</option>
                              @endforeach
                          </select>
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
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('user.delete', 0) }}" id="deleteMachineryForm">
          @csrf
          @method('DELETE')
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="plotModalLabel">Deseja realmente deletar este maquinario ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <!-- Aba 1: Dados do Usuário -->
              <div class="tab-pane fade show active" id="user-view" role="tabpanel" aria-labelledby="user-view-tab">
                  <div class="mb-3">
                      <label for="name" class="form-label">Nome</label>
                      <x-text-input type="text" class="form-control" id="user-delete-name" name="user-delete-name" required disabled/>
                  </div>

                  <div class="mb-3">
                      <label for="email" class="form-label">E-mail</label>
                      <x-text-input type="email" class="form-control" id="user-delete-email" name="user-delete-email" required disabled/>
                  </div>

                  <div class="mb-3">
                      <label for="role" class="form-label">Função</label>
                      <x-text-input type="text" class="form-control" id="user-delete-role" name="user-delete-role" required disabled/>
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
                    const modal = new bootstrap.Modal(document.getElementById('createUserModal'));
                    modal.show();
                }
            });
        });
    </script>

<script>
  const createUserModal = document.getElementById('createUserModal');
  createUserModal.addEventListener('show.bs.modal', function (event) {

  });

  // Modal VIEW
  const viewCropModal = document.getElementById('viewUserModal');
  viewCropModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');
    const farmIds = JSON.parse(button.getAttribute('data-farms'));

    document.getElementById('user-view-name').value = name;
    document.getElementById('user-view-email').value = email;
    document.getElementById('user-view-role').value = role;
  });

  //Editar
  const editModal = document.getElementById('editUserModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');
    const farmIds = JSON.parse(button.getAttribute('data-farms'));

    document.getElementById('user-update-name').value = name;
    document.getElementById('user-update-email').value = email;
    document.getElementById('user-update-role').value = role;

    // Atualiza a action do form dinamicamente com o ID correto
    const form = document.getElementById('editUserForm');
    form.action = `/user/${id}`;
  });


  //DELETE
  const deleteModal = document.getElementById('deleteUserModal');
  deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');

    document.getElementById('user-delete-name').value = name;
    document.getElementById('user-delete-email').value = email;
    document.getElementById('user-delete-role').value = role;

    // Atualiza a action do form com o id correto
    const form = document.getElementById('deleteMachineryForm');
    form.action = `/user/${id}`;
  });

  document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const searchTerm = document.getElementById('searchInput').value;

    fetch(`/user/find?findName=${encodeURIComponent(searchTerm)}`)
        .then(response => {
            if (!response.ok) throw new Error('Erro na requisição');
            return response.json();
        })
        .then(data => {
            console.log(data);
            const tbody = document.getElementById('userBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">Nenhum usuário encontrado.</td></tr>';
                return;
            }

            data.forEach((users, index) => {

                // Datas formatadas (ajuste se quiser usar uma lib)
                const formatDate = (dateStr) => {
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('pt-BR');
                };

                tbody.innerHTML += `
                <tr>
                    <th scope="row">${index + 1}</th>
                    <td>${users.name}</td>
                    <td>${users.email}</td>
                    <td>${users.farms[0]?.pivot?.role ?? '-'}</td>
                    <td class="text-center">
                        <!-- Visualizar -->
                        <button class="btn btn-outline-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#viewUserModal"
                            data-id="${users.id}"
                            data-name="${users.name}"
                            data-role="${users.farms[0]?.pivot?.role ?? '-'}"
                            >
                            Visualizar
                        </button>

                        <!-- Editar -->
                        <button class="btn btn-outline-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal"
                            data-id="${users.id}"
                            data-name="${users.name}"
                            data-email="${users.email}"
                            data-role="${users.farms[0]?.pivot?.role ?? '-'}"
                            >
                            Atualizar
                        </button>

                        <!-- Deletar -->
                        <button class="btn btn-outline-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal"
                            data-id="${users.id}"
                            data-name="${users.name}"
                            data-email="${users.email}"
                            data-role="${users.farms[0]?.pivot?.role ?? '-'}"
                            >
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
</x-layout>
