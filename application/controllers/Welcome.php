<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index()
    {
        //load models
        $this->load->model('timetable');
        $this->load->model('booking');
        
        //define data array and define title
        $data = array();
        $data['title'] = "Bookings";
        
        //create bookings by days element
        $bookings_by_days = $this->timetable->get_bookings_by_days();
        $fragments_by_days = '';
        foreach($bookings_by_days as $booking)
        {            
            //parse view fragment and add to fragments string
            $fragments_by_days .= $this->parser->parse('single_booking',$booking, TRUE);
        }
        $data['bookings-day'] = $fragments_by_days;
        
        //parse outer template
        $this->parser->parse('welcome', $data);

        //$this->load->view('welcome_message');
    }
}
