<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- start the XSL transformation -->
    <xsl:template match="/">
        
        <!-- because we are outputting HTML, we must define some HTML elements -->
        <html>
            <head>
                <title>Timetable Horizontal</title>
                <link rel="stylesheet" type="text/css" href="days.css" />
            </head>
            <body>
                <h1>Timetable</h1>
                <h2>Horizontal (days across top), based on timeslots facet</h2>

                <table>                    
                    <xsl:call-template name="headings"/>
                    <xsl:apply-templates select="timetable/timeslots/timeslot"/>     
                </table>
        
            </body>
        </html>
        
    </xsl:template>
    
    <!-- headings for weekdays are hardcoded here -->
    <xsl:template name="headings">
        <tr>
            <th></th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
        </tr>
    </xsl:template>
    
    <!-- for each timeslot, print out the time and information for the course in each day (if exists) -->
    <xsl:template match="timeslot">
        <tr>
            <td>
                <xsl:value-of select="@start-time" /> - <xsl:value-of select="@end-time" />
            </td>
            <td>
                <xsl:apply-templates select="day[@weekday='mon']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="day[@weekday='tues']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="day[@weekday='weds']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="day[@weekday='thurs']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="day[@weekday='fri']"></xsl:apply-templates>
            </td>
        </tr>
    </xsl:template>
    
    <!-- this template is for a day: program, code, instructor, and booking(room) -->
    <xsl:template match="day">
        <xsl:value-of select="course/@program" />
        <xsl:value-of select="course/@code" />
        <br />
        <xsl:value-of select="course/booking/@instructor" />
        <br />
        <xsl:value-of select="course/booking" />                    
    </xsl:template>

</xsl:stylesheet>
