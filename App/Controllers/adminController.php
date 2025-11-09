<?php

use App\Core\Controller;
use App\Models\User;
use App\Models\Product;

class adminController extends Controller {

    public function index() {
        $u = new User;
        $user = $u->getUserLogged();
        
        if (!$user || !$user['admin']) {
            header('Location: /home');
            exit();
        }

        $params['title'] = 'Admin Panel';
        $params['user'] = $user;

        $p = new Product;
        $params['products'] = $p->getAll();

        $this->render('admin/index', $params, 'site');
    }

    public function create() {
        $u = new User;
        $user = $u->getUserLogged();
        
        if (!$user || !$user['admin']) {
            header('Location: /home');
            exit();
        }

        $params['title'] = 'Create Product';
        $params['user'] = $user;
        $this->render('admin/create', $params, 'site');
    }

    public function store() {
        $u = new User;
        $user = $u->getUserLogged();
        
        if (!$user || !$user['admin']) {
            header('Location: /home');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $p = new Product;
            
            $newProduct = [
                'id' => $p->getLastId(),
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'image' => 'producte.png',
                'price' => floatval($_POST['price'])
            ];

            $p->create($newProduct);
            header('Location: /admin');
            exit();
        }
    }

    public function edit($params) {
        $u = new User;
        $user = $u->getUserLogged();
        
        if (!$user || !$user['admin']) {
            header('Location: /home');
            exit();
        }

        $id = $params[0];
        $p = new Product;
        $product = $p->getById($id);

        if (!$product) {
            header('Location: /admin');
            exit();
        }

        $params['title'] = 'Edit Product';
        $params['user'] = $user;
        $params['product'] = $product;
        $this->render('admin/edit', $params, 'site');
    }

    public function update($params) {
        $u = new User;
        $user = $u->getUserLogged();
        
        if (!$user || !$user['admin']) {
            header('Location: /home');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $params[0];
            $p = new Product;
            $product = $p->getById($id);

            if ($product) {
                $product['name'] = $_POST['name'];
                $product['description'] = $_POST['description'];
                $product['price'] = floatval($_POST['price']);
                
                $p->updateItemById($product);
            }

            header('Location: /admin');
            exit();
        }
    }

    public function delete($params) {
        $u = new User;
        $user = $u->getUserLogged();
        
        if (!$user || !$user['admin']) {
            header('Location: /home');
            exit();
        }

        $id = $params[0];
        $p = new Product;
        $p->removeItemById($id);
        
        header('Location: /admin');
        exit();
    }
}