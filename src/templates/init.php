<link rel="stylesheet" href="<?= $prefixURL; ?>assets/css/signin.css">
<div class="container">
  <form class="form-signin" method="post" action="auth">
    <img class="img-responsive" alt="LogoLogin" src="<?= $prefixURL; ?>assets/images/logoLogin.png" style="width:150px;height:139px">
    <!-- <h2 class="form-signin-heading">Entre com login</h2> -->
    <label for="inputEmail" class="sr-only">Login</label>
    <input name="login" type="login" id="inputEmail" class="form-control" placeholder="Login" required="" autofocus="">
    <label for="inputPassword" class="sr-only">Senha</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Senha" required="">
    <div class="checkbox">
      <!-- <label>
        <input name="remember" type="checkbox" value="yes"> Lembre-me
      </label> -->
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
  </form>
</div>