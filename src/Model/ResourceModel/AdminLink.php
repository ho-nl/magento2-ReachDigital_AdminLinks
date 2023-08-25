<?php
declare(strict_types=1);
namespace ReachDigital\AdminLinks\Model\ResourceModel;

class AdminLink extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Initialize connection and define main table
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('reachdigital_admin_links', 'link_id');
    }

    /**
     * @return \Magento\Framework\DB\Select
     */
    public function getSelect()
    {
        $columns = [
            'link_id' => 'link_id',
            'reference' => 'reference',
            'url' => 'url',
        ];
        $select = $this->getConnection()
            ->select()
            ->from('reachdigital_admin_links', $columns);
        return $select;
    }

}
