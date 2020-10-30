<?php
session_start();

/**Flash Mensaje Helper
 * Ejemplo flash('mensaje_usuario','Te has Registrado')
 * Para Mostrar en la Vista - <?php echo flash('mensaje_usuario'); ?>
 * @param string $name nombre del mensaje
 * @param string $message mensaje a mostrar
 * @param string $class clase del alert usando bootstrap por 
 **/
function flash($name = null, $message = null, $class = 'alert alert-success alert-dismissible fade show')
{
    /** Entramos Solo si el Nombre No esta vacío es decir que
     * se le esta pasando parámetros.
     */
    if (!empty($name)) {
        /** Comprobamos si el mensaje No esta vacío es decir que le estamos
         * pasando parámetros ya sesión con ese nombre esta vaciá
         * si asi entramos y creamos el mensaje caso contrario estamos queriendo
         * mostrar un mensaje y lo mostramos y limpiamos las sesiones.
         **/
        if (!empty($message) && empty($_SESSION[$name])) {
            /**Si la sesión con ese nombre mo esta vacía la limpiamos */
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            /**Si la sesión con ese nombre mo esta vacía la limpiamos */
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }
            /**Creamos y Guardamos el mensaje en la
             * sesión con el nombre pasado por parámetros.
             **/
            $_SESSION[$name] = $message;
            /**Creamos y Guardamos en la sesión con el nombre
             * pasado por parámetros y le concatenamos _class para
             * la clase del mensaje.
             * */
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            /**Guardamos en $class "$name . '_class'" cuando es no esta vaciá la 
             * sesión "$name . '_class'" sino la dejamos vaciá.
             **/
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            /**Mostramos el mensaje con la clase por defecto o con 
             * la que se le pase por parámetros.
             **/
            echo '<div class="' . $class . '" id="msg-flash" role="alert">' . $_SESSION[$name] . '
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span></button>
                     </div>';
            /**Limpiamos todas la sesiones usadas */
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}
/**Comprueba si el usuario esta logueado
 *@param no necesita
 *@return bolean True si esta logueado False sino lo esta
 */
function isLoggedIn()
{
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
        return true;
    } else {
        return false;
    }
}
