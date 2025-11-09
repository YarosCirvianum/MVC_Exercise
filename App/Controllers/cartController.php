<?php
use App\Core\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\HistoricCart;
use App\Core\Mailer;

class cartController extends Controller {
    public function index() {
        $params['title'] = 'Cart';
        $u = new User;
        $user = $u->getUserLogged();
        $params['user'] = $user;

        if ($user == null) {
            header('Location: /home');
            exit();
        }

        // Crear el carro amb l'ID de l'usuari
        $cart = new Cart($user['id']);
        $cartItems = $cart->getAll();

        if (empty($cartItems)) {
            $params['empty_cart'] = true;
        } else {
            $params['empty_cart'] = false;
            $params['cart'] = $cartItems;
            $params['totalCartImport'] = $cart->getTotalImport();
        }
        $this->render('cart/cart', $params, 'site');
    }

    public function addItemsToCart() {
        $u = new User;
        $user = $u->getUserLogged();
        
        if ($user == null) {
            header('Location: /user');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
            $id = $_POST['id'];
            $p = new Product;
            $myProduct = $p->getById($id);
            
            // Crear el carro amb l'ID de l'usuari
            $cart = new Cart($user['id']);
            $myProductCart = $cart->getById($id);
            
            if (is_null($myProductCart)) {
                $myProduct['qty'] = 1;
                $cart->create($myProduct);
                $cart->setLastProductAdded($id);
            } else {
                $cart->updateProductQty($id);
                $cart->setLastProductAdded($id);
            }

            header('Location: /product');
            exit();
        }
    }

    public function updateCart() {
        $u = new User;
        $user = $u->getUserLogged();
        
        if ($user == null) {
            header('Location: /user');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST)) {
                $id = $_POST['id'];
                $operation = $_POST['operation'];

                // Crear el carro amb l'ID de l'usuari
                $cart = new Cart($user['id']);
                $cart->updateItemCart($id, $operation);
                
                $params['user'] = $user;
                $params['empty_cart'] = false;
                $params['totalCartImport'] = $cart->getTotalImport();
                $params['cart'] = $cart->getAll();

                $this->render("cart/cart", $params, "site");
            }
        }
    }

    public function confirm() {
        $params['title'] = 'Confirm Order';
        $u = new User;
        $user = $u->getUserLogged();
        $params['user'] = $user;

        if ($user == null) {
            header('Location: /home');
            exit();
        }

        // Crear el carro amb l'ID de l'usuari
        $cart = new Cart($user['id']);
        $cartItems = $cart->getAll();

        if (empty($cartItems)) {
            header('Location: /cart');
            exit();
        }

        $params['cart'] = $cartItems;
        $params['totalCartImport'] = $cart->getTotalImport();
        $this->render('cart/checkout', $params, 'site');
    }

    public function validate() {
        $u = new User;
        $user = $u->getUserLogged();
        if ($user == null) {
            header('Location: /home');
            exit();
        }

        // Crear el carro amb l'ID de l'usuari
        $cart = new Cart($user['id']);
        $products = $cart->getAll();

        if (empty($products)) {
            header('Location: /cart');
            exit();
        }

        $d = new DateTime();
        $date = $d->format('Y/m/d H:i:s');
        $id_user = $user['id'];

        $hc = new HistoricCart;
        $myhc = [
            'id' => $hc->getLastId(),
            'date' => $date,
            'id_user' => $id_user,
            'products' => $products,
            'total' => $cart->getTotalImport()
        ];

        $hc->create($myhc);

        // Enviar correu de confirmacio
        $mailer = new Mailer;
        $mailer->mailServerSetup();
        $mailer->addRec($user['mail']);
        $mailer->addOrderContent($user, $products, $cart->getTotalImport());
        $mailer->send();

        $cart->reset();

        
        header('Location: /order/confirmation');
        exit();
    }

    public function confirmation() {
        $params['title'] = 'Order Confirmation';
        $u = new User;
        $params['user'] = $u->getUserLogged();
        $this->render('cart/confirmation', $params, 'site');
    }

    public function history() {
        $params['title'] = 'Order History';
        $u = new User;
        $user = $u->getUserLogged();
        $params['user'] = $user;

        if ($user == null) {
            header('Location: /home');
            exit();
        }

        $hc = new HistoricCart;
        $allOrders = $hc->getAll();
        $userOrders = array_filter($allOrders, function($order) use ($user) {
            return $order['id_user'] == $user['id'];
        });
        
        // Ordenar per data mes recent primer
        usort($userOrders, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        $params['orders'] = $userOrders;
        $this->render('order/history', $params, 'site');
    }
}
?>