<?php

// app/Models/ChurchFundModel.php
namespace App\Models;  // Use this namespace in Models

use CodeIgniter\Model;

class ChurchFundModel extends Model
{
    protected $table      = 'ChurchFund';
    protected $primaryKey = 'fund_Id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['fund_Id','fund_type', 'amount', 'description', 'date'];
    
    public function getTotalDonations()
    {
        return $this->selectSum('amount')->get()->getRow()->amount ?? 0;
    }
    

}

