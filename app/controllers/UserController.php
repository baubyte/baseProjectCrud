<?php
defined('BASEPATH') or exit('No se permite acceso directo');
class UserController extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        if (!isLoggedIn()) {
            redirect('user/login');
        }
        $users = $this->userModel->getUsers();
        $data = [
            'users' => $users
        ];
        return $this->view('user/index', $data);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**Limpiamos Saneamos el Array POST */
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            /**Validamos el Mail */
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor ingrese su correo electrónico.';
            } else {
                /**Vivificamos si ya existe*/
                if ($this->userModel->getUserByEmail($data['email'])) {
                    $data['email_err'] = 'Correo electrónico ya está en uso. ¡Elige otro!';
                }
            }

            /**Validamos el Nombre */
            if (empty($data['name'])) {
                $data['name_err'] = 'Por favor ingrese su nombre.';
            }

            /**Validamos el Contraseña */
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese una contraseña.';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres.';
            }

            /**Validamos el Contraseña */
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Por favor ingrese una contraseña.';
            } else if ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = '¡Las contraseñas no coinciden!';
            }

            /**Verificamos si no hubo errores */
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                /**HASH Contrseña */
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->register($data)) {
                    flash('register_success', '¡Ya estás registrado!');
                    $this->login();
                } else {
                    die('Algo salió mal.');
                }
            } else {
                /**Cargamos la Vista */
                $this->view('user/register', $data);
            }
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            /**Cargamos la Vista */
            $this->view('user/register', $data);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**Limpiamos Saneamos el Array POST */
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            /**Validamos el Mail*/
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor ingrese su email.';
            } else if (!$this->userModel->getUserByEmail($data['email'])) {
                /**No existe el Usuario */
                $data['email_err'] = '¡Usuario no existe|';
            }

            /**Validamos la Contrseña*/
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese su contraseña.';
            }

            /**Verificamos si no hubo errores */
            if (empty($data['email_err']) && empty($data['password_err'])) {

                $userAuthenticated = $this->userModel->login($data['email'], $data['password']);
                if ($userAuthenticated) {
                    $this->createUserSession($userAuthenticated);
                } else {
                    $data = [
                        'email' => trim($_POST['email']),
                        'password' => '',
                        'email_err' => 'El e-mail o la contraseña son incorrectos',
                        'password_err' => 'El e-mail o la contraseña son incorrectos',
                    ];
                    $this->view('user/login', $data);
                }
            } else {
                /**Cargamos la Vista */
                $this->view('user/login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            /**Cargamos la Vista */
            $this->view('user/login', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_mail']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('user/login');
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('post');
    }
    public function changePassword()
    {
        if (!isLoggedIn()) {
            redirect('user/login');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**Limpiamos Saneamos el Array POST */
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => $_SESSION['user_email'],
                'password_old' => trim($_POST['password_old']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'password_old_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            /**Validamos la Contraseña Anterior */
            if (empty($data['password_old'])) {
                $data['password_old_err'] = 'Ingrese su contraseña anterior.';
            } elseif (strlen($data['password_old']) < 6) {
                $data['password_old_err'] = 'La contraseña anterior debe tener al menos 6 caracteres.';
            } else if (!$this->userModel->checkPassword($data['email'], $data['password_old'])) {
                $data['password_old_err'] = '¡Tu contraseña anterior es incorrecta!';
            }

            /**Validamos la Contraseña*/
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese su contraseña.';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres.';
            }

            /**Validamos la Contraseña*/
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Por favor, confirme su contraseña.';
            } else if ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = '¡Las contraseñas no coinciden!';
            }

            /**Verificamos si no hubo errores */
            if (empty($data['password_old_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                /**HASH Contrseña*/
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->updatePassword($data)) {
                    flash('register_success', 'Password updated!');
                    redirect('posts');
                } else {
                    die('Algo salió mal.');
                }
            } else {
                /**Cargamos la Vista */
                $this->view('user/changepassword', $data);
            }
        } else {
            $data = [
                'email' => $_SESSION['user_email'],
                'password_old' => '',
                'password' => '',
                'confirm_password' => '',
                'password_old_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            /**Cargamos la Vista */
            $this->view('user/changepassword', $data);
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**Limpiamos Saneamos el Array POST */
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            /**Validamos el Mail */
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor ingrese su email.';
            } else {
                /**Verificamos si existe */
                if ($this->userModel->getUserByEmail($data['email'])) {
                    $data['email_err'] = 'El mail';
                }
            }

            /**Validamos en Nombre*/
            if (empty($data['name'])) {
                $data['name_err'] = 'Por favor ingrese el email.';
            }

            /**Validamos la Contraseña*/
            if (empty($data['password'])) {
                $data['password_err'] = 'Por favor ingrese la contraseña.';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres.';
            }

            /**Validamos la Contraseña*/
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Por favor ingrese la contraseña.';
            } else if ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = '¡Las contraseñas no coinciden!';
            }

            /**Verificamos si no hubo errores */
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                /**HASH Contraseña*/
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if ($this->userModel->addUser($data)) {
                    flash('user_message', '¿El usuario fue creado Correctamente!');
                    redirect('user/index');
                } else {
                    die('¡Algo salio Mal!');
                }
            } else {
                /**Cargamos la Vista */
                $this->view('user/add', $data);
            }
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            /**Cargamos la Vista */
            $this->view('user/add', $data);
        }
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            /**Verificamos is el Usuario existe*/
            $user = $this->userModel->getUserById($id);
            $row = $this->postModel->getPostByUserId($id);
            /**Verificamos si el Usuario Logueado*/
            if ($user->id == $_SESSION['user_id']) {
                flash('user_message', '¡No puedes eliminar tu propio usuario!','alert alert-danger alert-dismissible fade show');
                redirect('user');
            } elseif ($row->total > 0) {
                flash('user_message', '¡No puede eliminar un usuario con publicaciones Vinculadas!','alert alert-danger alert-dismissible fade show');
                redirect('user');
            } else {

                if ($this->userModel->deleteUser($id)) {
                    flash('user_message', '¡El usuario fue eliminado con éxito!');
                    redirect('user');
                } else {
                    flash('user_message', 'Ocurrió un error al eliminar usuario.');
                    redirect('user');
                }
            }
        } else {
            redirect('user');
        }
    }
}
