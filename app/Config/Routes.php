<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Route to the Dashboard (Manager Index)
$routes->get('Dashboard', 'admin::dashboard'); // This will point to the index method in Manager controller

// Routes for Church Funds
$routes->get('Manager/churchfund', 'Manager::churchfund');
$routes->get('Manager/AddFund', 'Manager::AddFund');
$routes->get('Manager/EditFund/(:segment)', 'Manager::EditFund/$1');
$routes->post('Manager/insertFund', 'Manager::insertFund');
$routes->post('Manager/updateFund/(:segment)', 'Manager::updateFund/$1');
$routes->post('Manager/deleteFund/(:segment)', 'Manager::deleteFund/$1');
$routes->get('Manager/Reports/ChurchFundReport', 'Manager::ChurchFundReport');


// Routes for Church Events
$routes->get('Events', 'Events::ChurchEvents'); // This is for viewing all events
$routes->get('Events/AddEvent', 'Events::AddEvent'); // Form for adding an event
$routes->get('Events/EditEvent/(:segment)', 'Events::EditEvent/$1'); // Form for editing an event using event ID
$routes->post('Events/insertEvent', 'Events::insertEvent'); // Insert new event
$routes->post('Events/updateEvent/(:segment)', 'Events::updateEvent/$1'); // Update existing event using event ID
$routes->post('Events/deleteEvent/(:segment)', 'Events::deleteEvent/$1'); // Delete event using event ID

// Routes for Anniversary Contributions
$routes->get('AnnivCon', 'AnnivCon::ChurchAnnivCon'); // View all anniversary contributions
$routes->get('AnnivCon/AddContrib', 'AnnivCon::AddContrib'); // Add new contribution form
$routes->post('AnnivCon/insertAnnivCon', 'AnnivCon::insertAnnivCon'); // Insert new contribution
$routes->get('AnnivCon/EditAnnivCon/(:num)', 'AnnivCon::EditAnnivCon/$1'); // Edit an existing contribution
$routes->post('AnnivCon/updateAnnivCon/(:num)', 'AnnivCon::updateAnnivCon/$1'); // Update an existing contribution
$routes->get('AnnivCon/DeleteAnnivCon/(:num)', 'AnnivCon::DeleteAnnivCon/$1'); // Delete a contribution
$routes->get('AnnivCon/Reports/AnnivConReport', 'AnnivCon::AnnivConReport');

// Routes for Church Expenses
$routes->get('Expenses', 'Expenses::ChurchExpenses');
$routes->get('Expenses/AddExpense', 'Expenses::AddExpense');
$routes->post('Expenses/insertExpense', 'Expenses::insertExpense');
$routes->get('Expenses/EditExpense/(:num)', 'Expenses::EditExpense/$1');
$routes->post('Expenses/updateExpense/(:num)', 'Expenses::updateExpense/$1');
$routes->get('Expenses/deleteExpense/(:num)', 'Expenses::deleteExpense/$1');
$routes->get('Expenses/Reports/ChurchExpensesReport', 'Expenses::ChurchExpensesReport');


// Admin authentication & dashboard
$routes->get('admin/login',     'Admin::login');       // Show login form
$routes->post('admin/auth',     'Admin::auth');        // Process login
$routes->get('admin/dashboard', 'Admin::dashboard');   // Show admin dashboard
$routes->get('admin/logout',    'Admin::logout');      // Log out and redirect to login
