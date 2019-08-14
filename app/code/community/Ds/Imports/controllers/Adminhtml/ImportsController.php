<?php

class Ds_Imports_Adminhtml_ImportsController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
	{
		$this->loadLayout()
			->_setActiveMenu('imports/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Orders Import'), Mage::helper('adminhtml')->__('Orders Import'));
		
		return $this;
	}
 
	public function indexAction()
    {
		$enble =  Mage::helper('imports')->getStoreVar();
		if($enble ==  1){
			$this->_title($this->__('Orders Import'));
			$this->loadLayout();
			$this->_setActiveMenu('sales/sales');
			$this->_addContent($this->getLayout()->createBlock('imports/adminhtml_sales_order_Form'));
			$this->renderLayout();
		}else{
			
			$message = $this->__('Please Enble extension System->Configuration->Ds order export/import->enble. Please <a href="'.Mage::helper("adminhtml")->getUrl("*/system_config").'">here</a>');
			Mage::getSingleton('core/session')->addError($message);
			$this->_redirect('*/sales_order');
		}	
    }
	
	public function importallOrdersAction() 
	{
		if($_FILES['order_csv']['name'] != '') {
		    $data = $this->getRequest()->getPost();
			try {
				$uploader = new Varien_File_Uploader('order_csv');
				$uploader->setAllowedExtensions(array('csv'));
				$uploader->setAllowRenameFiles(false);
				$uploader->setFilesDispersion(false);
				$path = Mage::getBaseDir('media') . DS.'ds/ordercsvimport/';
				$uploader->save($path, $_FILES['order_csv']['name'] );
				$csv = Mage::getModel('imports/importallorders')->readCSV($path.$_FILES['order_csv']['name'],$data);
				
			} catch (Exception $e) {
				Mage::getModel('core/session')->addError(Mage::helper('imports')->__('Invalid file type!!'));
			}
			$this->_redirect('*/*/');
		}
		else {
		   Mage::getSingleton('adminhtml/session')->addError(Mage::helper('imports')->__('Unable to find the import file'));
           $this->_redirect('*/*/');
		}
	}
	public function errorAction()
	{
		$this->_title($this->__('Error'));
        $this->loadLayout();		
		$file = 'error.htm';
		$this->_prepareDownloadResponse($file, file_get_contents(Mage::getBaseDir('var') .'/ds/log/'.$file));
	} 
}