<?php


namespace App\Helpers;


use App\Models\Document;
use App\Models\MarkerWord;
use App\Models\Material;
use App\Models\MaterialWord;
use App\Models\MaterialWordPosition;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Random;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Str;

/**
 * Class AppHelper
 * @package App\Helpers
 */
class AppHelper
{
    public function fileBlade($fieldName, $label, $document = null, $required = false)
    {
        return view('uitypes.file', compact('fieldName', 'label', 'document', 'required'));
    }

    public function selectBlade($fieldName, $label, $options, $value = null, $required = false, $readonly = false, $ajax = null)
    {
        return view('uitypes.select', compact('fieldName', 'label', 'options', 'value', 'required', 'readonly', 'ajax'));
    }

    public function selectText($fieldName, $label, $options, $value = null, $required = false, $readonly = false)
    {
        return view('uitypes.select_text', compact('fieldName', 'label', 'options', 'value', 'required', 'readonly'));
    }

    public function selectFIO($fieldName, $label, $options, $value = null, $required = false, $readonly = false)
    {
        return view('uitypes.select_fio', compact('fieldName', 'label', 'options', 'value', 'required', 'readonly'));
    }

    public function selectContractor($fieldName, $label, $options, $value = null, $required = false, $readonly = false, $ajax = null)
    {
        return view('uitypes.select_contractor', compact('fieldName', 'label', 'options', 'value', 'required', 'readonly', 'ajax'));
    }
    public function selectCover($fieldName, $label, $options, $value = null, $required = false, $readonly = false, $ajax = null)
    {
        return view('uitypes.select_cover', compact('fieldName', 'label', 'options', 'value', 'required', 'readonly', 'ajax'));
    }

    public function selectMultipleSubjectBlade($fieldName, $label, $options, $values = [], $required = false, $readonly = false, $ajax = null)
    {
        return view('uitypes.select_multiple_subject', compact('fieldName', 'label', 'options', 'values', 'required', 'readonly', 'ajax'));
    }
    public function selectMultipleBlade($fieldName, $label, $options, $values = [], $required = false, $readonly = false, $ajax = null)
    {
        return view('uitypes.select_multiple', compact('fieldName', 'label', 'options', 'values', 'required', 'readonly', 'ajax'));
    }

    public function dependedSelectBlade($fieldName, $label, $options, $value = null, $required = false, $parentSelect = null, $dependencies = null, $formArea = null)
    {
        return view('uitypes.select_depend', compact('fieldName', 'label', 'options', 'value', 'required', 'parentSelect', 'dependencies', 'formArea'));
    }

    public function CustomDependedSelectBlade($fieldName, $label, $options, $value = null, $required = false, $parentSelect = null, $dependencies = null, $formArea = null,$childOption = null, $childOptionRelation = null, $types = null)
    {
        return view('uitypes.select_custom_depend', compact('fieldName', 'label', 'options', 'value', 'required', 'parentSelect', 'dependencies', 'formArea', 'childOption', 'childOptionRelation', 'types'));
    }

    public function textBlade($fieldName, $label, $value = null, $required = false, $readonly = false, $type = 'text')
    {
        return view('uitypes.text', compact('fieldName', 'label', 'value', 'required', 'readonly', 'type'));
    }

    public function dateBlade($fieldName, $label, $value = null, $required = false, $readonly = false)
    {
        return view('uitypes.date', compact('fieldName', 'label', 'value', 'required', 'readonly'));
    }

    public function textareaBlade($fieldName, $label, $value = null, $required = false, $readonly = false)
    {
        return view('uitypes.textarea', compact('fieldName', 'label', 'value', 'required', 'readonly'));
    }

    public function htmlBlade($fieldName, $label, $value = null)
    {
        return view('uitypes.html', compact('fieldName', 'label', 'value'));
    }

    public function passwordBlade($fieldName, $label, $required = false)
    {
        return view('uitypes.password', compact('fieldName', 'label', 'required'));
    }

    public function showBlade($label, $value = null)
    {
        return view('uitypes.show', compact('label', 'value'));
    }

