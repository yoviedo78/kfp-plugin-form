<?php
/**
 * Plugin Name: KFP Plugin Form
 * Author: Yesid Oviedo
 * Description: Formulario Personalizado con DB
 * shortcode [kfp_plugin_form]
 */

register_activation_hook(__FILE__, 'Kfp_Comprador_init');

function Kfp_Comprador_init()
{
    global $wpdb;
    $tabla_comprador = $wpdb->prefix . 'comprador';
    $charset_collate = $wpdb->get_charset_collate();
    //Prepara la consulta
    $query = "CREATE TABLE IF NOT EXISTS $tabla_comprador(
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        pais varchar(40) NOT NULL,
        compania varchar(40) NOT NULL,
        nombre varchar(40) NOT NULL,
        apellido varchar(40) NOT NULL,
        telefono varchar(50) NOT NULL,
        email varchar(100) NOT NULL,
        tipocliente varchar(50) NOT NULL,
        created_at datetime NOT NULL,
        UNIQUE (id)
        ) $charset_collate";
    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query);
}

 //Define el shortcode que pinta el formulario
add_shortcode( 'kfp_plugin_form', 'KFP_Plugin_form');

function KFP_Plugin_form()
{
    global $wpdb;
    
    if (!empty($_POST) AND
        $_POST['nombre'] != '' AND is_email($_POST['email']) AND
       strlen($_POST['telefono']) > 5)
       {
        $tabla_comprador = $wpdb->prefix . 'comprador';
        $pais = sanitize_text_field($_POST['pais']);
        $compania = sanitize_text_field($_POST['compania']);
        $nombre = sanitize_text_field($_POST['nombre']);
        $apellido = sanitize_text_field($_POST['apellido']);
        $telefono = sanitize_text_field($_POST['telefono']);
        $email = sanitize_email($_POST['email']);
        $tipocliente = sanitize_text_field($_POST['tipocliente']);
        $created_at = date('d-m-Y H:i:s');
        $wpdb->insert($tabla_comprador, array('pais' => $pais,  
                                              'compania' => $compania,
                                              'nombre' => $nombre,
                                              'apellido' => $apellido,
                                              'telefono' => $telefono,
                                              'email' => $email,
                                              'tipocliente' => $tipocliente,
                                              'created_at' => $created_at
                                            ));
    }
    ob_start();
    ?>
<form action="<?php get_the_permalink(); ?>" method="post" class="cuestionario">
    <div class="form-input">
        <label for="pais">Pais</label>
        <input type="text" name="pais" id="pais" required>
    </div>
    <div class="form-input">
        <label for="compania">Campañia</label>
        <input type="text" name="compania" id="compania" required>
    </div>
    <div class="form-input">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required>
    </div>
    <div class="form-input">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" required>
    </div>
    <div class="form-input">
        <label for="telefono">Telefono</label>
        <input type="text" name="telefono" id="telefono" required>
    </div>
    <div class="form-input">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-input">
        <label for="tipocliente">Tipo Cliente</label>
        <input type="text" name="tipocliente" id="tipocliente" required>
    </div>

    <div class="form-input">
        <input type="submit" value="Enviar">
    </div>
</form>
<?php
    return ob_get_clean();
}