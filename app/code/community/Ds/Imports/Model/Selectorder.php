<?php

class Ds_Imports_Model_Selectorder extends Ds_Imports_Model_Functional_Export
{
    const ENCLOSURE = '"';
    const DELIMITER = ',';

    public function selectOrders($orders)
    {
		$i = 0;
		$len = count($orders);
		//echo $len;
		foreach ($orders as $item) {
			if ($i == 0) {
				$startid = $item;
				} else if ($i == $len - 1) {
				$lastid = $item;
			}
			$i++;
		}
		if($lastid == 0 || $lastid == null || empty($lastid)){
			$lastid = $startid;
		}
		if($startid > $lastid){
			$lastid1 = $lastid;
			$lastid = $startid;
			$startid = $lastid1;
		}
		
        $fileName = 'orderexport_form_orderid_'.$startid.'_to_'.$lastid.'_date_'.date("Ymd_His").'.csv';
		//echo $fileName;
		//die("testing");
		$locatio = Mage::getBaseDir('var').'\ds\ordercsv';
        $fp = fopen($locatio .'/'.$fileName, 'w');
		//$fp = fopen(Mage::getBaseDir('export').'/'.$fileName, 'w');
        $this->writeHeadRow($fp);
        foreach ($orders as $order) {
        	$order = Mage::getModel('sales/order')->load($order);
            $this->writeOrder($order, $fp);
        }

        fclose($fp);

        return $fileName;
    }
	public function selectOrdersdownload($orders)
    {
		$i = 0;
		$len = count($orders);
		//echo $len;
		foreach ($orders as $item) {
			if ($i == 0) {
				$startid = $item;
				} else if ($i == $len - 1) {
				$lastid = $item;
			}
			$i++;
		}
		if($lastid == 0 || $lastid == null || empty($lastid)){
			$lastid = $startid;
		}
		if($startid > $lastid){
			$lastid1 = $lastid;
			$lastid = $startid;
			$startid = $lastid1;
		}
		
        $fileName = 'orderexport_form_orderid_'.$startid.'_to_'.$lastid.'_date_'.date("Ymd_His").'.csv';
		//echo $fileName;
		//die("testing");
		$locatio = Mage::getBaseDir('var').'\ds\ordercsv';
        //$fp = fopen($locatio .'/'.$fileName, 'w');
		$fp = fopen(Mage::getBaseDir('export').'/'.$fileName, 'w');
        $this->writeHeadRow($fp);
        foreach ($orders as $order) {
        	$order = Mage::getModel('sales/order')->load($order);
            $this->writeOrder($order, $fp);
        }

        fclose($fp);

        return $fileName;
    }

   
	public function writeHeadRow($fp)
    {
		$head = Mage::getModel('imports/table_csvhead')->getCSVHead();
        fputcsv($fp, $head , self::DELIMITER, self::ENCLOSURE);
    }

    
    public function writeOrder($order, $fp)
    {
		$common = Mage::getModel('imports/table_csvcontent')->getCSVvalue($order);
        //$common = $this->getCSVvalue($order);
        $blank = $this->getBlankOrderValues($order);
		$orderItems = $order->getItemsCollection();
        $itemInc = 0;
		$data = array();
		$count = 0;
        foreach ($orderItems as $item)
        {
            if($count==0)
			{
                $record = array_merge($common, $this->getOrderItemValues($item, $order, ++$itemInc));
                fputcsv($fp, $record, self::DELIMITER, self::ENCLOSURE);
			}
			else
			{
				$record = array_merge($blank, $this->getOrderItemValues($item, $order, ++$itemInc));
                fputcsv($fp, $record, self::DELIMITER, self::ENCLOSURE);
			}
			$count++;
        }
		
    }
	
   
	public function getBlankOrderValues($order)
    {
       return array(
            '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
            '','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',
			'','','','','','','','','','','','','','','','','','','','','','','','','');
    }

    //To return the array of ordered items
	public function getOrderItemValues($item, $order, $itemInc=1)
    {
		return array(
             $this->getItemSku($item),
             $this->formatText($item->getName()),
			 (int)$item->getQtyOrdered(),
             (int)$item->getQtyInvoiced(),
             (int)$item->getQtyShipped(),
             (int)$item->getQtyRefunded(),
             (int)$item->getQtyCanceled(),
             $item->getProductType(),
             $item->getOriginalPrice(),
             $item->getBaseOriginalPrice(),
             $item->getRowTotal(),
             $item->getBaseRowTotal(),
			 $item->getRowWeight(),
             $item->getPriceInclTax(),
             $item->getBasePriceInclTax(),
             $item->getTaxAmount(),
             $item->getBaseTaxAmount(),
             $item->getTaxPercent(),
             $item->getDiscountAmount(),
             $item->getBaseDiscountAmount(),
             $item->getDiscountPercent(),
			 $this->getChildInfo($item),
			 $item->getdata('product_options')
		);
    }
}