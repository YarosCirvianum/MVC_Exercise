<?php

namespace App\Models;

use App\Models\Orm;

class Cart extends Orm {

    public function __construct($userId = null) {
        // si no hi ha  userId, obtenir-lo de la SESSION
        if ($userId === null) {
            $user = $_SESSION['user_logged'] ?? null;
            $userId = $user ? $user['id'] : 'guest';
        }
        
        $this->model = 'cart_' . $userId;
        if (!isset($_SESSION[$this->model])) {
            $_SESSION[$this->model] = [];
        }
    }

    public function updateProductQty($id) {
        $productToUpdate = $this->getById($id);
        $productToUpdate['qty'] = $productToUpdate['qty'] + 1;
        $this->updateItemById($productToUpdate);
    }

    public function totalProductsInCart() {
        $totalProducts = 0;
        foreach ($_SESSION[$this->model] as $key => $cartProduct) {
            $totalProducts = $totalProducts + $cartProduct['qty'];
        }
        return $totalProducts;
    }

    public function getLastProductAdded() {
        $model = $this->model . '_last';
        if (isset($_SESSION[$model])) {
            return $_SESSION[$model];
        }
        return null;
    }

    public function setLastProductAdded($id) {
        $lastProduct = $this->getById($id);
        $model = $this->model . '_last';
        $_SESSION[$model] = $lastProduct;
    }

    public function getTotalImport() {
        $totalImport = 0;
        foreach ($_SESSION[$this->model] as $key => $cartProduct) {
            $totalImport = $totalImport + ($cartProduct['qty'] * $cartProduct['price']);
        }
        return $totalImport;
    }

    public function updateItemCart($id, $op) {
        $product = $this->getById($id);
        if ($op == '+') {
            $product['qty'] = $product['qty'] + 1;
            $this->updateItemById($product);
        }

        if ($op == '-') {
            $product['qty'] = $product['qty'] - 1;
            if ($product['qty'] <= 0) {
                $this->removeItemById($id);
            } else {
                $this->updateItemById($product);
            }
        }
    }

    // netejar el carro al fer logout
    public function clearUserCart($userId) {
        $model = 'cart_' . $userId;
        if (isset($_SESSION[$model])) {
            unset($_SESSION[$model]);
        }
        // netejar ultim producte afegit
        $lastModel = $model . '_last';
        if (isset($_SESSION[$lastModel])) {
            unset($_SESSION[$lastModel]);
        }
    }
}