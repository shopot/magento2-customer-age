<?php


namespace Simplelab\Customerattrage\Plugin;


use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\RequestInterface;

class AgeVerification extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    private $resultFactory;
    private $_messageManager;
    private $getRequest;

    public function __construct(
        ResultFactory $Redirect,
        ManagerInterface $messageManager,
        RequestInterface $request
    )
    {
        $this->resultFactory = $Redirect;
        $this->_messageManager = $messageManager;
        $this->getRequest = $request;
    }

    public function beforeExecute(\Magento\Customer\Controller\Account\CreatePost $subject)
    {
        $age = $this->getRequest->getParam('age');

        if ($age < 21) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $this->_messageManager->addError('You must be 21 years old or over.');
            $resultRedirect->setPath('customer/account/');
            $this->getRequest->setParam('age', '');
            return $resultRedirect;
        } else {
            return true;
        }

    }
}