    public function indexActionBlade($model, $route, $permission)
    {
        return view('layouts.index-actions', compact('model', 'route', 'permission'));
    }

    public function AjaxIndexActionBlade($model, $route, $permission)
    {
        return view('layouts.ajax-index-actions', compact('model', 'route', 'permission'));
    }

    public function materialExpertiseActionBlade($model, $route, $permission)
    {
        return view('layouts.material-expertise-index-action', compact('model', 'route', 'permission'));
    }

    /**
     * @param UploadedFile|string $file
     * @param string $folder
     * @return null
     */
    public function saveDocument($file, $folder, $creator_id = null, $localFile = null)
    {
        if (is_null($localFile)) {

            if (is_string($file) && request()->hasFile($file))
                $file = request()->file($file);
            elseif (is_string($file) && file_exists($file))
                $file = self::createFileFromText(file_get_contents($file), basename($file));
            elseif (!($file instanceof UploadedFile))
                return null;
        } else {
            $file = $localFile;
        }

        $newPath = storage_path('app/' . $folder);
        if (!is_dir($newPath)) {
            mkdir($newPath, 0777);
        }

        if (!empty($file)) {
            $fileHashName = $file->hashName();
            $path = $file->getRealPath();
            $file->storeAs($folder, $fileHashName);

            $document = Document::create([
                'name' => $file->getClientOriginalName(),
                'name_uuid' => $fileHashName,
                'extension' => $file->guessExtension(),
                'folder' => $folder,
                'creator_id' => $creator_id != null ? $creator_id : auth()->id()
            ]);

            if (strpos($path, 'tmp-files') !== false)
                unlink($path);

            return $document->id;
        }
        return null;
    }

    /**
     * @param Document|int $id
     * @return boolean
     */
    public function deleteDocument($id)
    {
        $document = Document::find($id);
        if ($document && file_exists($document->getRealPath())) {
            $deleted = unlink($document->getRealPath());
            if ($deleted) {
                return $document->delete();
            }
        }

        return false;
    }

    /**
     * @param $url
     * @return UploadedFile
     */
    public function createFileObject($url)
    {

        $path_parts = pathinfo($url);

        $newPath = storage_path('tmp-files/');
        if (!is_dir($newPath)) {
            mkdir($newPath, 0777);
        }

        $newUrl = $newPath . $path_parts['basename'];
        copy($url, $newUrl);
        $imgInfo = getimagesize($newUrl);

        $file = new UploadedFile(
            $newUrl,
            $path_parts['basename'],
            $imgInfo['mime'],
            true,
            true
        );

        return $file;
    }

    public function createFileFromText($text, $filename)
    {
        $newPath = storage_path('tmp-files/');
        if (!is_dir($newPath)) {
            mkdir($newPath, 0777);
        }

        $path = $newPath . $filename;
        file_put_contents($path, $text);

        $file = new UploadedFile(
            $path,
            $filename,
            mime_content_type($path),
            true,
            true
        );

        return $file;
    }

    public function convertWordToPDF(Document $document)
    {
        $newPath = storage_path('tmp-files/');
        if (!is_dir($newPath)) {
            mkdir($newPath, 0777);
        }

//        $domPdfPath = base_path('vendor/dompdf/dompdf');
//        Settings::setPdfRendererPath($domPdfPath);
//        Settings::setPdfRendererName('DomPDF');

        $domPdfPath = base_path('vendor/mpdf/mpdf');
        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName(Settings::PDF_RENDERER_MPDF);

        //Load word file
        $content = IOFactory::load($document->getRealPath());

        //Save it into PDF
        $PDFWriter = IOFactory::createWriter($content, 'PDF');

        $filename = Str::random(20) . '.pdf';
        $path = $newPath . $filename;
        $PDFWriter->save($path);
        $file = new UploadedFile(
            $path,
            $filename,
            '	application/pdf',
            true,
            true
        );

        return self::saveDocument($file, 'analyzes');
    }

