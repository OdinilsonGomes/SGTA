<!-- Modals -->
<!-- Add Modal-->
<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registar utilisador</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user-insert">
                    <div class="form-group">
                        <input id="username_to_insert" type="text" class="form-control " placeholder="Nome do utilisador"/>
                    </div>
                    <div class="form-group">
                        <input id="password_to_insert" type="password" class="form-control " placeholder="palavra pass"/>
                    </div>
                    <div class="form-group">
                        <input id="access_to_insert" type="number" min="0" max="1" class="form-control " placeholder="Acesso"/>
                    </div>
                    <hr />
                    <table>
                        <tr>
                            <td><b>Acesso 0:</b></td>
                            <td>Acesso total</td>
                        </tr>
                        <tr>
                            <td><b>Acesso 1:</b></td>
                            <td>Acesso restrito sem gerenciamento de usuários</td>
                        </tr>
                    </table>
                    <hr />
                    <div id="insert_state" class="" role="alert">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-success" href="javascript:insert()">Registar</a>
            </div>
        </div>
    </div>
</div>
<!-- Upd Modal-->
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar utilisador</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="update-user">
                    <div class="form-group">
                        <input id="id_to_update" type="hidden" class="form-control " />
                    </div>
                    <div class="form-group">
                        <label>Nome do utilisador </label>
                        <input id="username_to_update" type="text" class="form-control " />
                    </div>
                    <div class="form-group">
                        <label>Palavra pass </label>
                        <input id="password_to_update" type="password" class="form-control " />
                    </div>
                    <div class="form-group">
                        <label>Acesso </label>
                        <input id="access_to_update" type="number" min="0" max="1" class="form-control " />
                    </div>
                    <hr />
                    <table>
                        <tr>
                            <td><b>Acesso 0:</b></td>
                            <td>Acesso total</td>
                        </tr>
                        <tr>
                            <td><b>Access 1:</b></td>
                            <td>Acesso restrito sem gerenciamento de usuários</td>
                        </tr>
                    </table>
                    <hr />
                    <div id="update_state" class="" role="alert">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success" href="javascript:updateAsync()">Update</a>
            </div>
        </div>
    </div>
</div>
<!-- Del Modal-->
<div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar utilisador</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Desejas eliminar este utilisador?</p>
                <input id='id_to_remove' type='hidden' />
                <div id='remove_state' role='alert'></div >
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-success" href="javascript:removeAsync()">Eliminar</a>
            </div>
        </div>
    </div>
</div>