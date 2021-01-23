<?php

namespace Rice\MonologDatabase\Model;

use DateTimeInterface;
use DateTimeImmutable;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Lfi\Email\Api\Data\RecordInterface;

/**
 * @method setId(int $id)
 * @method getId(): int
 */
class Record extends AbstractModel implements IdentityInterface, RecordInterface
{
    public function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\Record::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentities()
    {
        return [ResourceModel\Record::TABLE_NAME . '_' . $this->getId()];
    }

    /**
     * {@inheritDoc}
     */
    public function setChannel(string $channel)
    {
        return $this->setData(self::CHANNEL, $channel);
    }

    /**
     * {@inheritDoc}
     */
    public function getChannel(): string
    {
        return $this->getData(self::CHANNEL)?? 'undefined';
    }

    /**
     * {@inheritDoc}
     */
    public function setLevel(int $level)
    {
        return $this->setData(self::LEVEL, $level);
    }

    /**
     * {@inheritDoc}
     */
    public function getLevel(): int
    {
        return $this->getData(self::LEVEL)?? 0;
    }

    /**
     * {@inheritDoc}
     */
    public function setLevelName(string $name)
    {
        return $this->setData(self::LEVEL_NAME, $name);
    }

    /**
     * {@inheritDoc}
     */
    public function getLevelName(): string
    {
        return $this->getData(self::LEVEL_NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setMessage(string $message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * {@inheritDoc}
     */
    public function getMessage(): ?string
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * {@inheritDoc}
     */
    public function setContext(array $context)
    {
        $encoded = json_encode($context);
        return $this->setData(self::CONTEXT, $encoded);
    }

    /**
     * {@inheritDoc}
     */
    public function getContext(): ?array
    {
        $context = $this->getData(self::CONTEXT);
        $decoded = json_decode($context, true);
        return $decoded;
    }

    /**
     * {@inheritDoc}
     */
    public function setDatetime(DateTimeInterface $datetime)
    {
        $formatted = $datetime->format('Y-m-d H:i:s');
        return $this->setData(self::DATETIME, $formatted);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatetime(): DateTimeInterface
    {
        $value = $this->getData(self::DATETIME);
        $datetime = new DateTimeImmutable($value);
        return $datetime;
    }
}
