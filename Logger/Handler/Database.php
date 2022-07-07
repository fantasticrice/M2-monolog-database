<?php

namespace Lfi\MonologDatabase\Logger\Handler;

use Monolog\Logger;

class Database extends \Monolog\Handler\AbstractProcessingHandler
{
    protected $resource;
    protected $factory;


    public function __construct(
        \Lfi\MonologDatabase\Model\ResourceModel\Record $recordResource,
        \Lfi\MonologDatabase\Model\RecordFactory $recordFactory,
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
    protected function write(array $record): void
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
