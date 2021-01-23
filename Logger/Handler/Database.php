<?php

namespace Lfi\Email\Logger\Handler;

use Monolog\Logger;

class Database extends \Monolog\Handler\AbstractProcessingHandler
{
    protected $resource;
    protected $factory;


    public function __construct(
        \Lfi\Email\Model\ResourceModel\Record $recordResource,
        \Lfi\Email\Model\RecordFactory $recordFactory,
        $level = Logger::DEBUG,
        $bubble = true
    ) {
        parent::__construct($level, $bubble);
        $this->resource = $recordResource;
        $this->factory = $recordFactory;
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        $model = $this->factory->create()
            ->setChannel($record['channel'])
            ->setLevel($record['level'])
            ->setLevelName($record['level_name'])
            ->setMessage($record['message'])
            ->setContext($record['context'])
            ->setDatetime($record['datetime']);

        $this->resource->save($model);
    }
}
