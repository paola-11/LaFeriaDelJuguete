
<header>
		
		<div class="logo-space"><a href="index.php"><img src="img/logo.png"></a></div>
		
		<div class="search-space">
			<input type="text" id="idsearch" placeholder="Qu&eacute; est&aacute;s buscando.."value="<?php if(isset($_GET['text'])){echo $_GET['text'];}else{echo '';} ?>">
			<button class="btn-print btn-buscar" onclick="buscar_productos()"><i class="fa fa-search" aria-hidden="true"></i></button>

		</div>
		<div class="header-options">
			<?php
			if (isset($_SESSION['cdusu'])) {
				echo 
				'<div class="catalog-option"><i class="fa fa-user" aria-hidden="true"></i><p>'.$_SESSION['nomusu'].'</p></div>';
			}else{
			?>
			<a href="registro.php" title="Registrate">
			<div class="catalog-option" ><i class="fa fa-user" aria-hidden="true"></i></div>
		</a>


			<a href="login.php" title="Ingresar">
			<div class="catalog-option" ><i class="fa fa-sign-in" aria-hidden="true"></i></div>
			</a>


			<?php
				}
			?>
			
			<div class="catalog-option" title="Mis compras">
				<a href="carro.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
			</div>
		</div>
	</header>