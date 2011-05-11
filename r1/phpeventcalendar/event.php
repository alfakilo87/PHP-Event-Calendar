<?php

class Event extends PHPEventCalendar
{
	var $content_visible;
	var $content_hidden;
	var $colorRGB;
	var $datetime_start;
	var $datetime_end;
	var $duration;
	var $checked;
	
	public function Event($content_vis, $content_hid, $year_st, $month_st, $day_st, $hour_st = 0, $min_st = 0, $year_end = 0, $month_end = 0, $day_end = 0, $hour_end = 0, $min_end = 0)
	{
		$this->content_visible = $content_vis;
		$this->content_hidden = $content_hid;
		$this->colorRGB = null;
		$this->datetime_start = mktime($hour_st, $min_st, 0, $month_st, $day_st, $year_st);
		$this->datetime_end = mktime($hour_end, $min_end, 0, $month_end, $day_end, $year_end);
		$this->duration = $this->getDuration();
		$this->checked = false;
	}
	
	function setColorRGB($RGBstring)
	{
		$this->colorRGB = $RGBstring;
	}
	
	function getColorRGB()
	{
		return $this->colorRGB;
	}
	
	function isAllDayEvent()
	{
		if ($this->getDuration() == 0 || date("j", $this->datetime_start) != date("j", $this->datetime_end) || date("n", $this->datetime_start) != date("n", $this->datetime_end) || date("Y", $this->datetime_start) != date("Y", $this->datetime_end)) return true;
		else return false;
	}
	
	function isRunningOnSpecTime($year, $month, $day, $hour, $min)
	{
		if ($this->datetime_end > $this->datetime_start)
		{
			$time = mktime($hour, $min, 0, $month, $day, $year);
			if ($time >= $this->datetime_start && $time <= $this->datetime_end) return true;
			return false;
		}
		else return false;
	}
	
	private function getDuration()
	{
		if ($this->datetime_end > $this->datetime_start)
		{
			$duration = $this->datetime_end - $this->datetime_start;
			return $duration;
		}
		else return 0;
	}
}

?>
