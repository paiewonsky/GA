<?php
/*
Plugin Name: Google Analytics-UD
Description: Inserción código Google Analytics
Version: 1.0
Author: Miren Cava */

// Hook the 'wp_head' action hook, add the function named 'setGA' to it
add_action("wp_head", "setGA");

function setGA()
{
  $options = get_option('ud_analytics_setup');
  error_log("Estamos en setGA ");
  error_log( $options['UA']);
  echo '<!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id='.$options['UA'].'"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());
    gtag("config", "'.$options['UA'].'");
  </script>'; 

}


add_action('admin_menu', 'ud_analytics_init');

// añade el menu en el sidebar de la izquierda
function ud_analytics_init(){
	add_menu_page(
		"Google Analytics",
		"Google Analytics",
		'level_10',
		'ud-google-analytics',
		'ud_analytics_setup'
	);
}



function ud_analytics_setup(){
  $options = get_option('ud_analytics_setup');
  if(!is_array($options)){
    $options['UA'] = '';
  }


  // $_POST tenemos el control de manejar los datos que llegan del formulario
  if (isset($_POST['ud_analytics_setup_submitted']) && $_POST['ud_analytics_setup_submitted']) {
    $options['UA']   = isset($_POST['UA']) && !empty($_POST['UA']) ? $_POST['UA'] : '';

    update_option('ud_analytics_setup', $options);
  
    ?>
    <div id="setting-error-settings_updated" class="updated settings-error">
    
        <button onclick="esconderBanner()" >Cerrar</button>
        <p><strong>Configuración guardada.</strong></p>
    </div>
    <script type="text/javascript">
          function esconderBanner() {
            document.getElementById("setting-error-settings_updated").style.visibility = "hidden";
          }
    </script> 


    <?php
  }

  
	?>
  <div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>

  
    <form action="?page=ud-google-analytics"  method="post">
         
          <h3>Configuración de Google Analytics</h3>
          <table class="form-table">
              <tr valign="top">
                  <th scope="row"><label for="UA">Código Analytics:</label></th>
                  <td><input placeholder="Código Analytics" name="UA" id="UA" value="<?php echo esc_attr(stripslashes($options['UA']));?>" required></td>
              </tr>
              <!-- <tr>
              <th scope="row"><label for="URL">URL</label></th>
              <td><input placeholder="url" name="URL" id="URL" value="<?php echo esc_attr(stripslashes($options['URL']));?>" required></td>
              <tr> -->
              
          </table>


        
          <input type="hidden" name="ud_analytics_setup_submitted" value="1" />
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Guardar cambios"  /></p>
    </form>
  </div>
<?php

}

?>