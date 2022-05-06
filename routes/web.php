<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('generate-docx', [\App\Http\Controllers\HomeController::class, 'generateDocx']);
Route::get('template-docx', [\App\Http\Controllers\HomeController::class, 'templateDocx']);
Route::get('view-file/{name_uuid}', [\App\Http\Controllers\DocumentController::class, 'view'])->name('view-file');

Route::group(['middleware' => ['auth']], function () {
    Route::get('download-file/{name_uuid}', [\App\Http\Controllers\DocumentController::class, 'download'])->name('download-file');
    Route::view('profile', 'profile.show')->name('profile.show');
    Route::view('editProfile', 'profile.edit')->name('profile.edit');
    Route::patch('profile-update', [\App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::resource('expertise', \App\Http\Controllers\ExpertiseController::class);
    Route::get('index-by-expert/{user}', [\App\Http\Controllers\ExpertiseController::class, 'indexByExpert'])->name('index.by.expert');
    Route::resource('materials', \App\Http\Controllers\MaterialController::class);
    Route::resource('tasks', \App\Http\Controllers\ExpertiseTaskController::class, ['as' => 'expertise']);
    Route::resource('conclusions', \App\Http\Controllers\MaterialConclusionController::class, ['as' => 'materials']);
    Route::resource('material/decisions', \App\Http\Controllers\MaterialDecisionController::class, ['as' => 'materials']);
    Route::resource('material/analyzes', \App\Http\Controllers\MaterialAnalyzeController::class, ['as' => 'materials']);
    Route::get('material/analyze', [\App\Http\Controllers\MaterialAnalyzeController::class, 'analyze'])->name('materials.analyzes.analyze');
    Route::post('material/analyze/extract', [\App\Http\Controllers\MaterialAnalyzeController::class, 'extract'])->name('materials.analyzes.extract');
    Route::post('material/analyze/search', [\App\Http\Controllers\MaterialAnalyzeController::class, 'search'])->name('materials.analyzes.search');
    Route::get('material/analyze/search/get', [\App\Http\Controllers\MaterialAnalyzeController::class, 'search_data'])->name('materials.analyzes.search.get');
    Route::post('material/analyze/get_detail', [\App\Http\Controllers\MaterialAnalyzeController::class, 'get_detail'])->name('materials.analyzes.get_detail');
    Route::post('material/analyze/save', [\App\Http\Controllers\MaterialAnalyzeController::class, 'save_analyze'])->name('materials.analyzes.save');
    Route::get('/material/{id}/images', [\App\Http\Controllers\MaterialImagesController::class, 'images'])->name('materials.images');
    Route::get('/material/{id}/images/search', [\App\Http\Controllers\MaterialImagesController::class, 'search'])->name('materials.images.search');
    Route::get('/material/{id}/images/get_detail', [\App\Http\Controllers\MaterialImagesController::class, 'get_detail'])->name('materials.images.get_detail');
    Route::post('/material/{id}/images/save', [\App\Http\Controllers\MaterialImagesController::class, 'save_analyze'])->name('materials.images.save');
    Route::resource('petitions', \App\Http\Controllers\ExpertisePetitionController::class, ['as' => 'expertise']);
    Route::resource('decisions', \App\Http\Controllers\ExpertiseDecisionController::class, ['as' => 'expertise']);
    Route::resource('contractors', \App\Http\Controllers\ContractorController::class, ['as' => 'modules']);
    Route::resource('subjects', \App\Http\Controllers\SubjectController::class, ['as' => 'modules']);
    Route::resource('nicknames', \App\Http\Controllers\SubjectNicknameController::class, ['as' => 'modules']);
    Route::resource('expertiseArticles', \App\Http\Controllers\ExpertiseArticleController::class, ['as' => 'modules']);
    Route::resource('entities', \App\Http\Controllers\EntityController::class, ['as' => 'modules']);
    Route::resource('entity_forbidden', \App\Http\Controllers\EntityForbiddenController::class, ['as' => 'modules']);
    Route::resource('marker_black_words', \App\Http\Controllers\MarkerBlackWordController::class, ['as' => 'modules']);
    Route::resource('marker_words', \App\Http\Controllers\MarkerWordController::class, ['as' => 'modules']);
    Route::get('/material/{id}/content', [\App\Http\Controllers\MaterialContentController::class, 'content'])->name('materials.content');
    Route::get('/material/{id}/content/highlight', [\App\Http\Controllers\MaterialContentController::class, 'highlight'])->name('materials.content.highlight');
    Route::post('/material/{id}/content/move_word', [\App\Http\Controllers\MaterialContentController::class, 'move_word'])->name('materials.content.move_word');
    Route::get('/material/marker_words', [\App\Http\Controllers\MaterialContentController::class, 'marker_words'])->name('materials.marker_words');
    Route::post('/getDeclensions', [\App\Http\Controllers\MarkerWordController::class, 'getDeclensions'])->name('getDeclensions');
    Route::post('/getContractors', [\App\Http\Controllers\ContractorController::class, 'ajaxGetContractors'])->name('getContractors');
    Route::post('/getCovers', [\App\Http\Controllers\ContractorController::class, 'ajaxGetCovers'])->name('getCovers');
    Route::resource('templates', \App\Http\Controllers\TemplatesController::class, ['as' => 'modules']);
    Route::resource('histories', \App\Http\Controllers\HistoryController::class)->only('index');
    Route::resource('security/roles', \App\Http\Controllers\RoleController::class, ['as' => 'security']);
    Route::resource('security/users', \App\Http\Controllers\UserController::class, ['as' => 'security']);
    Route::get('reports/generate', [\App\Http\Controllers\ReportsController::class, 'generate'])->name('modules.reports.generate');
    Route::resource('reports', \App\Http\Controllers\ReportsController::class, ['as' => 'modules']);
    Route::resource('settings/reports', \App\Http\Controllers\SettingReportController::class, ['as' => 'settings']);
    Route::group(['prefix' => 'material-modal', 'as' => 'material.modal.'], function () {
        Route::resource('conclusions', App\Http\Controllers\AjaxCRUDs\Materials\MaterialExpertConclusionController::class);
        Route::resource('decisions', App\Http\Controllers\AjaxCRUDs\Materials\MaterialJudgesDecisionController::class);
        Route::resource('expertise', App\Http\Controllers\AjaxCRUDs\Materials\MaterialExpertiseController::class)
            ->only('index', 'show');
        Route::resource('material-analyzes', \App\Http\Controllers\AjaxCRUDs\Materials\MaterialAnalyzeMaterialController::class)
            ->except('create', 'store');
        Route::resource('material-analyzes-images', \App\Http\Controllers\AjaxCRUDs\Materials\MaterialAnalyzeImageController::class)
            ->except('create', 'store');
    });
    Route::group(['prefix' => 'expertise-modal', 'as' => 'expertise.modal.'], function () {
        Route::resource('expert-tasks', App\Http\Controllers\AjaxCRUDs\Expertise\ExpertiseTaskExpertController::class);
        Route::resource('conclusions', App\Http\Controllers\AjaxCRUDs\Expertise\ExpertiseExpertConclusionController::class);
        Route::resource('decisions', App\Http\Controllers\AjaxCRUDs\Expertise\ExpertiseJudgesDecisionController::class);
        Route::resource('petitions', \App\Http\Controllers\AjaxCRUDs\Expertise\ExpertisePetitionController::class);
        Route::resource('materials', \App\Http\Controllers\AjaxCRUDs\Expertise\ExpertiseMaterialController::class);
    });
    Route::resource('modal-contractors', App\Http\Controllers\AjaxCRUDs\ModalCoverController::class)->only('create', 'store');
    Route::resource('modal-cover', App\Http\Controllers\AjaxCRUDs\ModalCoverController::class)->only('create', 'store');
    Route::resource('modal-subject', App\Http\Controllers\AjaxCRUDs\ModalSubjectController::class)->only('create', 'store');
    Route::group(['middleware' => ['permission:queue-monitor']], function () {
        Route::prefix('jobs')->group(function () {
            Route::queueMonitor();
        });
    });
    Route::get('export-expertises', [\App\Http\Controllers\ExportExpertiseController::class, 'index'])->name('new-index');
    Route::get('export-materials', [\App\Http\Controllers\ExportMaterialsController::class, 'index'])->name('export-materials');
});

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