    public function solrExtractText($content, $filename)
    {
        $solr_api = config('custom.solr_api');
        try {
            $response = Http::accept('application/json')
                ->attach('myfile', $content, $filename)
                ->post($solr_api . '/techproducts/update/extract', [
                    'extractOnly' => 'true',
                    'extractFormat' => 'text',
                    'uprefix' => 'ignored_',
                    'commit' => 'true',
                    'literal.id' => null,
                ]);
        } catch (ConnectionException $e) {
            return null;
        }
        $result = $response->json();
        $text = isset($result['myfile']) ? $result['myfile'] : '';
        $text = strip_tags($text);
        $text = preg_replace('/(\s)\s*/uim', '$1', $text);
        return $text ?: null;
    }

    public function solrSearchMaterial($query)
    {
        $solr_api = config('custom.solr_api');

        $query = mb_substr($query, 0, 2000);
        $query = str_replace(['!', '#', '$', '&', '\'', '(', ')', '*', ',', '/', ':', ';', '=', '?', '@', '+', '-', '|', '!', '{', '}', '[', ']', '^', '"', '~'], '', $query);
        $query = addcslashes($query, '!#$&\'()*+-,:;=?@[]/"~');

        $params = [
            "q" => "$query",
            "q.op" => "OR",
            "indent" => "true",
            "fl" => "*,score",
            "hl" => "true",
            "hl.fl" => "content",
            "hl.fragsize" => "200",
            "hl.simple.pre" => '<em class="medium"><em class="highlight">',
            "hl.simple.post" => '</em></em>',
            "hl.snippets" => "5000",
            "hl.maxAnalyzedChars" => "500000",
            "mlt" => "true",
            "mlt.fl" => "content",
//            "mlt.mindf"=>"1",
        ];
        try {
            $response = Http::accept('application/json')
                ->withBody(http_build_query($params), 'application/x-www-form-urlencoded')
                ->post($solr_api . '/techproducts/select');
        } catch (ConnectionException $e) {
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }
        $result = $response->json();

        if (isset($result['error'])) {
            return [
                'error' => $result['error']['msg'],
                'code' => $result['error']['code'],
            ];
        }

        $found = [];
        Log::info('before highlight');
        foreach ($result['response']['docs'] as $doc) {
            $content = join("\n\n\n\n", isset($doc['content']) ? $doc['content'] : '');
            $highlighting = isset($result['highlighting'][$doc['id']]['content']) ? $result['highlighting'][$doc['id']]['content'] : [];
            foreach ($highlighting as $item) {
                $text = str_replace(['<em class="medium"><em class="highlight">', '</em></em>'], '', $item);
//                $text2 = ltrim(preg_replace('/<em>/uim', '<em class="highlight">', $item));
                $content = str_replace($text, $item, $content);
            }
//            $highlighting = join("<br>............<br>", $highlighting);
//            $highlighting = str_replace('<em>', '<em class="highlight">', $highlighting);
            $found[] = [
                'id' => $doc['id'],
                'score' => $doc['score'],
                'content' => $content,
//                'highlighting' => $highlighting
            ];
        }
        Log::info('after highlight');
        return $found;
    }

    public function solrAddDocument($content, $filename, $id)
    {
        $solr_api = config('custom.solr_api');
        try {
            $response = Http::accept('application/json')
                ->attach('myfile', $content, $filename)
                ->post($solr_api . '/techproducts/update/extract', [
                    'uprefix' => 'ignored_',
                    'commit' => 'true',
                    'literal.id' => $id,
                ]);
        } catch (ConnectionException $e) {
            return false;
        }
        $result = $response->json();

        return isset($result['responseHeader']) && $result['responseHeader']['status'] == 0;
    }

    public function solrDeleteDocument($id)
    {
        $solr_api = config('custom.solr_api');
        try {
            Http::accept('application/json')
                ->withBody("commit=true&stream.body=<delete><id>$id</id></delete>", 'application/x-www-form-urlencoded')
                ->post($solr_api . '/techproducts/update');
        } catch (ConnectionException $e) {

        }
    }

