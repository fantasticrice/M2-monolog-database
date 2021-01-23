<?php

namespace Rice\MonologDatabase\Api\Data;

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
     * @return $this
     */
    public function setChannel(string $channel);

    /**
     * @return string
     */
    public function getChannel(): string;

    /**
     * @param int $level
     * @return $this
     */
    public function setLevel(int $level);

    /**
     * @return int
     */
    public function getLevel(): int;

    /**
     * @param string $name
     * @return $this
     */
    public function setLevelName(string $name);

    /**
     * @return string
     */
    public function getLevelName(): string;

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message);

    /**
     * @return string
     */
    public function getMessage(): ?string;

    /**
     * @param array $context
     * @return $this
     */
    public function setContext(array $context);

    /**
     * @return array
     */
    public function getContext(): ?array;

    /**
     * @param DateTimeInterface $datetime
     * @return $this
     */
    public function setDatetime(DateTimeInterface $datetime);

    /**
     * @return DateTimeInterface
     */
    public function getDatetime(): DateTimeInterface;
}
