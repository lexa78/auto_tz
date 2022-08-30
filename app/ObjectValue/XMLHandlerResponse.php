<?php

namespace App\ObjectValue;

/**
 * Class XMLHandlerResponse
 * @package App\ObjectValue
 */
class XMLHandlerResponse
{
    /** @var string */
    private string $textResponse = '';
    /** @var int[] */
    private array $supplierCatalogIdFromDb = [];
    /** @var int[] */
    private array $supplierCatalogIdFromXML = [];

    /**
     * XMLHandlerResponse constructor.
     * @param string $textResponse
     * @param array $supplierCatalogIdFromDb
     * @param array $supplierCatalogIdFromXML
     */
    public function __construct(
        string $textResponse,
        array $supplierCatalogIdFromDb = [],
        array $supplierCatalogIdFromXML = []
    ) {
        $this->textResponse = $textResponse;
        $this->supplierCatalogIdFromDb = $supplierCatalogIdFromDb;
        $this->supplierCatalogIdFromXML = $supplierCatalogIdFromXML;
    }

    /**
     * @return string
     */
    public function getTextResponse(): string
    {
        return $this->textResponse;
    }

    /**
     * @param string $textResponse
     * @return $this
     */
    public function setTextResponse(string $textResponse): XMLHandlerResponse
    {
        $this->textResponse = $textResponse;

        return $this;
    }

    /**
     * @return int[]
     */
    public function getSupplierCatalogIdFromDb(): array
    {
        return $this->supplierCatalogIdFromDb;
    }

    /**
     * @param int[] $supplierCatalogIdFromDb
     * @return $this
     */
    public function setSupplierCatalogIdFromDb(array $supplierCatalogIdFromDb): XMLHandlerResponse
    {
        $this->supplierCatalogIdFromDb = $supplierCatalogIdFromDb;

        return $this;
    }

    /**
     * @return int[]
     */
    public function getSupplierCatalogIdFromXML(): array
    {
        return $this->supplierCatalogIdFromXML;
    }

    /**
     * @param int[] $supplierCatalogIdFromXML
     * @return $this
     */
    public function setSupplierCatalogIdFromXML(array $supplierCatalogIdFromXML): XMLHandlerResponse
    {
        $this->supplierCatalogIdFromXML = $supplierCatalogIdFromXML;

        return $this;
    }


}
