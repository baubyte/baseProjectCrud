<?php
defined('BASEPATH') or exit('No se permite acceso directo');
/**
 * Controlador Principal
 * Se encarga de cargar las Vistas y Modelos
 */
class Controller
{
  /**
   * Carga el modelo le pasemos y lo instancia
   *
   * @param [string] $model Modelo a Instanciar
   * @return void
   */
  public function model($model)
  {
    /**Requerimos el Archivo del Modelo */
    require_once '../app/models/' . $model . '.php';

    /**Instanciamos el Modelo */
    return new $model();
  }

  /**
   * Carga la visa que le pasemos y le pase los parámetros que mandemos.
   *
   * @param [string] $view Vista a Cargar
   * @param array $data Daros a mostrar en la vista.
   * @return void
   */
  public function view($view, $data = [])
  {
    /**
     * Comprobamos si el archivo existe, si es asi lo requerimos.
     * Caso contrario mostramos un error.
     **/
    if (file_exists('../app/views/' . $view . '.php')) {
      require_once('../app/views/inc/header.php');
      require_once('../app/views/' . $view . '.php');
      require_once('../app/views/inc/footer.php');
    } else {
      /**La Vista no Existe. */
      die('La Vista No Existe.');
    }
  }
}
