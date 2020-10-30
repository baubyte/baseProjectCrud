<?php
/**Archivo que se encarga de Arrancar toda la Aplicacion.*/

/**
 * Cargamos toda la Configuración de la Aplicacion.
 */
require_once 'config/config.php';

/**
 * Cargamos los Helpers o Ayudantes de la Aplicacion.
 */
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/datetime_helper.php';

/**
 * Autocargamos todas las clases de la Aplicacion.
 */
spl_autoload_register(function ($className) {
    require_once 'libraries/' . $className . '.php';
});
