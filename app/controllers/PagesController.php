<?php


    class Pages extends Controller
    {

       public function index()
       {
          if( isLoggedIn() ) {
             redirect('posts');
          }
          $data = [
              'title' => 'PHP MVC',
              'description' => 'Proyecto PHP/MVC Base.'
          ];
          $this->view('pages/index', $data);
       }

       public function about()
       {
          $data = [
              'title' => 'Acerca de',
              'description' => 'Simple CRUD de Post.'
          ];
          $this->view('pages/about',$data);
       }
    }