<section id="regiter">
	<div class="row ">
		<div class="col-lg-6 mx-auto mt-5">
			<div class="card">
				<h3 class="card-header">Creer un compte</h3>
				<div class="card-body">
					<div class="mb-5">
						<input_text_v2 :input="email" :label="'Email'" :id_html="'field-email'"></input_text_v2>
  					<input_text_v2 :input="password" :label="'Mot de passe'" :id_html="'field-password'"></input_text_v2>
  					<input_text_v2 :input="password_confirm" :label="'Confirmer le mot de passe'" :id_html="'field-password-2'"></input_text_v2>
  					<input_select_v2 :label="'Selection le role'" :input="role"></input_select_v2>
  					<input_radio_v2 :input="activation_compte" :label="'Activer le compte'"></input_radio_v2>
					</div>
					<div class="d-flex "><span class="btn btn-outline-success ml-auto " @click="register">Créer le compte</span></div>
				</div>
			</div>
		</div>
	</div>
	<send_data_ajax :url="url_post" :headers="headers" @ev_data_from_ajax="data_from_ajax" :datas="post_datas" :trigger_loanding="trigger_post_loanding"></send_data_ajax>
</section>

<script src="/App/Ressources/js/register.js?v=<?php
echo time();
?>"></script>