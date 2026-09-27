<?php

namespace App\Controllers;

use App\Models\ChurchFundModel;
use App\Models\DonationModel;
use App\Models\ExpenseModel;
use App\Models\AnnivConModel;
use App\Models\ChurchEventModel;
use App\Models\ChurchExpensesModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Manager extends BaseController
{
    protected $donationModel;
    protected $expenseModel;
    protected $annivConModel;
    protected $eventModel;

    public function __construct()
    {
        $this->donationModel = new ChurchFundModel();
        $this->expenseModel = new ChurchExpensesModel();
        $this->annivConModel = new AnnivConModel();
        $this->eventModel = new ChurchEventModel();
    }

    public function churchfund(): string
    {
        $model = new ChurchFundModel();
        $FundInfo = $model->findAll();

        $data = [
            'page_title' => 'Church Fund Records',
            'FundInfo'   => $FundInfo,
        ];

        return view('Template/SideNav')
            . view('Template/Header')
            . view('Manager/churchfund', $data)
            . view('Template/Footer');
    }

    public function AddFund(): string
    {
        $data = ['page_title' => 'Add Church Fund'];
        return view('Template/SideNav') .
            view('Template/Header') .
            view('Manager/AddFund', $data) .
            view('Template/Footer');
    }

    public function EditFund($fund_Id): string
    {
        $model = new ChurchFundModel();
        $FundInfo = $model->find($fund_Id);

        $data = [
            'page_title' => 'Edit Church Fund',
            'FundInfo'   => $FundInfo,
        ];

        return view('Template/SideNav')
            . view('Template/Header')
            . view('Manager/AddFund', $data)
            . view('Template/Footer');
    }

    public function insertFund()
        {
            $post = $this->request->getPost([
                'fund_type', 'fund_amount', 'description', 'date'  // Removed 'fund_Id'
            ]);

            $rules = [
                'fund_type'   => 'required',
                'fund_amount' => 'required|numeric',
                'description' => 'required',
                'date'        => 'required|valid_date',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Please correct the errors below.');
            }

            $model = new ChurchFundModel();

            // Removed 'fund_Id' from $insertData
            $insertData = [
                'fund_type'   => $post['fund_type'],
                'amount'      => $post['fund_amount'],
                'description' => $post['description'],
                'date'        => $post['date'],
            ];

            $model->insert($insertData);
            return redirect()->to('/Manager/churchfund');
        }


    public function updateFund($fund_Id)
    {
        $post = $this->request->getPost([
            'fund_type', 'fund_amount', 'description', 'date'
        ]);

        $rules = [
            'fund_type'   => 'required',
            'fund_amount' => 'required|numeric',
            'description' => 'required',
            'date'        => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        $model = new ChurchFundModel();

        $updateData = [
            'fund_type'   => $post['fund_type'],
            'amount'      => $post['fund_amount'],
            'description' => $post['description'],
            'date'        => $post['date'],
        ];

        $model->update($fund_Id, $updateData);
        return redirect()->to('/Manager/churchfund');
    }

    public function deleteFund($fund_Id)
    {
        $model = new ChurchFundModel();
        
        // Correct the delete statement by adding a where condition
        $model->delete(['fund_id' => $fund_Id]);
    
        // Redirect after successful delete
        return redirect()->to('/Manager/churchfund');
    }
    
    

    public function ChurchFundReport()
    {
        $model = new ChurchFundModel();
        $data['FundInfo'] = $model->findAll();
        $data['title'] = 'Church Fund Report';
        $data['logoPath'] = 'file://' . str_replace('\\', '/', FCPATH . 'assets/nlbflogo.png');
        $download = $this->request->getGet('download') == '1';

        $html = view('Manager/Reports/ChurchFundReport', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("Church_Fund_Report.pdf", ["Attachment" => $download ? 1 : 0]);
    }
}
