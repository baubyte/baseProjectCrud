<?php
class  Alumno
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }
    public function getAlumnos()
    {
        $this->db->query('SELECT * FROM alumnos');
        return $this->db->getAll();
    }
}
