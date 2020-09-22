<?php
/**Redireccionar Paginas */
function redirect($page)
{
    header('locahost'.APP_URL.$page);
}