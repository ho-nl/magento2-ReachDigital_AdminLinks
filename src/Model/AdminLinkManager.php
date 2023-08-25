<?php
declare(strict_types=1);

namespace ReachDigital\AdminLinks\Model;

use Magento\Framework\Escaper;
use ReachDigital\AdminLinks\Model\ResourceModel\AdminLink\CollectionFactory;
use Magento\Framework\Math\Random;

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

    public function __construct(
        CollectionFactory $adminLinkCollectionFactory,
        Random $mathRandom,
        AdminLinkFactory $adminLinkFactory,
        Escaper $escaper
    ) {
        $this->adminLinkCollectionFactory = $adminLinkCollectionFactory;
        $this->mathRandom                 = $mathRandom;
        $this->adminLinkFactory           = $adminLinkFactory;
        $this->escaper                    = $escaper;
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
