<?php class Ds_Imports_Model_Table_Billingtable extends Mage_Core_Model_Abstract
	{
   		 //To create order
		public function getbillingtable()
		{
			$table = array();
			$table =   array(
				'customer_address_id',
				'prefix',
				'firstname',
				'middlename',
				'lastname' ,
				'suffix',
				'street',
				'city',
				'region',
				'country_id',
				'postcode',
				'telephone' ,
				'company',
				'fax'
			);
			return $table;
			
		}
		
    }