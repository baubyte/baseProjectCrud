<?php
defined('BASEPATH') or exit('No se permite acceso directo');
/**PDO Database Class
 * Permite a conectar a la Base de datos
 * Crear consultas preparadas
 * Bind Vincular valores
 * Retornar filas y resultados
 **/
class Database
{

    /**Propiedad Singleton*/
    private static $instance;
    /**Propiedad Servidor de Base de Datos*/
    private $host = DB_HOST;
    /**Propiedad Usuario de Base de Datos*/
    private $user = DB_USER;
    /**Propiedad Contraseña de Base de Datos*/
    private $pass = DB_PASS;
    /**Propiedad Codificación para conexión Base de Datos*/
    private $charset = DB_CHARSET;
    /**Propiedad Base de Datos*/
    private $dbname = DB_NAME;
    /**Propiedad Instancia de Conexión de Base de Datos*/
    private $dbh;
    /**Propiedad Consultas Preparadas de Base de Datos*/
    private $stmt;
    /**Propiedad Errores en la ejecución*/
    private $error;

    public function __construct()
    {
        /**Sesteamos el dsn */
        $dsn = 'mysql:host=' . $this->host . ';charset=' . $this->charset . ';dbname=' . $this->dbname;
        /**Opciones para la Conexión
         * ATTR_PERSISTENT conexión persistente, en lugar de crear una nueva conexión.
         * ATTR_ERRMODE -> ERRMODE_EXCEPTION laza una excepción con un error.
         * ATTR_DEFAULT_FETCH_MODE-> devuelve un objeto asociativo.active.
         * ATTR_CASE->CASE_LOWER forzamos los nombres de columnas en minúsculas.
        */
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_LOWER
        );

        /**Instancia de la Conexión.
         * Capturamos el Error.
        */
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
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

    /**Consultas Preparadas
     * 
     * @param string $sql Query a ejecutar.
     * @return void
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Vinculamos los Valores a la query preparada
     *
     * @param [string] $param columna a vincular con valor.
     * @param [string] $value valor a vincular con la columna.
     * @param [string] $type tipo de valor para validar
     * @return void
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Ejecuta las consultas preparadas
     *
     * @return void
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Ejecuta la consulta preparada para multiples resultados
     *
     * @return void
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Ejecuta la consulta preparada para un solo resultado
     *
     * @return void
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Ejecuta la consulta preparada y devuelve el numero de filas
     *
     * @return void
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
