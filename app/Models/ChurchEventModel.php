<?php

// app/Models/ChurchEventModel.php
namespace App\Models;

use CodeIgniter\Model;

class ChurchEventModel extends Model
{
    protected $table      = 'churchevent'; // Table name
    protected $primaryKey = 'event_Id'; // Primary key

    protected $useAutoIncrement = true; // Auto increment for the primary key

    protected $returnType     = 'array'; // Return data as an array
    // protected $useSoftDeletes = true; // Uncomment if you plan to use soft deletes

    protected $allowedFields = ['event_name', 'date', 'time', 'description']; // Fields that are allowed to be inserted/updated

    public function getUpcomingEvents()
    {
        return $this->where('date >=', date('Y-m-d'))  // Change 'event_date' to 'date'
                    ->orderBy('date', 'ASC')
                    ->findAll();
    }


}
