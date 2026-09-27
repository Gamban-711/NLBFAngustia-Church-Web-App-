<?php

namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admins'; // your database table
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];
}
