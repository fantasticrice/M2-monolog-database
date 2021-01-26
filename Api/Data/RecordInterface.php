<?php

namespace Lfi\MonologDatabase\Api\Data;

use DateTimeInterface;

interface RecordInterface
{
    const ID = 'id';
    const CHANNEL = 'channel';
    const LEVEL = 'level';
    const LEVEL_NAME = 'level_name';
    const MESSAGE = 'message';
    const CONTEXT = 'context';
    const DATETIME = 'datetime';


    /**
     * @param string $channel
     * @return RecordInterface
     */
    public function setChannel(string $channel): RecordInterface;

    /**
     * @return string
     */
    public function getChannel(): string;

    /**
     * @param int $level
     * @return RecordInterface
     */
    public function setLevel(int $level): RecordInterface;

    /**
     * @return int
     */
    public function getLevel(): int;

    /**
     * @param string $name
     * @return RecordInterface
     */
    public function setLevelName(string $name): RecordInterface;

    /**
     * @return string
     */
    public function getLevelName(): string;

    /**
     * @param string $message
     * @return RecordInterface
     */
    public function setMessage(string $message): RecordInterface;

    /**
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * @param array $context
     * @return RecordInterface
     */
    public function setContext(array $context): RecordInterface;

    /**
     * @return array|null
     */
    public function getContext(): ?array;

    /**
     * @param DateTimeInterface $datetime
     * @return RecordInterface
     */
    public function setDatetime(DateTimeInterface $datetime): RecordInterface;

    /**
     * @return DateTimeInterface|null
     */
    public function getDatetime(): ?DateTimeInterface;
}
