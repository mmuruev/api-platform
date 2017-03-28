<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Validator\Constraints as Assert;

use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

/**
 * This is client Entity
 *
 * @ApiResource(attributes={"filters"={"client.search","client.phone"}})
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Client
{
    /**
     *  Amount symbols from right side to show unmasked
     */
    const UNMASKED_SYMBOLS_IN_PHONE = 4;

    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var PhoneNumber phone
     * @ORM\Column(type="phone_number_crypt")
     * @Assert\NotBlank
     * @AssertPhoneNumber(defaultRegion="GB")
     */
    private $phone = null;

    /**
     * @var string client email
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9_.+-]+@([a-z0-9]+([\-\.]{1}[a-z0-9\-]+)*\.[a-z\d\-]{1,10}(:[0-9]{1,5})?(\/.*‌​)?)$/",
     *     match=true,
     *     message="Invalid email"
     * )
     */
    private $email = '';

    /**
     * @ORM\Column(type="json_document", options={"jsonb": true})
     * @var mixed
     */
    private $data = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string - masked phone number
     */
    public function getPhone(): string
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $this->getFullPhone();
        $formattedPhone = $phoneNumberUtil->format($phone, PhoneNumberFormat::NATIONAL);
        return str_pad(substr($formattedPhone, -static::UNMASKED_SYMBOLS_IN_PHONE), mb_strlen($formattedPhone, mb_detect_encoding($formattedPhone)) - static::UNMASKED_SYMBOLS_IN_PHONE, '*', STR_PAD_LEFT);
    }

    /**
     * @return PhoneNumber
     */
    protected function getFullPhone(): PhoneNumber
    {
        return $this->phone;
    }

    /**
     * @param $phone
     */
    public function setPhone(PhoneNumber $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }


    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return $this->data[$property];
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
            return;
        }

        $this->data[$property] = $value;
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */

//    /**
//     * @param $name
//     * @param $args
//     * @return mixed|null
//     */
//    public function __call($name, $args)
//    {
//        var_dump($name, $args);
//        $property = lcfirst(substr($name, 3));
//        if ('get' === substr($name, 0, 3)) {
//            return isset($this->data[$property])
//                ? $this->data[$property]
//                : null;
//        } elseif ('set' === substr($name, 0, 3)) {
//            $value = 1 == count($args) ? $args[0] : null;
//            $this->data[$property] = $value;
//        }
//    }
//    /**
//     * @PostPersist
//     */
//    public function doPostPersist()
//    {
//        $encodedPhone = $this->encrypt->decode($this->phone);
//        var_dump($encodedPhone);
//        $this->phone = PhoneNumberUtil::getInstance()->parse($encodedPhone, 'GB');
//    }
//
//    /**
//     * @PrePersist
//     */
//    public function doStuffOnPrePersist()
//    {
//        var_dump($this);
//    }
//
//
//    /** @PostLoad */
//    public function doStuffOnPostLoad()
//    {
//        $encodedPhone = $this->encrypt->decode($this->phone);
//        var_dump($encodedPhone);
//        $this->phone = PhoneNumberUtil::getInstance()->parse($encodedPhone, 'GB');
//    }
//
//    /** @PreUpdate */
//    public function doStuffOnPreUpdate()
//    {
//        $this->value = 'changed from preUpdate callback!';
//    }

}