    /**
     * Image Extract
     * @param $content
     * @param $filename
     * @return UploadedFile[]
     */
    public function extractImages($content, $filename)
    {
        $extract_image_api = config('custom.extract_image_api');

        try {
            $response = Http::accept('application/json')
                ->attach('userfile', $content, $filename)
                ->post($extract_image_api, [
                    'method' => 'extract',
                ]);
        } catch (ConnectionException $e) {
            return [];
        }

        $result = $response->json();
        $images = [];

        if (!isset($result['images'])) {
            return $images;
        }

        $base_url = $result['url'];
        foreach ($result['images'] as $num => $name) {
            $images[] = self::createFileObject($base_url . $name);
        }
        return $images;
    }

    public function solrAddImage($content, $filename, $id)
    {
        $extract_image_api = config('custom.extract_image_api');

        try {
            $response = Http::accept('application/json')
                ->attach('userfile', $content, $filename)
                ->post($extract_image_api, [
                    'method' => 'indexSendFile',
                    'fileid' => $id
                ]);
        } catch (ConnectionException $e) {
            return false;
        }

        $responseStr = json_encode($response->json());
        return preg_match('/"status.?"\>0\</uim', $responseStr);
    }

    public function solrDeleteImage($id, $ext)
    {
        $solr_api = config('custom.extract_image_api');
        try {
            $response = Http::accept('application/json')
                ->withBody(http_build_query([
                    'method' => 'deleteImage',
                    'mid' => "/var/www/html/img/upload/$id/$id.$ext",
                ]), 'application/x-www-form-urlencoded')
                ->post($solr_api);
        } catch (ConnectionException $e) {
            return false;
        }
        $responseStr = json_encode($response->json());
        return preg_match('/"status.?"\>0\</uim', $responseStr);
    }

    public function solrSearchImage($url)
    {
        $solr_api = config('custom.solr_api');

        $params = [
            "fl" => "*,score",
            "accuracy" => 0.99,
            "rows" => 1000,
            "url" => $url,
            "field" => "ce_ha",
            "ms" => "false",
        ];
        try {
            $response = Http::accept('application/json')
                ->withBody(http_build_query($params), 'application/x-www-form-urlencoded')
                ->post($solr_api . '/imglib/lireq');
        } catch (ConnectionException $e) {
            return [];
        }

        $result = $response->json();

        if (isset($result['Error'])) {
            return [
                'error' => $result['Error'],
                'code' => 500,
            ];
        }

        $found = [];
        foreach ($result['response']['docs'] as $doc) {
            $id = preg_match('/.+\/(\d+)/uim', $doc['id'], $match) ? $match[1] : null;
            if ($id != null) {
                $image = Document::find($id);
                if ($image) {
                    $material = Material::query()
                        ->leftJoin('material_images', 'materials.file_id', '=', 'material_images.file_id')
                        ->where('material_images.image_id', '=', $id)
                        ->orWhere('materials.file_id', '=', $id)
                        ->select('materials.*')->first();
                    if ($material) {
                        $found[] = [
                            'id' => $id,
                            'score' => $doc['score'],
                            'image' => $image,
                            'material' => $material
                        ];
                    }
                }
            }
        }

        return $found;
    }

    public function tesseractExtractText($content, $filename)
    {
        $extract_image_api = config('custom.extract_image_api');
        $number = Random::generate(10, '0-9');
        try {
            $response = Http::accept('text/html')
                ->attach('userfile', $content, $filename)
                ->post($extract_image_api, [
                    'method' => 'extractSendFile',
                    'lang' => 'rus+kir',
                    'fileid' => $number,
                ]);
        } catch (ConnectionException $e) {
            return null;
        }

        return $response->body();
    }

    public function percent($num, $total)
    {
        if ($total > 0) {
            return ($num * 100) / $total;
        } else {
            return 0;
        }
    }

    public function groupBy($data, $key = null)
    {
        $result = array();
        foreach ($data as $element) {
            if (is_array($element))
                $result[mb_strtolower($element[$key])][] = $element;
            elseif (is_object($element))
                $result[mb_strtolower($element->$key)][] = $element;
            else
                $result[mb_strtolower($element)][] = $element;

        }
        return array_values($result);
    }

