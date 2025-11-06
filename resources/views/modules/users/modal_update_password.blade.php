<!-- Modal -->
<form id="form_update_password" onsubmit="return update_password()">
    <div class="modal fade" id="update_password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Escribe el nuevo password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="user_id" name="user_id" hidden>
                    <label for="password">Password nuevo</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</span>
                    <button class="btn btn-warning">Actualizar password</button>
                </div>
            </div>
        </div>
    </div>

</form>
