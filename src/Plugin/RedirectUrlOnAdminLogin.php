<?php
declare(strict_types=1);

namespace ReachDigital\AdminUrls\Plugin;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\RequestInterface;
class RedirectUrlOnAdminLogin {

    /**
     * @var RequestInterface
     */
    private $request;
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function afterGetStartupPageUrl(UrlInterface $url, $result) {
        $redirectUrl = $this->request->getParam('redirect-url');
        if ($redirectUrl) {
            return 'adminhtml/' . $redirectUrl;
        }
        return $result;
    }
}

