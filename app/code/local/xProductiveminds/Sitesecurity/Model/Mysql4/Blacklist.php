<?php

class Productiveminds_Sitesecurity_Model_Mysql4_Blacklist extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct()
	{
		$this->_init('sitesecurity/blacklist', 'id');
	}
}