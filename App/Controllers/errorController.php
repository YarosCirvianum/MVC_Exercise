<?php

use App\Core\Controller;

class errorController extends Controller {

    public function index() {
        //carrega la vista del error
        $params = [];
        $params['title'] = 'Error';
        $this->render('error/error', $params);
    }

    public function error_view() {

    }
}