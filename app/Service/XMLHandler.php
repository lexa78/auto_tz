<?php

namespace App\Service;

use App\Constant\XMLFileHandler;
use App\Models\BodyType;
use App\Models\Catalog;
use App\Models\Color;
use App\Models\EngineType;
use App\Models\GearType;
use App\Models\Generation;
use App\Models\Mark;
use App\Models\Run;
use App\Models\Transmission;
use App\Models\VehicleModel;
use App\Models\Year;
use App\ObjectValue\XMLHandlerResponse;
use SimpleXMLElement;

/**
 * Class XMLHandler
 * @package App\Service
 */
class XMLHandler
{
    /**
     * @var string[]
     */
    protected array $markHandbook = [];
    /**
     * @var string[]
     */
    protected array $modelHandbook = [];
    /**
     * @var int[]
     */
    protected array $yearHandbook = [];
    /**
     * @var int[]
     */
    protected array $runHandbook = [];
    /**
     * @var string[]
     */
    protected array $colorHandbook = [];
    /**
     * @var string[]
     */
    protected array $bodyTypeHandbook = [];
    /**
     * @var string[]
     */
    protected array $engineTypeHandbook = [];
    /**
     * @var string[]
     */
    protected array $transmissionHandbook = [];
    /**
     * @var string[]
     */
    protected array $gearTypeHandbook = [];
    /**
     * @var array<int, string>
     */
    protected array $generationHandbook = [];
    /**
     * @var int[]
     */
    protected array $supplierCatalogIdHandbook = [];

    /**
     * XMLHandler constructor.
     */
    public function __construct()
    {
        $this->markHandbook
            = $this->setNameAsKey(Mark::addSelect(['id', 'name'])->get()->toArray(), 'name');
        $this->modelHandbook
            = $this->setNameAsKey(VehicleModel::addSelect(['id', 'name'])->get()->toArray(), 'name');
        $this->yearHandbook
            = $this->setNameAsKey(Year::addSelect(['id', 'year'])->get()->toArray(), 'year');
        $this->runHandbook
            = $this->setNameAsKey(Run::addSelect(['id', 'km'])->get()->toArray(), 'km');
        $this->colorHandbook
            = $this->setNameAsKey(Color::addSelect(['id', 'name'])->get()->toArray(), 'name');
        $this->bodyTypeHandbook
            = $this->setNameAsKey(BodyType::addSelect(['id', 'name'])->get()->toArray(), 'name');
        $this->engineTypeHandbook
            = $this->setNameAsKey(EngineType::addSelect(['id', 'name'])->get()->toArray(), 'name');
        $this->transmissionHandbook
            = $this->setNameAsKey(Transmission::addSelect(['id', 'name'])->get()->toArray(), 'name');
        $this->gearTypeHandbook
            = $this->setNameAsKey(GearType::addSelect(['id', 'name'])->get()->toArray(), 'name');
        $this->supplierCatalogIdHandbook
            = $this->setNameAsKey(
                Catalog::addSelect(['id', 'supplier_id'])->get()->toArray(),
                'supplier_id'
        );
        $this->generationHandbook = $this->fillGenerationHandbook();
    }

    /**
     * @return array
     */
    private function fillGenerationHandbook(): array
    {
        $result = [];

        foreach (Generation::all() as $item) {
            $result[sprintf('%s~%s', $item->supplier_id, $item->name)] = $item->id;
        }

        return $result;
    }

