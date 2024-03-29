<?php

class Ds_Imports_Model_Table_Csvhead extends Mage_Core_Model_Abstract
{
    public function getCSVHead()
    {
		$head = array();
        $head = array(
            "order_id",
			"email",
			"firstname",
			"lastname",
			"prefix",
			"middlename",
			"suffix",
			"taxvat",
			"created_at",
			"updated_at",
			"invoice_created_at",
			"shipment_created_at",
			"creditmemo_created_at",
			"tax_amount",
			"base_tax_amount",
			"discount_amount",
			"base_discount_amount",
			"shipping_tax_amount",
			"base_shipping_tax_amount",
			"base_to_global_rate",
			"base_to_order_rate",
			"store_to_base_rate",
			"store_to_order_rate",
			"subtotal_incl_tax",
			"base_subtotal_incl_tax",
			"coupon_code",
			"shipping_incl_tax",
			"base_shipping_incl_tax",
			"shipping_method",
			"shipping_amount",
			"subtotal",
			"base_subtotal",
			"grand_total",
			"base_grand_total",
			"base_shipping_amount",
			"adjustment_positive",
			"adjustment_negative",
			"refunded_shipping_amount",
			"base_refunded_shipping_amount",
			"refunded_subtotal",
			"base_refunded_subtotal",
			"refunded_tax_amount",
			"base_refunded_tax_amount",
			"refunded_discount_amount",
			"base_refunded_discount_amount",
			"store_id",
			"order_status",
			"order_state",
			"hold_before_state",
			"hold_before_status",
			"store_currency_code",
			"base_currency_code",
			"order_currency_code",
			"total_paid",
			"base_total_paid",
			"is_virtual",
			"total_qty_ordered",
			"remote_ip",
			"total_refunded",
			"base_total_refunded",
			"total_canceled",
			"total_invoiced",
			"customer_id",
			"billing_prefix",
			"billing_firstname",
			"billing_middlename",
			"billing_lastname",
			"billing_suffix",
			"billing_street_full",
			"billing_city",
			"billing_region",
			"billing_country",
			"billing_postcode",
			"billing_telephone",
			"billing_company",
			"billing_fax",
			"customer_id",
			"shipping_prefix",
			"shipping_firstname",
			"shipping_middlename",
			"shipping_lastname",
			"shipping_suffix",
			"shipping_street_full",
			"shipping_city",
			"shipping_region",
			"shipping_country",
			"shipping_postcode",
			"shipping_telephone",
			"shipping_company",
			"shipping_fax",
			"payment_method",
			"product_sku",
			"product_name",
			"qty_ordered",
            "qty_invoiced",
            "qty_shipped",
            "qty_refunded",
            "qty_canceled",
            "product_type",
            "original_price",
            "base_original_price",
            "row_total",
            "base_row_total",
            "row_weight",
            "price_incl_tax",
            "base_price_incl_tax",
			"product_tax_amount",
			"product_base_tax_amount",
            "product_tax_percent",
            "product_discount",
            "product_base_discount",
            "product_discount_percent",
            "is_child",
			"product_option"
			
    	);
		return $head;
    }
	
}