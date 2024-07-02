<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'phone'];

    public function register($data)
    {

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email format');
        }

        if (!preg_match('/^[0-9]{10,15}$/', $data['phone'])) {
            throw new \Exception('Invalid phone number format');
        }

        $existingUser = $this->where('email', $data['email'])->orWhere('phone', $data['phone'])->first();
        if ($existingUser) {
            throw new \Exception('Email or phone number already exists');
        }

        $this->save($data);
        return $this->where('email', $data['email'])->first();
    }
}
