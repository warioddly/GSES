<?php

namespace App\Http\Controllers\Components;

use App\Models\Document;
use App\Models\DocumentTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class WordReportGeneratorComponent {

    private TemplateProcessor $file;
    private $relationModelInstance;
    private array $options = [
        // Data
        'relationId' => 0,
        'relationModel' => '',
        'templateCode' => '',
        'templateName' => '',
        // Symbols
        'emptySymbol' => '',
        'explodeSymbol' => '.',
        'arraySeparator' => '<w:br/>',
    ];

    public function __construct(array $options = []) {
        if ($options) {
            $this->options = array_merge($this->options, $options);
        }

        if ($this->checkValuesInOptions(['relationId', 'relationModel', 'templateCode'])) {
            $this->relationModelInstance = $this->getModelInstanceByName($this->options['relationModel']);
            $documentTemplate = DocumentTemplate::query()
                    ->where('code', $this->options['templateCode'])
                    ->with('document')
                    ->first();

            if ($this->relationModelInstance) {
                $this->relationModelInstance = $this->relationModelInstance->query()->find($this->options['relationId']);
            }

            if ($documentTemplate && $documentTemplate->document) {
                $file = storage_path(
                        'app/' . $documentTemplate->document->folder . '/' . $documentTemplate->document->name_uuid
                );
                if (file_exists($file)) {
                    $this->file = new TemplateProcessor($file);
                    $this->options['templateName'] = $documentTemplate->document->name;
                }
            }
        }
    }

    public function generate() {
        $result = [
            'file' => '',
            'document' => null
        ];

        if ($this->file && $this->relationModelInstance) {
            foreach ($this->file->getVariables() as $variable) {
                $this->replaceVariable($variable);
            }

            $folder = 'reports';
            $fileExtension = 'docx';

            $newPath = storage_path('app/'.$folder);
            if(!is_dir ($newPath)){
                mkdir($newPath, 0777);
            }

            $fileName = Str::random(40) . '.' . $fileExtension;
            $filePath = storage_path("app/$folder/$fileName");
            $this->file->saveAs($filePath);

            $document = new Document();
            $document->name = $this->options['templateName'];
            $document->name_uuid = $fileName;
            $document->extension = $fileExtension;
            $document->folder = $folder;
            $document->creator_id = auth()->id();
            $document->save();

            $result['file'] = $filePath;
            $result['document'] = $document;
        }

        return $result;
    }

    private function replaceVariable(string $variable) {
        $variableExploded = $this->explodeString($variable);
        if (!$variableExploded) {
            return null;
        }

        $result = $this->getRecursiveProperty($variableExploded, $this->relationModelInstance);
        $emptySymbol = $this->checkValuesInOptions(['emptySymbol']) ? $this->options['emptySymbol'] : ' ';
        $this->file->setValue(
                $variable,
                $result ? $result : $emptySymbol
        );

        return null;
    }

    private function getModelInstanceByName(string $name) {
        foreach (scandir(app_path('Models')) as $modelFile) {
            if (in_array($modelFile, ['.', '..'])) {
                continue;
            }

            $modelFileExploded = $this->explodeString($modelFile);
            if (count($modelFileExploded) === 2 && $modelFileExploded[1] === 'php') {
                $model = 'App\\Models\\' . $modelFileExploded[0];
                $instance = new $model();
                if ($instance instanceof Model && $instance->getTable() === $name) {
                    return $instance;
                }
            }
        }

        return null;
    }

    private function getRecursiveProperty(array $variables, $value = null) {
        $firstItem = array_shift($variables);
        if (!$value || !is_scalar($firstItem)) {
            return null;
        }

        if (is_iterable($value)) {
            if (is_numeric($firstItem) && isset($value[$firstItem])) {
                if (is_scalar($value[$firstItem])) {
                    return $value[$firstItem];
                } else {
                    return $this->getRecursiveProperty($variables, $value[$firstItem]);
                }
            }

            $result = '';
            foreach ($value as $k => $v) {
                if (isset($v->$firstItem)) {
                    if (is_scalar($v->$firstItem)) {
                        $result .= $v->$firstItem;
                    } else {
                        $result .= $this->getRecursiveProperty($variables, $v->$firstItem);
                    }

                    if ($result && $k !== count($value) - 1) {
                        $result .= $this->checkValuesInOptions(['arraySeparator']) ? $this->options['arraySeparator'] : ' ';
                    }
                }
            }
            return $result;
        } else if (isset($value->$firstItem)) {
            if (is_scalar($value->$firstItem)) {
                return $value->$firstItem;
            }
            return $this->getRecursiveProperty($variables, $value->$firstItem);
        }

        return null;
    }

    private function explodeString(string $string) {
        if (!$string || !$this->checkValuesInOptions(['explodeSymbol'])) {
            return [];
        }

        $array = explode($this->options['explodeSymbol'], $string);
        foreach ($array as $key => $value) {
            $array[$key] = trim($value);
        }

        return $array;
    }

    private function checkValuesInOptions(array $array) {
        foreach ($array as $v) {
            if (!isset($this->options[$v]) || !is_scalar($this->options[$v]) || !$this->options[$v]) {
                return false;
            }
        }

        return true;
    }

}
