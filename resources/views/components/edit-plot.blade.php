@props(['modalId', 'route'])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ $route }}" id="{{ $modalId }}Form">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="{{ $modalId }}Label">Editar Talhão</h5>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
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
</script>