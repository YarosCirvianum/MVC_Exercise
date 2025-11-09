<?php 

namespace App\Core;

use App\Models\User;

class Controller{

    // Render a view with layout
    protected function render($path, $params = [], $layout ="main"){
        ob_start();
        require_once(__DIR__ . "/../Views/" . $path . ".view.php");
        $params['content'] = ob_get_clean();
        
        // Pass logged user to site layout
        if ($layout === 'site') {
            $userModel = new User();
            $userLogged = $userModel->getUserLogged();
            if ($userLogged) {
                $params['user'] = $userLogged;
            }
        }
        
        require_once(__DIR__ . "/../Views/layouts/" . $layout . ".layout.php");
    }

    // Check if user is logged in
    protected function userLogged(){
        $userModel = new User();
        return $userModel->getUserLogged() !== null;
    }

    // Check if admin is logged in
    protected function adminLogged() {
        $userModel = new User();
        $user = $userModel->getUserLogged();
        return $user && $user['admin'] === true;
    }
}
?>