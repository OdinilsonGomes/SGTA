<!-- Modals -->
<!-- Add Modal-->
<!-- Modal Inserir Transferencia Aluno --> 
<div class="modal fade" id="transferir_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transferir Aluno</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="aluno-transferir">
					<div class="form-group">
						<input id="id_aluno_tranferir_insert" type="hidden" class="form-control" placeholder="Id Aluno"/>
                       <label><b>Turma Destino:</b></label>
					   <select id="turma_tranferir_insert" class="form-control"></select>
                    </div>
                    <div class="form-group">
					<label><b>Data:</b></label>
                        <input id="data_transferir" type="date" class="form-control" placeholder="data"/>
                    </div>
                    <div class="form-group">
					<label><b>Motivo:</b></label>
                        <input id="motivo_transferir" type="text" class="form-control" placeholder="Motivo"  maxlength="150"/>
                    </div>
					
                    <div id="transferir_state" class="" role="alert">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-success" href="javascript:transferirAsync()">Registar</a>
            </div>
        </div>
    </div>
</div>
<!-- FIM Transferencia Aluno --> 


<!-- Modal Actualizar Transferencia Aluno --> 
<div class="modal fade" id="transferir_modal_update" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Transferência do Aluno</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="aluno-transferir">
					<div class="form-group">
						<input id="id_tranferirencia_update" type="hidden" class="form-control" placeholder="Id Aluno"/>
                       <label><b>Turma Destino:</b></label>
					   <select id="turma_tranferir_update" class="form-control"></select>
                    </div>
                    <div class="form-group">
					<label><b>Data:</b></label>
                        <input id="data_transferir_update" type="date" class="form-control" placeholder="data"/>
                    </div>
                    <div class="form-group">
					<label><b>Motivo:</b></label>
                        <input id="motivo_transferir_update" type="text" class="form-control" placeholder="Motivo"  maxlength="150"/>
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
<!-- Fim Actualizar Transferencia Aluno --> 

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
