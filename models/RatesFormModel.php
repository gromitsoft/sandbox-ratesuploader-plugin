<?php

namespace Sandbox\Uploader\Models;

use Model;
use October\Rain\Database\Relations\AttachOne;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

/**
 * @property File $rates_file
 * @method AttachOne rates_file()
 */
class RatesFormModel extends Model
{
    public $attachOne = [
        'rates_file' => File::class,
    ];

    use Validation;

    public $rules = [
        'rates_file' => 'required|file|mimes:xml'
    ];

    public $customMessages = [
        'rates_file.required' => 'Загрузите файл',
        'rates_file.file'     => 'Загрузите файл',
        'rates_file.mimes'    => 'Файл должен быть в формате XML',
    ];
}
