<?php
declare(strict_types=1);

namespace ReachDigital\AdminLinks\Model;

class AdminLink extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\ReachDigital\AdminLinks\Model\ResourceModel\AdminLink::class);
    }

    public function getUrl(): ?string {
        return $this->getData('url');
    }
    public function setUrl(string $url) {
        $this->setData('url', $url);
    }

    public function getReference(): ?string {
        return $this->getData('reference');
    }
    public function setReference(string $reference) {
        $this->setData('reference', $reference);
    }
}
