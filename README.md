holidays
========

A Symfony project created on May 3, 2016, 11:56 am.

Fill database

Check on http://holidays.kayaposoft.com/public_holidays.php : Kayaposoft 
or https://www.mozilla.org/en-US/projects/calendar/holidays/ : Mozilla to get ics calendar

Check if the calendar name is a CIO code.ics like FRA.ics

Function date

CheckHoliday : Check if the day is a Holiday and return a new date (timestamp). 
We can follow the link like /checkHoliday/FRA/20160505 -> 20160506->getTimestamp()

IsHoliday : Check if the day is a Holiday and return a boolean. We can follow the link like /isHoliday/FRA/20160505 -> 1 (true)

We can add a number of day in addition like /checkHoliday/FRA/20160505/2 -> 20160509->getTimestamp()
