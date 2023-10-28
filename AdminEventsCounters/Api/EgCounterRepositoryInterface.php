<?php
declare(strict_types=1);

namespace EGSolution\AdminEventsCounters\Api;
use EGSolution\AdminEventsCounters\Api\Data\EgCounterInterface;

interface EgCounterRepositoryInterface
{

    public function save(EgCounterInterface $egCounter);

    public function getById($egCounterId);

    public function delete(EgCounterInterface $egCounter);

    public function deleteById($egCounterId);
}

