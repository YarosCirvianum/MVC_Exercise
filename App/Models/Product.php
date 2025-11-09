<?php

namespace App\Models;

use App\Models\Orm;

class Product extends Orm{
    public function __construct()
    {
        parent::__construct('products');
    }
}