<?php

namespace App\Console\Commands;

use App\Constant\XMLFileHandler;
use Illuminate\Support\Facades\Storage;

use function sprintf;
/**
 * Class CreateXMLFile
 * @package App\Console\Commands
 */
class CreateXMLFile extends AbstractWorkWithXMLFile
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmlFile:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create folders and XML file by default';

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws \App\Exceptions\FileNotFound
     */
    public function handle(): int
    {
        $xmlFilePath = $this->getPathToFile(false);
        $defaultXmlFilePath = XMLFileHandler::EXAMPLE_XML_FILE_PATH;
        Storage::put($xmlFilePath, Storage::disk('public')->get($defaultXmlFilePath));
        $this->info(sprintf('File %s was created successfully', $xmlFilePath));
        return 0;
    }
}
