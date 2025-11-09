<?php

use App\Core\Controller;
use App\Models\User;
use App\Models\Cart;
use App\Core\Mailer;

class userController extends Controller
{

    public function index()
    {
        //Carrega la vista del login
        $params['title'] = 'Login';
        $this->render('user/login', $params);
    }

    public function register() {
        //carrega la vista del registre
        $params = [];
        $params['title'] = 'Register';
        $this->render('user/register', $params);
    }

    public function profile()
    {
        //carrega la vista del perfil d'usuari
        //es una ruta protegia, cal fer servir funcions de Controller
        $u = new User;
        $currentUser = $u->getUserLogged();
        $params = [];
        $params['title'] = 'Profile';
        $params['user'] = $currentUser;
        $this->render('user/profile', $params, 'site');

    }

    public function logout()
    {
        $u = new User;
        $currentUser = $u->getUserLogged();

        $u->setUserLogged(null);

        header('Location: /home');
        exit();
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST)) {
                $username = $_POST['username'];
                $pass1 = $_POST['pass1'];
                $pass2 = $_POST['pass2'];
                $mail = $_POST['mail'];
                $user = new User;
                
                if ($user->usernameExist($username)) {
                    $params['error'] = "Username already exists";
                    $this->render('user/register', $params);
                    return;
                }
                if (!$user->checkUsername($username)) {
                    $params['error'] = "Username doesn't meet requirements (lowercase letters only)";
                    $this->render('user/register', $params);
                    return;
                }
                
                if (!$user->checkPassword($pass1)) {
                    $params['error'] = "Password doesn't meet requirements (numbers only)";
                    $this->render('user/register', $params);
                    return;
                }

                if ($pass1 !== $pass2) {
                    $params['error'] = "Passwords don't match";
                    $this->render('user/register', $params);
                    return;
                }

                if ($user->checkEmail($mail) == false) {
                    $params['error'] = "Invalid email format!";
                    $this->render('user/register', $params);
                    return;
                }

                $profileImage = 'default.png';
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                    $imageFile = $_FILES['profile_image'];
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($imageFile['type'], $allowedTypes)) {
                        $params['error'] = "Only JPG, PNG and GIF images are allowed";
                        $this->render('user/register', $params);
                        return;
                    }
                    if ($imageFile['size'] > 2 * 1024 * 1024) {
                        $params['error'] = "Image size must be less than 2MB";
                        $this->render('user/register', $params);
                        return;
                    }
                    $fileExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                    $newFilename = $username . '_' . time() . '.' . $fileExtension;
                    $uploadPath = __DIR__ . '/../../Public/assets/avatar/' . $newFilename;
                    
                    if (move_uploaded_file($imageFile['tmp_name'], $uploadPath)) {
                        $profileImage = $newFilename;
                    } else {
                        $params['error'] = "Error uploading image";
                        $params['title'] = "Login";
                        $this->render('user/register', $params);
                        return;
                    }
                }

                // GENERAR TOKEN ÚNIC
                $token = $user->generateToken();
                
                $newUser = [
                    'id' => $user->getLastId(),
                    'username' => $username,
                    'password' => $pass1,
                    'mail' => $mail,
                    'admin' => false,
                    'token' => $token, // UTILITZEM EL TOKEN GENERAT
                    'verified' => false,
                    'image' => $profileImage
                ];

                // ENVIAR CORREU DE VERIFICACIÓ
                $mailer = new Mailer;
                $mailer->mailServerSetup();
                $mailer->addRec($newUser['mail']);
                $mailer->addContent($newUser);
                
                if ($mailer->send()) {
                    $params['success'] = "Registration successful! Please check your email to verify your account.";
                } else {
                    $params['error'] = "Registration successful but verification email failed to send. Please contact support.";
                }

                // CREAR USUARI
                $user->create($newUser);
                $this->render('user/login', $params);
            }
        }
    }

    public function verify($values) {
        $id = $values[0];
        $token = $values[1];

        $u = new User;
        $user = $u->getById($id);
        if ($token == $user['token']) {
            $user['verified'] = true;
            $u->updateItemById($user);
            $this->index();

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
                    if (!$u->userVerified($userLogged)) {
                        $params['error'] = 'Usuari No-verificat';
                        $this->render('user/login', $params);
                    } else {
                        header('Location: /product');
                    }
                }
            }
        }
    }

    public function edit() {
        //fa la logica d'editar el perfil d'usuari
        //es una ruta protegia, cal fer servir funcions de Controller

        // Logica per editar el perfil d'usuari
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $u = new User;
            $currentUser = $u->getUserLogged();
            
            if (!$currentUser) {
                header('Location: /user/login');
                exit();
            }

            $params = [];
            $params['title'] = 'Profile';
            $params['user'] = $currentUser;

            // Processar canvi de contrasenya
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Si s'ha intentat canviar la contrasenya
            if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
                // Verificar que tots els camps de contrasenya estiguin omplerts
                if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                    $params['error'] = "All password fields are required to change password";
                    $this->render('user/profile', $params, 'site');
                    return;
                }

                // Verificar contrasenya actual
                if ($currentUser['password'] !== $currentPassword) {
                    $params['error'] = "Current password is incorrect";
                    $this->render('user/profile', $params, 'site');
                    return;
                }

                // Verificar que les noves contrasenyes coincideixin
                if ($newPassword !== $confirmPassword) {
                    $params['error'] = "New passwords do not match";
                    $this->render('user/profile', $params, 'site');
                    return;
                }

                // Verificar format de la nova contrasenya
                if (!$u->checkPassword($newPassword)) {
                    $params['error'] = "New password does not meet requirements (numbers only)";
                    $this->render('user/profile', $params, 'site');
                    return;
                }

                // Actualitzar contrasenya
                $currentUser['password'] = $newPassword;
            }

            // Processar pujada d'imatge
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $imageFile = $_FILES['profile_image'];
                
                // Validar que es una imatge
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imageFile['type'], $allowedTypes)) {
                    $params['error'] = "Only JPG, PNG and GIF images are allowed";
                    $this->render('user/profile', $params, 'site');
                    return;
                }

                // Validar mida (maxim 2MB)
                if ($imageFile['size'] > 2 * 1024 * 1024) {
                    $params['error'] = "Image size must be less than 2MB";
                    $this->render('user/profile', $params, 'site');
                    return;
                }

                // Generar nom unic per la imatge
                $fileExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
                $newFilename = $currentUser['username'] . '_' . time() . '.' . $fileExtension;
                $uploadPath = __DIR__ . '/../../Public/assets/avatar/' . $newFilename;

                // Moure el fitxer pujat
                if (move_uploaded_file($imageFile['tmp_name'], $uploadPath)) {
                    // Eliminar la imatge anterior si no és la per defecte
                    $oldImage = $_POST['current_image'] ?? 'default.png';
                    if ($oldImage !== 'default.png') {
                        $oldImagePath = __DIR__ . '/../../Public/assets/avatar/' . $oldImage;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    
                    $currentUser['image'] = $newFilename;
                } else {
                    $params['error'] = "Error uploading image";
                    $this->render('user/profile', $params, 'site');
                    return;
                }
            }

            // Actualitzar l'usuari a la base de dades (sessió)
            $u->updateItemById($currentUser);
            
            // Actualitzar l'usuari a la sessió
            $u->setUserLogged($currentUser);

            $params['success'] = "Profile updated successfully";
            $params['user'] = $currentUser; // Actualitzar les dades a la vista
            
            $this->render('user/profile', $params, 'site');
        } else {
            header('Location: /user/profile');
            exit();
        }
    }
}
