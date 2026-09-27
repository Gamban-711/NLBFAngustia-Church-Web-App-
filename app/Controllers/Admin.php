<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ChurchFundModel;
use App\Models\ChurchExpensesModel;
use App\Models\AnnivConModel;
use App\Models\ChurchEventModel;

class Admin extends BaseController
{
    protected $session;
    protected $adminModel;
    protected $churchFundModel;
    protected $churchExpensesModel;
    protected $annivConModel;
    protected $churchEventModel;

    public function __construct()
    {
        $this->session               = session();
        $this->adminModel            = new AdminModel();
        $this->churchFundModel       = new ChurchFundModel();
        $this->churchExpensesModel   = new ChurchExpensesModel();
        $this->annivConModel         = new AnnivConModel();
        $this->churchEventModel      = new ChurchEventModel();
    }

// In your LoginController.php (or similar controller responsible for login)
public function login()
{
    // Validate the login form
    if ($this->request->getMethod() == 'post') {
        // Check if the username and password are correct
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Replace with actual validation logic (for example, checking the database)
        if ($username == 'admin' && $password == 'password123') {
            // Successful login: Set session flash data to display a message on the dashboard
            $this->session->setFlashdata('loginSuccess', 'You have successfully logged in!');

            // Redirect to the dashboard or wherever you want
            return redirect()->to('dashboard');
        } else {
            // Login failed, show an error message
            $this->session->setFlashdata('loginError', 'Invalid username or password!');
        }
    }

    // Load the login view
    return view('/admin/login');
}


    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->where('username', $username)->first();

        if ($admin && password_verify($password, $admin['password'])) {
            $this->session->destroy();
            $this->session->start();
            $this->session->regenerate();
            $this->session->set([
                'isLoggedIn'     => true,
                'admin_id'       => $admin['id'],
                'admin_username' => $admin['username'],
            ]);
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->back()->with('error', 'Invalid username or password.');
    }

    public function dashboard()
    {
        if (! $this->session->get('isLoggedIn')) {
            return redirect()->to('/admin/login')->with('error', 'Please login first.');
        }

        $data = [
            'totalDonations'          => $this->churchFundModel->getTotalDonations(),
            'totalExpenses'           => $this->churchExpensesModel->getTotalExpenses(),
            'totalAnnivContributions' => $this->annivConModel->getTotalAnnivContributions(),
            'upcomingEvents'          => $this->churchEventModel->getUpcomingEvents(),
        ];

        return view('admin/dashboard', $data);
    }

    public function logout()
{
    // Destroy all session data and invalidate the browser cache for protected pages.
    if (session()->has('isLoggedIn')) {
        session()->destroy();
    }

    $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    $this->response->setHeader('Pragma', 'no-cache');
    $this->response->setHeader('Expires', '0');

    // Redirect back to the login page with an optional flash message
    return redirect()->to('/admin/login')
                     ->with('success', 'You have been logged out.');
}

}
