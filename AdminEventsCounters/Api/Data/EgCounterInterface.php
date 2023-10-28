<?php
declare(strict_types=1);


namespace EGSolution\AdminEventsCounters\Api\Data;

interface EgCounterInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getDescription();

    public function setDescription($description);

    public function getStoreView();

    public function setStoreView($storeView);

    public function getStatus();

    public function setStatus($status);

    public function getLatitude();

    public function setLatitude($latitude);

    public function getLongitude();

    public function setLongitude($longitude);

    public function getCreatedAt();

    public function getUpdatedAt();
}

