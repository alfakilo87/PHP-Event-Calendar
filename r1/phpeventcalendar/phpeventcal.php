<?php

require_once 'config.php';
require_once 'event.php';

class PHPEventCalendar
{
	var $settings;
	var $events;
	
	function PHPEventCalendar()
	{
		$this->settings = new config();
		$this->events = array();
	}
	
	function addEvent(Event $event)
	{
		array_push($this->events, $event);
	}
	
	function getNumberOfEvents($year, $month, $day, $hour = false, $min = false)
	{
		$out = 0;
		if ($hour != false)
		{
			foreach ($this->events as $event)
			{
				if ($event->isRunningOnSpecTime($year, $month, $day, $hour, $min)) $out++;
			}
		}
		else
		{
			$date = mktime(0, 0, 0, $month, $day, $year);
			foreach ($this->events as $event)
			{
				if (date("Y.m.d", $event->getDateTimeStart()) == date("Y.m.d", $date)) $out++;
			}
		}
		return $out;
	}
	
	function getEventHeight($duration)
	{
		if ($duration > 900) return $duration / 60;
		else return 15;
	}
	
	function getEvents($year, $month, $day, $hr = null, $min = null, $allday = true)
	{
		$dt1 = mktime($hr, $min, 0, $month, $day, $year);
		$dt2 = mktime($hr, $min + 15, 0, $month, $day, $year);
		$out = array();
		$ctrl1 = 0;
		$ctrl2 = 1;
		if ($hr != null && $allday != true)
		{
			while ($ctrl1 != $ctrl2)
			{
				$ctrl2 = $ctrl1;
				foreach ($this->events as $event)
				{
					if ($event->isAllDayEvent() != true && $event->checked != true && ($event->datetime_start >= $dt1 && $event->datetime_start < $dt2))
					{
						array_push($out, $event);
						if ($dt2 < $event->datetime_end) $dt2 = $event->datetime_end;
						$event->checked = true;
						$ctrl1++;
					}
				}
			}
		}
		else if ($hr != null)
		{
			foreach ($this->events as $event)
			{
				if ($dt1 >= $event->datetime_start && $dt1 <= $event->datetime_end)
				{
					array_push($out, $event);
				}
			}
		}
		else if ($hr == null)
		{
			foreach ($this->events as $event)
			{
				if ((date("Y", $dt1) == date("Y", $event->datetime_start) && date("n", $dt1) == date("n", $event->datetime_start) && date("j", $dt1) == date("j", $event->datetime_start)) || (date("Y", $dt1) >= date("Y", $event->datetime_start) && date("Y", $dt1) <= date("Y", $event->datetime_end) && date("n", $dt1) >= date("n", $event->datetime_start) && date("n", $dt1) <= date("n", $event->datetime_end) && date("j", $dt1) >= date("j", $event->datetime_start) && date("j", $dt1) <= date("j", $event->datetime_end)))
				{
					array_push($out, $event);
				}
			}
		}
		return $out;
	}
	
	function drawSmallSizeEvents($year, $month, $day, $allday = false)
	{
		$out = "";
		
		if ($allday != false)
		{
			foreach ($this->getEvents($year, $month, $day) as $event)
			{
				if ($event->isAllDayEvent() != false)
				{
					$out .= "<span class=\"event\"  style=\"background-color: rgb(";
					if ($event->getColorRGB()) $out .= $event->getColorRGB();
					else $out .= $this->settings->rgbdefaulteventcolor;
					$out .= "); display: block; max-height: 1.3em; overflow: hidden; margin: 1px; padding-left: 3px;\">\n";
					$out .= $event->getVisibleContent()."\n";
					$out .= "</span>\n";
				}
			}
		}
		else if ($allday != true)
		{
			foreach ($this->getEvents($year, $month, $day) as $event)
			{
				$out .= "<span class=\"event\"  style=\"background-color: rgb(";
				if ($event->getColorRGB()) $out .= $event->getColorRGB();
				else $out .= $this->settings->rgbdefaulteventcolor;
				$out .= "); display: block; max-height: 1.3em; overflow: hidden; margin: 1px; padding-left: 3px;\">\n";
				$out .= $event->getVisibleContent()."\n";
				$out .= "</span>\n";
			}
		}
		return $out;
	}
	