    public function mb_substr_replace($original, $replacement, $position, $length)
    {
        $startString = mb_substr($original, 0, $position, "UTF-8");
        $endString = mb_substr($original, $position + $length, mb_strlen($original), "UTF-8");

        $out = $startString . $replacement . $endString;

        return $out;
    }

    public function analyzeContent($text, $material_id)
    {
        set_time_limit(3600);

        // Удаляем
        MaterialWord::where('material_id', '=', $material_id)->delete();

        $collocations = self::wordCollocation($text);

        foreach ($collocations as $wordCount => $wordGroup) {
            foreach ($wordGroup as $positions) {
                $word = $positions[0][0];
                $marker_word = MarkerWord::firstWhere('word', '=', $word);
                if (empty($marker_word)) {
                    $marker_word = MarkerWord::create([
                        'word' => $word,
                        'type_id' => 1,
                        'word_count' => $wordCount,
                    ]);
                }
                $material_word = MaterialWord::firstWhere(['material_id' => $material_id, 'word_id' => $marker_word->id]);
                if (empty($material_word)) {
                    $material_word = MaterialWord::create([
                        'material_id' => $material_id,
                        'word_id' => $marker_word->id,
                        'type_id' => $marker_word->type_id,
                        'frequency' => count($positions),
                    ]);
                } else {
                    $marker_word->frequency += count($positions);
                }
                foreach ($positions as $position) {
                    MaterialWordPosition::create([
                        'material_word_id' => $material_word->id,
                        'position' => $position[1]
                    ]);
                }
            }
        }
    }

    public function wordCollocation($text)
    {
        $regexWord = '[^  "”“:;.·,\[\]\(\)\_\r\n\t<>{}?!؟؛۔،]+';
        $regexSpace = '[ \t\r\n ]+';
        preg_match_all('/' . $regexWord . '/uim', $text, $matches, PREG_OFFSET_CAPTURE);

        $collocations = [];
        $collocations[1] = AppHelper::groupBy($matches[0], 0);
        $collocations[2] = [];
        $collocations[3] = [];
        foreach ($collocations[1] as &$word) {
            foreach ($word as &$position) {
                $position[1] = mb_strlen(substr($text, 0, $position[1]));
                $pos = $position[1] + mb_strlen($position[0]);
                $substring = mb_substr($text, $pos, 500, 'UTF-8');
                if (preg_match('/^(' . $regexSpace . $regexWord . ')(' . $regexSpace . $regexWord . ')?/ui', $substring, $match)) {
                    if (!empty($match[1])) {
                        $collocations[2][] = [$position[0] . ' ' . $match[1], $position[1]];
                    }
                    if (!empty($match[2])) {
                        $collocations[3][] = [$position[0] . ' ' . $match[1] . ' ' . $match[2], $position[1]];
                    }
                }
            }
        }
        $collocations[2] = AppHelper::groupBy($collocations[2], 0);
        $collocations[3] = AppHelper::groupBy($collocations[3], 0);

        return $collocations;
    }

    public function getFieldRelationship($model, $fieldname)
    {
        $method1 = str_replace('_id', '', $fieldname);
        $method2 = preg_replace_callback('/_(.)/uim', function ($match) {
            return strtoupper($match[1]);
        }, str_replace('_id', '', $fieldname));
        if (method_exists($model, $method1)) {
            return $model->{$method1}();
        } elseif (method_exists($model, $method2)) {
            return $model->{$method2}();
        }

        return null;
    }

    /**
     * @param $path
     * @param bool $test
     * @return UploadedFile
     */
    public static function pathToUploadedFile($path, $test = true): UploadedFile
    {
        $filesystem = new Filesystem;

        $name = $filesystem->name($path);
        $extension = $filesystem->extension($path);
        $originalName = $name . '.' . $extension;
        $mimeType = $filesystem->mimeType($path);
        $error = null;

        return new UploadedFile($path, $originalName, $mimeType, $error, $test);
    }
}
