<?php

use App\Core\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Orm;

class homeController extends Controller
{

    public function index()
    {
        //carrega la vista principal de l'aplicacio
        
        $params['title'] = 'PearHome';

        $usr = new User();
        //comprova si s'ha creat la variable de sessio d'usuaris
        if (!$usr->sessionCreated() || empty($usr->getAll())) $this->loadUserData();

        $p = new Product();
        if (!$p->sessionCreated() || empty($p->getAll())) $this->loadProductData();

        $params['users'] = $usr->getAll();
        $this->render('/home/index', $params);
    }

    public function loadUserData()
    {
        //Carrega dades d'usuari dins l'aplicacio
        $user = [
            'id' => 0,
            'username' => 'admin',
            'password' => '123',
            'mail' => 'mail@mail.es',
            'admin' => true,
            'token' => 'token1',
            'verified' => true,
            'image' => 'default.png'
        ];
        $u = new User;
        $u->create($user);

        $user = [
            'id' => 1,
            'username' => 'yaros',
            'password' => '123',
            'mail' => 'yaros@mail.cat',
            'admin' => false,
            'token' => 'token1',
            'verified' => true,
            'image' => 'default.png'
        ];
        $u = new User;
        $u->create($user);
        
        $user = [
            'id' => 2,
            'username' => 'toni',
            'password' => '123',
            'mail' => 'toni@mail.cat',
            'admin' => false,
            'token' => 'token.toni',
            'verified' => true,
            'image' => 'default.png'
        ];
        $u = new User;
        $u->create($user);
    }

    public function loadProductData() {
        // iPhone 16
        $product = [
            'id' => 0,
            'name' => 'iPhone 16',
            'description' => 'Latest iPhone with advanced camera and A18 chip',
            'image' => 'iphone16.jpg',
            'price' => 999.0
        ];
        $p = new Product;
        $p->create($product);

        // iPhone 17
        $product = [
            'id' => 1,
            'name' => 'iPhone 17 Pro',
            'description' => 'Pro model with enhanced display and battery life',
            'image' => 'iphone17.jpg',
            'price' => 1199.0
        ];
        $p = new Product;
        $p->create($product);

        // iPhone 99 (futuristic)
        $product = [
            'id' => 2,
            'name' => 'iPhone 99',
            'description' => 'Future technology with holographic display',
            'image' => 'iphone99.webp',
            'price' => 1999.0
        ];
        $p = new Product;
        $p->create($product);

        // MacBook
        $product = [
            'id' => 3,
            'name' => 'MacBook Pro',
            'description' => 'Powerful laptop for professionals and creators',
            'image' => 'macbook.jpg',
            'price' => 2499.0
        ];
        $p = new Product;
        $p->create($product);

        // Producte extra amb la imatge genèrica
        $product = [
            'id' => 4,
            'name' => 'AirPods Pro',
            'description' => 'Wireless earbuds with noise cancellation',
            'image' => 'producte.png',
            'price' => 249.0
        ];
        $p = new Product;
        $p->create($product);
    }
}