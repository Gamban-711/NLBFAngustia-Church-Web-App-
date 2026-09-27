<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\AnnivConModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AnnivCon extends BaseController
{
    public function ChurchAnnivCon(): string
    {
        $model = new AnnivConModel();
        $data = [
            'page_title' => 'Anniversary Contributions',
            'AnnivContributions' => $model->findAll()
        ];

        return view('Template/SideNav')
             . view('Template/Header')
             . view('AnnivCon/ChurchAnnivCon', $data)
             . view('Template/Footer');
    }

    public function AddContrib(): string
    {
        $data = [
            'page_title' => 'Add Contribution',
            'validation' => \Config\Services::validation(),
        ];

        return view('Template/SideNav')
             . view('Template/Header')
             . view('AnnivCon/AddContrib', $data)
             . view('Template/Footer');
    }

    public function EditAnnivCon($annivcon_id): string
    {
        $model = new AnnivConModel();
        $contribution = $model->find($annivcon_id);

        if (!$contribution) {
            throw new PageNotFoundException("Contribution not found");
        }

        $data = [
            'page_title' => 'Edit Contribution',
            'AnnivInfo' => $contribution,
            'validation' => \Config\Services::validation(),
        ];

        return view('Template/SideNav')
             . view('Template/Header')
             . view('AnnivCon/AddContrib', $data)
             . view('Template/Footer');
    }


    public function insertAnnivCon()
    {
        $rules = [
            'family_name' => 'required',
            'amount'      => 'required|numeric',
            'date'        => 'required|valid_date',
            'description' => 'permit_empty|string',
            'receipt'     => 'uploaded[receipt]|max_size[receipt,2048]|ext_in[receipt,jpg,jpeg,png,pdf]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Please correct the errors below.')
                             ->with('validation', $this->validator);
        }

        $file = $this->request->getFile('receipt');
        $fileName = $file->getRandomName();
        $file->move('uploads/anniv_receipts/', $fileName); // make sure this folder exists

        $model = new AnnivConModel();

        $model->insert([
            'family_name' => $this->request->getPost('family_name'),
            'amount'      => $this->request->getPost('amount'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
            'receipt'     => $fileName,
        ]);

        return redirect()->to('/AnnivCon');
    }



    public function UpdateAnnivCon($annivcon_id)
    {
        $rules = [
            'family_name' => 'required',
            'amount'      => 'required|numeric',
            'date'        => 'required|valid_date',
            'description' => 'permit_empty|string',
            'receipt'     => 'if_exist|max_size[receipt,2048]|ext_in[receipt,jpg,jpeg,png,pdf]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Please correct the errors below.')
                             ->with('validation', $this->validator);
        }

        $model = new AnnivConModel();
        $contribution = $model->find($annivcon_id);

        if (!$contribution) {
            throw new PageNotFoundException("Contribution not found");
        }

        $data = [
            'family_name' => $this->request->getPost('family_name'),
            'amount'      => $this->request->getPost('amount'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
        ];

        $file = $this->request->getFile('receipt');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/anniv_receipts/', $fileName);
            $data['receipt'] = $fileName;
        }

        $model->update($annivcon_id, $data);
        return redirect()->to('/AnnivCon');
    }

    public function DeleteAnnivCon($annivcon_id)
    {
        $model = new AnnivConModel();
        $model->delete($annivcon_id);
        return redirect()->to('/AnnivCon');
    }

    public function AnnivConReport()
    {
        $model = new AnnivConModel();
        $data['contribution'] = $model->findAll();
        $data['logoPath'] = 'file://' . str_replace('\\', '/', FCPATH . 'assets/nlbflogo.png');
        $download = $this->request->getGet('download') == '1';

        $html = view('AnnivCon/Reports/AnnivConReport', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("Anniversary_Contribution_Report.pdf", ["Attachment" => $download ? 1 : 0]);
    }
}
