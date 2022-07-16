<?php

namespace Barronhsu15\IP;

abstract class IP
{
    /**
     * @param string $address
     * @return bool
     */
    abstract protected function checkAddressFormat($address);

    /**
     * @param string|int $mask The mask or network-prefix-length
     * @return bool
     */
    abstract protected function checkMaskFormat($mask);

    /**
     * @param string $address
     * @return string Binary
     */
    abstract protected function convertAddressToBinary($address);

    /**
     * @param string|int $mask The mask or network-prefix-length
     * @return string Binary
     */
    abstract protected function convertMaskToBinary($mask);

    /**
     * @param string $address Binary
     * @param string $mask Binary
     * @return string Binary
     */
    protected function maskAddress($address, $mask)
    {
        $addressSplited = str_split($address);
        $maskSplited = str_split($mask);
        $result = '';

        for ($i = 0; $i < count($addressSplited); $i++) {
            $result .= strval(intval($addressSplited[$i]) * intval($maskSplited[$i]));
        }

        return $result;
    }

    /**
     * @param string $ip
     * @param string $network
     * @param string|int $mask The mask or network-prefix-length
     * @return bool|null Return null when the format is incorrect
     */
    public function match($ip, $network, $mask)
    {
        if ($this->checkAddressFormat($ip) && $this->checkAddressFormat($network) && $this->checkMaskFormat($mask)) {
            $ipBinary = $this->convertAddressToBinary($ip);
            $networkBinary = $this->convertAddressToBinary($network);
            $maskBinary = $this->convertMaskTobinary($mask);

            $ipMasked = $this->maskAddress($ipBinary, $maskBinary);
            $networkMasked = $this->maskAddress($networkBinary, $maskBinary);

            return $ipMasked === $networkMasked;
        } else {
            return null;
        }
    }
}
