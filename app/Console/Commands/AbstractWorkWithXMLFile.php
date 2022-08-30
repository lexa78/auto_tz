<?php

namespace App\Console\Commands;

use App\Exceptions\FileNotFound;
use App\Exceptions\ValueNotFound;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Class AbstractWorkWithXMLFile
 * @package App\Console\Commands
 */
abstract class AbstractWorkWithXMLFile extends Command
{
    /**
     * Constructor of all XML file workers.
     * @throws ValueNotFound
     */
    public function __construct()
    {
        if (is_null(env('DEFAULT_XML_FILE_PATH'))) {
            throw new ValueNotFound('Value of parameter DEFAULT_XML_FILE_PATH in .env file is not found');
        }
        $this->signature = sprintf(
            '%s {filePath=%s : path and file name}',
            $this->signature,
            env('DEFAULT_XML_FILE_PATH')
        );
        parent::__construct();
    }

    /**
     * @param bool $needToCheck
     * @return string
     * @throws FileNotFound
     */
    protected function getPathToFile(bool $needToCheck = false): string
    {
        $xmlFilePath = $this->argument('filePath');
        if ($needToCheck) {
            if (!Storage::exists($xmlFilePath)) {
                throw new FileNotFound(sprintf('File %s is not found', $xmlFilePath));
            }
        }

        return $xmlFilePath;
    }
}
