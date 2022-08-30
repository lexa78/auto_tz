<?php

namespace App\Console\Commands;

use App\Constant\XMLFileHandler;
use App\Exceptions\FileNotFound;
use App\Models\Catalog;
use App\ObjectValue\XMLHandlerResponse;
use App\Service\XMLHandler;
use DOMDocument;
use Illuminate\Support\Facades\Storage;

/**
 * Class HandleXMLFile
 * @package App\Console\Commands
 */
class HandleXMLFile extends AbstractWorkWithXMLFile
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmlFile:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data according to received XML file';

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws FileNotFound
     */
    public function handle(XMLHandler $handler): int
    {
        $xmlFilePath = $this->getPathToFile(true);
        $xmlObject = simplexml_load_string(Storage::get($xmlFilePath));

        $dom = new DOMDocument;
        $dom->loadXML(Storage::get($xmlFilePath));
        if ($dom->Schemavalidate(storage_path(env('XML_VALIDATION_SCHEME_PATH')))) {
            $supplierCatalogIdFromDb = [];
            $supplierCatalogIdFromXML = [];
            foreach ($xmlObject->offers->offer as $item) {
                /** @var XMLHandlerResponse $result */
                $result = $handler->handle($item);
                if ($result->getTextResponse() === XMLFileHandler::OK_RESPONSE) {
                    $supplierCatalogIdFromDb = $result->getSupplierCatalogIdFromDb();
                    $supplierCatalogIdFromXML = array_merge(
                        $supplierCatalogIdFromXML,
                        $result->getSupplierCatalogIdFromXML()
                    );
                    $this->info(sprintf('Offer with id = %s is handled successfully', $item->id));
                } else {
                    $this->error($result->getTextResponse());
                }
            }
        } else {
            $this->error('XML file is not valid');
            return 1;
        }

        $idForDelete = array_diff(array_keys($supplierCatalogIdFromDb), array_unique($supplierCatalogIdFromXML));

        Catalog::whereIn('supplier_id', $idForDelete)->delete();
        if (count($idForDelete) > 0) {
            $this->info(sprintf('There are %s rows was removed', count($idForDelete)));
        }

        $this->info(sprintf('File %s was handled successfully', $xmlFilePath));

        return 0;
    }
}
