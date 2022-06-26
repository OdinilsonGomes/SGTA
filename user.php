<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SGIDOC</title>

   

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            require_once("cmp/session.php");
			require_once 'cmp/menu_lateral.php';
		
		?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
					<?php require_once 'cmp/topo.php'; ?>
				<!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="content">

                    <!-- Page Heading -->
                    <div class="col-lg-12">
                        <div class="align-items-center justify-content-between mb-4">
                        
                        <a href="javascript:open_formUser(0);" class="d-none d-sm-inline-block btn  btn-primary shadow-sm"><i
                            class="fas fa-plus text-white-50"></i> Novo utilizador</a>
                        </div>
                    </div>
                    

                    <!-- Content Row -->
                    <div class="row">
						<div class="card-body">
                            <div class="">
                                <table id="dataTable"  class="table table-striped table-bordered table-hover display" >
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Nif</th>
                                            <th>Data Nascimento</th>
                                            <th>Email</th>
                                            <th>Ver Acessos</th>
                                            <th>Novo Acessos</th>
                                            <th>Alterar</th>
                                            <th>Eliminar</th>
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

              
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
                <?php 
                require 'cmp/footer.php';
                require 'cmp/modal_remove.php';
                require 'cmp/funcao.php';
                ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <div id="form-adduser" title="Adicionar utilizador" style="display:none;">
      
        <form id="messageForm" method="POST" action="post_contato.php">
            <div class="row">
            <input type="hidden" id="id_utilisador" name="nome" class="form-control"/>
                <div class="col-lg-2"><label><b>Nome:</b></label></div>
                <div class="col-lg-10"><input type="text" id="nome_utilisador" name="nome" class="form-control"/></div>
            </div><br>
            <div class="row">
                <div class="col-lg-2"><label><b>Nif:</b></label></div>
                <div class="col-lg-10"><input type="number" id="nif_utilisador" maxlength="9" name="nif_utilisador" class="form-control"/></div>
            </div><br>
            <div class="row">
                <div class="col-lg-4"><label><b>Data Nascimento:</b></label></div>
                <div class="col-lg-8"><input type="date" id="data_utilisador" name="data_utilisador" class="form-control"/></div>
            </div><br>
            <div class="row">
                <div class="col-lg-2"><label><b>Email:</b></label></div>
                <div class="col-lg-10"><input type="email" id="email_utilisador" name="nome" class="form-control"/></div>
            </div><br>
            <div class="row">
                <div class="col-lg-2"><label><b>Password:</b></label></div>
                <div class="col-lg-10"><input type="password" id="password_utilisador" name="nome" class="form-control"/></div>
            </div><br>
            <div class="row">
                <div class="col-lg-4"><label><b>Confirmação da Password:</b></label></div>
                <div class="col-lg-8"><input type="password" id="password_utilisador2" name="nome" class="form-control"/></div>
            </div>
            
        </form>
          <div id="user_state" class="col-lg-12 alert-danger" align="center"></div>     
	</div>

    
    <div id="form-addacess" title="Adicionar Acesso" style="display:none;">
      
        <form id="messageForm" method="POST" action="post_contato.php">
            <div class="row">
            <input type="hidden" id="id_utilisadorPerfil" name="nome" class="form-control"/>
                <div class="col-lg-2"><label><b>Nome:</b></label></div>
                <div class="col-lg-10"><input type="text" id="nome_utilisadorPerfil" desabled="desabled" name="nome" class="form-control"/></div>
            </div><br>
            <div class="row">
                <div class="col-lg-2"><label><b>Instituição:</b></label></div>
                <div class="col-lg-10">
                    <select type="text" id="id_instituicao" name="nome" class="form-control" placeholder="Instituição" >
                        <?php echo optionEntity2(); ?>
                    </select>
                </div>
            </div><br>
            <div class="row">
                <div class="col-lg-4"><label><b>Sector:</b></label></div>
                <div class="col-lg-8">
                    <select type="text" id="id_sector" name="nome" class="form-control" placeholder="Sector" >
                        <?php echo optionSector(); ?>
                    </select>
                </div>
            </div><br>
            <div class="row">
                <div class="col-lg-2"><label><b>Categoria:</b></label></div>
                <div class="col-lg-10">
                    <select type="text" id="id_categoria" name="nome" class="form-control" placeholder="Categoria"  >
                        <?php echo optionCategoria(); ?>
                    </select>
                </div>
            </div><br>
            <div class="row">
                <div class="col-lg-2"><label><b>Previlegio:</b></label></div>
                <div class="col-lg-10">
                    <select type="text" id="id_previlegio" name="nome" class="form-control" placeholder="Categoria" >
                        <option value="0">Super Administrador</option>
                        <option value="1">Administrador</option>
                        <option value="2">Secretaria</option>
                        <option value="3">Utilizador</option>
                    </select>
                </div>
            </div>
            
        </form>
          <div id="user_statePerfil" class="col-lg-12 alert-danger" align="center"></div>     
	</div>

    
    <div id="form-viewacess" title="Ver Acessos" style="display:none;">
    <input type="hidden" id="id_utilisadorView" name="nome" class="form-control"/>
    <div class="row">
        <div id="result_viewacess"></div>
    </div>  
	</div>
    <script src="js/user.js"></script>

   
 
</body>

</html>