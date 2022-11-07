<?php

namespace Lkt\Translations\Helpers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DataParser
{
    /**
     * @param array $translations
     * @param array|null $languages
     * @return array
     */
    public static function prepareData(array $translations, array $languages = null): array
    {
        $data = [];

        if (is_array($languages)) {
            $trans = [];
            foreach ($languages as $lang => $status){
                if ($status){
                    $trans[$lang] = $translations[$lang];
                }
            }
        } else {
            $trans = $translations;
        }

        $keys = [];

        unset($translations);

        $langs = array_keys($trans);

        $t = ['Key'];

        foreach ($langs as $lang){
            $t[] = "Datum ({$lang})";
        }

        $data[] = $t;

        foreach ($trans as $content){
            $arrayKeys = array_keys($content);
            foreach ($arrayKeys as $arrayKey){
                if (!in_array($arrayKey, $keys, true)){
                    $keys[] = $arrayKey;
                }
            }
        }

        sort($keys);

        foreach ($keys as $key){
            $t = [$key];
            foreach ($langs as $lang){
                $t[] = isset($trans[$lang][$key]) ? trim($trans[$lang][$key]) : '';
            }
            $data[] = $t;
        }

        return $data;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param array $data
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function fillSpreadSheet(Spreadsheet &$spreadsheet, array $data)
    {
        foreach ($data as $i => $row) {
            $index = $i + 1;

            // Calculate last pointer and echo content
            $j = 0;
            $l = -1;

            foreach ($row as $item) {
                if (trim($item) === '') {
                    continue;
                }
                if ($j > 25) {
                    ++$l;
                    $j = 0;
                }
                $superPointer = '';
                if ($l >= 0) {
                    $superPointer = chr(65 + $l);
                }
                $tempPointer = chr(65 + $j);
                $pointer = "{$superPointer}{$tempPointer}{$index}";

                $spreadsheet->setActiveSheetIndex(0)->setCellValue($pointer, mb_convert_encoding($item, 'UTF-8', 'UTF-8'));
                ++$j;
            }
        }
    }
}