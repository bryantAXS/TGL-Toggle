<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tgl_toggle
{
	public $return_data = NULL;
	public $session_value = NULL;

	/**
	 *  main {exp:tgl_toggle} method which checks for {session valie=""} tags and returns the 
	 *  correct content, based on the session value that is set.
 	 */
	public function __construct()
	{
		
		$this->EE =& get_instance();

		$tagdata = $this->EE->TMPL->tagdata;

		$this->session_value = "diamond";

		//loop through case parameters and find cause pair value that matches our variable
		$index = 0;

		foreach ($this->EE->TMPL->var_pair as $key => $val)
		{

			if(preg_match('/^session*/', $key))
			{

				// index of the case tag pair we're looking at
				$index++;	
						
				// define the pattern we're searching for in tagdata that encloses the current case content
				// make search string safe by replacing any regex in the case values with a marker
				$pattern = '/{session'.$index.'}(.*){\/session}/Usi';
				$tagdata = str_replace($key, 'session_'.$index, $tagdata);

				if(isset($val['value']) && $val['value'] == $this->session_value)
				{

					$match = true;

					// define the pattern we're searching for in tagdata that encloses the current case content
					// make search string safe by replacing any regex in the case values with a marker
					$pattern = '/{session_'.$index.'}(.*){\/session}/Usi';
					$tagdata = str_replace($key, 'session_'.$index, $tagdata);

					// we've found a match, grab case content and exit loop
					preg_match($pattern, $tagdata, $matches);
					$this->return_data = @$matches[1];

				}

			}
			
		}

		if($this->return_data === NULL)
		{
			$this->return_data = "";
		}

	}

	/**
	 * Returns the value of the session value we are able to set - this can be used to add to the body class 
	 * to handle value-specific styling.	 
	 * @return string the value of the session value we are able to set. 
	 */
	public function get_session_value()
	{
		return $this->session_value;
	}

}

/* End of File: mod.module.php */