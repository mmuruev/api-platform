<?php

namespace AppBundle\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use AppBundle\Types\PhoneNumberCryptType;
use Symfony\Component\HttpFoundation\Request;

final class ClientPhoneFilter extends SearchFilter
{
    /**
     * {@inheritdoc}
     */
    protected function extractProperties(Request $request): array
    {
        $encoder =  PhoneNumberCryptType::getEncryptor();
        $filter = $request->query->get('filter[phone]', []);
        return $filter;
    }

}
