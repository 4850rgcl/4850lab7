<?xml version="1.0" encoding="UTF-8"?>

<!--
    Document   : daysvert.xsl
    Created on : March 31, 2016, 1:11 PM
    Author     : Richard
    Description:
        Purpose of transformation follows.
-->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <!-- TODO customize transformation rules 
         syntax recommendation http://www.w3.org/TR/xslt 
    -->
    
    <!-- start transformation process -->
    <xsl:template match="/">
        <!-- define some HTML elements -->
         <html>
            <head>
                <title>Timetable Vertical</title>
                <link rel="stylesheet" type="text/css" href="days.css" />
            </head>
            <body>
                <h1>Timetable</h1>
                <h2>Vertical (timeslots across top), based on day facet</h2>

                <table>                    
                    <xsl:call-template name="headings"/>
                    <xsl:apply-templates select="timetable/days/day"/>     
                </table>
        
            </body>
        </html>
        
        
        
        
    </xsl:template>
    
    <!-- headings for weekdays are hardcoded here -->
    <xsl:template name="headings">
        <tr>
            <th></th>
            <th>8:30 - 9:20</th>
            <th>9:30 - 10:20</th>
            <th>10:30 - 11:20</th>
            <th>11:30 - 12:20</th>
            <th>12:30 - 13:20</th>
            <th>13:30 - 14:20</th>
            <th>14:30 - 15:20</th>
            <th>15:30 - 16:30</th>
            <th>16:30 - 17:20</th>
        </tr>
    </xsl:template>
    
    <xsl:template match="day">
        <tr>
            <td>
                <xsl:value-of select="@weekday" />
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='830']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='930']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='1030']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='1130']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='1230']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='1330']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='1430']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='1530']"></xsl:apply-templates>
            </td>
            <td>
                <xsl:apply-templates select="timeslot[@start-time='1630']"></xsl:apply-templates>
            </td>
        </tr>
       
    </xsl:template>
    
    <xsl:template match="timeslot">
        <xsl:value-of select="course/@program" />
        <xsl:value-of select="course/@code" />
        <br />
        <xsl:value-of select="course/booking/@instructor" />
        <br />
        <xsl:value-of select="course/booking" />                    
    </xsl:template>
    
    

</xsl:stylesheet>
