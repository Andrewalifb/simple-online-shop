<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CartModel;

class CartController extends ResourceController
{
    protected $modelName = 'App\Models\CartModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON();
        if (!$data) {
            return $this->fail('No data sent');
        }
        try {
            $newCart = $this->model->addCart((array)$data);
            return $this->respondCreated(['status' => 201, 'message' => 'Cart created successfully', 'data' => $newCart]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function checkout($id = null)
    {
        try {
            $cartItems = $this->model->checkout($id);
            $total = array_reduce($cartItems, function ($carry, $item) {
                return $carry + $item['price'] * $item['quantity'];
            }, 0);
            return $this->respond(['status' => 200, 'message' => 'Cart checked out successfully', 'data' => ['id' => $id, 'items' => $cartItems, 'total' => $total]]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function history($userId = null)
    {
        try {
            $history = $this->model->getShoppingHistory($userId);
            foreach ($history as &$cart) {
                $cart['total'] = array_reduce($cart['items'], function ($carry, $item) {
                    return $carry + $item['price'] * $item['quantity'];
                }, 0);
            }
            return $this->respond(['status' => 200, 'message' => 'Shopping history retrieved successfully', 'data' => $history]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
