<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\ChurchExpensesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Expenses extends BaseController
{
    public function ChurchExpenses(): string
    {
        $model = new ChurchExpensesModel();
        $fundModel = new \App\Models\ChurchFundModel();  
        
        // Fetch total donations
        $totalDonations = $fundModel->getTotalDonations();

        // ✅ Fetch total expenses
        $totalExpenses = $model->selectSum('amount')->get()->getRow()->amount ?? 0;

        // ✅ Deduct expenses from donations
        $availableDonations = $totalDonations - $totalExpenses;

        $data = [
            'page_title'        => 'Church Expenses',
            'Expenses'          => $model->findAll(),
            'totalDonations'    => $availableDonations, // 👈 This will now show the correct balance
        ];

        return view('Template/SideNav')
            . view('Template/Header')
            . view('Expenses/ChurchExpenses', $data)
            . view('Template/Footer');
    }

    public function AddExpense(): string
    {
        $data = [
            'page_title'  => 'Add Expense',
            'validation'  => \Config\Services::validation(),
        ];

        return view('Template/SideNav')
             . view('Template/Header')
             . view('Expenses/AddExpense', $data)
             . view('Template/Footer');
    }

    public function EditExpense($expenses_id): string
    {
        $model = new ChurchExpensesModel();
        $expense = $model->find($expenses_id);

        if (!$expense) {
            throw new PageNotFoundException("Expense not found");
        }

        $data = [
            'page_title' => 'Edit Expense',
            'ExpenseInfo'    => $expense,
            'validation' => \Config\Services::validation(),
        ];

        return view('Template/SideNav')
             . view('Template/Header')
             . view('Expenses/AddExpense', $data)
             . view('Template/Footer');
    }

    public function insertExpense()
    {
        // Validation rules
        $rules = [
            'amount'      => 'required|numeric',
            'description' => 'required',
            'date'        => 'required|valid_date',
            'receipt'     => 'uploaded[receipt]|max_size[receipt,2048]|ext_in[receipt,jpg,jpeg,png,pdf]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Please correct the errors below.')
                            ->with('validation', $this->validator);
        }

        // Handle file upload
        $file = $this->request->getFile('receipt');
        $fileName = $file->getRandomName();
        $file->move('uploads/receipts/', $fileName); // Make sure this directory exists

        // Get the input data
        $amount = $this->request->getPost('amount');
        $description = $this->request->getPost('description');
        $date = $this->request->getPost('date');

        // Insert into ChurchExpenses table
        $model = new ChurchExpensesModel();
        $model->insert([
            'amount'      => $amount,
            'description' => $description,
            'date'        => $date,
            'receipt'     => $fileName,
        ]);

        // The logic for deducting expenses from donations in the churchfund table has been removed.

        return redirect()->to('/Expenses');
    }


    public function updateExpense($expenses_id)
    {
        $rules = [
            'amount'      => 'required|numeric',
            'description' => 'required',
            'date'        => 'required|valid_date',
            'receipt'     => 'if_exist|max_size[receipt,2048]|ext_in[receipt,jpg,jpeg,png,pdf]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Please correct the errors below.')
                             ->with('validation', $this->validator);
        }

        $model = new ChurchExpensesModel();
        $expense = $model->find($expenses_id);

        if (!$expense) {
            throw new PageNotFoundException("Expense not found");
        }

        $data = [
            'amount'      => $this->request->getPost('amount'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
        ];

        $file = $this->request->getFile('receipt');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/receipts/', $fileName);
            $data['receipt'] = $fileName;
        }

        $model->update($expenses_id, $data);
        return redirect()->to('/Expenses');
    }

    public function deleteExpense($expenses_id)
    {
        $model = new ChurchExpensesModel();
        $model->delete($expenses_id);
        return redirect()->to('/Expenses');
    }


public function ChurchExpensesReport()
{
    $model = new \App\Models\ChurchExpensesModel();
    $data['expenses'] = $model->findAll();
    $data['title'] = 'Church Expenses Report';
    $data['logoPath'] = 'file://' . str_replace('\\', '/', FCPATH . 'assets/nlbflogo.png');
    $download = $this->request->getGet('download') == '1';

    $html = view('Expenses/Reports/ChurchExpensesReport', $data);

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->stream("Church_Expenses_Report.pdf", ["Attachment" => $download ? 1 : 0]);
}



}
