<?php
declare(strict_types=1);

namespace ReachDigital\AdminLinks\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\UrlInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\App\AreaList;
use Magento\Framework\App\Route\ConfigInterface;

/**
 *
 */
class ToolbarEntry extends Template
{

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var AreaList
     */
    private $areaList;

    /**
     * @var ConfigInterface
     */
    private $routeConfig;
    public function __construct(
        Template\Context $context,
        UrlInterface $url,
        AreaList $areaList,
        ConfigInterface $routeConfig,
        array $data = [],
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    ) {
        $this->url = $url;
        $this->areaList = $areaList;
        $this->routeConfig = $routeConfig;
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
    }

    public function getRedirectUrl() {
        $currentUrl = $this->url->getCurrentUrl();
        $baseUrl = $this->getLoginUrl() . '/';
        $redirectUrl = \str_replace($baseUrl, '', $currentUrl);
        $keyPos = \strpos($redirectUrl, '/key/');
        if ($keyPos) {
            for ($keyEndPos = $keyPos + 5; $keyEndPos < \strlen($redirectUrl) && ctype_alnum($redirectUrl[$keyEndPos]); $keyEndPos++) {
            }
            $redirectUrl = \substr($redirectUrl, 0, $keyPos) . \substr($redirectUrl, $keyEndPos);
        }
        $routeParts = explode("/", $redirectUrl);
        if (isset($routeParts[0])) {
            $route = $this->routeConfig->getRouteByFrontName($routeParts[0]);
            $routeParts[0] = $route;
            $redirectUrl = \implode('/', $routeParts);
        }
        return $redirectUrl;
    }

    public function getLoginUrl(): string {
        return $this->url->getBaseUrl() . $this->areaList->getFrontName('adminhtml');
    }

    public function getAdminLinkUrl() {
        return $this->url->getUrl('admin_links/index');
    }
}
