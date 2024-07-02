<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ItemModel;

class ItemController extends ResourceController
{
    protected $modelName = 'App\Models\ItemModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON();
        if (!$data) {
            return $this->fail('No data sent');
        }
        try {
            $newItem = $this->model->addItem((array)$data);
            return $this->respondCreated(['status' => 201, 'message' => 'Item created successfully', 'data' => $newItem]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        if (!$data) {
            return $this->fail('No data sent');
        }
        try {
            $updatedItem = $this->model->editItem($id, (array)$data);
            return $this->respond(['status' => 200, 'message' => 'Item updated successfully', 'data' => $updatedItem]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
