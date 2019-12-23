<?php
namespace Emizentech\Captcha\Observer;
class Checkreviewpostobserver implements \Magento\Framework\Event\ObserverInterface
{
  /**
     * @var \Magento\Captcha\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $_actionFlag;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;

    /**
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlManager;

    /**
     * @var CaptchaStringResolver
     */
    protected $captchaStringResolver;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;

     /**
     * Generic session
     *
     * @var \Magento\Framework\Session\Generic
     */
    protected $reviewSession;


    /**
     * @param \Magento\Captcha\Helper\Data $helper
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\Session\SessionManagerInterface $session
     * @param \Magento\Framework\UrlInterface $urlManager
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param CaptchaStringResolver $captchaStringResolver
     * @param \Magento\Framework\Session\Generic $reviewSession
     */
    public function __construct(
        \Magento\Captcha\Helper\Data $helper,
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Magento\Framework\UrlInterface $urlManager,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Captcha\Observer\CaptchaStringResolver $captchaStringResolver,
        \Magento\Framework\Session\Generic $reviewSession
    ) {
        $this->_helper 				= $helper;
        $this->_actionFlag 			= $actionFlag;
        $this->messageManager 		= $messageManager;
        $this->_session 			= $session;
        $this->_urlManager 			= $urlManager;
        $this->redirect 			= $redirect;
        $this->reviewSession 		= $reviewSession;
        $this->captchaStringResolver= $captchaStringResolver;
    }

    /**
     * Check Captcha On User Login Page
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $formId = 'review_form';
        $captchaModel = $this->_helper->getCaptcha($formId);
        if ($captchaModel->isRequired()) {
            /** @var \Magento\Framework\App\Action\Action $controller */
            $controller = $observer->getControllerAction();
            if (!$captchaModel->isCorrect($this->captchaStringResolver->resolve($controller->getRequest(), $formId))) {
                $this->messageManager->addError(__('Incorrect CAPTCHA'));
                $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
                $data = $this->reviewSession->getFormData(true);
                if (!$data) {
		            $data 	= $controller->getRequest()->getPostValue();
		        }
                $this->reviewSession->setFormData($data);
                $controller->getResponse()->setRedirect($this->redirect->getRefererUrl());
            }
        }
        return $this;
    }
}