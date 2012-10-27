<?php

abstract class KOS_App {
	abstract function __construct($iid);
	abstract public function iid();
	abstract public function appName();
	abstract public function windowTitle();
	abstract public function windowContents();

	abstract public function opening();
	abstract public function closing();

	abstract public function act($action);
}

?>
