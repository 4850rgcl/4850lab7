<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Timetable extends CI_model 
    {
    
    private static $list_weekdays =  array('mon'=>'Monday','tues'=>'Tuesday','weds'=>'Wednesday','thurs'=>'Thursday','fri'=>'Friday');
    private static $list_timeslots = array('0830'=>'8:30-9:20', '0930'=>'9:30-10:20', '1030'=>'10:30-11:20', '1130'=>'11:30-12:20', '1230'=>'12:30-13:20',
                                             '1330'=>'13:30-14:20', '1430'=>'14:30-15:20', '1530'=>'15:30-16:20', '1630'=>'16:30-17:20');
     
    protected $xml = null;
    protected $bookings_by_days = array();
    protected $bookings_by_timeslots = array();
    protected $bookings_by_courses = array();
    
    
    //constructor
    function __construct() 
    {

        $this->xml = simplexml_load_file(DATAPATH . 'timetable.xml');

        //first facet
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
        //second facet
        foreach ($this->xml->timeslots->timeslot as $timeslot) 
        {
            // a timeslot can exist on many days
            foreach ($timeslot->day as $day)
            {
                $booking_details = array(); 
                
                //get start and end of timeslot from attributes of timeslot
                $booking_details['timeslot_start'] = $timeslot['start-time'];
                $booking_details['timeslot_end'] = $timeslot['end-time'];
                
                //get the weekday as attribute from day element
                $booking_details['day_of_week'] = $day['weekday']; 
                
                //get the course element and its attributes
                $course = $day[0]->course;
                $booking_details['course_program'] = $course['program'];
                $booking_details['course_code'] = $course['code'];
                
                //get the booking element, attribute, and contents
                $booking = $course[0]->booking;
                $booking_details['instructor'] = $booking['instructor'];
                $booking_details['room'] = $booking;
                
                //build the booking object and add to array
                $this->bookings_by_timeslots[] = new Booking($booking_details);
            }
            
        }
        
        //third facet
        foreach ($this->xml->courses->course as $course)
        {
            // a course can be on multiple days
            foreach ($course->day as $day)
            {
                // a course could happen multiple times per day
                foreach ($day->timeslot as $timeslot)
                {
                    $booking_details = array();
                    
                    //get the course element and its attributes
                    
                    $booking_details['course_program'] = $course['program'];
                    $booking_details['course_code'] = $course['code'];
                    
                    //get the weekday as attribute from day element
                    $booking_details['day_of_week'] = $day['weekday']; 
                    
                    //get start and end of timeslot from attributes of timeslot
                    $booking_details['timeslot_start'] = $timeslot['start-time'];
                    $booking_details['timeslot_end'] = $timeslot['end-time'];
                    
                    //get the booking element, attribute, and contents
                    $booking = $timeslot[0]->booking;
                    $booking_details['instructor'] = $booking['instructor'];
                    $booking_details['room'] = $booking;
                    
                    $this->bookings_by_courses[] = new Booking($booking_details);
                    
                }                
            }
        }
        
    }
    
    //accessors
    
    function get_bookings_by_days()
    {
        return isset($this->bookings_by_days)? $this->bookings_by_days : null;
    }

    function get_bookings_by_timeslots()
    {
        return isset($this->bookings_by_timeslots) ? $this->bookings_by_timeslots : null;
    }
    
    function get_bookings_by_courses()
    {
        return isset($this->bookings_by_courses) ? $this->bookings_by_courses : null;
    }
    
    static function get_list_weekdays() {
        return self::$list_weekdays;
    }

    static function get_list_timeslots() {
        return self::$list_timeslots;
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
    function __construct($details = null) //default value to fix construct problems
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