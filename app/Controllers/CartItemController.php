<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CartItemModel;

class CartItemController extends ResourceController
{
    protected $modelName = 'App\Models\CartItemModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON();
        if (!$data) {
            return $this->fail('No data sent');
        }
        try {
            $newCartItem = $this->model->addItemToCart((array)$data);
            return $this->respondCreated(['status' => 201, 'message' => 'Item added to cart successfully', 'data' => $newCartItem]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
