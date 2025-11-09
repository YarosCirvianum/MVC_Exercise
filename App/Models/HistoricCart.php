<?php

namespace App\Models;

use App\Models\Orm;

class HistoricCart extends Orm {
    public function __construct() {
        parent::__construct('historic_carts');
    }

    // sobreescriute el metode create()
    public function create($item) {
        
        if (isset($item['products']) && is_array($item['products'])) {
            $item['products'] = $item['products'];
        }
        parent::create($item);
    }

    // metode per obtenir les comandes d'un usuari concret
    public function getOrdersByUser($userId) {
        $allOrders = $this->getAll();
        return array_filter($allOrders, function($order) use ($userId) {
            return $order['id_user'] == $userId;
        });
    }
}