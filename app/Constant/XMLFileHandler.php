<?php

namespace App\Constant;

/**
 * Class XMLFileHandler
 * @package App\Constant
 */
class XMLFileHandler
{
    /**
     * Путь до файла, из которого будет создаваться дефолтный XML файл
     * @var string
     */
    public const EXAMPLE_XML_FILE_PATH = '/example/data.xml.full';

    /** Действия над обрабатываемыми позициями из XML файла */
    /** @var string  */
    public const CREATE_ACTION = 'create';
    /** @var string  */
    public const UPDATE_ACTION = 'updatate';

    /**
     * Ответ обработчика о нормальном завершении
     * @var string
     */
    public const OK_RESPONSE = 'ok';
}
