<html>
<head>
<title>PHP Calendar testpage</title>
</head>
<body>
<noscript><br>
Some features are not available, because Your browser does not support
JavaScript! <br>
</noscript>

<?php

require_once 'phpeventcalendar/phpeventcal.php';
$cal2 = new PHPEventCalendar();
$e1 = new Event("allday1", "", 2011, 5, 9);
$e1->setColorRGB("100,100,100");
$cal2->addEvent($e1);
$cal2->addEvent(new Event("allday2", "", 2011, 5, 10, 2, 0, 2011, 5, 10, 3, 15));
$cal2->addEvent(new Event("allday3", "", 2011, 5, 7, 0, 0));
$cal2->addEvent(new Event("Test3", "", 2011, 5, 3, 15, 0, 2011, 5, 3, 15, 30));
$e2 = new Event("Test4", "", 2011, 5, 3, 15, 0, 2011, 5, 3, 15, 15);
$cal2->addEvent($e2);
$cal2->addEvent(new Event("Test5", "", 2011, 5, 4, 16, 45, 2011, 5, 4, 18, 0));
$cal2->addEvent(new Event("Test6", "", 2011, 5, 4, 16, 0, 2011, 5, 4, 18, 0));
$cal2->addEvent(new Event("Test7", "", 2011, 5, 4, 16, 30, 2011, 5, 4, 17, 0));
$cal2->addEvent(new Event("Test8", "", 2011, 5, 4, 16, 0, 2011, 5, 4, 17, 0));
$cal2->addEvent(new Event("Test9", "", 2011, 5, 4, 18, 0, 2011, 5, 4, 18, 45));
$cal2->addEvent(new Event("Test10", "", 2011, 5, 12, 16, 45, 2011, 5, 12, 18, 0));
$cal2->addEvent(new Event("Test11", "", 2011, 5, 12, 16, 0, 2011, 5, 12, 18, 0));
$cal2->addEvent(new Event("Test12", "", 2011, 5, 12, 16, 30, 2011, 5, 12, 17, 0));
$cal2->addEvent(new Event("Test13", "", 2011, 5, 12, 16, 0, 2011, 5, 12, 17, 0));
$cal2->addEvent(new Event("Test14", "", 2011, 5, 12, 18, 0, 2011, 5, 12, 18, 45));
$cal2->addEvent(new Event("link", '<a href="http://maps.google.com/maps?f=d&hl=en&geocode=10741331078457941886,59.457082,24.839939&saddr=&daddr=59.457159,24.840152&mra=dme&mrcr=0&mrsp=1&sz=16&sll=59.457236,24.840496&sspn=0.007895,0.020084&ie=UTF8&ll=59.457072,24.838715&spn=0.031579,0.080338&z=14">http://maps.google.com/maps?f=d&hl=en&geocode=10741331078457941886,59.457082,24.839939&saddr=&daddr=59.457159,24.840152&mra=dme&mrcr=0&mrsp=1&sz=16&sll=59.457236,24.840496&sspn=0.007895,0.020084&ie=UTF8&ll=59.457072,24.838715&spn=0.031579,0.080338&z=14</a>', 2011, 5, 22));
$cal2->addEvent(new Event("See on pikem s�ndmuse kirjeldus", "", 2011, 5, date("j"), 4, 15, 2011, 5, date("j"), 5, 30));
$cal2->addEvent(new Event("allday4", "", 2011, 5, date("j")));
$cal2->getMonthView(2011, 5);
echo "</br>";
$cal2->getWeekView(2011, 5, 10);
echo "</br>";
echo "agenda:";
echo "</br>";
$cal2->getAgendaView(15);

//print_r($cal2->getEvents(2011, 4, 23));
//foreach ($cal2->getEvents() as $event)
//{
//	echo date("Y", $event->getDateTimeStart());
//}

//print_r($cal2->settings->getDays(1));
//print_r($cal2->settings->getMonths(3));

?>

</body>
</html>
