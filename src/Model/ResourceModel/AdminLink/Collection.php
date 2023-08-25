<?php
declare(strict_types=1);
namespace ReachDigital\AdminLinks\Model\ResourceModel\AdminLink;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'ReachDigital\AdminLinks\Model\AdminLink',
            'ReachDigital\AdminLinks\Model\ResourceModel\AdminLink'
        );
    }

}
