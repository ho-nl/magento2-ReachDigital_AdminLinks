<?php
declare(strict_types=1);

namespace ReachDigital\AdminLinks\Plugin;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\RequestInterface;
use ReachDigital\AdminLinks\Model\AdminLinkManager;

class RedirectUrlOnAdminLogin {

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var AdminLinkManager
     */
    private $adminLinkManager;
    public function __construct(RequestInterface $request, AdminLinkManager $adminLinkManager)
    {
        $this->request = $request;
        $this->adminLinkManager = $adminLinkManager;
    }

    public function afterGetStartupPageUrl(UrlInterface $url, $result) {
        $adminLinkReference = $this->request->getParam('al');
        if (!$adminLinkReference) {
            return $result;
        }
        $adminLink = $this->adminLinkManager->getAdminLinkByReference($adminLinkReference);
        if (!$adminLink) {
            return $result;
        }
        return $adminLink->getUrl();
    }
}

