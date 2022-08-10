<?php
/**
 * Plugin Name: KFP Plugin Form
 * Author: Yesid Oviedo
 * Description: Formulario Personalizado con DB
 * shortcode [kfp_plugin_form]
 */

 //Define el shortcode que pinta el formulario
add_shortcode( 'kfp_plugin_form', 'KFP_Plugin_form');

function KFP_Plugin_form()
{
    ob_start();
    ?>
<form action="<?php get_the_permalink(); ?>" method="post" class="cuestionario">
    <div class="form-input">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required>
    </div>
    <div class="form-input">
        <input type="submit" value="Enviar">
    </div>
</form>
<?php
    return ob_get_clean();
}