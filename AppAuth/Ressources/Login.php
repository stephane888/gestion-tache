<link 	href="/App/Ressources/css/conecxion.css" rel="stylesheet">

	<div class="container mt-5" id="login">
		<div class="row justify-content-center">
			<div class="col-lg-5 d-flex align-items-center container-login">
				<div class="login w-100 ">
					<?php
    include_once getenv("DOCUMENT_ROOT") . '/App/Ressources/Alert.php';

    ?>
					<form method="POST" >
						<div class="mb-4">
  						<div class="form-group">
  							<input type="email" class="form-control" id="exampleInputEmail1" name="email"
  								aria-describedby="emailHelp" placeholder="Votre email">
  						</div>
  						<div class="form-group">
  							<input type="password" class="form-control" name="password"
  								id="exampleInputPassword1" placeholder="Mot de passe">
  						</div>
  						<div class="form-check ">
                <input class="form-check-input" type="checkbox" name="remember_me" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                  souvenir de moi
                </label>
             </div>
           </div>
					<div >
						<button type="submit" class="btn btn-block btn-classik">Valider</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>