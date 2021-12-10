<?php

namespace Lfi\MonologDatabase\Cron;

use Lfi\MonologDatabase\Api\Data\RecordInterface;
use Lfi\MonologDatabase\Model\ResourceModel\Record;

class Clean
{
    const JOB_CODE = 'lfi_monolog_database_clean';

    protected $resource;


    public function __construct(Record $resource)
    {
        $this->resource = $resource;
    }

    protected function getThreshold($lifetime)
    {
        $dt = new \DateTime();
        $offset = new \DateInterval($lifetime);
        $dt->sub($offset);
        return $dt->format('Y-m-d H:i:s');
    }

    public function execute(): void
    {
        $threshold = 0;

        $conn = $this->resource->getConnection();
        $conn->delete(
            $this->resource->getMainTable(),
            $conn->quoteInto(RecordInterface::DATETIME . ' < ?', $threshold)
        );
    }
}
