<?php

namespace Teamleader\OneSky\Merge;

class PhpTranslationFileIoStrategy implements TranslationFileIoStrategy
{
    /**
     * @param string $file
     * @return array
     */
    public function readFile($file)
    {
        if (! file_exists($file)) {
            return [];
        }

        return include $file;
    }

    /**
     * @param array $translations
     * @return string
     */
    public function formatOutput(array $translations)
    {
        return '<?php ' . PHP_EOL . 'return ' . var_export($translations, true) . ';';
    }
}
