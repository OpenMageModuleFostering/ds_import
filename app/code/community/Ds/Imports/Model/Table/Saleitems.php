<?php class Ds_Imports_Model_Table_Saleitems extends Mage_Core_Model_Abstract
	{
   		 //To create order
		public function getSaleitems()
		{
			$sale = array();
			$sale =   array
			(
				'product_sku',
				'product_name',
				'qty_ordered',
				'qty_invoiced',
				'qty_shipped',
				'qty_refunded',
				'qty_canceled',
				'product_type',
				'original_price',
				'base_original_price',
				'row_total',
				'base_row_total',
				'row_weight',
				'price_incl_tax',
				'base_price_incl_tax',
				'product_tax_amount',
				'product_base_tax_amount',
				'product_tax_percent',
				'product_discount',
				'product_base_discount',
				'product_discount_percent',
                'is_child',
				'product_option' 
			);
			return $sale;
			
		}
		
    }