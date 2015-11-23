<?php
/** Calendar Class
 * 
 * @category 	Core
 * @version		0.1.0
 */
class Calendar
{
	var $user_id;
	var $calendar_id;
	var $event_id = false;
	
	var $limit = 500;
	
	function __construct()
	{
		
	}
	public static function calendars()
	{
		if (!empty($this->calendar_id))
			return select('calendars')->results();
		else
			return select('calendars')->where('calendar_id = '.$this->calendar_id)->results();
	}
	public function events()
	{
		if (!$this->event_id)
			return select('calendars_events')->limit($this->limit)->results();
		else
			return select('calendars_events')->where('calendar_event_id = '.$this->event_id)->result();
	}
	public function upcoming_events($time)
	{
		return select('calendars_events')->where('start >= '.$time)->order('start ASC')->limit($this->limit)->results();
	}
	public static function events_user()
	{
		return select('calendars_events')->where('user_id = '.$_SESSION['user_id'])->results();
	}
	public static function events_json($format = false)
	{
		$events = select('calendars_events')->which('title,start,end,url,color,textColor')->results();
		if ($format)
		{
			for ($i=0; $i<count($events); $i++)
			{
				$events[$i]['start'] = date($format, $events[$i]['start']);
				$events[$i]['end'] = date($format, $events[$i]['end']); 
			}
		}
		return json_encode($events);
	}
}
