<?php

namespace Barronhsu15\IP;

class IPv4 extends IP
{
    /**
     * @var int Binary
     */
    const TO_BASE = 2;

    /**
     * @var int Decimal
     */
    const FROM_BASE = 10;

    /**
     * @var int IPv4 length
     */
    const LENGTH = 32;

    /**
     * @var int IPv4 group
     */
    const GROUP = 4;

    /**
     * @var string IPv4 separator
     */
    const SEPARATOR = '.';

    /**
     * @var string Binary 0
     */
    const ZERO = '0';

    /**
     * @var string Binary 1
     */
    const ONE = '1';

    public function __construct()
    {
        // nothing
    }

    public function __destruct()
    {
        // nothing
    }

    /**
     * @param string $address
     * @return bool
     */
    protected function checkAddressFormat($address)
    {
        return filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * @param string|int $mask The mask or network-prefix-length
     * @return bool
     */
    protected function checkMaskFormat($mask)
    {
        $result = true;

        if (is_int($mask) && $mask >= 0 && $mask <= self::LENGTH) {
            $result = true;
        } elseif ($this->checkAddressFormat($mask)) {
            $result = strstr($this->convertAddressToBinary($mask), self::ZERO. self::ONE) === false;
        } else {
            $result = false;
        }

        return $result;
    }

    /**
     * @param string $address
     * @return string Binary
     */
    protected function convertAddressToBinary($address)
    {
        $lengthGroup = self::LENGTH / self::GROUP;
        $exploded = explode(self::SEPARATOR, $address);
        $result = '';

        for ($i = 0; $i < count($exploded); $i++) {
            $result .= str_pad(base_convert($exploded[$i], self::FROM_BASE, self::TO_BASE), $lengthGroup, self::ZERO, STR_PAD_LEFT);
        }

        return $result;
    }

    /**
     * @param string|int $mask The mask or network-prefix-length
     * @return string Binary
     */
    protected function convertMaskToBinary($mask)
    {
        return is_int($mask) ? str_pad(str_repeat(self::ONE, $mask), self::LENGTH, self::ZERO, STR_PAD_RIGHT) : $this->convertAddressToBinary($mask);
    }
}
