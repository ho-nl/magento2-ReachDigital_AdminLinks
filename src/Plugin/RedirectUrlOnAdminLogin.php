<?php
declare(strict_types=1);

namespace ReachDigital\AdminLinks\Plugin;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Escaper;

class RedirectUrlOnAdminLogin {

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Escaper
     */
    private $escaper;
    public function __construct(RequestInterface $request, Escaper $escaper)
    {
        $this->request = $request;
        $this->escaper = $escaper;
    }

    public function afterGetStartupPageUrl(UrlInterface $url, $result) {
        $redirectUrl = $this->request->getParam('redirect-url');
        if ($redirectUrl) {
            return $this->escaper->escapeUrl('adminhtml/' . $redirectUrl);
        }
        return $result;
    }
}

