<?php

namespace Draw\Bundle\SonataExtraBundle\Doctrine\DBALTypes;

use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class UtcDateTimeType extends DateTimeType
{
    use UtcPhpDateTimeMappingTypeTrait;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof DateTimeInterface) {
            $value = clone $value;
            $value = $value->setTimezone(new DateTimeZone('UTC'));
        }

        return parent::convertToDatabaseValue($value, $platform);
    }
}