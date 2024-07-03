<?php namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cart_id', 'item_id', 'quantity'];

    public function addItemToCart($data)
    {
        // Perform input validation here
        if (empty($data['cart_id']) || empty($data['item_id']) || empty($data['quantity'])) {
            throw new \Exception('Cart ID, Item ID, and Quantity are required');
        }

        if (!is_numeric($data['quantity']) || $data['quantity'] <= 0) {
            throw new \Exception('Invalid quantity');
        }

        $this->save($data);
        $insertedData = $this->where('cart_id', $data['cart_id'])->first();

        $itemModel = new \App\Models\ItemModel();
        $item = $itemModel->find($data['item_id']);
        $insertedData['name'] = $item['name'];
        $insertedData['price'] = $item['price'];
        $insertedData['subtotal'] = $item['price'] * $data['quantity'];

        return $insertedData;
    }

    public function getItemsInCart($cartId)
    {
        return $this->select('cart_items.id, cart_items.quantity, items.name, items.price')
                    ->join('items', 'items.id = cart_items.item_id')
                    ->where('cart_id', $cartId)
                    ->findAll();
    }
}
