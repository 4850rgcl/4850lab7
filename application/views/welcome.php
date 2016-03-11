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

    <h1>Bookings by Day</h1>
    {bookings-days}    
    
    <h1>Bookings by Timeslot</h1>
    {bookings-timeslots}
    
    <h1>Bookings by Course</h1>
    {bookings-courses}

</div>

</body>
</html>