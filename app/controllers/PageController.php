<?php
defined('BASEPATH') or exit('No se permite acceso directo');
class PageController extends Controller
{

   public function index()
   {
      if (isLoggedIn()) {
         redirect('post');
      }
      $data = [
         'title' => 'PHP MVC',
         'description' => 'Proyecto PHP/MVC Base.'
      ];
      $this->view('page/index', $data);
   }

   public function about()
   {
      $data = [
         'title' => 'Acerca de',
         'description' => 'Simple CRUD.'
      ];
      $this->view('page/about', $data);
   }
}
