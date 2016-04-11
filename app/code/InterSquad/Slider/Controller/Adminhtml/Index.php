<?php
namespace InterSquad\Slider\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->layoutFactory = $layoutFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }


    /**
     * Index action
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        var_dump('fap');die('quay');
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('InterSquad::slider');
        $resultPage->addBreadcrumb(__('Sliders'), __('Sliders'));
        $resultPage->addBreadcrumb(__('Manage Sliders'), __('Manage Sliders'));
        $resultPage->getConfig()->getTitle()->prepend(__('Sliders'));

        return $resultPage;
    }

    /**
     * Is the user allowed to view the blog post grid.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        var_dump($this->_authorization->isAllowed('InterSquad::slider'));die('xxxx');
        return $this->_authorization->isAllowed('InterSquad::slider');
    }


}