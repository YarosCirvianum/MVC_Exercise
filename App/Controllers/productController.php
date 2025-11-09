<?php

use App\Core\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class productController extends Controller {

    public function index() {
        $params['title'] = 'Pear-Store';
        $u = new User;
        $user = $u->getUserLogged();
        $params['user'] = $user;

        if ($user == null) {
            header('Location: /home');
            exit();
        }

        $p = new Product;
        $params['products'] = $p->getAll();

        // CART
        $cart = new Cart($user['id']);
        $cartItems = $cart->getAll();
        
        if (!empty($cartItems)) {
            $lastProduct = $cart->getLastProductAdded();
            if ($lastProduct) {
                $params['messageCart'] = "You successfully added " . $lastProduct['name'] . " to your cart!";
            }
            $params['numProducts'] = $cart->totalProductsInCart();
        }
        
        $this->render('product/list', $params, 'site');
    }

    public function search() {
        $params['title'] = 'Pear-Store';
        $u = new User;
        $user = $u->getUserLogged();
        $params['user'] = $user;

        if ($user == null) {
            header('Location: /home');
            exit();
        }

        $p = new Product;
        $allProducts = $p->getAll();
        
        $searchQuery = $_POST['q'] ?? '';
        $params['search_query'] = $searchQuery;
        
        if (!empty($searchQuery)) {
            $filteredProducts = [];
            foreach ($allProducts as $product) {
                if (stripos($product['name'], $searchQuery) !== false) {
                    $filteredProducts[] = $product;
                }
            }
            $params['products'] = $filteredProducts;
        } else {
            $params['products'] = $allProducts;
        }

        // CART
        $cart = new Cart($user['id']);
        $cartItems = $cart->getAll();
        
        if (!empty($cartItems)) {
            $lastProduct = $cart->getLastProductAdded();
            if ($lastProduct) {
                $params['messageCart'] = "You successfully added " . $lastProduct['name'] . " to your cart!";
            }
            $params['numProducts'] = $cart->totalProductsInCart();
        }
        
        $this->render('product/list', $params, 'site');
    }
}