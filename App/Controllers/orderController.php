<?php

use App\Core\Controller;
use App\Models\User;

class orderController extends Controller {

    public function confirmation() {
        $params['title'] = 'Order Confirmation';
        $u = new User;
        $params['user'] = $u->getUserLogged();
        
        if ($params['user'] == null) {
            header('Location: /home');
            exit();
        }
        
        $this->render('order/confirmation', $params, 'site');
    }
}