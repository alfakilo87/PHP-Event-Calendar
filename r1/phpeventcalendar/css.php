<?php

require_once 'config.php';
$config = new config();
$out = "";

$out .= "
<style type=\"text/css\">
div.cal
{
	font-family: ".$config->fontfamily.";
	background-color: rgb(".$config->rgbheadercolor.");
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
	background-color: rgb(".$config->rgbtodayheadercolor.");
}

div.cal table.agenda td.day
{
	background-color: rgb(".$config->rgbbackgroundcolor.");
}

div.cal table.agenda td.today
{
	background-color: rgb(".$config->rgbtodaycolor.");
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
	background-color: rgb(".$config->rgbtodayheadercolor.");
}

div.cal table.week tr.allday td
{
	background-color: rgb(".$config->rgbbackgroundcolor.");
	border-bottom-style: solid;
	border-width: 5px;
	border-color: rgb(".$config->rgbheadercolor.");
	font-size: small;
}

div.cal table.week tr.allday td.today
{
	background-color: rgb(".$config->rgbtodaycolor.");
}

div.cal table.week tr.hour th.hour
{
	text-align: right;
	vertical-align: top;
}

div.cal table.week tr.hour td
{
	font-size: small;
}

div.cal table.week tr.hour td.notoday
{
	background-color: rgb(".$config->rgbbackgroundcolor.");
}

div.cal table.week tr.hour td.today
{
	background-color: rgb(".$config->rgbtodaycolor.");
}

div.cal table.week tr.hour div.quarter
{
	position: relative;
	height: 14px;
	min-height: 14px;
	max-height: 14px;
	overflow: visible;
	border-bottom-style: dotted;
	border-color: rgb(".$config->rgbheadercolor.");
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
	background-color: rgb(".$config->rgbheadercolor.");
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
	background-color: rgb(".$config->rgbbackgroundcolor.");
}

div.cal table.month td.today
{
	background-color: rgb(".$config->rgbtodaycolor.");
	border-style: solid;
	border-width: 1px;
	border-color: rgb(".$config->rgbtodayheadercolor.");
}

div.cal table.month td table.day
{
	width: 100%;
	font-size: small;
}

div.cal table.month table.day th
{
	background-color: rgb(".$config->rgbdayheadercolor.");
	height: 10px;
	min-height: 10px;
	max-height: 10px;
	font-weight: normal;
	text-align: right;
}

div.cal table.month td.today table.day th
{
	background-color: rgb(".$config->rgbtodayheadercolor.");
}

div.cal table.month table.day div.content
{
	min-height: 50px;
}

</style>
";

echo $out;

?>