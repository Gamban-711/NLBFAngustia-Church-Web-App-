<?php

namespace App\Controllers;

use App\Models\ChurchEventModel;
use CodeIgniter\Controller;

class Events extends BaseController
{
    // Display all events grouped by date
    public function ChurchEvents()
    {
        $ChurchEventModel = new ChurchEventModel();

        // Fetch all events from the database
        $events = $ChurchEventModel->findAll();

        // Group events by date
        $eventsByDate = [];
        foreach ($events as $event) {
            $eventsByDate[$event['date']][] = $event;
        }

        // Pass data to the view
        $data['eventsByDate'] = $eventsByDate;
        return view('Events/ChurchEvents', $data);
    }

    // Show form for adding or editing an event
    public function AddEvent($event_Id = null)
    {
        $ChurchEventModel = new ChurchEventModel();
        $data = [];

        if ($event_Id) {
            $data['event'] = $ChurchEventModel->find($event_Id);
        }

        return view('Events/AddEvent', $data);
    }

    // Show edit form with templates
    public function EditEvent($event_Id)
    {
        $ChurchEventModel = new ChurchEventModel();
        $event = $ChurchEventModel->find($event_Id);

        if (!$event) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Event not found");
        }

        return view('Template/SideNav') .
            view('Template/Header') .
            view('Events/EditEvent', ['event' => $event]) .
            view('Template/Footer');
    }

    // Insert a new event with email notification
    public function insertEvent()
    {
        $eventModel = new ChurchEventModel();   
        $data = [
            'event_name'  => $this->request->getPost('event_name'),
            'date'        => $this->request->getPost('date'),
            'time'        => $this->request->getPost('time'),
            'description' => $this->request->getPost('description'),
        ];   
        if ($eventModel->insert($data)) {
            // Send email notification to multiple recipients
            $email = \Config\Services::email();
            $email->setFrom('jubermas@my.cspc.edu.ph', 'Church Admin');
    
            $email->setTo([
                'bermasjuliannah@gmail.com',
                'marcarongamban.18@gmail.com',
                'nonaleeespero@gmail.com',
                'agnotealdrin7@gmail.com',             
                'alexandermaranan98@gmail.com'
            ]); 
            $email->setSubject('New Church Event Added');
            $email->setMessage(
                '<h2>New Event Notification</h2>' .
                '<p><strong>Event Name:</strong> ' . esc($data['event_name']) . '</p>' .
                '<p><strong>Date:</strong> ' . esc($data['date']) . '</p>' .
                '<p><strong>Time:</strong> ' . esc($data['time']) . '</p>' .
                '<p><strong>Description:</strong> ' . esc($data['description']) . '</p>'
            );
    
            if (!$email->send()) {
                log_message('error', 'Failed to send email: ' . $email->printDebugger(['headers']));
            }
    
            return redirect()->to('/Events')->with('success', 'Event added successfully and notification sent.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add event.');
        }
    }
        // Update an existing event
    public function updateEvent($event_Id)
    {
        $eventModel = new ChurchEventModel();

        $data = [
            'event_name'  => $this->request->getPost('event_name'),
            'date'        => $this->request->getPost('date'),
            'time'        => $this->request->getPost('time'),
            'description' => $this->request->getPost('description'),
        ];

        if ($eventModel->update($event_Id, $data)) {
            return redirect()->to('/Events')->with('success', 'Event updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update event.');
        }
    }

    // Delete an event
    public function deleteEvent($event_Id)
    {
        $ChurchEventModel = new ChurchEventModel();
        $ChurchEventModel->delete($event_Id);
        session()->setFlashdata('success', 'Event deleted successfully!');
        return redirect()->to('/Events');
    }
}
