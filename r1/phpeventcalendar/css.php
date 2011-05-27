<?php

require_once 'config.php';
$settings = new Config();
$out = "";

$out .= "
<style type=\"text/css\">
div.cal
{
	font-family: ".$settings->fontfamily.";
	background-color: rgb(".$settings->rgbheadercolor.");
}

div.cal table.agenda
{
	width: 100%;
}

div.cal table.agenda th
{
	width: 50px;
	min-width: 50px;
	vertical-align: top;
}

div.cal table.agenda th.today
{
	background-color: rgb(".$settings->rgbtodayheadercolor.");
}

div.cal table.agenda td.day
{
	background-color: rgb(".$settings->rgbbackgroundcolor.");
}

div.cal table.agenda td.today
{
	background-color: rgb(".$settings->rgbtodaycolor.");
}

div.cal table.agenda table.day22
{
	width: 100%;
}

div.cal table.agenda td.time
{
	width: 100px;
	text-align: center;
}

div.cal table.week
{
	width: 100%;
}

div.cal table.week th.day
{
	min-width: 100px;
}

div.cal table.week th.today
{
	min-width: 100px;
	background-color: rgb(".$settings->rgbtodayheadercolor.");
}

div.cal table.week tr.allday td
{
	background-color: rgb(".$settings->rgbbackgroundcolor.");
	border-bottom-style: solid;
	border-width: 5px;
	border-color: rgb(".$settings->rgbheadercolor.");
	font-size: 10pt;
}

div.cal table.week tr.allday td.today
{
	background-color: rgb(".$settings->rgbtodaycolor.");
}

div.cal table.week tr.hour th.hour
{
	text-align: right;
	vertical-align: top;
}

div.cal table.week tr.hour td
{
	font-size: 10pt;
}

div.cal table.week tr.hour td.notoday
{
	background-color: rgb(".$settings->rgbbackgroundcolor.");
}

div.cal table.week tr.hour td.today
{
	background-color: rgb(".$settings->rgbtodaycolor.");
}

div.cal table.week tr.hour div.quarter
{
	position: relative;
	height: 14px;
	min-height: 14px;
	max-height: 14px;
	overflow: visible;
	border-bottom-style: dotted;
	border-color: rgb(".$settings->rgbheadercolor.");
	border-width: 1px;
}

div.cal table.week tr.hour div.lquarter
{
	position: relative;
	height: 14px;
	min-height: 14px;
	max-height: 14px;
	overflow: visible;
}

div.cal table.month
{
	width: 100%;
}

div.cal table.month caption
{
	background-color: rgb(".$settings->rgbheadercolor.");
	font-weight: bold;
}

div.cal table.month th.weekday
{
	min-width: 100px;
	max-width: 200px;
}

div.cal table.month td
{
	vertical-align: top;
	margin: 0px;
	padding: 0px;
}

div.cal table.month td.notoday
{
	background-color: rgb(".$settings->rgbbackgroundcolor.");
}

div.cal table.month td.today
{
	background-color: rgb(".$settings->rgbtodaycolor.");
	border-style: solid;
	border-width: 1px;
	border-color: rgb(".$settings->rgbtodayheadercolor.");
}

div.cal table.month td table.day
{
	width: 100%;
	font-size: 10pt;
	height: 60px;
}

div.cal table.month table.day th
{
	background-color: rgb(".$settings->rgbdayheadercolor.");
	height: 10px;
	min-height: 10px;
	max-height: 10px;
	font-weight: normal;
	text-align: right;
}

div.cal table.month td.today table.day th
{
	background-color: rgb(".$settings->rgbtodayheadercolor.");
}

div.cal table.month table.day div.content
{
	min-height: 50px;
}

div.cal div.event
{
	position: absolute;
	float: left;
	overflow: hidden;
	border-color: rgb(".$settings->rgbheadercolor.");
	font-size: 10pt;
	min-width: ".$settings->eventminwidthpx."px;
	max-width: ".$settings->eventmaxwidthpx."px;
	border-style: solid;
	border-width: 1px;
	text-align: center;
	z-index: 1;
}

div.cal div.sevent
{
	max-height: 1.3em;
	overflow: hidden;
	margin: 1px;
	padding-left: 3px;
}

</style>
";

echo $out;

?>