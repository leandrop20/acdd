<link rel="stylesheet" href="<?= $prefixURL; ?>assets/css/menu.css">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-img" href="<?= $prefixURL; ?>home"><img style="vertical-align:text-top; margin-left:5px;" width="45" height="45" src="<?= $prefixURL; ?>assets/images/logoLogin.png" alt="logo"></a>
      <!-- <p class="navbar-text pull-right">
        <a href="#"><span id="bell" class="glyphicon glyphicon-bell" aria-hidden="true"></span> <span class="badge">0</span></a>
      </p> -->
    </div>
    <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
      <ul class="nav navbar-nav navbar-right">
      <?php if ($auth->getAuth()->setor == 0 || $auth->getAuth()->setor == 1 || $auth->getAuth()->setor == 2) { ?>
        <li><a href="<?= $prefixURL; ?>assistidos/index">Assistidos</a></li>
      <?php
      }
      if ($auth->getAuth()->setor == 0 ||$auth->getAuth()->setor == 1) {
      ?>
        <li><a href="<?= $prefixURL; ?>trabalhadores/index">Trabalhadores</a></li>
      <?php
      }
      if ($auth->getAuth()->setor == 0 || $auth->getAuth()->setor == 1 || $auth->getAuth()->setor == 2) {
      ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Atendimentos <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= $prefixURL; ?>atendimentos/passes/index">Passes</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?= $prefixURL; ?>atendimentos/cirurgias/index">Cirurgias</a></li>
            <li><a href="<?= $prefixURL; ?>atendimentos/cirurgias/retornos/index">Retornos</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?= $prefixURL; ?>atendimentos/desobsessoes/index">Desobsessões</a></li>
            <li><a href="<?= $prefixURL; ?>atendimentos/desobsessoes/retornos/index">Retornos</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?= $prefixURL; ?>atendimentos/agenda">Agenda</a></li>
          </ul>
        </li>
      <?php
      }
      if ($auth->getAuth()->setor == 0 || $auth->getAuth()->setor == 4) { ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cursos <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="<?= $prefixURL; ?>cursos/index">Lista de Cursos</a></li>
          <li><a href="<?= $prefixURL; ?>cursos/grupos/index">Grupos</a></li>
          </ul>
        </li>
        <?php 
        }
        if ($auth->getAuth()->setor == 0 || $auth->getAuth()->setor == 3) {
        ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Farmácia <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= $prefixURL; ?>farmacia/medicamentos/index">Medicamentos</a></li>
            <li><a href="<?= $prefixURL; ?>farmacia/lotes/index">Lotes</a></li>
            <li><a href="<?= $prefixURL; ?>farmacia/saidas/index">Saídas</a></li>
          </ul>
        </li>
        <?php
        }
        if ($auth->getAuth()->setor == 0) {
        ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= $prefixURL; ?>relatorios/assistidos">Assistidos</a></li>
            <li><a href="<?= $prefixURL; ?>relatorios/trabalhadores">Trabalhadores</a></li>
            <li><a href="<?= $prefixURL; ?>relatorios/atendimentos">Atendimentos</a></li>
            <li><a href="<?= $prefixURL; ?>relatorios/cursos">Cursos</a></li>
            <li><a href="<?= $prefixURL; ?>relatorios/farmacia">Farmácia</a></li>
          </ul>
        </li>
        <?php } ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle btn-circle btn-primary" style="width:40px; height:40px; margin:5px 5px; padding:10px 10px;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
          <ul class="dropdown-menu">
            <li><a class="btn disabled"><?= $authData->name; ?></a></li>
            <li><a href="<?= $prefixURL; ?>trabalhadores/edit/<?= $authData->id; ?>">Editar Perfil</a></li>
            <li><a href="<?= $prefixURL; ?>logout">Sair</a></li>
          </ul>
        </li>
      </ul>
      <!-- <p class="navbar-text pull-left">
        <?php //echo "Bem vindo(a) ".$authData->name."!" ?>
      </p> -->
    </div>
  </div>
</nav>