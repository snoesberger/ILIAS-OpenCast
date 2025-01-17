<?php

declare(strict_types=1);

namespace srag\Plugins\Opencast\Model\Event;

use srag\Plugins\Opencast\Model\ACL\ACLParser;
use srag\Plugins\Opencast\Model\Metadata\Helper\MDParser;
use srag\Plugins\Opencast\Model\Scheduling\SchedulingParser;
use stdClass;

class EventParser
{
    private MDParser $MDParser;
    private ACLParser $ACLParser;
    private SchedulingParser $schedulingParser;

    public function __construct(MDParser $MDParser, ACLParser $ACLParser, SchedulingParser $schedulingParser)
    {
        $this->MDParser = $MDParser;
        $this->ACLParser = $ACLParser;
        $this->schedulingParser = $schedulingParser;
    }

    public function parseAPIResponse(stdClass $data, string $identifier): Event
    {
        $event = new Event();
        $event->setPublicationStatus($data->publication_status);
        $event->setProcessingState($data->processing_state);
        $event->setStatus($data->status);
        $event->setHasPreviews($data->has_previews);
        $event->setXoctEventAdditions(EventAdditionsAR::findOrGetInstance($identifier));

        if (isset($data->metadata)) {
            $event->setMetadata($this->MDParser->getMetadataFromResponse($data->metadata));
        } else {
            $event->setMetadata($this->MDParser->getMetadataFromData($data));
        }

        if (isset($data->acl)) {
            $event->setAcl($this->ACLParser->parseAPIResponse($data->acl));
        }

        if (isset($data->publications)) {
            // todo: publications should have a parser as well
            $event->publications()->loadFromArray($data->publications);
        }

        if ($event->isScheduled() && isset($data->scheduling)) {
            $event->setScheduling($this->schedulingParser->parseApiResponse($data->scheduling));
        }
        return $event;
    }
}
