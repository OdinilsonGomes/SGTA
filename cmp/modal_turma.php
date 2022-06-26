<!-- Modal Adicionar Turma -->
<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registar Turma</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user-insert">
                    <div class="form-group">
                        <input id="nome_turma" type="text" class="form-control " maxlength="150" placeholder="Nome"/>
                    </div>
                    <div class="form-group">
                        <input id="serie_turma" type="text" class="form-control " maxlength="150" placeholder="Serie"/>
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
<!-- FIM Modal Adicionar Turma -->

<!-- Modal Alteração da turma -->
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar Turma</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user-insert">
				<input id="id_to_update" type="hidden" class="form-control" />
                    <div class="form-group">
                        <input id="nome_turmaU" type="text" class="form-control"  maxlength="150"  placeholder="Nome"/>
                    </div>
                 
                    <div id="update_state" class="" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-success" href="javascript:updateAsync()">Alterar</a>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal Alteração da turma -->

<!-- Modal Ver Aluno da Turma-->
<div class="modal fade" id="ver_aluno_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aluno_modal_titulo"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <input id="id_turma_aluno_filtro"  type="hidden" class="form-control" placeholder="ID"/>
                <table id="dataTableAluno" class="table table-striped table-bordered table-hover display">
                <thead>
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>Data Nascimento</th>
                      <th>Email</th>
                    </tr>
					 <tr>
                      <th></th>
                      <th><input id="nome_aluno_filtro" onkeyUp="fetchAlunoByNome()"  type="text" class="form-control" placeholder="Filtrar por nome"/></th>
                      <th></th>
                      <th></th>
                    </tr>
					
                </thead>
                <tbody id="bodyDataTableAluno">
				
				</tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!--  Fim ver Aluno da Turma-->

<!-- Del Modal-->
<div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Turma</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Desejas eliminar esta turma?</p>
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