<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function list () {
        // TODO: return a list of orders
    }

    public function store (Request $req) {
        // TODO: save a new order
    }

    public function update (Request $req, Order $order) {
        // TODO: update an existing order
    }
}
