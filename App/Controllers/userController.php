<?php

use App\Core\Controller;
use App\Models\User;

class userController extends Controller
{

    public function index()
    {
        //Carrega la vista del login
        $params['title'] = 'Login';
        $this->render('user/login', $params);
    }

    public function register()
    {
        //carrega la vista del registre
        $params['title'] = 'Registre';
        $this->render('user/register', $params);
    }

    public function profile()
    {
        //carrega la vista del perfil d'usuari
        //es una ruta protegia, cal fer servir funcions de Controller


    }

    public function logout()
    {
        //Fa la lògica del logout
        //es una ruta protegia, cal fer servir funcions de Controller

    }

    public function store()
    {
        //crea el nou usuari
        //si hi ha errors, per exemple que el usuari ja existeix redirigeix a
        //la vista del registe amb els errors
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST)) {
                // print_r($_POST);
                $username = $_POST['username'];
                $pass1 = $_POST['pass1'];
                $pass2 = $_POST['pass2'];
                $mail = $_POST['mail'];
                $user = new User;
                if ($user->usernameExist($username)) {
                    $params['error'] = "El nom d'usuari ja existeix";
                    $this->render('user/register', $params);
                }
                //falten les comprovaciosn de password, mail....
                //falta un metode per obtenir el id del nou usuari

                $newUser = [
                    'id' => 2, //cal afegir la funció per obtenir el id
                    'username' => $username,
                    'password' => $pass1,
                    'mail' => $mail,
                    'admin' => false
                ];

                $user->create($newUser);
                $this->index();
            }
        }
    }

    public function login()
    {
        //fa la logica del login
        //si hi ha erros els mostra a la vista del login
        //si el login te exit redirigeix al productController amb
        //header('Location: .....')
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                //creem una instancia de la classe User per poder utilitzar
                //tots els seu mètodes
                $u = new User;
                //fem la comprovació del regex del password
                if (!$u->checkPassword($password)) {
                    $params['error'] = 'Crontrasenya incorrecta';
                    $this->render("user/login", $params);
                }
                //fem la comprovació del regex del password
                if (!$u->checkUsername($username)) {
                    $params['error'] = "Nom d'usuari incorrecte";
                    $this->render("user/login", $params);
                }
                $userLogged = $u->login($username, $password);
                //Si retorna null credencials incorretes
                if ($userLogged == null) {
                    $params['error'] = 'Credencials incorrectes';
                    $this->render("user/login", $params);
                } else {
                    //Evitem variables de sessió al Controller i les deixem al model
                    // $_SESSION['user_logged'] =  $u->login($username,$password);
                    $u->setUserLogged($userLogged);
                    header('Location: /product');
                }
            }
        }
    }

    public function edit()
    {
        //fa la logica d'editar el perfil d'usuari
        //es una ruta protegia, cal fer servir funcions de Controller
    }
}
