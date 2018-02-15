<?php

namespace Teamleader\OneSky\Merge;

use InvalidArgumentException;

class Format
{
    const FORMAT_PHP = 'PHP';
    const FORMAT_JSON = 'JSON';

    /** @var string */
    private $format;

    /**
     * @param string $format
     */
    private function __construct($format)
    {
        $this->guardValid($format);
        $this->format = $format;
    }

    /**
     * @param string $formatString
     * @throws InvalidArgumentException
     */
    private function guardValid($formatString)
    {
        if (!in_array($formatString, [self::FORMAT_JSON, self::FORMAT_PHP])) {
            throw new InvalidArgumentException('Invalid format: ' . $formatString);
        }
    }

    /**
     * @param $string
     * @return static
     */
    public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * @return static
     */
    public static function php()
    {
        return new static(self::FORMAT_PHP);
    }

    /**
     * @return static
     */
    public static function json()
    {
        return new static(self::FORMAT_JSON);
    }
}
