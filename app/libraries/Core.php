<?php
/*
* Clase principal de la aplicación
* Crear URL y cargar controlador central
* FORMATO URL - /controller/method/params
* Ejemplo /article/update/1
**/
class Core
{
    /**Propiedad Singleton*/
    private static $instance;
    /**Propiedad para el Controlador Actual por 
     * Defecto siempre es Pages
     **/
    protected $currentController = 'Pages';
    /**Propiedad para el Método Actual por 
     * Defecto siempre es index
     **/
    protected $currentMethod = 'index';
    /**Propiedad para los Parámetros**/
    protected $params = [];

    public function __construct()
    {
        /**Obtenemos la URL es un array */
        $url = $this->getUrl();
        /**Tomamos el primer valor para el Controlador y 
         * verificamos si existe el archivo.
         * Ponemos en Mayúscula primer letra de la Palabra
         **/
        if (file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')) {
            /**Si existe seteamos el controlador y blanqueamos 
             * la primer posición del array $url.
             **/
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        /**
         * Requerimos el Controlador y lo Intanciamos.
         */
        require_once '../app/controllers/' . $this->currentController . 'Controller.php';
        $this->currentController =  new $this->currentController;

        /**
         * Verificamos la segunda parte de la url.
         * Para ver si estamos pasando un método.
         */
        if (isset($url[1])) {
            /**Verificamos si el Método existe en la clase.
             * Si existe o Seteamos.
             * Blanqueamos la posición del array url.
             */
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        /**
         * Verificamos si el array url tiene valores.
         * Si tiene seteamos params, sino lo dejamos vacío.
         */
        $this->params = $url ? array_values($url) : [];

        /**
         * Llamamos al metodo con un array de parámetros.
         */
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
    
    /**getInstance
     * este método singleton devolverá una instancia de la clase.
     *@param no recibe parámetros
     *@return instancia de la clase
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instance;
    }
    /**
     * Obtiene la url, la limpia y convierte en array. 
     *
     * @return array $url con todos los parámetros del la url
     */
    public function  getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
