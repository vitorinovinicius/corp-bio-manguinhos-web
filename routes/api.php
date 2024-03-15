<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'occurrences','namespace' => 'Api', 'middleware' => ['cors','auth:api', 'tenant', 'bindings']], function () {

    Route::get("/opened", ["as" => "api.occurrences.listOpenedOccurrences", "uses" => "OccurrenceController@getOccurrenceOpenedByOperator"]);
    Route::get("/prevision", ["as" => "api.occurrences.listPrevisionByOperator", "uses" => "OccurrenceController@getPrevisionByOperator"]);
    Route::get("/opened_force", ["as" => "api.occurrences.listOpenedForceOccurrences", "uses" => "OccurrenceController@getOccurrenceOpenedByOperatorForce"]);

    Route::get("/executed", ["as" => "api.occurrences.listOpenedOccurrences", "uses" => "OccurrenceController@getOccurrenceExecutedByOperator"]);

    Route::post("/update", ["as" => "api.occurrences.occurrenceDataBasic.store", "uses" => "OccurrenceController@updateOccurrenceApi"]);
    Route::post("/notRealized", ["as" => "api.occurrences.occurrenceDataBasic.notRealized", "uses" => "OccurrenceController@addNewNotRealizedOccurrence"]);
    Route::post("/upload-image", ["as" => "api.occurrences.image.store", "uses" => "OccurrenceController@addNewOccurrenceImageApi"]);

    Route::post("/received", ["as" => "api.occurrences.received", "uses" => "OccurrenceController@updateOccurrencesStatus"]);
    Route::post("/store-manual-occurrence", ["as" => "api.occurrences.store_manual_occurrence", "uses" => "OccurrenceController@storeManualOccurrence"]);
    Route::post("/finish-work-day", ["as" => "api.occurrences.finish_work_day", "uses" => "OccurrenceController@storeFinishWorkDay"]);
    Route::post("/update-order-os", ["as" => "api.occurrences.update_order_os", "uses" => "OccurrenceController@storeOrderOs"]);

});

Route::group(['prefix' => 'app','namespace' => 'Api', 'middleware' => ['cors']], function () {
    Route::get("/atualizaApp/{version}", ["as" => "api.app.update", "uses" => "AppController@atualizaApp"]);
});

Route::group(['prefix' => 'config',
    'namespace' => 'Api',
    'middleware' => ['cors','auth:api', 'tenant', 'bindings']
], function () {
    Route::get("/full", ["as" => "api.config.full", "uses" => "ConfigController@getFullConfig"]);
    Route::get("/cancel-status", ["as" => "api.config.cancel.status", "uses" => "CancelamentoStatusController@download"]);
    Route::get("/all-pecas", ["as" => "api.pecas.all", "uses" => "ConfigController@getPecas"]);
    Route::get("/all-servicos", ["as" => "api.servicos.all", "uses" => "ConfigController@getServicos"]);
    Route::get("/all-documentos", ["as" => "api.documentos.all", "uses" => "ConfigController@getDocumentos"]);
    Route::get("/all-occurrence-types", ["as" => "api.occurrence_types.all", "uses" => "ConfigController@getOsType"]);
    Route::get("/all-interferences", ["as" => "api.interferences.all", "uses" => "ConfigController@getInterferences"]);
    Route::post("/getVersions", ["as" => "api.form.versions", "uses" => "FormController@getVersions"]);
    Route::get("/all-expense-types", ["as" => "api.expense_types.all", "uses" => "ConfigController@getExpenseTypes"]);
});
Route::group(['prefix' => 'clients','namespace' => 'Api', 'middleware' => ['cors','auth:api', 'tenant', 'bindings']], function () {
    Route::post("/find-client", ["as" => "api.client.findClient", "uses" => "ClientController@findClient"]);

});

Route::group(['prefix' => 'checklist-vehicle','namespace' => 'Api', 'middleware' => ['cors','auth:api', 'tenant', 'bindings']], function () {
    Route::get("/check", ["as" => "api.checklist_vehicle.check", "uses" => "CheckListVehicleController@check"]);
    Route::post("/store", ["as" => "api.checklist_vehicle.store", "uses" => "CheckListVehicleController@store"]);
    Route::post("/store-image", ["as" => "api.checklist_vehicle.store_image", "uses" => "CheckListVehicleController@storeImage"]);
});

Route::group(['prefix' => 'services','namespace' => 'Api','middleware' => ['cors','auth:api', 'tenant', 'bindings']], function () {
    Route::get('/find-cep/{CEP?}', ["as"=>"api.find.cep","uses" => "ServicesController@findCep"]);
});
Route::group(['prefix' => 'operator','namespace' => 'Api', 'middleware' => ['cors','auth:api']], function () {
    Route::post("/updateLocation", ["as" => "api.operator.updateLocation", "uses" => "OperatorController@updateLocation"]);
    Route::get("/verifyIsOperator", ["as" => "api.operator.verifyIsOperator", "uses" => "OperatorController@verifyIsOperator"]);
    Route::post("/save-move", ["as" => "api.operator.saveMove", "uses" => "OperatorController@saveMove"]);
    Route::post("/update-profile", ["as" => "api.operator.updateProfile", "uses" => "OperatorController@updateProfile"]);

});

Route::group(['prefix' => 'forms','namespace' => 'Api', 'middleware' => ['cors','auth:api', 'tenant', 'bindings']], function () {
    Route::post("/getForms", ["as" => "api.form.getForms", "uses" => "FormController@getForms"]);
});

Route::group(['prefix' => 'log','namespace' => 'Api', 'middleware' => ['cors']], function () {
    Route::post("/updateLog", ["as" => "api.app.updateLog", "uses" => "LogController@updateLog"]);
});

Route::group(['prefix' => 'helper', 'middleware' => ['cors']], function () {
    Route::get("/get_address_rep/{CEP}", ["as" => "api.helper.get_address_rep", "uses" => "HelperController@getAddressToCepRepulica"]);
});

    Route::group(['prefix' => 'expenses','namespace' => 'Api', 'middleware' => ['cors']], function () {
        Route::post("/", ["as" => "api.expense.list", "uses" => "ExpenseController@list"]);
        Route::post("/store", ["as" => "api.expense.store", "uses" => "ExpenseController@store"]);
        Route::post("/image/store", ["as" => "api.expense.image.store", "uses" => "ExpenseController@imageStore"]);
    });
/*\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
});*/
