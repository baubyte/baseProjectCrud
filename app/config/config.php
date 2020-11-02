<?php
defined('BASEPATH') or exit('No se permite acceso directo');
    /**Parámetro de Configuración para la 
     * conexiona a la Base de datos.
     **/
    /**DB_HOST Servidor de la Base de datos.*/
    define('DB_HOST','localhost');
    /**DB_USER Usuario de la Base de datos.*/
    define('DB_USER','root');
    /**DB_PASS Contraseña de la Base de datos.*/
    define('DB_PASS','');
    /**DB_NAME Nombre de la Base de datos.*/
    define('DB_NAME','db_crud');
    /**DB_CHARSET Codificación para la conexión de la Base de datos.*/
    define('DB_CHARSET','utf8');
    /***APP_ENV Entorno de la Aplicacion local,development,production. */
    define('APP_ENV','development');
    /**APP_ROOT Ruta Raíz de la Aplicación */
    define('APP_ROOT', dirname(dirname(__FILE__)));
    /**URL_ROOT URL Raíz de la Aplicación */
    define('URL_ROOT','http://baseprojectcrud.test:8080');
    /**SITE_NAME Nombre de la Aplicación */
    define('SITE_NAME', 'Base Proyecto');
    /**SITE_NAME Version de la Aplicación */
    define('APP_VERSION', '1.0.2');
    /**APP_DATE Fecha de Version de la Aplicación */
    define('APP_DATE', '30/10/2020');
    /**APP_DATE_TIME_FORMAT Formato de Fecha y Hora de la Aplicación */
    define('APP_DATE_TIME_FORMAT', 'd/m/Y H:i:s');