	function drawEvents($year, $month, $day, $hour, $min)
	{
		$out = "";
		$dt = mktime($hour, $min, 0, $month, $day, $year);
		$events = $this->getEvents($year, $month, $day, $hour, $min, false);
		$count = count($events);
		if ($count > 0) $w = 100 / $count;
		else $w = 100;
		$i = 0;
		foreach ($events as $event)
		{
			$x = $event->datetime_start - $dt;
			$x = $x / 60;
			$out .= "<div style=\"position: absolute; top: ".$x."px; left: ".$i * $w."%;";
			$out .= " font-size: small; float: left; overflow: hidden; width: ".$w."%;";
			$out .= " min-width: ".$this->settings->eventminwidthpx."px;";
			$out .= " max-width: ".$this->settings->eventmaxwidthpx."px;";
			$out .= " height: ".$this->getEventHeight($event->duration)."px;";
			$out .= " border-style: solid; border-width: 1px; border-color: rgb(".$this->settings->rgbbackgroundcolor."); text-align: center; z-index: 3;";
			if ($event->getColorRGB() != null) $out .= " background-color: rgb(".$event->getColorRGB().");";
			else $out .= " background-color: rgb(".$this->settings->rgbdefaulteventcolor.");";
			$out .= "\">\n<div style=\"background-color: white; opacity: 0.3;\">\n<div style=\"max-height: 1.3em; overflow: hidden; padding-left: 3px;\">".date("H:i", $event->datetime_start)." - ".date("H:i", $event->datetime_end)."</div>\n</div>\n";
			$out .= $event->getVisibleContent()."\n";
			$out .= "</div>\n";
			$i++;
		}
		return $out;
	}
	
	function getFirstDateForMonthView($year, $month)
	{
		$date1 = mktime(0, 0, 0, $month, 1, $year);
		$date2 = $date1;
		$week = (int)date("W", $date1);
		while ($week === (int)date("W", $date2))
		{
			$date2 = $date2 - 1;
		}
		return $date2 + 1;
	}
	
	function getFirstDateForWeekView($year, $month, $day)
	{
		$date1 = mktime(0, 0, 0, $month, $day, $year);
		$date2 = $date1;
		$week = (int)date("W", $date1);
		while ($week === (int)date("W", $date2))
		{
			$date2 = $date2 - 1;
		}
		return $date2 + 1;
	}
	
	function getMonthView($year, $month)
	{
		$date = mktime(0, 0, 0, $month, 1, $year);
		$dateToday = $date;
		$week = (int)date("W", $date);
		$FirstDay = $this->getFirstDateForMonthView($year, $month);
		$date = $FirstDay;
		$pr = 100/7;
		$out = "";
		$out .= "<div class=\"cal\">\n<table class=\"monthview\" cellspacing=\"1\" style=\"width: 100%; background-color: rgb(".$this->settings->rgbheadercolor.");\">\n<caption style=\"background-color: rgb(".$this->settings->rgbheadercolor.");\">";
		$m = $this->settings->getMonths();
		$out .= $m[$month - 1]." ".$year;
		$out .= "</caption>\n<tbody>\n";
		$out .= "<tr>\n";
		if ($this->settings->showweeknumber)
		{
			$out .= "<th style=\"min-width: 50px;\">".$this->settings->weekname."</th>\n";
		}
		foreach ($this->settings->getDays() as $d)
		{
			$out .= "<th style=\"width: ".$pr."%; min-width: 100px; max-width: 200px;\">".$d."</th>\n";
		}
		$out .= "</tr>\n";
		for ($i = 1; $i <= 4; $i++)
		{
			
		}
		while (date("Y-m", $date) <= date("Y-m", $dateToday))
		{
			$out .= "<tr>\n";
			if ($this->settings->showweeknumber)
			{
				$out .= "<th>".date("W", $date)."</th>\n";
			}
			for ($j = 1; $j <= 7; $j++)
			{
				$out .= "<td id=\"\" style=\"background-color: rgb(".$this->settings->rgbbackgroundcolor.");";
				if (date("Y-m-d", $date) === date("Y-m-d")) $out .= " border-style: solid; border-width: 1px; border-color: rgb(".$this->settings->rgbtodayheadercolor.");";
				$out .= "\">\n";
				
				$out .= "<table class=\"day\" cellspacing=\"0\" style=\"width: 100%;\">\n<tbody>\n<tr>\n";
				
				$out .= "<th";
				if (date("Y-m-d", $date) === date("Y-m-d")) $out .= " style=\"background-color: rgb(".$this->settings->rgbtodayheadercolor.");\"";
				$out .= ">".date("j", $date)."</th>\n";
				
				$out .= "</tr>\n<tr>\n";
				$out .= "<td>\n";
				
				$out .= $this->drawSmallSizeEvents(date("Y", $date), date("n", $date), date("j", $date));
				
				$out .= "</td>\n";
				$out .= "</tr>\n</tbody>\n</table>\n";
				
				$out .= "</td>\n";
				$date = mktime(0, 0, 0, date("m", $date), date("d", $date) + 1, date("y", $date));
			}
			$out .= "</tr>\n";
		}
		$out .= "</tbody>\n</table>\n</div>\n";
		echo $out;
	}
	
