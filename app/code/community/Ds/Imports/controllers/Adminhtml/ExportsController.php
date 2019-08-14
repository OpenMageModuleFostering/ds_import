<?php

class Ds_Imports_Adminhtml_ExportsController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
		$enble =  Mage::helper('imports')->getStoreVar();
		if($enble ==  1){
			$this->_title($this->__('Orders export'));
			$this->loadLayout();
			$this->_setActiveMenu('sales/sales');
			$this->_addContent($this->getLayout()->createBlock('imports/adminhtml_sales_order_grid'));	
			$this->renderLayout();
		}else{
			
			$message = $this->__('Please Enble extension System->Configuration->Ds order export/import->enble. Please <a href="'.Mage::helper("adminhtml")->getUrl("*/system_config").'">here</a>');
			//echo '<h1>' . $message . '</h1>';
			Mage::getSingleton('core/session')->addError($message);
			$this->_redirect('*/sales_order');
		}
    }
	public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('imports/adminhtml_sales_order_grid')->toHtml()
        );
    }
	
	
 	public function selectorderAction()
    {
		$orders = $this->getRequest()->getPost('order_ids', array());
		$file = Mage::getModel('imports/selectorder')->selectOrders($orders);	   
		$file1 = Mage::getModel('imports/selectorder')->selectOrdersdownload($orders);	   
		$this->_prepareDownloadResponse($file1, file_get_contents(Mage::getBaseDir('export').'/'.$file1));
		$message = $this->__('Successfully CSV Export in "var/ds/ordercsv" directory.');
		Mage::getSingleton('core/session')->addSuccess($message);
		//$this->_redirect('*/exports');
    }
	
	public function exportallorderAction()
	{
		$orders = Mage::getModel('sales/order')->getCollection()->addAttributeToSelect('entity_id');
		$order_arr = array();
		foreach ($orders as $order)  {
				$order_arr[] = $order->getId();
		}
		$file = Mage::getModel('imports/allorder')->selectOrders($order_arr);
		$file1 = Mage::getModel('imports/selectorder')->selectOrdersdownload($order_arr);	   
		$this->_prepareDownloadResponse($file1, file_get_contents(Mage::getBaseDir('export').'/'.$file1));
		$message = $this->__('Successfully CSV Export in "var/ds/ordercsv" directory.');
		Mage::getSingleton('core/session')->addSuccess($message);
		//$this->_redirect('*/exports');
	}

	
	
}