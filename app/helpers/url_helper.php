<?php
/**Redireccionar Paginas */
function redirect($page)
{
    header('location: '.APP_URL.$page);
}