<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* TODO: check if app was succesfully opened, if not delete the instance */

class Msession extends CI_Model {
	public function __construct() {
		$this->load->model('user');

		$this->apps = array();

		# Required
		parent::__construct();
	}

	protected function setError($error) {
		trigger_error($error);
		$this->lastError = $error;
		return FALSE;
	}
	public function getError() {
		return $this->lastError;
	}

	protected function includeApp($file) {
		$f = $this->config->item('app_prefix').$file;
		if (!is_file($f)) {
			return $this->setError('App file does not exist '.$f);
		}
		if (!(include_once $f)) {
			return $this->setError('Include error '.$f);
		}
	}

	protected function getApp($aid, $iid, $file, $class) {
		$this->includeApp($file);
		return new $class($iid, $aid);
	}

	public function getAppClass($aid) {
		$this->db->select('classname, filename');
		$this->db->where('aid', $aid);
		$q = $this->db->get('apps');
		if ($q->num_rows() == 0)
			return FALSE;
		$row = $q->row();
		$filename = $row->filename;
		$classname = $row->classname;
		$this->includeApp($filename);
		return $classname;
	}

	public function getAppInst($iid) {
		if (isset($this->apps[$iid])) {
			return $this->apps[$iid];
		} else {
			$this->db->select('aid, corename');
			$this->db->where('iid', $iid);
			$q = $this->db->get('session_apps');
			if ($q->num_rows() == 0)
				return FALSE;
			$row = $q->row();
			$aid = $row->aid;

			if ($aid == -1) {
				$filename = 'core/'.$row->corename.'.php';
				$classname = ucfirst($row->corename);
			} else {
				$this->db->select('classname, filename');
				$this->db->where('aid', $aid);
				$q = $this->db->get('apps');
				if ($q->num_rows() == 0)
					return FALSE;
				$row = $q->row();
				$filename = $row->filename;
				$classname = $row->classname;
			}
			return $this->getApp($aid, $iid, $filename, $classname);
		}
	}

	public function openCoreApp($name) {
		$idata = array(
			'sid' => $this->user->sid(),
			'aid' => -1,
			'corename' => $name,
		);
		$this->db->insert('session_apps', $idata);
		$iid = $this->db->insert_id();

		$app = $this->getApp(-1, $iid, 'core/'.$name.'.php', ucfirst($name));
		if ($app) {
			$app->opening();
			$this->apps[$iid] = $app;
		}
		return $app;
	}
	public function openApp($aid) {
		$sid = $this->user->sid();
		$level = $this->user->level();

		$this->db->select('classname, filename, access');
		$this->db->where('aid', $aid);
		$q = $this->db->get('apps');
		if ($q->num_rows() == 0)
			return $this->setError('No such app');
		$row = $q->row();
		if (!$level)
			return $this->setError('No access');
		elseif ($row->access == 'operator' && $level == 'user')
			return $this->setError('No access');
		elseif ($row->access == 'manager' && $level != 'manager')
			return $this->setError('No access');
		// they have access, go on

		$idata = array(
			'sid' => $this->user->sid(),
			'aid' => $aid,
		);
		$this->db->insert('session_apps', $idata);
		$iid = $this->db->insert_id();

		$app = $this->getApp($aid, $iid, $row->filename, $row->classname);
		if ($app) {
			$app->opening();
			$this->apps[$iid] = $app;
		}
		return $app;
	}
	public function closeApp($iid) {
		$app = $this->getAppInst($iid);
		$app->closing();

		$this->db->where('iid', $iid);
		$this->db->delete('session_apps');
	}

	// UNUSED HERE, REMOVE
	public function do_login($uid) {
		$this->db->select('display_name, level');
		$this->db->where('uid', $uid);
		$q = $this->db->get('users');
		if ($q->num_rows() == 0)
			return FALSE;
		$row = $q->row();
		$this->uid($uid);
		$this->display_name($row->display_name);
		$this->level($row->level);

		$sdata = array(
			'uid' => $uid,
			'started' => time(),
			'last' => time(),
			'lockip' => $this->input->ip_address(),
		);
		$this->db->insert('sessions', $sdata);
		$this->sid($this->db->insert_id());

		return $this->sid();
	}

	public function sid($new=NULL) {
		if (!empty($new)) {
			$old = $this->cached_sid;
			$this->cached_sid = $new;
			return $old;
		}

		if (isset($this->cached_sid) && $this->cached_sid != 0) {
			return $this->cached_sid;
		} else {
			// TODO IP-lock checking...
			$this->cached_sid = $this->input->cookie('session_id');
			if ($this->cached_sid != 0) {
				return $this->cached_sid;
			}
		}
		return FALSE; // fallback to this
	}
}
