<?php
class  Book
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    /**Obtiene todos los libres */
    public function getBooks()
    {
        $this->db->query('SELECT * FROM books');
        return $this->db->getAll();
    }
    /**Agrega un nuevo libro */
    public function create($data)
    {
        /**Preparamos la query para insertar los datos */
        $this->db->query('INSERT INTO books(title, description, author, price) VALUES (:title, :description, :author, :price)');
        /**Vinculamos los Valores */
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':price', $data['price']);
        /**Ejecutamos la Query */
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    /**Obtener Libro por le ID */
    public function getBookById($id)
    {
        $this->db->query('SELECT * FROM books WHERE  id = :id');
        /**Vinculamos los Valores */
        $this->db->bind(':id', $id);
        return $this->db->getOne();
    }
    /**Editar Libro */
    public function edit($data)
    {
        /**Preparamos la query para editar los datos */
        $this->db->query('UPDATE books SET title = :title , description = :description, author = :author, price = :price WHERE id = :id');
        /**Vinculamos los Valores */
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':author', $data['author']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':id', $data['id']);
        /**Ejecutamos la Query */
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    /**Borrar Libro */
    public function destroy($data)
    {
        /**Preparamos la query para Borrar el Libros */
        $this->db->query('DELETE FROM books WHERE id = :id');
        /**Vinculamos los Valores */
        $this->db->bind(':id', $data['id']);
        /**Ejecutamos la Query */
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
