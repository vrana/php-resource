<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Ldap extends Resource {
	protected static $prefix = 'ldap_';
	protected $destructor = 'close';
	protected $resources = array(
		'ldap result' => 'freeResult',
		'ldap result entry' => '',
	);
	
	function firstAttribute($result_entry_identifier, &$ber_identifier) {
		if (is_object($result_entry_identifier) && $result_entry_identifier instanceof Resource) {
			$result_entry_identifier = $result_entry_identifier->resource;
		}
		return ldap_first_attribute($this->resource, $result_entry_identifier, $ber_identifier);
	}
	
	function nextAttribute($result_entry_identifier, &$ber_identifier) {
		if (is_object($result_entry_identifier) && $result_entry_identifier instanceof Resource) {
			$result_entry_identifier = $result_entry_identifier->resource;
		}
		return ldap_next_attribute($this->resource, $result_entry_identifier, $ber_identifier);
	}
	
	function getOption($option, &$retval) {
		return ldap_get_option($this->resource, $option, $retval);
	}
	
	function parseReference($entry, &$referrals) {
		if (is_object($entry) && $entry instanceof Resource) {
			$entry = $entry->resource;
		}
		return ldap_parse_reference($this->resource, $entry, $referrals);
	}
	
	function parseResult($result, &$errcode, &$matcheddn = null, &$errmsg = null, &$referrals = null) {
		if (is_object($result) && $result instanceof Resource) {
			$result = $result->resource;
		}
		return ldap_parse_result($this->resource, $result, $errcode, $matcheddn, $errmsg, $referrals);
	}
}
