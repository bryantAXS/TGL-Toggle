<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tgl_toggle_upd
{
	public $version = '1.0';

	public function __construct()
	{
		$this->EE =& get_instance();
	}

	public function install()
	{
		
		$this->EE->load->dbforge();

		$this->EE->db->insert('modules', array(
			'module_name' => 'Tgl_toggle',
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		));

		//Creating Toggle Settings table
		$fields = array(
			'id' => array('type' => 'int', 'constraint' => '10', 'unsigned' => TRUE, 'null' => FALSE, 'auto_increment' => TRUE),
			'site_id'	=>	array('type' => 'int', 'constraint' => '8', 'unsigned' => TRUE, 'null' => FALSE, 'default' => '1'),
			'var'		=>	array('type' => 'varchar', 'constraint' => '60', 'null' => FALSE),
			'var_value'	=>	array('type' => 'varchar', 'constraint' => '100', 'null' => FALSE)
		);

		$this->EE->dbforge->add_field($fields);
		$this->EE->dbforge->add_key('id', TRUE);
		$this->EE->dbforge->create_table('tgl_toggle_settings');	

		return TRUE;
	}

	public function update( $current = '' )
	{
		if($current == $this->version) { return FALSE; }
		return TRUE;
	}

	public function uninstall()
	{

		$this->EE->load->dbforge();
		
		$this->EE->db->query("DELETE FROM exp_modules WHERE module_name = 'Tgl_toggle'");
		
		$this->EE->dbforge->drop_table('tgl_toggle_settings');
		
		return TRUE;
	}
}

/* End of File: upd.module.php */
