<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Timetable extends CI_model 
    {
    
    protected $xml = null;
    protected $bookings_by_days = array();
    protected $bookings_by_timeslots = array();
    protected $bookings_by_courses = array();
    
    
    //constructor
    function __construct() 
    {
        $this->xml = simplexml_load_file(DATAPATH . 'timetable.xml');
        
        
        // build the list of bookings by days
//        foreach ($this->xml->bookings_by_days->days->day as $days) {
//         
//        }
//        
//        
//      
//        
        
        foreach ($this->xml->days->day as $day)
        {
            //a day can have more than one booking
            foreach($day->timeslot as $timeslot)
            {
                //a timeslot must have only one booking in this context
                $booking_details = array(); //create details array
                
                //get the weekday as attribute from day element
                $booking_details['day_of_week'] = $day['weekday']; 
                
                //get start and end of timeslot from attributes of timeslot
                $booking_details['timeslot_start'] = $timeslot['start-time'];
                $booking_details['timeslot_end'] = $timeslot['end-time'];
                
                //get the course element and its attributes
                $course = $timeslot[0]->course;
                $booking_details['course_program'] = $course['program'];
                $booking_details['course_code'] = $course['code'];
                
                //get the booking element, attribute, and contents
                $booking = $course[0]->booking;
                $booking_details['instructor'] = $booking['instructor'];
                $booking_details['room'] = $booking;
                                          
                //build the booking object and add to array
                $this->bookings_by_days[] = new Booking($booking_details);
                
            }
            
        }
        
        
    }
    
    function get_bookings_by_days()
    {
        return $this->bookings_by_days;
    }



    
    
    
    
    
    
    
    
    
}


class Booking extends CI_model
{
    public $course_program;
    public $course_code;
    public $day_of_week;
    public $timeslot_start;
    public $timeslot_end;
    public $instructor;
    public $room;
    
    //constructor, takes associative array
    //because of the way our XML is designed, it would be very cumbersome to handle XML structure here
    //instead, we will handle it in the timetable class and build Booking to have no knowledge of it
    function __construct($details) 
    {
        $this->course_program = (String) $details['course_program'];
        $this->course_code = (String) $details['course_code'];
        $this->day_of_week = (String) $details['day_of_week'];
        $this->timeslot_start = (String) $details['timeslot_start'];
        $this->timeslot_end = (String) $details['timeslot_end'];
        $this->instructor = (String) $details['instructor'];
        $this->room = (String) $details['room'];        
    }
    
    
}