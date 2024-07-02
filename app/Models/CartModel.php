<?php namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'status'];

    public function addCart($data)
    {

        if (empty($data['user_id'])) {
            throw new \Exception('User ID is required');
        }
    
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($data['user_id']);
        if (!$user) {
            throw new \Exception('User not found');
        }
    
        $cartId = $this->insert($data);
        return $this->find($cartId);
    }
    
    public function checkout($id)
    {

        $cart = $this->find($id);
        if (!$cart) {
            throw new \Exception('Cart not found');
        }

        if ($cart['status'] !== 'open') {
            throw new \Exception('Cart is not open');
        }

        $cartItemModel = new \App\Models\CartItemModel();
        $cartItems = $cartItemModel->getItemsInCart($id);
        if (empty($cartItems)) {
            throw new \Exception('Add items to the cart before checking out');
        }

        $this->update($id, ['status' => 'checked_out']);

        return $cartItems;
    }

    public function getShoppingHistory($userId)
    {
        $carts = $this->where('user_id', $userId)->findAll();

        $cartItemModel = new \App\Models\CartItemModel();
        foreach ($carts as &$cart) {
            $cart['items'] = $cartItemModel->getItemsInCart($cart['id']);
        }

        return $carts;
    }
}
