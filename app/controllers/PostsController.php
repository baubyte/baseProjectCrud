<?php


class Posts extends Controller
{
   public function __construct()
   {
      if(!isLoggedIn() ){
         redirect('users/login');
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
       $this->view('posts/index', $data);
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
                redirect('posts');
             } else{
                die('Algo salió mal.');
             }
          } else {
             /**Cargamos la Vista */
             $this->view('posts/add', $data);
          }

       } else{
          $data = [
             'title' => '',
             'body' => ''
          ];
          $this->view('posts/add', $data);
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
               redirect('posts');
            } else{
               die('Algo salió mal.');
            }
         } else {
            /**Cargamos la Vista */
            $this->view('posts/edit', $data);
         }

      } else{
         /**Buscamos el POST y validamos si es del usuario*/
         $post = $this->postModel->getPostById($id);
         if( $post->user_id != $_SESSION['user_id'] ){
            redirect('posts');
         }
         $data = [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'title_err' => '',
            'body_err' => ''
         ];
         /**Cargamos la Vista */
         $this->view('posts/edit', $data);
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
      $this->view('posts/show', $data);
   }


   public function delete($id)
   {
      if($_SERVER['REQUEST_METHOD']=='POST') {
         /**Buscamos el POST y validamos si es del usuario*/
         $post = $this->postModel->getPostById($id);
         if( $post->user_id != $_SESSION['user_id'] ){
            redirect('posts');
         }
         if( $this->postModel->deletePost($id) ){
            flash('post_message', 'Publicación Eliminado con Éxito.');
            redirect('posts');
         } else {
            die('Algo salió mal.');
         }

      } else {
         redirect('posts');
      }
   }
}