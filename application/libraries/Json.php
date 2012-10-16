<?php

class Json {
	public function get_reply($html, $data=NULL) {
		$rep = array(
			'success' => TRUE,
			'contents' => $html,
			'data' => $data,
		);
		return json_encode($rep);
	}
	public function reply($html, $data=NULL) {
		echo $this->get_reply($html, $data);
	}

	public function get_error($reason) {
		$rep = array(
			'success' => FALSE,
			'error' => $reason,
		);
		return json_encode($rep);
	}
	public function error($reason) {
		echo $this->get_error($reason);
	}
}
