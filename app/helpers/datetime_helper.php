<?php
defined('BASEPATH') or exit('No se permite acceso directo');
    /**Helper para dar formato a la fecha y hora
     *@param Date $date Fecha a Formatear
     *@param Formato $format Formato a dar Opcional
     *@return fecha formateada
    **/
    function helper_format_date($date, $format = APP_DATE_TIME_FORMAT){
        return date( $format, strtotime($date) );
    }
