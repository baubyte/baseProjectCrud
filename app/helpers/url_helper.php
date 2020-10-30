<?php
    /**Helper url redirect
     * Hace un header location a la pagina que se le pase por parámetros
     * Ejemplo redirect('users/login');
     * @param string $page pagina a redirigir
     * @return void
     *
    **/
    function redirect( $page ){
        header('Location: ' .URL_ROOT . '/' . $page);
    }
