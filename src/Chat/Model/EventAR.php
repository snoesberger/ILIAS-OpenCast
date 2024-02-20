<?php

declare(strict_types=1);

namespace srag\Plugins\Opencast\Chat\Model;

use ActiveRecord;

/**
 * Class EventAR
 * @package srag\Plugins\Opencast\Chat
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class EventAR extends ActiveRecord
{
    public const TABLE_NAME = 'sr_chat_event';

    public const EVENT_ID_USER_JOINED = 1;
    public const EVENT_ID_USER_LEFT = 2;

    public function getConnectorContainerName(): string
    {
        return self::TABLE_NAME;
    }

    /**
     * @var string
     *
     * @con_has_field    true
     * @con_fieldtype    text
     * @con_length       56
     * @con_is_primary   true
     */
    protected $id;

    /**
     * @var int
     *
     * @db_is_notnull       true
     * @db_has_field        true
     * @db_fieldtype        integer
     * @db_length           8
     */
    protected $chat_room_id;

    /**
     * @var int
     *
     * @db_has_field        true
     * @db_fieldtype        integer
     * @db_length           8
     */
    protected $subject_id;

    /**
     * @var int
     *
     * @db_has_field        true
     * @db_is_notnull       true
     * @db_fieldtype        integer
     * @db_length           8
     */
    protected $event_type_id;

    /**
     * @var string
     *
     * @db_has_field        true
     * @db_is_notnull       true
     * @db_fieldtype        timestamp
     */
    protected $sent_at;

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getChatRoomId(): int
    {
        return (int) $this->chat_room_id;
    }

    public function setChatRoomId(int $chat_room_id): void
    {
        $this->chat_room_id = $chat_room_id;
    }

    public function getSubjectId(): int
    {
        return (int) $this->subject_id;
    }

    public function setSubjectId(int $subject_id): void
    {
        $this->subject_id = $subject_id;
    }

    public function getEventTypeId(): int
    {
        return (int) $this->event_type_id;
    }

    public function setEventTypeId(int $event_type_id): void
    {
        $this->event_type_id = $event_type_id;
    }

    public function getSentAt(): string
    {
        return $this->sent_at;
    }

    public function setSentAt(string $sent_at): void
    {
        $this->sent_at = $sent_at;
    }
}
