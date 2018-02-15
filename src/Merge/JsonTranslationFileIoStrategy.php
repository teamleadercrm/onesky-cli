<?php

namespace Teamleader\OneSky\Merge;

class JsonTranslationFileIoStrategy implements TranslationFileIoStrategy
{

    /**
     * @param string $file
     * @return array
     */
    public function readFile($file)
    {
        return json_decode(file_get_contents($file), true);
    }

    /**
     * @param array $translations
     * @return string
     */
    public function formatOutput(array $translations)
    {
        return json_encode($translations, JSON_PRETTY_PRINT);
    }
}
