<?php

class Ds_Imports_Model_Importallorders extends Mage_Core_Model_Abstract
{
    public $order_info = array();
    public $order_item_info = array();
    public $order_item_flag = 0;
  
	public function readCSV($csvFile,$data)
    {
		$import_limit = $data['import_limit'];
	    $store_id = $data['store_id'];
		$file_handle = fopen($csvFile, 'r');
		$i=0;
		$decline = array();
		$available = array();
		$success = 0;
		$parent_flag = 0;
		$invalid = 0;
		$line_number = 2;
		$total_order = 0;
		Mage::helper('imports')->unlinkFile();
		Mage::helper('imports')->header();
		feof($file_handle);
		//print_r(feof($file_handle));
		//die("test");
		while (!feof($file_handle) ) 
		{
			$count[] = fgetcsv($file_handle);
			//print_r($count);
			//die();
			if($i!=0)
			{
				if($count[$i][0]!='' && $parent_flag==0)
				{ 
					$this->insertOrderData($count[$i]); 
					$parent_flag = 1;
					$total_order++;
				}
				else if($count[$i][91]!='' && $parent_flag == 1 && $count[$i][0]=='')
				{
					$this->insertOrderItem($count[$i]);
				}
				else if($parent_flag==1)
				{
					try
					{
						$message = Mage::getModel('imports/createorder')->createOrder($this->order_info,$this->order_item_info,$store_id);
						Mage::getModel('imports/createorder')->removeOrderStatusHistory();
					} catch (Exception $e) {
						Mage::helper('imports')->logException($e,$this->order_info['increment_id'],'order',$line_number);
						Mage::helper('imports')->footer();
						$decline[] = $this->order_info['increment_id'];
						$message = 0;
					}
			  
				if($message== 1)
			    $success++;
				
				if($message== 2){
				  Mage::helper('imports')->logAvailable($this->order_info['increment_id'],'order',$line_number);
				  Mage::helper('imports')->footer();
				  $decline[] = $this->order_info['increment_id'];
				}
				
				$this->order_info = array();
			    $this->order_item_info = array();
			    $this->order_item_flag = 0;
				
			    $this->insertOrderData($count[$i]); 
			    $parent_flag = 1; 
				$line_number = $i+1;
				$total_order++;
			 }
			 
			}
			
			$i++;
			
			if($import_limit < $total_order)
			break;
		}
		$isPrintable = Mage::helper('imports')->isPrintable();
		if($success)
		Mage::getModel('core/session')->addSuccess(Mage::helper('imports')->__('Total '.$success.' order(s) imported successfully!'));
		  
		if($decline || $isPrintable)
		Mage::getModel('core/session')->addError(Mage::helper('imports')->__('Click <a href="'.Mage::helper("adminhtml")->getUrl("*/*/error").'">here</a> to view the error log. please give 777 permission file var/ds/log/error.htm then you can access error.' ));
		
		fclose($file_handle);
		//print_r($file_handle);
		//die("test");
		return array($success,$decline);
    }
   
	public function insertOrderData($orders_data)
	{
		$sales_order_arr = array();
		$sales_order_item_arr = array();
		//$sales_order = $this->getSalesTable();
		$sales_order = Mage::getModel('imports/table_saletable')->getsalestable();
		$sales_shipping = Mage::getModel('imports/table_billingtable')->getbillingtable();
		$sales_billing = Mage::getModel('imports/table_billingtable')->getbillingtable();
		//Mage::getModel('imports/table_saletable');
		$sales_payment = $this->getSalesPayment();
		//$sales_shipping = $this->getSalesBilling();
		//$sales_billing = $this->getSalesBilling();
		$sales_order_item = Mage::getModel('imports/table_saleitems')->getSaleitems();
		$model = Mage::getModel('sales/order');		
		$i = 0;
		$j = 0;
		$k = 0;
		$l = 0;
		$m = 0;
		foreach($orders_data as $order)
		{
		if(count($sales_order)>$i)
		$sales_order_arr[$sales_order[$i]]= $order;
		
		else if(count($sales_billing)>$j)
		{
			$sales_billing[$j].$sales_order_arr['billing_address'][$sales_billing[$j]]= $order;
			$j++;
		}
		else if(count($sales_shipping)>$k)
		{
			$sales_order_arr['shipping_address'][$sales_shipping[$k]]= $order;
			$k++;
		}
		else if(count($sales_payment)>$l)
		{
			$sales_order_arr['payment'][$sales_payment[$l]]= $order;
			$l++;
		} 
		else if(count($sales_order_item)>$m)
		{
			$sales_order_item_arr[$sales_order_item[$m]]= $order;
			$m++;
		}
		$i++;
		}
		
		$this->order_info = $sales_order_arr;
		$this->order_item_info[$this->order_item_flag] = $sales_order_item_arr;
		$this->order_item_flag++;
	}
   
	public function insertOrderItem($orders_data)
	{
		$sales_order_item_arr = array();
		//$sales_order_item = $this->getSalesItem();
		$sales_order_item = Mage::getModel('imports/table_saleitems')->getSaleitems();
		$i=0;
		for($j=91;$j<count($orders_data); $j++)
		{
			if(count($sales_order_item)>$i)
			$sales_order_item_arr[$sales_order_item[$i]]= $orders_data[$j];
			$i++;
		}
		$this->order_item_info[$this->order_item_flag] = $sales_order_item_arr;
		$this->order_item_flag++;	
	}
	public function getSalesPayment()
	{
		return array('method');
	}
	
   
   
  
}