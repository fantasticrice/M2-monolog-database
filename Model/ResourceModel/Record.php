<?php

namespace Rice\MonologDatabase\Model\ResourceModel;

use Rice\MonologDatabase\Api\Data\RecordInterface;

class Record extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const TABLE_NAME = 'monolog';


    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, RecordInterface::ID);
    }
}
