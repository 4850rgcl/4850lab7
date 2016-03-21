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
        
        //fill booking search lists
        $list_weekdays = array();
        foreach($this->timetable->get_list_weekdays() as $weekday => $weekday_value)
        {
            $list_weekdays[] = array('key'=>$weekday,'value'=>$weekday_value);
        }
        $data['select-days'] = $list_weekdays;
        
        $list_timeslots = array();
        foreach($this->timetable->get_list_timeslots() as $timeslot => $timeslot_value)
        {
            $list_timeslots[] = array('key'=>$timeslot,'value'=>$timeslot_value);
        }
        $data['select-timeslots'] = $list_timeslots;
        
        //parse outer template
        $this->parser->parse('welcome', $data);
    }
    
    function search()
    { 
        //load models
        $this->load->model('timetable');
        $this->load->model('booking');
        
        //define data and results array (inner and outer)
        $data = array();       
        $results = array();
        $multi_bookings = false; // boolean for error condition of multiple booking responses, should never happen
        $bingo = false; // check for bingo condition
        
        //get day and slot from get/post data
        $day = $this->input->get_post('select-days', TRUE);
        $slot = $this->input->get_post('select-timeslots', TRUE);
        
        //create (ugly) custom page title
        $data['title'] = "Results for " . $day . ":" . $slot;
      
        //get matching bookings by day and add to results array
        foreach($this->timetable->search_bookings_by_days($day, $slot) as $booking)
        {
            if (isset($day_booking)) // check for multiple booking responses, should never happen
            {
                $multi_bookings = true;
            }
            $booking = (array)$booking; //convert to array
            $day_booking = $booking; // for bingo check
            $booking['facet'] = "By Day"; //add facet info
            $results[] = $booking;
        }
        
        //get matching bookings by timeslot and add to results array
        foreach($this->timetable->search_bookings_by_timeslots($day, $slot) as $booking)
        {
            if (isset($time_booking)) // check for multiple booking responses, should never happen
            {
                $multi_bookings = true;
            }
            $booking = (array)$booking; //convert to array
            $time_booking = $booking; // for bingo check
            $booking['facet'] = "By Timeslot"; //add facet info
            $results[] = $booking;
        }
        
        //get matching bookings by course and add to results array
        foreach($this->timetable->search_bookings_by_courses($day, $slot) as $booking)
        {
            if (isset($course_booking)) // check for multiple booking responses, should never happen
            {
                $multi_bookings = true;
            }
            $booking = (array)$booking; //convert to array
            $course_booking=$booking; //for bingo check
            $booking['facet'] = "By Courses"; //add facet info
            $results[] = $booking;
        }
        
        //check for bingo condition
        if (!$multi_bookings) 
            {
                if (isset($day_booking) && isset($time_booking) && isset($course_booking))
                {
                 if ($day_booking == $time_booking && $day_booking == $course_booking )
                    {
                      $bingo = true;
                    }
                }
        }
        
        if ($bingo) // show single common result if all 3 match
        {
        $time_booking['facet'] = "Any";
            $data['results'] = array($time_booking);
            $data['bingo'] = "BINGO!!!";
         }
        else 
        {    
            //put the results in data and parse the template
            $data['results'] = $results;
        }  
            $this->parser->parse('booking_results', $data);
    }
}