    /**
     * @param SimpleXMLElement $offer
     * @return XMLHandlerResponse
     */
    public function handle(SimpleXMLElement $offer): XMLHandlerResponse
    {
        $supplierCatalogIdFromXML = [];
        $createOrUpdateData = [];
        $idForUpdate = null;
        $offerAsArray = get_object_vars($offer);
        if (!array_key_exists('id', $offerAsArray)) {
            return new XMLHandlerResponse('В XML файле в блоке offer отсутвует значение id. ');
        }
        foreach($offerAsArray as $property => $value) {
            switch ($property) {
                case 'id':
                    $supplierCatalogIdFromXML[] = $value;
                    if (array_key_exists($value, $this->supplierCatalogIdHandbook)) {
                        $action = XMLFileHandler::UPDATE_ACTION;
                        $idForUpdate = $this->supplierCatalogIdHandbook[$value];
                    } else {
                        $action = XMLFileHandler::CREATE_ACTION;
                        $createOrUpdateData['supplier_id'] = $value;
                    }
                    break;
                case 'mark':
                    if (!array_key_exists($value, $this->markHandbook)) {
                        $model = Mark::create(['name' => $value]);
                        $createOrUpdateData['mark_id'] = $model->id;
                        $this->markHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['mark_id'] = $this->markHandbook[$value];
                    }
                    break;
                case 'model':
                    if (!array_key_exists($value, $this->modelHandbook)) {
                        $model = VehicleModel::create(['name' => $value]);
                        $createOrUpdateData['model_id'] = $model->id;
                        $this->modelHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['model_id'] = $this->modelHandbook[$value];
                    }
                    break;
                case 'year':
                    if (!array_key_exists($value, $this->yearHandbook)) {
                        $model = Year::create(['year' => $value]);
                        $createOrUpdateData['year_id'] = $model->id;
                        $this->yearHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['year_id'] = $this->yearHandbook[$value];
                    }
                    break;
                case 'run':
                    if (!array_key_exists($value, $this->runHandbook)) {
                        $model = Run::create(['km' => $value]);
                        $createOrUpdateData['run_id'] = $model->id;
                        $this->runHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['run_id'] = $this->runHandbook[$value];
                    }
                    break;
                case 'color':
                    if (!empty($value)) {
                        if (!array_key_exists($value, $this->colorHandbook)) {
                            $model = Color::create(['name' => $value]);
                            $createOrUpdateData['color_id'] = $model->id;
                            $this->colorHandbook[$value] = $model->id;
                        } else {
                            $createOrUpdateData['color_id'] = $this->colorHandbook[$value];
                        }
                    }
                    break;
                case 'body-type':
                    if (!array_key_exists($value, $this->bodyTypeHandbook)) {
                        $model = BodyType::create(['name' => $value]);
                        $createOrUpdateData['body_type_id'] = $model->id;
                        $this->bodyTypeHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['body_type_id'] = $this->bodyTypeHandbook[$value];
                    }
                    break;
                case 'engine-type':
                    if (!array_key_exists($value, $this->engineTypeHandbook)) {
                        $model = EngineType::create(['name' => $value]);
                        $createOrUpdateData['engine_type_id'] = $model->id;
                        $this->engineTypeHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['engine_type_id'] = $this->engineTypeHandbook[$value];
                    }
                    break;
                case 'transmission':
                    if (!array_key_exists($value, $this->transmissionHandbook)) {
                        $model = Transmission::create(['name' => $value]);
                        $createOrUpdateData['transmission_id'] = $model->id;
                        $this->transmissionHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['transmission_id'] = $this->transmissionHandbook[$value];
                    }
                    break;
                case 'gear-type':
                    if (!array_key_exists($value, $this->gearTypeHandbook)) {
                        $model = GearType::create(['name' => $value]);
                        $createOrUpdateData['gear_type_id'] = $model->id;
                        $this->gearTypeHandbook[$value] = $model->id;
                    } else {
                        $createOrUpdateData['gear_type_id'] = $this->gearTypeHandbook[$value];
                    }
                    break;
            }
        }
        if (!empty($offerAsArray['generation_id']) && !empty($offerAsArray['generation'])) {
                $compositeKey = sprintf('%s~%s', $offerAsArray['generation_id'], $offerAsArray['generation']);
                if (!array_key_exists($compositeKey, $this->generationHandbook)) {
                    $model = Generation::create([
                        'name' => $offerAsArray['generation'],
                        'supplier_id' => $offerAsArray['generation_id'],
                    ]);
                    $createOrUpdateData['generation_id'] = $model->id;
                    $this->generationHandbook[$compositeKey] = $model->id;
                } else {
                    $createOrUpdateData['generation_id'] = $this->generationHandbook[$compositeKey];
                }
        }

        if ($action === XMLFileHandler::CREATE_ACTION) {
            $catalog = Catalog::create($createOrUpdateData);
            $this->supplierCatalogIdHandbook[$createOrUpdateData['supplier_id']] = $catalog->id;
        } else {
            Catalog::where('id', $idForUpdate)->update($createOrUpdateData);
        }

//        $idForDelete = array_diff(array_keys($this->supplierCatalogIdHandbook), $supplierCatalogIdFromXML);
//        Catalog::whereIn('supplier_id', $idForDelete)->delete();

        return new XMLHandlerResponse(
            XMLFileHandler::OK_RESPONSE,
            $this->supplierCatalogIdHandbook,
            $supplierCatalogIdFromXML
        );
    }

    /**
     * @param array $data
     * @param string $parameterNameForKey
     * @return array
     */
    private function setNameAsKey(array $data, string $parameterNameForKey): array
    {
        $result = [];

        foreach ($data as $item) {
            $result[$item[$parameterNameForKey]] = $item['id'];
        }

        return $result;
    }
}
