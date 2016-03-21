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

        <h1>Results</h1>
        <h2>{bingo}</h2>
        {results}
        <p>{facet} : {course_program}{course_code} | {day_of_week}: {timeslot_start}-{timeslot_end} | {instructor} | {room}</p>
        {/results}

    </div>

    </body>
</html>