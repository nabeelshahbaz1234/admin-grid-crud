<?php

namespace EGSolution\AdminEventsCounters\Api\Data;

interface EventInterface
{
    public function getEventId();

    public function setEventId($eventId);

    public function getEntityId();

    public function setEntityId($entityId);

    public function getEventName();

    public function setEventName($eventName);

    public function getEventStartDate();

    public function setEventStartDate($startDate);

    public function getEventEndDate();

    public function setEventEndDate($endDate);

    public function getStartTime();

    public function setStartTime($startTime);

    public function getEndTime();

    public function setEndTime($endTime);

    public function getEventStatus();

    public function setEventStatus($eventStatus);

    public function getEventTitle();

    public function setEventTitle($eventTitle);

    public function getEventImage();

    public function setEventImage($eventImage);

    public function getCmsBlock();

    public function setCmsBlock($cmsBlock);

    public function getEventDescription();

    public function setEventDescription($eventDescription);

    public function getStoreView();

    public function setStoreView($storeView);

    public function getUrlKey();

    public function setUrlKey($urlKey);

    public function getMetaTitle();

    public function setMetaTitle($metaTitle);

    public function getMetaKeywords();

    public function setMetaKeywords($metaKeywords);

    public function getMetaDescription();

    public function setMetaDescription($metaDescription);

    public function getCreatedAt();

    public function getUpdatedAt();
}
