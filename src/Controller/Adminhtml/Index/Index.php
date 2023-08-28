<?php
declare(strict_types=1);
namespace ReachDigital\AdminLinks\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RawFactory;
use ReachDigital\AdminLinks\Model\AdminLinkManager;

class Index implements HttpPostActionInterface
{

    /**
     * @var RawFactory
     */
    private $rawResultFactory;

    /**
     * @var AdminLinkManager
     */
    private $adminLinkManager;

    /**
     * @var RequestInterface
     */
    private $request;
    public function __construct(RawFactory $rawResultFactory, AdminLinkManager $adminLinkManager, RequestInterface $request)
    {
        $this->rawResultFactory = $rawResultFactory;
        $this->adminLinkManager = $adminLinkManager;
        $this->request = $request;
    }

    /**
     * custom action handler
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $url = $this->request->getParam('url');
        $adminLink = $this->adminLinkManager->getAdminLinkForUrl($url);
        return $this->rawResultFactory->create()->setContents($adminLink->getReference());
    }
}
