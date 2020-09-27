<?php
class Page extends Controller
{
    public function __construct()
    {
        $this->bookModel = $this->model('Book');
    }
    /**Listar Todos los Libros */
    public function index()
    {
        $books = $this->bookModel->getBooks();
        $data = [
            'titulo' => 'baseProject',
            'books' => $books
        ];
        $this->view('pages/index', $data);
    }
    /**Agregar Libros */
    public function create()
    {
        /**Comprobamos que el metodo post se ejecuto */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'author' => trim($_POST['author']),
                'price' => trim($_POST['price'])
            ];
            if ($this->bookModel->create($data)) {
                redirect('page');
            } else {
                die('Ups Algo Salio Mal');
            }
        } else {
            $data = [
                'title' => '',
                'description' => '',
                'author' => '',
                'price' => ''
            ];
            $this->view('pages/create', $data);
        }
    }
    /**Editar los Libros */
    public function edit($id)
    {
        /**Comprobamos que el metodo post se ejecuto */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'author' => trim($_POST['author']),
                'price' => trim($_POST['price'])
            ];
            if ($this->bookModel->edit($data)) {
                redirect('page');
            } else {
                die('Ups Algo Salio Mal');
            }
        } else {

            /**Obtenemos los Datos del Libro */
            $book = $this->bookModel->getBookById($id);

            $data = [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'author' => $book->author,
                'price' => $book->price
            ];
            $this->view('pages/edit', $data);
        }
    }
    /**Borrar Libros */
    public function destroy($id)
    {
        /**Obtenemos los Datos del Libro */
        $book = $this->bookModel->getBookById($id);

        $data = [
            'id' => $book->id,
            'title' => $book->title,
            'description' => $book->description,
            'author' => $book->author,
            'price' => $book->price
        ];
        /**Comprobamos que el metodo post se ejecuto */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id
            ];
            if ($this->bookModel->destroy($data)) {
                redirect('page');
            } else {
                die('Ups Algo Salio Mal');
            }
        } 
            $this->view('pages/destroy', $data);
    }
}
