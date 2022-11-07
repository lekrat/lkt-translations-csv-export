<?php

namespace Lkt\Translations;

use Lkt\Translations\Helpers\DataParser;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class TranslationsToCSV
{
    /**
     * @param string $title
     * @param string $subject
     * @param string $description
     * @param string $creator
     * @param string $lastModifiedBy
     * @return Spreadsheet
     */
    public static function createSpreadSheet(string $title, string $subject, string $description = '', string $creator = '', string $lastModifiedBy = ''): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()
            ->setCreator($creator)
            ->setLastModifiedBy($lastModifiedBy)
            ->setTitle($title)
            ->setSubject($subject)
            ->setDescription($description);

        $spreadsheet->getActiveSheet();

        return $spreadsheet;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param array|null $availableLanguages
     * @return Csv
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function getAllTranslationsCSV(Spreadsheet $spreadsheet, array $availableLanguages = null): Csv
    {
        $translations = Translations::export();
        $data = DataParser::prepareData($translations, $availableLanguages);
        DataParser::fillSpreadSheet($spreadsheet, $data);
        return new Csv($spreadsheet);
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param array|null $availableLanguages
     * @return Csv
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function getMissedTranslationsCSV(Spreadsheet $spreadsheet, array $availableLanguages = null): Csv
    {
        $translations = Translations::getMissedTranslations();
        $data = DataParser::prepareData($translations, $availableLanguages);
        DataParser::fillSpreadSheet($spreadsheet, $data);
        return new Csv($spreadsheet);
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param array|null $availableLanguages
     * @return Csv
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function getTranslationsNotTranslatedCSV(Spreadsheet $spreadsheet, array $availableLanguages = null): Csv
    {
        $translations = Translations::getTranslationsNotTranslated();
        $data = DataParser::prepareData($translations, $availableLanguages);
        DataParser::fillSpreadSheet($spreadsheet, $data);
        return new Csv($spreadsheet);
    }

    /**
     * @param Csv $writer
     * @param string $fileName
     * @return void
     */
    public static function writeToOutput(Csv $writer, string $fileName = '')
    {
        $fileName = trim($fileName);
        $fileName .= '.csv';

        header("Content-Disposition: attachment; filename={$fileName}");
        $writer->save('php://output');
        die();
    }
}