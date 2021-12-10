<?php

namespace Lfi\MonologDatabase\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Lfi\MonologDatabase\Api\Data\RecordInterface;
use Lfi\MonologDatabase\Model\ResourceModel\Record;

class Clean
{
    protected $config;
    protected $resource;


    public function __construct(ScopeConfigInterface $config, Record $resource)
    {
        $this->config = $config;
        $this->resource = $resource;
    }

    /**
     * Get the record lifetime threshold based on the number of days.
     * @param int $days
     * @return string
     */
    protected function getThreshold(int $days): string
    {
        $dt = new \DateTime();
        $offset = new \DateInterval("P{$days}D");
        $dt->sub($offset);
        return $dt->format('Y-m-d H:i:s');
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException from \Magento\Framework\Model\ResourceModel\Db\AbstractDb::getMainTable
     */
    public function execute(): void
    {
        $lifetime = (int) $this->config->getValue('system/monolog_database/lifetime');
        $conn = $this->resource->getConnection();
        $conn->delete(
            $this->resource->getMainTable(),
            $conn->quoteInto(RecordInterface::DATETIME . ' < ?', $this->getThreshold($lifetime))
        );
    }
}
