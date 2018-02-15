<?php

namespace Teamleader\OneSky\Merge;

class TranslationMerger
{
    /**
     * @var TranslationFileIoStrategy
     */
    private $translationFileIoStrategy;

    /**
     * @param TranslationFileIoStrategy $translationFiloIoStrategy
     */
    public function __construct(TranslationFileIoStrategy $translationFiloIoStrategy)
    {
        $this->translationFileIoStrategy = $translationFiloIoStrategy;
    }

    /**
     * @param string[] $files
     */
    public function merge(array $files)
    {
        $merged = [];

        foreach ($files as $file) {
            $translations = $this->translationFileIoStrategy->readFile($file);
            $merged = array_merge($translations, $merged);
        }

        return $this->translationFileIoStrategy->formatOutput($merged);
    }
}
