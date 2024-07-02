<?php namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price'];

    public function addItem($data)
    {
 
        if (empty($data['name']) || empty($data['price'])) {
            throw new \Exception('Name and price are required');
        }

        if (!is_numeric($data['price']) || $data['price'] < 0) {
            throw new \Exception('Invalid price');
        }

        $this->save($data);
        return $this->where('name', $data['name'])->first();
    }

    public function editItem($id, $data)
    {
 
        if (empty($data['name']) || empty($data['price'])) {
            throw new \Exception('Name and price are required');
        }

        if (!is_numeric($data['price']) || $data['price'] < 0) {
            throw new \Exception('Invalid price');
        }

        $this->update($id, $data);
        return $this->find($id);
    }
}
