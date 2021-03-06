<?php
defined('BASEPATH') or exit('No se permite acceso directo');
class PostController extends Controller
{
   public function __construct()
   {
      if(!isLoggedIn() ){
         redirect('user/login');
      }
      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
   }

   public function index()
    {
       $posts = $this->postModel->getPosts();
       $data = [
          'posts' => $posts
       ];
       $this->view('post/index', $data);
    }


    public function add()
    {
       if($_SERVER['REQUEST_METHOD']=='POST'){
          /**Limpiamos Saneamos el Array POST */
          $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

          $data = [
             'title' => trim($_POST['title']),
             'body' => trim($_POST['body']),
             'user_id' => $_SESSION['user_id'],
             'title_err' => '',
             'body_err' => ''
          ];

          /**Validaciones */
          if( empty($data['title']) ){
             $data['title_err'] = 'Por favor ingrese el titulo.';
          }
          if( empty($data['body']) ){
             $data['body_err'] = 'Por favor ingrese el cuerpo.';
          }

          /**Verificamos si no hubo errores */
          if ( empty($data['title_err']) && empty($data['body_err']) ){
             /**Validamos*/
             if( $this->postModel->addPost($data) ){
                flash('post_message', 'Post Agregado con Éxito.');
                redirect('post');
             } else{
                die('Algo salió mal.');
             }
          } else {
             /**Cargamos la Vista */
             $this->view('post/add', $data);
          }

       } else{
          $data = [
             'title' => '',
             'body' => ''
          ];
          $this->view('post/add', $data);
       }

    }



   public function edit($id)
   {
      if($_SERVER['REQUEST_METHOD']=='POST'){
         /**Limpiamos Saneamos el Array POST */
         $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

         $data = [
            'id' => $id,
            'title' => trim($_POST['title']),
            'body' => trim($_POST['body']),
            'user_id' => $_SESSION['user_id'],
            'title_err' => '',
            'body_err' => ''
         ];

         /**Validaciones */
         if( empty($data['title']) ){
            $data['title_err'] = 'Por favor ingrese el titulo.';
         }
         if( empty($data['body']) ){
            $data['body_err'] = 'Por favor ingrese el cuerpo.';
         }

         /**Verificamos si no hubo errores */
         if ( empty($data['title_err']) && empty($data['body_err']) ){
            /**Validamos */
            if( $this->postModel->updatePost($data) ){
               flash('post_message', 'Publicación Editado con Éxito.');
               redirect('post');
            } else{
               die('Algo salió mal.');
            }
         } else {
            /**Cargamos la Vista */
            $this->view('post/edit', $data);
         }

      } else{
         /**Buscamos el POST y validamos si es del usuario*/
         $post = $this->postModel->getPostById($id);
         if( $post->user_id != $_SESSION['user_id'] ){
            redirect('post');
         }
         $data = [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'title_err' => '',
            'body_err' => ''
         ];
         /**Cargamos la Vista */
         $this->view('post/edit', $data);
      }

   }

   public function show($id)
   {
      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);
      $data = [
         'post' => $post,
         'user' => $user
      ];
      $this->view('post/show', $data);
   }


   public function delete($id)
   {
      if($_SERVER['REQUEST_METHOD']=='POST') {
         /**Buscamos el POST y validamos si es del usuario*/
         $post = $this->postModel->getPostById($id);
         if( $post->user_id != $_SESSION['user_id'] ){
            redirect('post');
         }
         if( $this->postModel->deletePost($id) ){
            flash('post_message', 'Publicación Eliminado con Éxito.');
            redirect('post');
         } else {
            die('Algo salió mal.');
         }

      } else {
         redirect('post');
      }
   }
}