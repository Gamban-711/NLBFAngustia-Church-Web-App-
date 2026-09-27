<?php

namespace App\Models;

use CodeIgniter\Model;

class ChurchExpensesModel extends Model
{
    protected $table = 'expenses'; // Name of your table
    protected $primaryKey = 'expenses_id'; // Name of the primary key column

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['expenses_id', 'amount', 'description', 'date', 'receipt']; // Fields in your table

    // Method to get the total expenses
    public function getTotalExpenses()
    {
        return $this->selectSum('amount')  // Summing up the 'amount' field
                    ->get()                // Execute the query
                    ->getRow()             // Get the row result
                    ->amount ?? 0;         // Return the sum or 0 if no records found
    }
}
