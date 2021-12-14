<?php

namespace Lfi\MonologDatabase\Model\Config\Backend;

use Magento\Cron\Model\Config\Source\Frequency;
use Magento\Framework\Exception\CouldNotSaveException;

class Schedule extends \Magento\Framework\App\Config\Value
{
    const JOB_NAME = 'lfi_monolog_database_clean';

    protected $configValueFactory;
    protected $modelPath;

    
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Config\ValueFactory $configValueFactory,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        $runModelPath = '',
        array $data = []
    ) {
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->configValueFactory = $configValueFactory;
        $this->modelPath = $runModelPath;
    }

    /**
     * {@inheritDoc}
     * @throws CouldNotSaveException
     */
    public function afterSave()
    {
        $time = $this->getData('groups/monolog_database/fields/time/value');
        $frequency = $this->getData('groups/monolog_database/fields/frequency/value');

        $cronExprArray = [
            (int)$time[1], // min
            (int)$time[0], // hour
            $frequency == Frequency::CRON_MONTHLY? '1' : '*', // day of month
            '*', // month of year
            $frequency == Frequency::CRON_WEEKLY? '1' : '*', // day of week
        ];

        $cronExprString = implode(' ', $cronExprArray);
        $cronExprPath = sprintf('crontab/default/jobs/%s/schedule/cron_expr', self::JOB_NAME);
        $cronModelPath = sprintf('crontab/default/jobs/%s/run/model', self::JOB_NAME);

        try {
            $this->configValueFactory->create()->load($cronExprPath, 'path')
                ->setValue($cronExprString)
                ->setPath($cronExprPath)
                ->save();
            $this->configValueFactory->create()->load($cronModelPath, 'path')
                ->setValue($this->modelPath)
                ->setPath($cronModelPath)
                ->save();
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Failed to save cron expression: %s', $e->getMessage()));
        }

        return parent::afterSave();
    }
}
