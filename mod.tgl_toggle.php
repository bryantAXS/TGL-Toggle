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

		$this->session_value = $this->get_session_value();

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
				$pattern = '/{session_'.$index.'}(.*){\/session}/Usi';
				$tagdata = str_replace($key, 'session_'.$index, $tagdata);

				if(isset($val['value']) && $val['value'] == $this->session_value)
				{

					$match = true;

					// we've found a match, grab case content and exit loop
					preg_match($pattern, $tagdata, $matches);
					$this->return_data = @$matches[1];

				}

				// default value	
				if(isset($val['default']))
				{
					if(strtolower($val['default']) == 'yes' || strtolower($val['default']) == 'true' || $val['default'] == '1')
					{
						
						// found a default, save matched content and continue loop
						preg_match($pattern, $tagdata, $matches);
						$default_data = @$matches[1];

					}
				}	

			}
			
		}

		//if we didn't find anying, either set the default'ed piece of content or return nothing
		if($this->return_data === NULL)
		{
			if(isset($default_data))
			{
				$this->return_data = $default_data;
			}
			else
			{
				$this->return_data = "";
			}
		}

	}

	public function session()
	{

		$tagdata = $this->EE->TMPL->tagdata;
		$value = $this->EE->TMPL->fetch_param("value");
		$this->session_value = $this->get_session_value();

		if($value == $this->session_value)
		{
			return $tagdata;
		}

		return "";

	}

	/**
	 * Returns the value of the session value we are able to set - this can be used to add to the body class 
	 * to handle value-specific styling.	 
	 * @return string the value of the session value we are able to set. 
	 */
	public function get_session_value()
	{

		$cache_value = $this->EE->session->cache('tgl_toggle','session_value');
		if(empty($cache_value)){
			$cache_value = false;
		}
		
		if($cache_value)
		{
			return $cache_value;
		}
		else
		{
			return  $this->EE->input->cookie("tgl_toggle_session_value") === false ? "" : $this->EE->input->cookie("tgl_toggle_session_value");
		}

	}

}

/* End of File: mod.module.php */