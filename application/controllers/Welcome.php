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
        
        //create bookings by days section
        $bookings_by_days = $this->timetable->get_bookings_by_days();
        $fragments_by_days = '';
        foreach($bookings_by_days as $booking)
        {            
            //parse view fragment and add to fragments string
            $fragments_by_days .= $this->parser->parse('single_booking',$booking, TRUE);
        }
        $data['bookings-days'] = $fragments_by_days;
        
        //create bookings by timeslots section
        $bookings_by_timeslots = $this->timetable->get_bookings_by_timeslots();
        $fragments_by_timeslots = '';
        foreach($bookings_by_timeslots as $booking)
        {            
            //parse view fragment and add to fragments string
            $fragments_by_timeslots .= $this->parser->parse('single_booking',$booking, TRUE);
        }
        $data['bookings-timeslots'] = $fragments_by_timeslots;
        
        //create bookings by courses section
        $bookings_by_courses = $this->timetable->get_bookings_by_courses();
        $fragments_by_courses = '';
        foreach($bookings_by_courses as $booking)
        {            
            //parse view fragment and add to fragments string
            $fragments_by_courses .= $this->parser->parse('single_booking',$booking, TRUE);
        }
        $data['bookings-courses'] = $fragments_by_courses;
        
        //parse outer template
        $this->parser->parse('welcome', $data);
    }
}
