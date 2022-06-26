<!-- Logout Modal-->
<div class="modal fade" id="logout_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sair!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Desejas sair do sistema?</div>
            <hr />
            <div id="exit_state" class="d-flex justify-content-center" role="alert"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Não</button>
                <a class="btn btn-danger" href="javascript:exit()">Sim</a>
            </div>
        </div>
    </div>
</div>
<!-- Change Modal-->
<div class="modal fade" id="change_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar minhas informações</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user">
                    <div class="form-group">
                        <input id="username_changed" type="text" class="form-control " />
                    </div>
                    <div class="form-group">
                        <input id="password_changed" type="password" class="form-control " />
                    </div>
                    <div class="form-group">
                        <input id="email_changed" type="text" class="form-control " />
                    </div>
                    <hr />
                    <div id="change_my_info_state" class="d-flex justify-content-center" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-success" href="javascript:changeMyInfo()">Alterar</a>
            </div>
        </div>
    </div>
</div>