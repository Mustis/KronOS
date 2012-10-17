<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {
	protected $cached_sid, $cached_uid, $cached_level, $cached_display_name;
	public function __construct() {
		# Required
		parent::__construct();
	}

	public function try_login($user, $pass) {
		$this->db->select('uid, password, salt');
		$this->db->where('username', $user);
		$q = $this->db->get('users');
		if ($q->num_rows() > 0) {
			$row = $q->row();
			$pwdigest = sha1($row->salt.$pass);
			if ($pwdigest == $row->password) {
				return $this->do_login($row->uid);
			}
		}
		return FALSE;
	}
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

		$this->input->set_cookie('session_id', $this->sid());

		return TRUE;
	}

	public function sid($new=NULL) {
		if (!empty($new)) {
			$old = $this->cached_sid;
			$this->cached_sid = $new;
			return $old;
		}

		if (isset($this->cached_sid)) {
			return $this->cached_sid;
		} else {
			// FIXME needs IP-lock checking...
			return $this->cached_sid = $this->input->cookie('session_id');
		}
	}
	public function uid($new=NULL) {
		if (!empty($new)) {
			$old = $this->cached_uid;
			$this->cached_uid = $new;
			return $old;
		}

		if (isset($this->cached_uid)) {
			return $this->cached_uid;
		} else {
			$sid = $this->sid();
			if ($sid !== FALSE) {
				$this->db->select('uid');
				$this->db->where('sid', $sid);
				$q = $this->db->get('sessions');
				if ($q->num_rows() > 0) {
					$row = $q->row();
					return $this->cached_uid = $row->uid;
				}
			}
		}
		return FALSE;
	}
	public function display_name($new=NULL) {
		if (!empty($new)) {
			$old = $this->cached_display_name;
			$this->cached_display_name = $new;
			return $old;
		}

		if (isset($this->cached_display_name)) {
			return $this->cached_display_name;
		} else {
			$uid = $this->uid();
			if ($uid !== FALSE) {
				$this->db->select('display_name');
				$this->db->where('uid', $uid);
				$q = $this->db->get('users');
				if ($q->num_rows() > 0) {
					$row = $q->row();
					return $this->cached_display_name = $row->display_name;
				}
			}
		}
		return FALSE;
	}
	public function level($new=NULL) {
		// TODO TODO TODO
		$this->cached_level = $new;
	}

	public function is_logged_in() {
		return $this->sid() > 0;
	}
}
