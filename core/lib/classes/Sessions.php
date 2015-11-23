<?php
/** Session Class
 * 
 * This Class is managing Sessions in database
 * 
 * @category 	Core
 * @version		0.1.0
 * 
 */
class Sessions
{
    private $_session;
    public $max_time;
    private $db;
     
    public function __construct(PDO $database)
    {
	    global $setting;
		
	    $this->db = $database;
		
	    $this->maxTime['access'] = time();
		
	    $this->maxTime['gc'] = $setting['session_life'];
		
	    session_set_save_handler(array($this, '_open'),
		    array($this, '_close'),
		    array($this, '_read'),
		    array($this, '_write'),
		    array($this, '_destroy'),
		    array($this, '_clean')
    	);
    	
    	register_shutdown_function('session_write_close');
    	
    	session_start();
		
		/* Every guest are a part of session management so if not logged in give 0 to determine user auth level */
		if (empty($_SESSION['user_auth']))
		{
			$_SESSION['user_auth'] = 0;
			$_SESSION['user_id'] = 0;
		}
    }
     
    public function _open()
    {
    	return true;
    }
     
    public function _close()
    {
	    $this->_clean($this->maxTime['gc']);
	    return true;
    }
     
    public function _read($id)
    {
    	$getData = $this->db->prepare("SELECT * FROM sessions WHERE session_id = ?");
    	$getData->bindParam(1, $id);
    	$getData->execute();
     
    	$allData = $getData->fetch(PDO::FETCH_ASSOC);
    	$totalData = count($allData);
    	$hasData = (bool) $totalData >= 1;
     
    	return $hasData ? $allData['session_data'] : '';
    }
     
    public function _write($id, $data)
    {
	    $getData = $this->db->prepare("REPLACE INTO sessions VALUES (?, ?, ?)");
	    $getData->bindParam(1, $id);
	    $getData->bindParam(2, $data);
	    $getData->bindParam(3, $this->maxTime['access']);
	   
	    return $getData->execute();
    }
     
    public function _destroy($id)
    {
	    $getData = $this->db->prepare("DELETE FROM sessions WHERE session_id = ?");
	    $getData->bindParam(1, $id);
	    
	    return $getData->execute();
    }
     
    public function _clean($max)
    {
	    $old = ($this->maxTime['access'] - $max);
	     
	    $getData = $this->db->prepare("DELETE FROM sessions WHERE session_life < ?");
	    $getData->bindParam(1, $old);
	    
	    return $getData->execute();
    }
}