<?php

namespace AppBundle\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use JaegerApp\Encrypt;
use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;

/**
 * Class PhoneNumberCryptType - provide low level crypt for phone number
 * @package AppBundle\Types
 */
class PhoneNumberCryptType extends PhoneNumberType
{
    /**
     *  Key for encrypt phone number
     */
    const PHONE_ENCRYPTION_KEY = 'secret';

    /**
     * Phone number type name.
     */
    const NAME = 'phone_number_crypt';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return static::getEncryptor()->encode(parent::convertToDatabaseValue($value, $platform));
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $decodedValue = static::getEncryptor()->decode($value);
        return $decodedValue ? parent::convertToPHPValue($decodedValue, $platform) : parent::convertToPHPValue($value, $platform);
    }

    /**
     *
     * @return Encrypt
     */
    public static function getEncryptor()
    {
        $encryptor = new Encrypt();
        $encryptor->setKey(static::PHONE_ENCRYPTION_KEY);
        return $encryptor;
    }
}
