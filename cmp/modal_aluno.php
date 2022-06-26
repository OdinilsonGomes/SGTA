<!-- Modals -->
<!-- Add Modal-->
<!-- Add Modal-->

<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registar Aluno</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user-insert">
					<div class="form-group row">
                       <div class="col-lg-2"><label><b>Turma:</b></label></div>
					   <div class="col-lg-10"><select id="turma_aluno_insert" class="form-control"></select></div>
                    </div>
                    <div class="form-group">
                        <input id="nome_aluno" type="text" class="form-control" placeholder="Nome"  maxlength="150"/>
                    </div>
                    <div class="form-group">
                        <input id="data_nasc_aluno" type="date" class="form-control" placeholder="Data nascimento" />
                    </div>
					<div class="form-group">
                        <input id="email_aluno" type="email" class="form-control" placeholder="Email"  maxlength="150"/>
                    </div>
                   
                   
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
                <h5 class="modal-title">Alterar Aluno</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user-insert">
					<input id="id_aluno_update" type="hidden" class="form-control" placeholder="ID"/>
					<div class="form-group row">
                       <div class="col-lg-2"><label><b>Turma:</b></label></div>
					   <div class="col-lg-10"><select id="turma_aluno_update" disabled class="form-control"></select></div>
                    </div>
                    <div class="form-group">
                        <input id="nome_aluno_update" type="text" class="form-control" placeholder="Nome"  maxlength="150"/>
                    </div>
                    <div class="form-group">
                        <input id="data_nasc_aluno_update" type="date" class="form-control" placeholder="Data nascimento"/>
                    </div>
					<div class="form-group">
                        <input id="email_aluno_update" type="email" class="form-control" placeholder="Email"  maxlength="150" />
                    </div>
                   
                   
                    <div id="update_state" class="" role="alert">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-success" href="javascript:updateAsync()">Alterar</a>
            </div>
        </div>
    </div>
</div>

<!-- Del Modal-->
<div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Aluno</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Desejas eliminar esse aluno?</p>
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
