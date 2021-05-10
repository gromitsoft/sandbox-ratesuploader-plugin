<?php

namespace Sandbox\Uploader\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;
use Backend\Widgets\Form;
use Flash;
use October\Rain\Database\Models\DeferredBinding;
use Sandbox\Uploader\Models\RatesFormModel;
use System\Models\File;

class RatesUploader extends Controller
{
    /**
     * @throws \SystemException
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Sandbox.Uploader', 'uploader', '');

        if ($this->action === 'index') {
            $this
                ->makeWidget(Form::class, [
                    'alias'  => 'ratesUploadForm',
                    'model'  => new RatesFormModel(),
                    'fields' => [
                        'rates_file' => [
                            'label'     => 'Файл с курсами валют',
                            'type'      => 'fileupload',
                            'fileTypes' => 'xml',
                            'mode'      => 'file',
                        ]
                    ]
                ])
                ->bindToController();
        }
    }

    public function index(): void
    {
    }

    /**
     * @throws \SystemException
     */
    public function onOpenUploadPopup(): string
    {
        return $this->makePartial('upload_popup');
    }

    /**
     * @throws \October\Rain\Exception\ValidationException
     */
    public function onImport(): void
    {
        $sessionKey = post('_session_key');

        $file = $this->getFile($sessionKey);

        $this->importRates($file->getContents());

        DeferredBinding::cancelDeferredActions(RatesFormModel::class, $sessionKey);

        Flash::success('Курсы валют обновлены');
    }

    /**
     * @throws \October\Rain\Database\ModelException
     */
    private function getFile(string $sessionKey): File
    {
        $formModel             = new RatesFormModel();
        $formModel->sessionKey = $sessionKey;
        $formModel->validate();

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $formModel
            ->rates_file()
            ->withDeferred($sessionKey)
            ->orderByDesc('created_at')
            ->first();
    }

    private function importRates(string $rates): void
    {
        // импортируем курсы валют из файла

        // $rates = simplexml_load_string($rates);
        // foreach ($rates as $rate) {
        //     ...
        // }
    }
}
