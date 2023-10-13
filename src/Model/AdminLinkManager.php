<?php
declare(strict_types=1);

namespace ReachDigital\AdminLinks\Model;

use Magento\Backend\Setup\ConfigOptionsList as BackendConfigOptionsList;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use ReachDigital\AdminLinks\Model\ResourceModel\AdminLink\CollectionFactory;
use Magento\Framework\Math\Random;
use Magento\Framework\App\DeploymentConfig;
use Magento\Store\Model\StoreManagerInterface;

class AdminLinkManager
{

    /**
     * @var Factory
     */
    private $adminLinkCollectionFactory;

    /**
     * @var Random
     */
    private $mathRandom;

    /**
     * @var AdminLinkFactory
     */
    private $adminLinkFactory;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var DeploymentConfig
     */
    private $deploymentConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        CollectionFactory $adminLinkCollectionFactory,
        Random $mathRandom,
        AdminLinkFactory $adminLinkFactory,
        Escaper $escaper,
        UrlInterface $url,
        DeploymentConfig $deploymentConfig,
        StoreManagerInterface $storeManager,
    ) {
        $this->adminLinkCollectionFactory = $adminLinkCollectionFactory;
        $this->mathRandom                 = $mathRandom;
        $this->adminLinkFactory           = $adminLinkFactory;
        $this->escaper                    = $escaper;
        $this->url = $url;
        $this->deploymentConfig = $deploymentConfig;
        $this->storeManager = $storeManager;
    }

    public function getAdminLinkByReference(string $reference): ?AdminLink
    {
        $adminLinkCollection = $this->adminLinkCollectionFactory->create();
        $adminLinkCollection->addFilter('reference', $reference);
        $result = $adminLinkCollection->getFirstItem();
        if ($result && $result->getUrl()) {
            return $result;
        }
        return null;
    }

    public function getAdminLinkForUrl(string $url): AdminLink
    {
        $url                 = $this->escaper->escapeUrl($url);
        $adminLinkCollection = $this->adminLinkCollectionFactory->create();
        $adminLinkCollection->addFilter('url', $url);
        $adminLink = $adminLinkCollection->getFirstItem();
        if ($adminLink && $adminLink->getId()) {
            return $adminLink;
        }
        $reference = $this->generateUniqueReference();
        $adminLink = $this->adminLinkFactory->create();
        $adminLink->setUrl($url);
        $adminLink->setReference($reference);
        return $adminLink->save();
    }

    public function getRedirectUrl(AdminLink $adminLink): string
    {
        return $this->url->getBaseUrl(['_scope' => $this->storeManager->getDefaultStoreView()]) . $this->deploymentConfig->get(BackendConfigOptionsList::CONFIG_PATH_BACKEND_FRONTNAME) . '?al=' . $adminLink->getReference();
    }

    private function generateUniqueReference(): string
    {
        $reference = $this->mathRandom->getRandomString(50);
        while ($this->getAdminLinkByReference($reference)) {
            // In the unlikely event that the randomly generated reference matches a previously generated reference, get a new random string.
            $reference = $this->mathRandom->getRandomString(50);
        }
        return $reference;
    }
}
