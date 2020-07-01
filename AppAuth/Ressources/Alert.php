<?php
if (! empty($Connect::$message)) {

  ?>
    <div class="alert <?php

  echo $Connect::$alert_class?>" role="alert">
  			<?php
  echo $Connect::$message;
  ?>
		</div>
		<?php
}
?>