	function getWeekView($year, $month, $day)
	{
		$startdatetime = $this->getFirstDateForWeekView($year, $month, $day);
		$seqdatetime = $startdatetime;
		$proportion = 100/7;
		$out = "";
		$out .= "<div class=\"cal\">\n<table class=\"weekview\" cellspacing=\"1\" style=\"width: 100%; background-color: rgb(".$this->settings->rgbheadercolor.");\">\n<tbody>\n";
		$out .= "<tr>\n";
		$out .= "<th rowspan=\"2\" style=\"min-width: 50px;\"></th>\n";
		foreach ($this->settings->getDays(1) as $d)
		{
			$out .= "<th style=\"width: ".$proportion."%; min-width: 100px;";
			if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= " background-color: rgb(".$this->settings->rgbtodayheadercolor.");";
			$out .= "\">".$d." ".date("j.n", $seqdatetime)."</th>\n";
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		$seqdatetime = $startdatetime;
		$out .= "</tr>\n";
		$out .= "<tr class=\"allday\">\n";
		foreach ($this->settings->getDays() as $d)
		{
			$out .= "<td style=\"border-bottom-style: solid; border-width: 5px; font-size: small; border-color: rgb(".$this->settings->rgbheadercolor."); background-color: rgb(";
			if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= $this->settings->rgbtodaycolor;
			else $out .= $this->settings->rgbbackgroundcolor;
			$out .= ")\"><div style=\"min-height: 40px;\">";
			
			$out .= $this->drawSmallSizeEvents(date("Y", $seqdatetime), date("n", $seqdatetime), date("j", $seqdatetime), true);
			
			$out .= "</div></td>\n";
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		$seqdatetime = $startdatetime;
		$out .= "</tr>\n";
		for ($i = 0; $i <= 23; $i++)
		{
			$out .= "<tr class=\"hour\">\n";
			$out .= "<th style=\"text-align: right; vertical-align: top;\">".date("H:i", $seqdatetime)."</th>\n";
			for ($j = 1; $j <= 7; $j++)
			{
				$out .= "<td id=\"\" style=\"background-color: rgb(";
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= $this->settings->rgbtodaycolor;
				else $out .= $this->settings->rgbbackgroundcolor;
				$out .= "); font-size: small;\">\n";
				
				$out .= "<table class=\"hour\" cellspacing=\"0\" style=\"width: 100%; border-color: rgb(".$this->settings->rgbheadercolor.");\">\n<tbody>\n<tr>\n";
				$out .= "<td style=\"display: block; position: relative; border-bottom-style: dotted; border-width: 1px; height: 14px; min-height: 14px; max-height: 14px; overflow: visible; border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				//$out .= date("G:i", $seqdatetime);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</td>\n";
				$out .= "</tr>\n";
				$out .= "<tr>\n";
				$out .= "<td style=\"display: block; position: relative; border-bottom-style: dotted; border-width: 1px; height: 14px; min-height: 14px; max-height: 14px; overflow: visible; border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				//$out .= date("G:i", $seqdatetime);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</td>\n";
				$out .= "</tr>\n";
				$out .= "<tr>\n";
				$out .= "<td style=\"display: block; position: relative; border-bottom-style: dotted; border-width: 1px; height: 14px; min-height: 14px; max-height: 14px; overflow: visible; border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				//$out .= date("G:i", $seqdatetime);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</td>\n";
				$out .= "</tr>\n";
				$out .= "<tr>\n";
				$out .= "<td class=\"last\" style=\"display: block; position: relative; height: 14px; min-height: 14px; max-height: 14px; overflow: visible; border-color: rgb(".$this->settings->rgbheadercolor.");\">";
				$w = $this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime)) * 100;
				$out .= "<div style=\"width: ".$w."px;\"></div>";
				
				$out .= $this->drawEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime), date("H", $seqdatetime), date("i", $seqdatetime), $proportion);
				//$out .= date("G:i", $seqdatetime);
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) + 15, 0, date("m", $seqdatetime), date("d", $seqdatetime), date("y", $seqdatetime));
				
				$out .= "</td>\n";
				$out .= "</tr>\n</tbody>\n</table>\n";
				
				$out .= "</td>\n";
				$seqdatetime = mktime(date("G", $seqdatetime), date("i", $seqdatetime) - 60, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
			}
			$out .= "</tr>\n";
			$seqdatetime = mktime(date("G", $seqdatetime) + 1, 0, 0, date("m", $startdatetime), date("d", $startdatetime), date("y", $startdatetime));
		}
		$out .= "</tbody>\n</table>\n</div>\n";
		echo $out;
	}
	
	function getAgendaView($days = 10)
	{
		$startdatetime = mktime(0, 0, 0, date("m"), date("d"), date("y"));
		$seqdatetime = $startdatetime;
		$out = "";
		$out .= "<div class=\"cal\">\n";
		$out .= "<table class=\"agenda\" cellspacing=\"1\" style=\"width: 100%; background-color: rgb(".$this->settings->rgbheadercolor.");\">\n";
		$out .= "<tbody>\n";
		
		for ($i = 1; $i <= $days; $i++)
		{
			if ($this->getNumberOfEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime)) >= 1)
			{
				$out .= "<tr>\n";
				$out .= "<th style=\"";
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= "background-color: rgb(".$this->settings->rgbtodayheadercolor.");";
				$out .= "width: 50px; min-width: 50px; vertical-align: top;\">".date("j.n", $seqdatetime)."</th>\n";
				$out .= "<td style=\"background-color: rgb(";
				if (date("Y-m-d", $seqdatetime) === date("Y-m-d")) $out .= $this->settings->rgbtodaycolor;
				else $out .= $this->settings->rgbbackgroundcolor;
				$out .= ");\">";
				$out .= "<table cellspacing=\"0\" style=\"width: 100%;\">\n";
				$out .= "<tbody>\n";
				
				foreach ($this->getEvents(date("Y", $seqdatetime), date("m", $seqdatetime), date("d", $seqdatetime)) as $event)
				{
					$out .= "<tr>\n";
					$out .= "<td style=\"width: 100px; text-align: center;\">";
					if (date("Y", $event->datetime_end) >= date("Y"))
					{
						$out .= date("H:i", $event->datetime_start)." - ".date("H:i", $event->datetime_end);
					}
					else $out .= $this->settings->allday;
					$out .= "</td>\n";
					$out .= "<td";
					if ($event->getColorRGB()) $out .= " style=\"color: rgb(".$event->getColorRGB().");\"";
					$out .= ">".$event->content_visible."</td>\n";
					$out .= "</tr>\n";
				}
				
				$out .= "</tbody>\n";
				$out .= "</table>\n";
				$out .= "</td>\n";
				$out .= "</tr>\n";
			}
			$seqdatetime = mktime(0, 0, 0, date("m", $seqdatetime), date("d", $seqdatetime) + 1, date("y", $seqdatetime));
		}
		
		$out .= "</tbody>\n";
		$out .= "</table>\n";
		$out .= "</div>\n";
		echo $out;
	}
}

?>