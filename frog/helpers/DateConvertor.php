<?php

class DateConvertor
{
	private $day = null;
	private $month = null;
	private $year = null;
	private $timestamp = null;
	
	private $names = array(
		'month' => array(
			'cічня',
			'лютого',
			'березеня',
			'квітеня',
			'травеня',
			'червня',
			'липня',
			'серпня',
			'вересеня',
			'жовтня',
			'листопада',
			'грудня'
		),
		'days' => array(
			'неділя',
			'понеділок',
			'вівторок',
			'середа',
			'четвер',
			'п’ятниця',
			'субота'
		)
	);

	public function __construct( $day, $month, $year )
	{
		$this->day = (int)$day;
		$this->month = (int)$month;
		$this->year = (int)$year;
		
		$this->timestamp = mktime(0, 0, 0, $this->month, $this->day, $this->year);
	}
	
	public function __toString()
	{
		$week_day_num = (int)date('w', $this->timestamp);
		$month_num = (int)date('m', $this->timestamp);
		
		$day = $this->names['days'][$week_day_num];
		
		$day = iconv('UTF-8', 'Windows-1251', $day); // convert to windows-1251 
        $day = ucfirst($day); 
        $day = iconv('Windows-1251', 'UTF-8', $day); // convert back to utf-8 
		
		return $day . ', ' . date('d', $this->timestamp) . ' ' . $this->names['month'][$month_num-1] . ', ' . date('Y', $this->timestamp) . ' p.';
	}
}

?>