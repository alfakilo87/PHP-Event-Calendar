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
	
//	var $year_start;
//	var $month_start;
//	var $day_start;
//	var $hour_start;
//	var $min_start;
//	var $year_finish;
//	var $month_finish;
//	var $day_finish;
//	var $hour_finish;
//	var $min_finish;
	
	public function Event($content_vis, $content_hid, $year_st, $month_st, $day_st, $hour_st = 0, $min_st = 0, $year_end = 0, $month_end = 0, $day_end = 0, $hour_end = 0, $min_end = 0)
	{
		$this->content_visible = $content_vis;
		$this->content_hidden = $content_hid;
		$this->colorRGB = null;
		$this->datetime_start = mktime($hour_st, $min_st, 0, $month_st, $day_st, $year_st);
		$this->datetime_end = mktime($hour_end, $min_end, 0, $month_end, $day_end, $year_end);
		$this->duration = $this->getDuration();
		$this->checked = false;
		
//		$this->year_start = $year_st;
//		$this->month_start = $month_st;
//		$this->day_start = $day_st;
//		$this->hour_start = $hour_st;
//		$this->min_start = $min_st;
//		$this->year_finish = $year_fs;
//		$this->month_finish = $month_fs;
//		$this->day_finish = $day_fs;
//		$this->hour_finish = $hour_fs;
//		$this->min_finish = $min_fs;
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
	
	function getVisibleContent()
	{
		return $this->content_visible;
	}
	
	function getHiddenContent()
	{
		return $this->content_hidden;
	}
	
	function getDateTimeStart()
	{
		return $this->datetime_start;
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
	
	/**
 	*
 	* Get datetime finish of event
 	*
 	* @param	none
 	* @return	false or datetime
 	*
 	*/
	function getDateTimeEnd()
	{
		return $this->datetime_end;
	}
}

?>
