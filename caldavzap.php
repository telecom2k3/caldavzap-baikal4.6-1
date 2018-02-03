<?php
/**
 * Roundcube CalDAVZap Plugin
 * Integrate CalDAVZap in to Roundcube
 *
 * @version 1.03
 * @author Offerel
 * @copyright Copyright (c) 2017, Offerel
 * @license GNU General Public License, version 3
 */
 
class caldavzap extends rcube_plugin
{
	public $task = '.*';

	function init()
	{
		$rcmail = rcmail::get_instance();
		$this->load_config();
		$this->add_texts('localization/', true);
		
		$this->register_task('caldavzap');
		
		$this->add_button(array(
			'label'      => 'caldavzap.caldavzap',
			'command'    => 'caldavzap',
			'class'      => 'button-calendar',
			'classsel'   => 'button-calendar button-selected',
			'innerclass' => 'button-inner'
		), 'taskbar');
		
		if ($rcmail->task == 'caldavzap') {
			$this->register_action('index', array($this, 'action'));
			$this->baikal_check();
			$this->login_caldavzap();
		}
	}
	
	private function login_caldavzap()
	{
		$rcmail = rcmail::get_instance();
		$this->include_script('client.js');
		$rcmail->output->set_env('caldavzap_username', $rcmail->user->get_username());
		$rcmail->output->set_env('caldavzap_password', $rcmail->get_user_password());
		$rcmail->output->set_env('caldavzap_url', $rcmail->config->get('caldavzap_url', false));
 
	}

	private function baikal_check()
	{
		$rcmail = rcmail::get_instance();
                $j1name = $rcmail->user->get_username();
                $j1password =  $rcmail->get_user_password();
                $baikalhost = $rcmail->config->get('baikal_host', false);
                $baikaladmin = $rcmail->config->get('baikal_admin', false);
                $baikalpass = $rcmail->config->get('baikal_pw', false);
                $baikaldb = $rcmail->config->get('baikal_db', false);
                $baikalport = $rcmail->config->get('baikal_port', false);
                $baikalrealm = $rcmail->config->get('baikal_realm', false);
                $jdsn = "mysql:host=$baikalhost;port=$baikalport;dbname=$baikaldb;charset=utf8mb4";
                // error_log("SYNC: User: $j1name Password: $j1password",0);
                // error_log("SYNC: $jdsn $baikaladmin $baikalpass",0);
                try {

                   $jhandler = new PDO($jdsn,$baikaladmin,$baikalpass);
                   $jhandler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e){
                     exit($e->getMessage());
                }
                $j1handler = $jhandler->prepare("SELECT username FROM users  WHERE username = :name");
                $j1handler->bindParam(':name', $j1name);
                $j1handler->execute();
		$pwhashfunction = "$j1name:$baikalrealm:$j1password";
		$jhash = md5($pwhashfunction);
                   if($j1handler->rowCount() > 0) {
                      // error_log("SYNC: Username $j1name already exists",0);
		      $sql = "SELECT digesta1,id FROM users WHERE username = :username LIMIT 1";
		      $stmt20 = $jhandler->prepare($sql);
		      $stmt20->execute(array(':username' => $j1name));
		      $check1 = $stmt20->fetch();
		      $check = $check1['digesta1'];
		      $did = $check1['id'];
		      // error_log("SYNC: Digest is: $check, ID: $did",0);
			if (strcmp($check, $jhash) !== 0) {
			$sql = "UPDATE users SET digesta1=:hash WHERE id=:did";
			$stmt21 = $jhandler->prepare($sql);
			$stmt21->execute(array(':hash' => $jhash, ':did' => $did));
			error_log("SYNC: Password changed for $j1name",0);
			}
                   } else {
		      // error_log("SYNC: Username $j1name does not exist.",0);
		      $sql = 'INSERT INTO users(username, digesta1) VALUES(:username, :digesta1)';
		      $stmt = $jhandler->prepare($sql);
		      $stmt->execute(array(':username' => $j1name, ':digesta1' => $jhash));
		      $last_id = $jhandler->lastInsertId();
		      // error_log(SYNC: "Users updated: $j1name, ID: $last_id",0);
		      $j1prin = "principals/$j1name";
		      $sql = 'INSERT INTO principals(id, uri, email, displayname, vcardurl, inf_it_settings) VALUES(:id, :uri, :email, :displayname, :vcardurl, :inf_it_settings)';
		      $stmt1 = $jhandler->prepare($sql);
		      $stmt1->execute(array(':id' => null, ':uri' => $j1prin, ':email' => $j1name, ':displayname' => $j1name, ':vcardurl' => "", ':inf_it_settings' => ""));
		      // error_log("SYNC: Principals table updated",0);
		      $sql = 'INSERT INTO calendars(id, principaluri, displayname, uri, synctoken, description, calendarorder, calendarcolor, timezone, components, transparent) VALUES(:id, :principaluri, :displayname, :uri, :synctoken, :description, :calendarorder, :calendarcolor, :timezone, :components, :transparent)';
		      $stmt2 = $jhandler->prepare($sql);
		      $stmt2->execute(array(':id' => null, ':principaluri' => $j1prin, ':displayname' => "Default calendar", ':uri' => "default", ':synctoken' => "1", ':description' => "Default calendar", ':calendarorder' => "0", ':calendarcolor' => "", ':timezone' => "", ':components' => "VEVENT,VTODO",':transparent' => "0"));
		      // error_log("SYNC: Calendars table updated",0);
		      $sql = 'INSERT INTO addressbooks(id, principaluri, displayname, uri, description, synctoken) VALUES(:id, :principaluri, :displayname, :uri, :description, :synctoken)';
		      $stmt3 = $jhandler->prepare($sql); 
		      $stmt3->execute(array(':id' => null, ':principaluri' => $j1prin, ':displayname' => "Default Address Book", ':uri' => "default", ':description' => "Default Address Book", ':synctoken' => "1"));
		      // error_log("SYNC: Addressbooks table updated",0);
		      error_log("SYNC: $j1name added.",0);
                   }
		   $jhandler = null;
	}
	
	function action()
    	{
        	$rcmail = rcmail::get_instance();
        	// register UI objects
        	$rcmail->output->add_handlers(array('caldavzapcontent' => array($this, 'content'),));
		$rcmail->output->set_pagetitle($this->gettext('caldavzap'));
        	$rcmail->output->send('caldavzap.caldavzap');
    	}

	function content($attrib)
    	{
        	$rcmail = rcmail::get_instance();
		$attrib['src'] = $rcmail->config->get('caldavzap_url', false);
        	if (empty($attrib['id']))
            		$attrib['id'] = 'rcmailcaldavzapcontent';
        	$attrib['name'] = $attrib['id'];
        	return $rcmail->output->frame($attrib);
    	}
}
?>

