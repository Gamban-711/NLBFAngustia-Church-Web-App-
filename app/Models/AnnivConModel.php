<?php

// app/Models/AnnivConModel.php
namespace App\Models;

use CodeIgniter\Model;

class AnnivConModel extends Model
{
    protected $table      = 'AnnivCon';
    protected $primaryKey = 'annivcon_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['family_name', 'amount', 'date', 'description', 'receipt'];  

    public function getTotalAnnivContributions()
    {
        return $this->selectSum('amount')->get()->getRow()->amount ?? 0;
    }

}
