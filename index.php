<?php
$prefixURL = "";
for ($i = 0; $i < (count($_GET)-1); $i++) {
	$prefixURL .= "../";
}

use controllers\AuthController;
require 'vendor/autoload.php';

$auth = new AuthController();
$authData = $auth->getAuth();

$checkLASTPARAM = explode("/", $_SERVER['REQUEST_URI']);
$lastParam = $checkLASTPARAM[count($checkLASTPARAM)-1];
$ID = null;
if (is_numeric($lastParam)) {
	$ID = $lastParam;
}

if ($lastParam != "search" && $lastParam != "searchInstrutor" && $lastParam != "saveImage") {
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>SYS A Caminho de Deus</title>
		<link rel="icon" href="<?= $prefixURL; ?>assets/images/favicon.png" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?= $prefixURL; ?>plugins/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="<?= $prefixURL; ?>assets/css/default.css">
		<script src="<?= $prefixURL; ?>plugins/jquery/jquery-1.12.4.min.js"></script>
		<script src="<?= $prefixURL; ?>plugins/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
		<script> function redirect(url) { window.location = url; } </script>
	</head>
	<body>
		<?php
}
		$url = "src/templates";
		if ($authData->status) {
			$numParams = count($_GET);
			switch ($numParams) {
				case 0:
					require_once($url."/menu.php");
					require_once($url."/home.php");
					break;
				case 1:
					if ($numParams == 1 && $_GET["param1"] == "logout") {
						$auth->logout();
						require_once($url."/init.php");
					} else {
						require_once($url."/menu.php");
						require_once($url."/".$_GET["param".$numParams].".php");
					}
					break;
				default:
					if ($lastParam != "search" && $lastParam != "searchInstrutor" && $lastParam != "saveImage") { require_once($url."/menu.php"); }
					if ($ID) {
						for ($i = 0; $i < count($_GET)-1; $i++) {
							$url .= "/".$_GET["param".($i+1)];
						}
					} else {
						for ($i = 0; $i < count($_GET); $i++) {
							$url .= "/".$_GET["param".($i+1)];
						}
					}
					$url .= ".php";
					$url = str_replace("delete", "index", $url);
					require_once($url);
					break;
			}
		} else {
			if (!empty($_GET["param1"])) {
				if ($auth->checkLog()) {
					header("Location: ".$prefixURL."home");
				} else {
					?><div class="alert alert-danger" role="alert">
        				<strong>Ops!</strong> usuário ou senha inválidos.
      				</div><?php
      				require_once($url."/init.php");
				}
			} else {
				require_once($url."/init.php");
			}
		}
if ($lastParam != "search" && $lastParam != "searchInstrutor" && $lastParam != "saveImage") {
		?>
	</body>
	<div class="version text-muted"><?= "v 1.0.0" ?></div>
</html>
<?php
}
?>