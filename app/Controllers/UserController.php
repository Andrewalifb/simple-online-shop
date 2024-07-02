<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function register()
    {
        $data = $this->request->getJSON();
        if (!$data) {
            return $this->fail('No data sent');
        }
        try {
            $newUser = $this->model->register((array)$data);
            return $this->respondCreated(['status' => 201, 'message' => 'User created successfully', 'data' => $newUser]);
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
