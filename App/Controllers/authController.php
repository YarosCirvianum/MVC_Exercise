<?php

use App\Core\Controller;
use App\Models\User;

class authController extends Controller
{
    public function verify($params)
    {
        $id = $params[0] ?? null;
        $token = $params[1] ?? null;
        
        if ($id === null || $token === null) {
            header('Location: /user');
            exit();
        }

        $u = new User();
        $user = $u->getById($id);
        
        if ($user && $user['token'] === $token) {
            // Marcar com verificat
            $user['verified'] = true;
            $u->updateItemById($user);
            
            $params['success'] = "Email verified successfully! You can now login.";
            $params['title'] = 'Email Verified';
            $this->render('user/login', $params);
        } else {
            $params['error'] = "Invalid verification link";
            $params['title'] = 'Verification Error';
            $this->render('user/login', $params);
        }
    }
}