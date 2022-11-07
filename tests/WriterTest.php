<?php

namespace Lkt\Templates\Tests;

use Lkt\Translations\Translations;
use Lkt\Translations\TranslationsToCSV;
use PHPUnit\Framework\TestCase;

class WriterTest extends TestCase
{
    /**
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function testAllTranslations()
    {
        Translations::addLocalePath('en', __DIR__ . '/assets/en');
        Translations::addLocalePath('es', __DIR__ . '/assets/es');

        $spreadsheet = TranslationsToCSV::createSpreadSheet('Sample', 'Exported sample');
        $writer = TranslationsToCSV::getAllTranslationsCSV($spreadsheet);
        $writer->save(__DIR__ . '/assets/output-all.csv');
        $this->assertFileExists(__DIR__ . '/assets/output-all.csv');
    }

    /**
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function testMissedTranslations()
    {
        Translations::addLocalePath('en', __DIR__ . '/assets/en');
        Translations::addLocalePath('es', __DIR__ . '/assets/es');

        $spreadsheet = TranslationsToCSV::createSpreadSheet('Sample', 'Exported sample');
        $writer = TranslationsToCSV::getMissedTranslationsCSV($spreadsheet);
        $writer->save(__DIR__ . '/assets/output-missed.csv');
        $this->assertFileExists(__DIR__ . '/assets/output-missed.csv');
    }

    /**
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function testTranslationsNotTranslated()
    {
        Translations::addLocalePath('en', __DIR__ . '/assets/en');
        Translations::addLocalePath('es', __DIR__ . '/assets/es');

        $spreadsheet = TranslationsToCSV::createSpreadSheet('Sample', 'Exported sample');
        $writer = TranslationsToCSV::getTranslationsNotTranslatedCSV($spreadsheet);
        $writer->save(__DIR__ . '/assets/output-not-translated.csv');
        $this->assertFileExists(__DIR__ . '/assets/output-not-translated.csv');
    }
}