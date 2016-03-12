<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{title}</title>
    </head>

    <body>

    <div id="container">

        <div id="bookings-search">
            
            <h1>Bookings Search</h1>            
            
            <form name="search-form" action='welcome/search' id="dropdown-days">
                <select name="select-days">
                    {select-days}
                        <option value="{key}">{value}</option>
                    {/select-days}
                </select>
                <select name="select-timeslots">
                    {select-timeslots}
                        <option value="{key}">{value}</option>
                    {/select-timeslots}
                </select>
                <input type='submit' value='Submit'>
            </form>
            
        </div>
        
        <div id="bookings-lists">
            <h1>Bookings by Day</h1>
            {bookings-days}    

            <h1>Bookings by Timeslot</h1>
            {bookings-timeslots}

            <h1>Bookings by Course</h1>
            {bookings-courses}
        <div>        

    </div>

    </body>
</html>