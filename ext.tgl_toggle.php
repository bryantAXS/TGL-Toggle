<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
// ------------------------------------------------------------------------

/**
 * TGL Toggle Extension
 *
 * @package     ExpressionEngine
 * @subpackage  Addons
 * @category    Extension
 * @author      Bryant Hughes
 * @link        http://www.thegoodlab.com
 */

class Tgl_toggle_ext {
    
    public $settings        = array();
    public $description     = 'TGL Toggle Extension';
    public $docs_url        = 'https://github.com/bryantAXS/TGL-Toggle';
    public $name            = 'TGL Toggle';
    public $settings_exist  = 'n';
    public $version         = '0.1';
    
    private $EE;
    
    /**
     * Constructor
     *
     * @param   mixed   Settings array or empty string if none exist.
     */
    public function __construct($settings = '')
    {
        $this->EE =& get_instance();
        $this->settings = $settings;
    }// ----------------------------------------------------------------------
    
    /**
     * Activate Extension
     *
     * This function enters the extension into the exp_extensions table
     *
     * @see http://codeigniter.com/user_guide/database/index.html for
     * more information on the db class.
     *
     * @return void
     */
    public function activate_extension()
    {
        // Setup custom settings in this array.
        $this->settings = array();
        
        $data = array(
            'class'     => __CLASS__,
            'method'    => 'sessions_start',
            'hook'      => 'sessions_start',
            'settings'  => serialize($this->settings),
            'version'   => $this->version,
            'enabled'   => 'y'
        );

        $this->EE->db->insert('extensions', $data);         
        
    }   

    // ----------------------------------------------------------------------
    
    /**
     * sessions_start
     *
     * @param 
     * @return 
     */
    public function sessions_start()
    {
        // Add Code for the sessions_start hook here.  
        
        if(isset($_GET['session']))
        {
            $this->EE->functions->set_cookie("tgl_toggle_session_value", $_GET["session"], 604800); //one week
        }

    }

    // ----------------------------------------------------------------------

    /**
     * Disable Extension
     *
     * This method removes information from the exp_extensions table
     *
     * @return void
     */
    function disable_extension()
    {
        $this->EE->db->where('class', __CLASS__);
        $this->EE->db->delete('extensions');
    }

    // ----------------------------------------------------------------------

    /**
     * Update Extension
     *
     * This function performs any necessary db updates when the extension
     * page is visited
     *
     * @return  mixed   void on update / false if none
     */
    function update_extension($current = '')
    {
        if ($current == '' OR $current == $this->version)
        {
            return FALSE;
        }
    }   
    
    // ----------------------------------------------------------------------
}

/* End of file ext.tgl_toggle.php */
/* Location: /system/expressionengine/third_party/tgl_toggle/ext.tgl_toggle.php */