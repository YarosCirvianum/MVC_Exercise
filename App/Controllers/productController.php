<?php

//cal crear la classe productController
//el metode per defecte "index" ha de cridar la vista
//product.view.php
use App\Core\Controller;
use App\Models\User;

class productController extends Controller {

    public function index() {
        $u = new User;
        print_R( $u->getUserLogged());
    }

}