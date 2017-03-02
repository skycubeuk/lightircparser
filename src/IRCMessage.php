<?php

namespace Lightircparser;

class IRCMessage {
	public $ts;
	private $raw_processed;
	public $has_message_tags;
	public $has_prefix;
	public $message_tags = array();
	public $prefix = array();
	public $command;
	public $params = array();
	public $raw;


	function __construct($message) {
		$this->raw = $message;
		$this->raw_processed = $message;
		$this->ts = round(microtime(true) * 1000);
	}

	public function phrase() {
		$this->phrase_tags();
		$this->phrase_prefix();
		$this->phrase_command();
		$this->phrase_params();
		unset($this->raw_processed);

	}

	private function phrase_tags() {
		if ($this->raw_processed[0] == "@") {
			$this->has_message_tags = true;
			$tags = explode(" ", $this->raw_processed, 2);
			$this->raw_processed = $tags[1];
			$tags = explode(";", ltrim(trim($tags[0]), "@"));
			foreach ($tags as $tag) {
				$tag = explode("=", $tag, 2);
				$tag[1] = $tag[1] === "" ? null : $tag[1];
				$this->message_tags[$tag[0]] = $tag[1];
			}
		} else {
			$this->has_message_tags = false;
		}
	}

	private function phrase_prefix() {
		if ($this->raw_processed[0] == ":") {
			$has_user = false;
			$has_host = false;
			$this->has_prefix = true;
			$prefix = explode(" ", $this->raw_processed, 2);
			$this->raw_processed = $prefix[1];
			$prefix[0] = ltrim($prefix[0], ":");
			if (strpos($prefix[0], "!")) {
				$has_user = true;
			}
			if (strpos($prefix[0], "@")) {
				$has_host = true;
			}

			if ($has_user && $has_host) {
				$prefix_part = explode("!", $prefix[0], 2);
				$nick = $prefix_part[0];
				$prefix_part = explode("@", $prefix_part[1], 2);
				$user = $prefix_part[0];
				$host = $prefix_part[1];
				$this->prefix['nick'] = $nick;
				$this->prefix['user'] = $user;
				$this->prefix['host'] = $host;
			} elseif ($has_user) {
				$prefix_part = explode("!", $prefix[0], 2);
				$nick = $prefix_part[0];
				$user = $prefix_part[1];
				$this->prefix['nick'] = $nick;
				$this->prefix['user'] = $user;
			} elseif ($has_host) {
				$prefix_part = explode("@", $prefix[0], 2);
				$nick = $prefix_part[0];
				$host = $prefix_part[1];
				$this->prefix['nick'] = $nick;
				$this->prefix['host'] = $host;
			} else {
				$this->prefix['servername'] = $prefix[0];
			}
		} else {
			$this->has_prefix = false;
		}
	}

	private function phrase_command() {
		$command = explode(" ", $this->raw_processed, 2);
		$this->command = $command[0];
		$this->raw_processed = $command[1];
	}

	private function phrase_params() {
		while (strlen($this->raw_processed)) {
			if ($this->raw_processed[0] == ":") {
				array_push($this->params, ltrim($this->raw_processed, ":"));
				$this->raw_processed = "";
			} else {
				$e = explode(" ", $this->raw_processed, 2);
				array_push($this->params, $e[0]);
				if (isset($e[1])) {
					$this->raw_processed = $e[1];
				} else {
					$this->raw_processed = "";
				}
			}
		}
	}
}