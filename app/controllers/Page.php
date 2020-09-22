<?php
class Page extends Controller
{
    public function __construct()
    {
        $this->alumnoModel = $this->model('Alumno');
    }
    public function index()
    {
        $alumnos = $this->alumnoModel->getAlumnos();
        $data = [
            'titulo' => 'baseProject',
            'alumnos' => $alumnos
        ];
        $this->view('pages/index', $data);
    }
}
