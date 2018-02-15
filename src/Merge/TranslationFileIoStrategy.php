<?php

namespace Teamleader\OneSky\Merge;

interface TranslationFileIoStrategy
{
    /**
     * @param string $file
     * @return array
     */
    public function readFile($file);

    /**
     * @param array $translations
     * @return string
     */
    public function formatOutput(array $translations);
}
