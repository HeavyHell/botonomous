<?php

namespace Botonomous;

use Botonomous\utility\FileUtility;

/**
 * Class Dictionary.
 */
class Dictionary
{
    const DICTIONARY_DIR = 'dictionary';
    const DICTIONARY_FILE_SUFFIX = 'json';

    private $data;

    /**
     * @param $key
     *
     * @throws \Exception
     *
     * @return array|mixed
     */
    private function load($key)
    {
        $stopWordsPath = __DIR__.DIRECTORY_SEPARATOR.self::DICTIONARY_DIR.DIRECTORY_SEPARATOR.$key.'.'.
            self::DICTIONARY_FILE_SUFFIX;

        return (new FileUtility())->jsonFileToArray($stopWordsPath);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $fileName
     *
     * @return mixed
     */
    public function get($fileName)
    {
        $data = $this->getData();

        if (!isset($data[$fileName])) {
            $data[$fileName] = $this->load($fileName);
            $this->setData($data);
        }

        return $data[$fileName];
    }

    /**
     * Return value for the key in the file content.
     *
     * @param $fileName
     * @param $key
     * @param array $replacements
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function getValueByKey($fileName, $key, $replacements = [])
    {
        $fileContent = $this->get($fileName);

        if (!array_key_exists($key, $fileContent)) {
            throw new \Exception("Key: '{$key}' does not exist in file: {$fileName}");
        }

        $found = $fileContent[$key];

        if (empty($replacements)) {
            return $found;
        }

        foreach ($replacements as $key => $value) {
            $found = str_replace('{'.$key.'}', $value, $found);
        }

        return $found;
    }
}
