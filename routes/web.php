<?php

use Artesaos\Defender\Facades\Defender;

Route::get('/', function () {
//    return view('auth.login');
    return redirect()->route('login');
});
Auth::routes();

// Route::get('/home', function(){
//     if(Defender::hasRole('cliente')){
//         return redirect()->route('client.index');
//     }else{
//         return redirect()->route('admin.index');
//     }
// });
Route::get('/home', function(){
    return redirect()->route('word.index');
});

Route::group(['prefix' => 'word','middleware'=>['auth','systemConfiguration', 'checkStatus', 'authUnique', 'tenant', 'bindings']], function () {
    Route::get('/', ["as"=>"word.index","uses" => "WordController@index",'middleware'=>['needsPermission'], 'shield' => 'admin.index']);
    Route::get('/show/{document}', ["as"=>"word.show","uses" => "WordController@show",'middleware'=>['needsPermission'], 'shield' => 'admin.show']);
    Route::get('/create', ["as"=>"word.create","uses" => "WordController@create",'middleware'=>['needsPermission'], 'shield' => 'admin.create']);
    Route::get('/store', ["as"=>"word.store","uses" => "WordController@store",'middleware'=>['needsPermission'], 'shield' => 'admin.store']);
    Route::get('/edit/{document}', ["as"=>"word.edit","uses" => "WordController@edit",'middleware'=>['needsPermission'], 'shield' => 'admin.edit']);
    Route::put('/update', ["as"=>"word.update","uses" => "WordController@update",'middleware'=>['needsPermission'], 'shield' => 'admin.update']);
    Route::delete('/delete/{document}', ["as"=>"word.delete","uses" => "WordController@delete",'middleware'=>['needsPermission'], 'shield' => 'admin.destroy']);
});



// Route::get('/sms/envia/status', ["as"=>"sms.envia.status",'middleware'=>['bindings'],"uses" => "SmsController@recebeStatus"]);
// Route::get('/sms/envia/{occurrence}', ["as"=>"sms.envia",'middleware'=>['bindings'],"uses" => "SmsController@enviaSms"]);
// Route::get('/pdf/{occurrence}/{image?}/{formId?}', ["as"=>"admin.occurrences.show.pdf",'middleware'=>['bindings'], "uses" => "PdfController@getPdfOccurence"]);
// Route::get('/tracert/occurrence/{occurrence}', ["as"=>"occurrences.tracert",'middleware'=>['bindings'], "uses" => "OccurrenceController@showClient"]);
// Route::get('/redirect/{id}', ["as"=>"occurrences.redirect",'middleware'=>['bindings'],"uses" => "RedirectController@redirect_minify"]);
// Route::get('/vehicles-checklist/pdf/{checklist_vehicle}', ["as"=>"admin.vehicles.checklist.show.pdf",'middleware'=>['bindings'], "uses" => "PdfController@getPdfChecklistVehicle"]);
// Route::get('/repayment/pdf', ["as"=>"admin.repayment.show.pdf",'middleware'=>['bindings'], "uses" => "PdfController@getPdfRepayment"]);

// //EVALUATION
// Route::get('/evaluation/{occurrence}', ['as'=>'evaluation.create', "uses"=>"EvaluationController@create", 'middleware'=>['bindings']]);
// Route::post('/evaluation', ['as'=>'evaluation.store', "uses"=>"EvaluationController@store"]);

Route::group(['prefix' => 'admin','middleware'=>['auth','systemConfiguration', 'checkStatus', 'authUnique', 'tenant', 'bindings']], function () {

//     Route::get('/', ["as"=>"admin.index","uses" => "AdminController@monitoring",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);
//     Route::get('/monitoring', ["as"=>"admin.monitoring","uses" => "AdminController@monitoring",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);
//     Route::get('/monitoring_centralsystem', ["as"=>"admin.monitoring_nts","uses" => "AdminController@dashboard_nts",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring_nts']);
//     Route::get('/dashboard', ["as"=>"admin.dashboard","uses" => "AdminController@dashboard",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);
//     Route::get('/technical', ["as"=>"admin.technical","uses" => "AdminController@monitoring",'middleware'=>['needsPermission'], 'shield' => 'admin.technical']);
//     Route::get('/group-user', ["as"=>"group_user.index","uses" => "GroupUserControler@index",'middleware'=>['needsPermission'], 'shield' => 'group_user.index']);

//     //AJAX
//     Route::get('/dashboard/list', ["as"=>"admin.dashboard.list","uses" => "AdminController@table_list",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);
//     Route::get('/dashboard_tickets/list', ["as"=>"admin.dashboard_tickets.list","uses" => "AdminController@table_tickets_list",'middleware'=>['needsPermission']]);
//     Route::get('/dashboard/ajax', ["as"=>"admin.dashboard.ajax","uses" => "AdminController@dashboard_ajax",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);
//     Route::get('/dashboard_tikets/ajax', ["as"=>"admin.dashboard_tikets.ajax","uses" => "AdminController@dashboard_tikets_ajax",'middleware'=>['needsPermission']]);
//     Route::get('/dashboard/technical_maps', ["as"=>"admin.dashboard.technical_maps","uses" => "AdminController@technical_maps",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);
//     Route::get('/dashboard/os_maps', ["as"=>"admin.dashboard.os_maps","uses" => "AdminController@os_maps",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);


//     //APP_VERSION
// //    Route::resource("app_versions","AppVersionController"); // Add this line in routes.php
//     Route::get('/app_versions', ["as"=>"app_versions.index","uses" => "AppVersionController@index"]);
//     Route::get('/app_versions/create', ["as"=>"app_versions.create","uses" => "AppVersionController@create",'middleware'=>['needsPermission'], 'shield' => 'app_version.create']);
//     Route::post('/app_versions', ["as"=>"app_versions.store","uses" => "AppVersionController@store"]);
//     Route::get('/app_versions/{app_version}', ["as"=>"app_versions.show","uses" => "AppVersionController@show",'middleware'=>['needsPermission'], 'shield' => 'app_version.show']);
//     Route::put('/app_versions/{app_version}', ["as"=>"app_versions.update","uses" => "AppVersionController@update"]);
//     Route::get('/app_versions/{app_version}/edit', ["as"=>"app_versions.edit","uses" => "AppVersionController@edit",'middleware'=>['needsPermission'], 'shield' => 'app_version.edit']);
//     Route::delete('/app_versions/{app_version}', ["as"=>"app_versions.destroy","uses" => "AppVersionController@destroy",'middleware'=>['needsPermission'], 'shield' => 'app_version.destroy']);
//     Route::get("/app_versions/status/{app_version}/{status}",["as"=>"app_versions.status","uses" => "AppVersionController@status"]); // Add this line in routes.php

//     //STATUS DO CANCELAMENTO
// //    Route::resource("unrealizeds","CancelamentoStatusController");
//     Route::get('/unrealizeds', ["as"=>"cancelamento_statuses.index","uses" => "CancelamentoStatusController@index",'middleware'=>['needsPermission'], 'shield' => 'cancelamento_status.index']);
//     Route::get('/unrealizeds/create', ["as"=>"cancelamento_statuses.create","uses" => "CancelamentoStatusController@create",'middleware'=>['needsPermission'], 'shield' => 'cancelamento_status.create']);
//     Route::post('/unrealizeds', ["as"=>"cancelamento_statuses.store","uses" => "CancelamentoStatusController@store",'middleware'=>['needsPermission'], 'shield' => 'cancelamento_status.create']);
//     Route::get('/unrealizeds/{cancelamento_status}', ["as"=>"cancelamento_statuses.show","uses" => "CancelamentoStatusController@show",'middleware'=>['needsPermission'], 'shield' => 'cancelamento_status.show']);
//     Route::get('/unrealizeds/{cancelamento_status}/edit', ["as"=>"cancelamento_statuses.edit","uses" => "CancelamentoStatusController@edit",'middleware'=>['needsPermission'], 'shield' => 'cancelamento_status.edit']);
//     Route::put('/unrealizeds/{cancelamento_status}', ["as"=>"cancelamento_statuses.update","uses" => "CancelamentoStatusController@update",'middleware'=>['needsPermission'], 'shield' => 'cancelamento_status.edit']);
//     Route::delete('/unrealizeds/{cancelamento_status}', ["as"=>"cancelamento_statuses.destroy","uses" => "CancelamentoStatusController@destroy",'middleware'=>['needsPermission'], 'shield' => 'cancelamento_status.destroy']);

    //CONFIGURATION
    Route::get('/configuration', ["as"=>"configuration.index","uses" => "ConfigurationController@indexUnique",'middleware'=>['needsPermission'], 'shield' => 'configuration.index']);
    Route::post('/configuration', ["as"=>"configuration.store","uses" => "ConfigurationController@storeUnique",'middleware'=>['needsPermission'], 'shield' => 'configuration.store']);

    //CONFIGURATIONS
//    Route::resource("configurations","ConfigurationController");
    Route::get('/configurations', ["as"=>"configurations.index","uses" => "ConfigurationController@index",'middleware'=>['needsPermission'], 'shield' => 'configuration.index']);
    Route::get('/configurations/create', ["as"=>"configurations.create","uses" => "ConfigurationController@create",'middleware'=>['needsPermission'], 'shield' => 'configuration.create']);
    Route::post('/configurations', ["as"=>"configurations.store","uses" => "ConfigurationController@store",'middleware'=>['needsPermission'], 'shield' => 'configuration.create']);
    Route::get('/configurations/{configuration}', ["as"=>"configurations.show","uses" => "ConfigurationController@show",'middleware'=>['needsPermission'], 'shield' => 'configuration.show']);
    Route::get('/configurations/{configuration}/edit', ["as"=>"configurations.edit","uses" => "ConfigurationController@edit",'middleware'=>['needsPermission'], 'shield' => 'configuration.edit']);
    Route::put('/configurations/{configuration}', ["as"=>"configurations.update","uses" => "ConfigurationController@update",'middleware'=>['needsPermission'], 'shield' => 'configuration.edit']);
    Route::delete('/configurations/{configuration}', ["as"=>"configurations.destroy","uses" => "ConfigurationController@destroy",'middleware'=>['needsPermission'], 'shield' => 'configuration.destroy']);


    //Usuários
    //    Route::resource("users", "UserController");
    Route::get('/users', ["as"=>"users.index","uses" => "UserController@index",'middleware'=>['needsPermission'], 'shield' => 'users.index']);
    Route::get('/users/client', ["as"=>"users.clients","uses" => "UserController@clients",'middleware'=>['needsPermission'], 'shield' => 'users.index']);
    Route::get('/users/create', ["as"=>"users.create","uses" => "UserController@create",'middleware'=>['needsPermission'], 'shield' => 'users.create']);
    Route::post('/users', ["as"=>"users.store","uses" => "UserController@store"]);
    Route::get('/users/{user}', ["as"=>"users.show","uses" => "UserController@show",'middleware'=>['needsPermission'], 'shield' => 'users.show']);
    Route::put('/users/theme_color_update/', ["as"=>"users.themeColor","uses" => "UserController@updateThemeColor"]);
    Route::put('/users/{user}', ["as"=>"users.update","uses" => "UserController@update"]);
    Route::get('/users/{user}/edit', ["as"=>"users.edit","uses" => "UserController@edit",'middleware'=>['needsPermission'], 'shield' => 'users.edit']);
    Route::delete('/users/{user}', ["as"=>"users.destroy","uses" => "UserController@destroy",'middleware'=>['needsPermission'], 'shield' => 'users.destroy']);
    Route::get('/users/change_password/{user}', ["as"=>"users.change_password","uses" => "UserController@changePassword",'middleware'=>['needsPermission'], 'shield' => 'users.change_password']);
    Route::put('/users/update_password/{user}', ["as"=>"users.update_password","uses" => "UserController@updatePassword",'middleware'=>['needsPermission'], 'shield' => 'users.change_password']);

    //CONTRACTOR
    //    Route::resource("contractors", "ContractorController");
//     Route::get('/contractors', ["as"=>"contractors.index","uses" => "ContractorController@index",'middleware'=>['needsPermission'], 'shield' => 'contractor.index']);
//     Route::post('/contractors/mail/{contractor}', ["as"=>"mails.test_envio_email","uses" => "MailController@test_send_email",'middleware'=>['needsPermission'], 'shield' => 'occurrence.index']);
//     Route::get('/contractors/create', ["as"=>"contractors.create","uses" => "ContractorController@create",'middleware'=>['needsPermission'], 'shield' => 'contractor.create']);
//     Route::post('/contractors', ["as"=>"contractors.store","uses" => "ContractorController@store",'middleware'=>['needsPermission'], 'shield' => 'contractor.create']);
//     Route::get('/contractors/show', ["as"=>"contractors.admin.show","uses" => "ContractorController@admimShow",'middleware'=>['needsPermission'], 'shield' => 'contractor.show']);
//     Route::get('/contractors/edit', ["as"=>"contractors.admin.edit","uses" => "ContractorController@adminEdit",'middleware'=>['needsPermission'], 'shield' => 'contractor.edit']);
//     Route::put('/contractors/edit', ["as"=>"contractors.admin.update","uses" => "ContractorController@adminUpdate",'middleware'=>['needsPermission'], 'shield' => 'contractor.edit']);
//     Route::get('/contractors/{contractor}', ["as"=>"contractors.show","uses" => "ContractorController@show",'middleware'=>['needsPermission'], 'shield' => 'contractor.show']);
//     Route::put('/contractors/{contractor}', ["as"=>"contractors.update","uses" => "ContractorController@update",'middleware'=>['needsPermission'], 'shield' => 'contractor.edit']);
//     Route::get('/contractors/{contractor}/edit', ["as"=>"contractors.edit","uses" => "ContractorController@edit",'middleware'=>['needsPermission'], 'shield' => 'contractor.edit']);
//     Route::delete('/contractors/{contractor}', ["as"=>"contractors.destroy","uses" => "ContractorController@destroy",'middleware'=>['needsPermission'], 'shield' => 'contractor.destroy']);

//     //Ocorrências - Derivados
//     Route::get('/occurrences/mail/{occurrence}', ["as"=>"admin.occurrences.sendMail","uses" => "OccurrenceController@sendMail",'middleware'=>['needsPermission'], 'shield' => 'occurrence.show']);
//     Route::get('/occurrences/pdf/{occurrence}/{image?}/{formId?}', ["as"=>"admin.occurrences.pdfGenerate","uses" => "OccurrenceController@pdfGenerate",'middleware'=>['needsPermission'], 'shield' => 'occurrence.show']);
//     Route::get('/occurrences/export/{id}', ["as"=>"admin.occurrences.export","uses" => "OccurrenceController@export",'middleware'=>['needsPermission'], 'shield' => 'occurrence.export']);
//     Route::get('/occurrences/pending', ["as"=>"admin.occurrences.pending","uses" => "OccurrenceController@pending",'middleware'=>['needsPermission'], 'shield' => 'occurrences.pending']);
//     Route::get('/occurrences/not_executed', ["as"=>"admin.occurrences.not_executed","uses" => "OccurrenceController@notExecuted",'middleware'=>['needsPermission'], 'shield' => 'occurrences.pending']);
//     Route::get('/occurrences/status_schedule', ["as"=>"admin.occurrences.status_schedule","uses" => "OccurrenceController@statusScheduleList",'middleware'=>['needsPermission'], 'shield' => 'occurrences.pending']);
//     Route::get('/occurrences/unassigned', ["as"=>"admin.occurrences.unassigned","uses" => "OccurrenceController@unassigned",'middleware'=>['needsPermission'], 'shield' => 'occurrences.unassigned']);
//     Route::get('/occurrences/closed', ["as"=>"admin.occurrences.closed","uses" => "OccurrenceController@closed",'middleware'=>['needsPermission'], 'shield' => 'occurrences.closed']);
//     Route::get('/occurrences/closed_unsolved', ["as"=>"admin.occurrences.closed_unsolved","uses" => "OccurrenceController@closedUnsolved",'middleware'=>['needsPermission'], 'shield' => 'occurrences.closed_unsolved']);
//     Route::post('/occurrences/store', ["as"=>"occurrences.associate.store","uses" => "OccurrenceController@associateStore",'middleware'=>['needsPermission'], 'shield' => 'occurrences.associate.store']);
//     Route::post('/occurrences/assigned_operator', ["as"=>"occurrences.associate.operator","uses" => "OccurrenceController@associateOperator",'middleware'=>['needsPermission'], 'shield' => 'occurrences.associate.operator']);
//     Route::post('/occurrences/images/download/', ["as"=>"occurrence.images.download","uses" => "DownloadController@downloadImageByOs"]);
//     Route::post('/occurrences/anexos/download/', ["as"=>"occurrence.anexos.download","uses" => "DownloadController@downloadAnexosByOs"]);
//     Route::post('/occurrences/status/schedule/', ["as"=>"occurrence.change.status_schedule","uses" => "OccurrenceController@statusSchedule"]);
//     Route::post('/occurrences/remove_file/', ["as"=>"occurrence.remove_file","uses" => "OccurrenceController@removeFile",'middleware'=>['needsPermission'], 'shield' => 'occurrence_image.destroy']);
//     Route::get('/occurrences/operators/ajax/{operator}', ["as" => "occurrence.operator.ajax", "uses" => "OccurrenceController@operatorAjax"]);
//     Route::get('/occurrences/uploadJson/{occurrence}', ["as" => "occurrence.upload.json", "uses" => "OccurrenceController@uploadJson"]);

//     //Occorrências - Derivadas do financeiro

//     Route::get('/occurrences/to_adjust', ["as"=>"admin.occurrences.to_adjust","uses" => "OccurrenceController@toAdjust",'middleware'=>['needsPermission'], 'shield' => 'occurrences.to_adjust']);
//     Route::get('/occurrences/to_approved', ["as"=>"admin.occurrences.to_approved","uses" => "OccurrenceController@toApproved",'middleware'=>['needsPermission'], 'shield' => 'occurrences.to_approved']);
//     Route::get('/occurrences/approved', ["as"=>"admin.occurrences.approved","uses" => "OccurrenceController@approved",'middleware'=>['needsPermission'], 'shield' => 'occurrences.approved']);
//     Route::get('/occurrences/adjusted', ["as"=>"admin.occurrences.adjusted","uses" => "OccurrenceController@adjusted",'middleware'=>['needsPermission'], 'shield' => 'occurrences.adjusted']);
//     Route::get('/occurrences/disapproved', ["as"=>"admin.occurrences.disapproved","uses" => "OccurrenceController@disapproved",'middleware'=>['needsPermission'], 'shield' => 'occurrences.disapproved']);

//     //OCCURRENCES
// //    Route::resource("occurrences","OccurrenceController");
//     Route::get('/occurrences', ["as"=>"occurrences.index","uses" => "OccurrenceController@index",'middleware'=>['needsPermission'], 'shield' => 'occurrence.index']);
//     Route::post('/occurrences', ["as"=>"occurrences.store","uses" => "OccurrenceController@store"]);
//     Route::get('/occurrences/create/{operator?}', ["as"=>"occurrences.create","uses" => "OccurrenceController@create",'middleware'=>['needsPermission'], 'shield' => 'occurrence.create']);
//     Route::get('/occurrences/create-subos/{occurrence}', ["as"=>"occurrences.create_subos","uses" => "OccurrenceController@createSubOs",'middleware'=>['needsPermission'], 'shield' => 'occurrence.create_subos']);
//     Route::get('/occurrences/{occurrence}', ["as"=>"occurrences.show","uses" => "OccurrenceController@show",'middleware'=>['needsPermission'], 'shield' => 'occurrence.show']);
//     Route::put('/occurrences/{occurrence}', ["as"=>"occurrences.update","uses" => "OccurrenceController@update"]);
//     Route::put('/occurrences/edit_client/{occurrence}', ["as"=>"occurrences.edit.client","uses" => "OccurrenceController@editClient",'middleware'=>['needsPermission'], 'shield' => 'occurrence.edit']);
//     Route::get('/occurrences/{occurrence}/edit', ["as"=>"occurrences.edit","uses" => "OccurrenceController@edit",'middleware'=>['needsPermission'], 'shield' => 'occurrence.edit']);
//     Route::get('/occurrences/{occurrence}/execute', ["as"=>"occurrences.execute","uses" => "OccurrenceController@execute",'middleware'=>['needsPermission'], 'shield' => 'occurrence.edit']);
//     Route::post('/occurrences/{occurrence}/execute', ["as"=>"occurrences.execute.create","uses" => "OccurrenceController@createExecute",'middleware'=>['needsPermission'], 'shield' => 'occurrence.edit']);
//     Route::delete('/occurrences/{occurrence}', ["as"=>"occurrences.destroy","uses" => "OccurrenceController@destroy",'middleware'=>['needsPermission'], 'shield' => 'occurrence.destroy']);

//     //ORDENAÇÃO OS
//     Route::get('/occurrence_order/route/{id}', ['as'=>'occurrence.order.route', 'uses'=>'OccurrenceOrderController@route', 'middleware'=>['needsPermission'], 'shield'=>'occurrences.edit']);
//     Route::put('/occurrence_order/order', ["as"=>"occurrence.order.order","uses" => "OccurrenceOrderController@order",'middleware'=>['needsPermission'], 'shield' => 'occurrences.order']);

//     Route::post('/occurrences/ajax', ["as"=>"occurrences.store.ajax","uses" => "OccurrenceController@storeAjax"]);
//     Route::post('/occurrences/update/ajax/', ["as"=>"occurrences.update.ajax","uses" => "OccurrenceController@updateAjax"]);

    //ROTEIRIZAÇÃO
    Route::get('/routing', ['as' => 'routing.index', 'uses' => 'RoutingController@index', 'middleware' => ['needsPermission'], 'shield' => 'routing.index']);

    //OCCURRENCE CLIENTS
//    Route::resource("occurrence_clients","OccurrenceClientController");
    // Route::get('/occurrence_clients', ["as"=>"occurrence_clients.index","uses" => "OccurrenceClientController@index",'middleware'=>['needsPermission'], 'shield' => 'occurrence_clients.index']);
    // Route::post('/occurrence_clients', ["as"=>"occurrence_clients.store","uses" => "OccurrenceClientController@store",'middleware'=>['needsPermission'], 'shield' => 'occurrence_clients.create']);
    // Route::get('/occurrence_clients/create', ["as"=>"occurrence_clients.create","uses" => "OccurrenceClientController@create",'middleware'=>['needsPermission'], 'shield' => 'occurrence_clients.create']);
    // Route::get('/occurrence_clients/{occurrence_client}', ["as"=>"occurrence_clients.show","uses" => "OccurrenceClientController@show",'middleware'=>['needsPermission'], 'shield' => 'occurrence_clients.show']);
    // Route::put('/occurrence_clients/{occurrence_client}', ["as"=>"occurrence_clients.update","uses" => "OccurrenceClientController@update",'middleware'=>['needsPermission'], 'shield' => 'occurrence_clients.edit']);
    // Route::get('/occurrence_clients/{occurrence_client}/edit', ["as"=>"occurrence_clients.edit","uses" => "OccurrenceClientController@edit",'middleware'=>['needsPermission'], 'shield' => 'occurrence_clients.edit']);
    // Route::delete('/occurrence_clients/{occurrence_client}', ["as"=>"occurrence_clients.destroy","uses" => "OccurrenceClientController@destroy",'middleware'=>['needsPermission'], 'shield' => 'occurrence_clients.destroy']);

    // //OCCURRENCE_TYPE
    // Route::get('/occurrence_type/client_ajax/{id}', ["as"=>"admin.occurrence_client.get_ajax","uses" => "OccurrenceClientController@getClientAjax"]);
    // Route::get('/occurrence_type/getClientAjaxSelect2', ["as"=>"occurrence_client.get_ajax_select2","uses" => "OccurrenceClientController@getClientAjaxSelect2"]);
    // Route::get('/occurrence_types', ["as"=>"occurrence_types.index","uses" => "OccurrenceTypeController@index",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.index']);
    // Route::post('/occurrence_types', ["as"=>"occurrence_types.store","uses" => "OccurrenceTypeController@store"]);
    // Route::get('/occurrence_types/create', ["as"=>"occurrence_types.create","uses" => "OccurrenceTypeController@create",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.create']);
    // Route::get('/occurrence_types/{occurrence_type}', ["as"=>"occurrence_types.show","uses" => "OccurrenceTypeController@show",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.show']);
    // Route::put('/occurrence_types/{occurrence_type}', ["as"=>"occurrence_types.update","uses" => "OccurrenceTypeController@update"]);
    // Route::get('/occurrence_types/{occurrence_type}/edit', ["as"=>"occurrence_types.edit","uses" => "OccurrenceTypeController@edit",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.edit']);
    // Route::delete('/occurrence_types/{occurrence_type}', ["as"=>"occurrence_types.destroy","uses" => "OccurrenceTypeController@destroy",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.destroy']);

    // //OCCURRENCE_ARCHIVES
    // Route::post('/occurrence_archives', ["as"=>"occurrence_archives.store","uses" => "OccurrenceArchiveController@store"]);
    // Route::delete('/occurrence_archives/{occurrence_archives}', ["as"=>"occurrence_archives.destroy","uses" => "OccurrenceArchiveController@destroy", 'middleware'=>['needsPermission'], 'shield' => 'occurrence_archive.destroy']);
    
    // //OCCURRENCE_PHOTOS
    // Route::post('/occurrence_photos_upload', ["as"=>"occurrence_photos_uploads.store","uses" => "OccurrenceController@photosUpload"]);

    //TEAM
    
    //    Route::resource("teams", "TeamController");
    // Route::get('/teams', ["as"=>"teams.index","uses" => "TeamController@index",'middleware'=>['needsPermission'], 'shield' => 'team.index']);
    // Route::get('/teams/gantt', ["as"=>"teams.gantt","uses" => "TeamController@gantt",'middleware'=>['needsPermission'], 'shield' => 'team.edit']);
    // Route::post('/teams', ["as"=>"teams.store","uses" => "TeamController@store",'middleware'=>['needsPermission'], 'shield' => 'team.create']);
    // Route::get('/teams/create', ["as"=>"teams.create","uses" => "TeamController@create",'middleware'=>['needsPermission'], 'shield' => 'team.create']);
    // Route::get('/teams/{team}', ["as"=>"teams.show","uses" => "TeamController@show",'middleware'=>['needsPermission'], 'shield' => 'team.show']);
    // Route::put('/teams/{team}', ["as"=>"teams.update","uses" => "TeamController@update",'middleware'=>['needsPermission'], 'shield' => 'team.edit']);
    // Route::get('/teams/{team}/edit', ["as"=>"teams.edit","uses" => "TeamController@edit",'middleware'=>['needsPermission'], 'shield' => 'team.edit']);
    // Route::delete('/teams/{team}', ["as"=>"teams.destroy","uses" => "TeamController@destroy",'middleware'=>['needsPermission'], 'shield' => 'team.destroy']);
    
    //INTERFERENCE
    
//     //    Route::resource("interferences", "InterferenceController");
//     Route::get('/interferences/dashboard', ["as"=>"interferences.dashboard","uses" => "InterferenceController@dashboard",'middleware'=>['needsPermission'], 'shield' => 'interference.relatorio']);
//     Route::get('/interferences/clients', ["as"=>"interferences.clients","uses" => "InterferenceController@clients",'middleware'=>['needsPermission'], 'shield' => 'interference.relatorio']);
//     Route::get('/interferences/dashboard/ajax', ["as"=>"interferences.dashboard.ajax","uses" => "InterferenceController@dashboard_ajax",'middleware'=>['needsPermission'], 'shield' => 'interference.relatorio']);
//     Route::get('/interferences/relatorio/{interference}', ["as"=>"interferences.relatorio.show","uses" => "InterferenceController@relatorio_show",'middleware'=>['needsPermission'], 'shield' => 'interference.relatorio']);
//     Route::get('/interferences', ["as"=>"interferences.index","uses" => "InterferenceController@index",'middleware'=>['needsPermission'], 'shield' => 'interference.index']);
//     Route::post('/interferences', ["as"=>"interferences.store","uses" => "InterferenceController@store",'middleware'=>['needsPermission'], 'shield' => 'interference.create']);
//     Route::get('/interferences/create', ["as"=>"interferences.create","uses" => "InterferenceController@create",'middleware'=>['needsPermission'], 'shield' => 'interference.create']);
//     Route::get('/interferences/{interference}', ["as"=>"interferences.show","uses" => "InterferenceController@show",'middleware'=>['needsPermission'], 'shield' => 'interference.show']);
//     Route::put('/interferences/{interference}', ["as"=>"interferences.update","uses" => "InterferenceController@update",'middleware'=>['needsPermission'], 'shield' => 'interference.edit']);
//     Route::get('/interferences/{interference}/edit', ["as"=>"interferences.edit","uses" => "InterferenceController@edit",'middleware'=>['needsPermission'], 'shield' => 'interference.edit']);
//     Route::delete('/interferences/{interference}', ["as"=>"interferences.destroy","uses" => "InterferenceController@destroy",'middleware'=>['needsPermission'], 'shield' => 'interference.destroy']);

//     //OPERATORS
// //    Route::resource("operators","OperatorController");
//     Route::get('/operators', ["as"=>"operators.index","uses" => "OperatorController@index",'middleware'=>['needsPermission'], 'shield' => 'operator.index']);
//     Route::post('/operators', ["as"=>"operators.store","uses" => "OperatorController@store"]);
//     Route::get('/operators/create', ["as"=>"operators.create","uses" => "OperatorController@create",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::get('/operators/{operator}', ["as"=>"operators.show","uses" => "OperatorController@show",'middleware'=>['needsPermission'], 'shield' => 'operator.show']);
//     Route::put('/operators/{operator}', ["as"=>"operators.update","uses" => "OperatorController@update"]);
//     Route::get('/operators/{operator}/edit', ["as"=>"operators.edit","uses" => "OperatorController@edit",'middleware'=>['needsPermission'], 'shield' => 'operator.edit']);
//     Route::delete('/operators/{operator}', ["as"=>"operators.destroy","uses" => "OperatorController@destroy",'middleware'=>['needsPermission'], 'shield' => 'operator.destroy']);
//     Route::get('/operators/ajax/{id?}', ["as" => "operator.ajax", "uses" => "OperatorController@ajax"]);
//     Route::get('/operators/tracking/{operator}', ["as" => "operator.tracking", "uses" => "OperatorController@tracking",'middleware'=>['needsPermission'], 'shield' => 'operator.tracking']);

    
//     //RH
//     Route::get('/operators/rh/export', ["as"=>"rh.export","uses" => "OperatorController@workday",'middleware'=>['needsPermission'], 'shield' => 'operator.index']);
    
    //PERMISSIONS
    //    Route::resource("permissions","PermissionController");
    Route::get('/permissions', ["as"=>"permissions.index","uses" => "PermissionController@index",'middleware'=>['needsPermission'], 'shield' => 'permissions.index']);
    Route::post('/permissions', ["as"=>"permissions.store","uses" => "PermissionController@store"]);
    Route::get('/permissions/create', ["as"=>"permissions.create","uses" => "PermissionController@create",'middleware'=>['needsPermission'], 'shield' => 'permissions.create']);
    Route::get('/permissions/{permission}', ["as"=>"permissions.show","uses" => "PermissionController@show",'middleware'=>['needsPermission'], 'shield' => 'permissions.show']);
    Route::put('/permissions/{permission}', ["as"=>"permissions.update","uses" => "PermissionController@update"]);
    Route::get('/permissions/{permission}/edit', ["as"=>"permissions.edit","uses" => "PermissionController@edit",'middleware'=>['needsPermission'], 'shield' => 'permissions.edit']);
    Route::delete('/permissions/{permission}', ["as"=>"permissions.destroy","uses" => "PermissionController@destroy",'middleware'=>['needsPermission'], 'shield' => 'permissions.destroy']);

    //ROLES
    //    Route::resource("roles","RoleController");
    Route::get('/roles', ["as"=>"roles.index","uses" => "RoleController@index",'middleware'=>['needsPermission'], 'shield' => 'roles.index']);
    Route::post('/roles', ["as"=>"roles.store","uses" => "RoleController@store"]);
    Route::get('/roles/create', ["as"=>"roles.create","uses" => "RoleController@create",'middleware'=>['needsPermission'], 'shield' => 'roles.create']);
    Route::get('/roles/{role}', ["as"=>"roles.show","uses" => "RoleController@show",'middleware'=>['needsPermission'], 'shield' => 'roles.show']);
    Route::put('/roles/{role}', ["as"=>"roles.update","uses" => "RoleController@update"]);
    Route::get('/roles/{role}/edit', ["as"=>"roles.edit","uses" => "RoleController@edit",'middleware'=>['needsPermission'], 'shield' => 'roles.edit']);
    Route::delete('/roles/{role}', ["as"=>"roles.destroy","uses" => "RoleController@destroy",'middleware'=>['needsPermission'], 'shield' => 'roles.destroy']);
    Route::put('/roles/permission/{id}', ["as"=>"roles.permission.update","uses" => "RoleController@permissionUpdate"]);
    
    //LOG IMPORTAÇÃO
    // Route::get("log_imports/log/{log_import}", [ "as" => "log_imports.log", "uses" => "LogImportController@log",'middleware'=>['needsPermission'], 'shield' => 'log_imports.show' ]);
    // Route::get('/log_imports', ["as"=>"log_imports.index","uses" => "LogImportController@index",'middleware'=>['needsPermission'], 'shield' => 'log_imports.index']);
    // Route::get('/log_imports/{log_import}', ["as"=>"log_imports.show","uses" => "LogImportController@show",'middleware'=>['needsPermission'], 'shield' => 'log_imports.show']);
    // Route::put('/log_imports/{log_import}', ["as"=>"log_imports.update","uses" => "LogImportController@update"]);
    // Route::get('/log_imports/{log_import}/edit', ["as"=>"log_imports.edit","uses" => "LogImportController@edit",'middleware'=>['needsPermission'], 'shield' => 'log_imports.edit']);
    // Route::delete('/log_imports/{log_import}', ["as"=>"log_imports.destroy","uses" => "LogImportController@destroy",'middleware'=>['needsPermission'], 'shield' => 'log_imports.destroy']);
    
    // //LOG IMPORTAÇÃO - ERRORP
    // Route::get('/log_import_errors', ["as"=>"log_import_errors.index","uses" => "LogImportErrorController@index",'middleware'=>['needsPermission'], 'shield' => 'log_import_errors.index']);
    // Route::get('/log_import_errors/{log_import_error}', ["as"=>"log_import_errors.show","uses" => "LogImportErrorController@show",'middleware'=>['needsPermission'], 'shield' => 'log_import_errors.show']);
    // Route::put('/log_import_errors/{log_import_error}', ["as"=>"log_import_errors.update","uses" => "LogImportErrorController@update"]);
    // Route::get('/log_import_errors/{log_import_error}/edit', ["as"=>"log_import_errors.edit","uses" => "LogImportErrorController@edit",'middleware'=>['needsPermission'], 'shield' => 'log_import_errors.edit']);
    // Route::delete('/log_import_errors/{log_import_error}', ["as"=>"log_import_errors.destroy","uses" => "LogImportErrorController@destroy",'middleware'=>['needsPermission'], 'shield' => 'log_import_errors.destroy']);
    
    // //LOG ANDROID
    // Route::get('/log_locals', ["as"=>"log_locals.index","uses" => "LogLocalController@index",'middleware'=>['needsPermission'], 'shield' => 'log_locals.index']);
    // Route::get('/log_locals/{log_local}', ["as"=>"log_locals.show","uses" => "LogLocalController@show",'middleware'=>['needsPermission'], 'shield' => 'log_locals.show']);

    // // RELATORIO DE EXECUÇÃO DO DIA
    // Route::get('/finish_work_days', ["as"=>"finish_work_days.index","uses" => "FinishWorkDayController@index",'middleware'=>['needsPermission'], 'shield' => 'finish_work_days.index']);
    // Route::get('/finish_work_days/{finish_work_day}', ["as"=>"finish_work_days.show","uses" => "FinishWorkDayController@show",'middleware'=>['needsPermission'], 'shield' => 'finish_work_days.show']);

    //IMPORTAÇÃO
    Route::get("import-os", [ "as" => "importOs.index", "uses" => "ImportController@index",'middleware'=>['needsPermission'], 'shield' => 'importOs.index' ]);
    Route::get("import-os-personal", [ "as" => "importOs.import_nts", "uses" => "ImportController@importPersonal",'middleware'=>['needsPermission'], 'shield' => 'importOs.import_nts' ]);
    Route::post("import-os/import", [ "as" => "importOs.import", "uses" => "ImportController@importExcel"]);
    Route::post("import-os/import-personal", [ "as" => "importOs.importNts", "uses" => "ImportController@importNts"]);

    //EXPORTAÇÃO
    Route::get("export", [ "as" => "export.index", "uses" => "ExportController@index",'middleware'=>['needsPermission'], 'shield' => 'export.index' ]);
    Route::get("export/financeiro_cs", [ "as" => "export.financeiro_cs", "uses" => "ExportController@financeiro_cs",'middleware'=>['needsPermission'], 'shield' => 'export.financeiro_cs' ]);
    Route::get("export/repayment", [ "as" => "export.repayment", "uses" => "ExportController@exportRepayment",'middleware'=>['needsPermission'], 'shield' => 'repayment.index' ]);
    Route::get("export/operator", [ "as" => "export.operator", "uses" => "ExportController@operator",'middleware'=>['needsPermission'], 'shield' => 'repayment.index' ]);
    Route::get("export/export", [ "as" => "export.export", "uses" => "ExportController@export"]);
    
    //EQUIPMENTS
    
    // Route::get("equipments/", [ "as" => "equipments.index", "uses" => "EquipmentController@index","middleware"=>["needsPermission"], "shield" => "equipment.index"]);
    // Route::get("equipments/create", ["as" => "equipments.create", "uses" => "EquipmentController@create", "middleware" => ["needsPermission"], "shield" => "equipment.create"]);
    // Route::post("equipments/store", ["as" => "equipments.store", "uses" => "EquipmentController@store", "middleware" => ["needsPermission"], "shield" => "equipment.create"]);
    // Route::get("equipments/{equipment}", ["as" => "equipments.show", "uses" => "EquipmentController@show", "middleware" => ["needsPermission"], "shield" => "equipment.show"]);
    // Route::put("equipments/{equipment}", ["as" => "equipments.update", "uses" => "EquipmentController@update", "middleware" => ["needsPermission"], "shield" => "equipment.edit"]);
    // Route::get("equipments/{equipment}/edit", ["as" => "equipments.edit", "uses" => "EquipmentController@edit", "middleware" => ["needsPermission"], "shield" => "equipment.edit"]);
    // Route::delete("equipments/{equipment}", ["as" => "equipments.destroy", "uses" => "EquipmentController@destroy", "middleware" => ["needsPermission"], "shield" => "equipment.destroy"]);
    
    //Form
    //    Route::resource("forms","FormController");
    // Route::get('/forms', ["as"=>"forms.index","uses" => "FormController@index",'middleware'=>['needsPermission'], 'shield' => 'form.index']);
    // Route::get('/forms/preenchimento', ["as"=>"forms.preenchimento","uses" => "FormController@index",'middleware'=>['needsPermission'], 'shield' => 'form.index']);
    // Route::post('/forms', ["as"=>"forms.store","uses" => "FormController@store"]);
    // Route::get('/forms/create', ["as"=>"forms.create","uses" => "FormController@create",'middleware'=>['needsPermission'], 'shield' => 'form.create']);
    // Route::get('/forms/{form}', ["as"=>"forms.show","uses" => "FormController@show",'middleware'=>['needsPermission'], 'shield' => 'form.show']);
    // Route::put('/forms/{form}', ["as"=>"forms.update","uses" => "FormController@update"]);
    // Route::get('/forms/{form}/edit', ["as"=>"forms.edit","uses" => "FormController@edit",'middleware'=>['needsPermission'], 'shield' => 'form.edit']);
    // Route::delete('/forms/{form}', ["as"=>"forms.destroy","uses" => "FormController@destroy",'middleware'=>['needsPermission'], 'shield' => 'form.destroy']);

    // Route::post('/form_sections', ["as"=>"form_sections.store","uses" => "FormSectionController@store"]);
    // Route::get('/form_sections/create/{form}', ["as"=>"form_sections.create","uses" => "FormSectionController@create",'middleware'=>['needsPermission'], 'shield' => 'form_section.create']);
    // Route::put('/form_sections/{form_section}', ["as"=>"form_sections.update","uses" => "FormSectionController@update"]);
    // Route::get('/form_sections/{form_section}/edit', ["as"=>"form_sections.edit","uses" => "FormSectionController@edit",'middleware'=>['needsPermission'], 'shield' => 'form_section.edit']);
    // Route::delete('/form_sections/{form_section}', ["as"=>"form_sections.destroy","uses" => "FormSectionController@destroy",'middleware'=>['needsPermission'], 'shield' => 'form_section.destroy']);
    // Route::put('/form_sections_order/order', ["as"=>"form_sections_order.order","uses" => "FormSectionController@order"]);

//     //OccurrenceTypeForm
//     //    Route::resource("occurrence_type_forms","OccurrenceTypeFormController");
//     Route::get('/occurrence_type_forms', ["as"=>"occurrence_type_forms.index","uses" => "OccurrenceTypeFormController@index",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type_form.index']);
//     Route::post('/occurrence_type_forms', ["as"=>"occurrence_type_forms.store","uses" => "OccurrenceTypeFormController@store"]);
//     Route::get('/occurrence_type_forms/create', ["as"=>"occurrence_type_forms.create","uses" => "OccurrenceTypeFormController@create",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type_form.create']);
//     Route::get('/occurrence_type_forms/{occurrence_type_form}', ["as"=>"occurrence_type_forms.show","uses" => "OccurrenceTypeFormController@show",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type_form.show']);
//     Route::put('/occurrence_type_forms/{occurrence_type_form}', ["as"=>"occurrence_type_forms.update","uses" => "OccurrenceTypeFormController@update"]);
//     Route::get('/occurrence_type_forms/{occurrence_type_form}/edit', ["as"=>"occurrence_type_forms.edit","uses" => "OccurrenceTypeFormController@edit",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type_form.edit']);
//     Route::delete('/occurrence_type_forms/{occurrence_type_form}', ["as"=>"occurrence_type_forms.destroy","uses" => "OccurrenceTypeFormController@destroy",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type_form.destroy']);
//     Route::delete('/occurrence_type_forms/{occurrence_type_form}', ["as"=>"occurrence_type_forms.destroy","uses" => "OccurrenceTypeFormController@destroy",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type_form.destroy']);
    
//     //DOCUMENTS
// //    Route::resource("documents","DocumentController"); // Add this line in routes.php
// Route::get('/documents', ["as"=>"documents.index","uses" => "DocumentController@index",'middleware'=>['needsPermission'], 'shield' => 'document.index']);
//     Route::post('/documents', ["as"=>"documents.store","uses" => "DocumentController@store"]);
//     Route::get('/documents/create', ["as"=>"documents.create","uses" => "DocumentController@create",'middleware'=>['needsPermission'], 'shield' => 'document.create']);
//     Route::get('/documents/{document}', ["as"=>"documents.show","uses" => "DocumentController@show",'middleware'=>['needsPermission'], 'shield' => 'document.show']);
//     Route::put('/documents/{document}', ["as"=>"documents.update","uses" => "DocumentController@update"]);
//     Route::get('/documents/{document}/edit', ["as"=>"documents.edit","uses" => "DocumentController@edit",'middleware'=>['needsPermission'], 'shield' => 'document.edit']);
//     Route::delete('/documents/{document}', ["as"=>"documents.destroy","uses" => "DocumentController@destroy",'middleware'=>['needsPermission'], 'shield' => 'document.destroy']);

//     //FINANCIAL
//     //Route::resource("financials","FinancialController"); // Add this line in routes.php
//     Route::get('/financials/dashboard', ["as"=>"financials.dashboard","uses" => "FinancialController@dashboard",'middleware'=>['needsPermission'], 'shield' => 'financial.dashboard']);
//     Route::get('/financials/dashboard/ajax', ["as"=>"financials.dashboard.ajax","uses" => "FinancialController@dashboard_ajax",'middleware'=>['needsPermission'], 'shield' => 'financial.dashboard']);
    
//     Route::get('/financials', ["as"=>"financials.index","uses" => "FinancialController@index",'middleware'=>['needsPermission'], 'shield' => 'financial.index']);
//     Route::post('/financials/{occurrence}', ["as"=>"financials.store","uses" => "FinancialController@store"]);
//     Route::get('/financials/create/{occurrence}', ["as"=>"financials.create","uses" => "FinancialController@create",'middleware'=>['needsPermission'], 'shield' => 'financial.create']);
//     Route::get('/financials/{financial}', ["as"=>"financials.show","uses" => "FinancialController@show",'middleware'=>['needsPermission'], 'shield' => 'financial.show']);
//     Route::put('/financials/{financial}', ["as"=>"financials.update","uses" => "FinancialController@update"]);
//     Route::get('/financials/{financial}/edit', ["as"=>"financials.edit","uses" => "FinancialController@edit",'middleware'=>['needsPermission'], 'shield' => 'financial.edit']);
//     Route::delete('/financials/{financial}', ["as"=>"financials.destroy","uses" => "FinancialController@destroy",'middleware'=>['needsPermission'], 'shield' => 'financial.destroy']);
    
//     //FINANCIAL COMMUNICATION
//     //Route::resource("financial_communications","FinancialCommunicationController"); // Add this line in routes.php
//     Route::get('/financial_communications', ["as"=>"financial_communications.index","uses" => "FinancialCommunicationController@index",'middleware'=>['needsPermission'], 'shield' => 'financial_communication.index']);
//     Route::post('/financial_communications/{financial}', ["as"=>"financial_communications.store","uses" => "FinancialCommunicationController@store"]);
//     Route::get('/financial_communications/create/{financial}', ["as"=>"financial_communications.create","uses" => "FinancialCommunicationController@create",'middleware'=>['needsPermission'], 'shield' => 'financial_communication.create']);
//     Route::get('/financial_communications/{financial_communication}', ["as"=>"financial_communications.show","uses" => "FinancialCommunicationController@show",'middleware'=>['needsPermission'], 'shield' => 'financial_communication.show']);
//     Route::put('/financial_communications/{financial_communication}', ["as"=>"financial_communications.update","uses" => "FinancialCommunicationController@update"]);
//     Route::get('/financial_communications/{financial_communication}/edit', ["as"=>"financial_communications.edit","uses" => "FinancialCommunicationController@edit",'middleware'=>['needsPermission'], 'shield' => 'financial_communication.edit']);
//     Route::delete('/financial_communications/{financial_communication}', ["as"=>"financial_communications.destroy","uses" => "FinancialCommunicationController@destroy",'middleware'=>['needsPermission'], 'shield' => 'financial_communication.destroy']);

//     //SMS
// //    Route::resource("smss","SmsController");
//     Route::get('/sms', ["as"=>"sms.index","uses" => "SmsController@index",'middleware'=>['needsPermission'], 'shield' => 'sms.index']);
//     Route::get('/sms/{sms}', ["as"=>"sms.show","uses" => "SmsController@show",'middleware'=>['needsPermission'], 'shield' => 'sms.show']);

//     //EMAIL
//     Route::post('/mail/{occurrence}', ["as"=>"mails.envia_os_completa","uses" => "MailController@envia_os_completa",'middleware'=>['needsPermission'], 'shield' => 'occurrence.index']);

//     Route::get("log", [ "as" => "log.index", "uses" => "LogController@index",'middleware'=>['needsPermission'], 'shield' => 'log.index' ]);
//     Route::get("log/{id}", [ "as" => "log.show", "uses" => "LogController@show",'middleware'=>['needsPermission'], 'shield' => 'log.show' ]);
    

//     Route::get('/401', ["as"=>"errors.401","uses" => "ErrorController@error401"]);
//     Route::get('/404', ["as"=>"errors.404","uses" => "ErrorController@error404"]);
    
//     //CALENDAR
    
//     Route::get('/calendar', ['as'=>'calendar.index', 'uses' => 'CalendarController@index', 'middleware'=>['needsPermission'], 'shield' => 'calendar.index' ]);
//     Route::get('/calendar/list_occurrences', ["as"=>"calendar.list_occurrences", "uses"=>"CalendarController@listOccurrences",'middleware'=>['needsPermission'], 'shield' => 'calendar.index']);
    
//     //Buscas de CEP
//     Route::get('/helper/get_address_rep/{CEP}', ["as"=>"helper.busca_cep_rep","uses" => "HelperController@getAddressToCepRepulica"]);
    
//     //Ajax rotação de imagem
//     Route::post('/helper/rotate/', ["as"=>"helper.rotate","uses" => "HelperController@rotate"]);
    
//     //VEÍCULOS
//     Route::get('/vehicles', ["as"=>"vehicles.index","uses" => "VehicleController@index",'middleware'=>['needsPermission'], 'shield' => 'vehicles.index']);
//     Route::get('/vehicles/create', ["as"=>"vehicles.create","uses" => "VehicleController@create",'middleware'=>['needsPermission'], 'shield' => 'vehicles.create']);
//     Route::post('/vehicles/store', ["as"=>"vehicles.store","uses" => "VehicleController@store",'middleware'=>['needsPermission'], 'shield' => 'vehicles.create']);
//     Route::get('/vehicles/{vehicle}', ["as"=>"vehicles.show","uses" => "VehicleController@show",'middleware'=>['needsPermission'], 'shield' => 'vehicles.show']);
//     Route::get('/vehicles/{vehicle}/edit', ["as"=>"vehicles.edit","uses" => "VehicleController@edit",'middleware'=>['needsPermission'], 'shield' => 'vehicles.edit']);
//     Route::put('/vehicles/{vehicle}', ["as"=>"vehicles.update","uses" => "VehicleController@update",'middleware'=>['needsPermission'], 'shield' => 'vehicles.create']);
//     Route::delete('/vehicles/{vehicle}', ["as"=>"vehicles.destroy","uses" => "VehicleController@destroy",'middleware'=>['needsPermission'], 'shield' => 'vehicles.destroy']);
//     Route::get('/vehicles-checklist', ["as"=>"vehicles.checklist","uses" => "VehicleController@checklist",'middleware'=>['needsPermission'], 'shield' => 'vehicles.checklist']);
//     Route::get('/vehicles-checklist/{checklist_vehicle}', ["as"=>"vehicles.checklist.show","uses" => "VehicleController@checklistShow",'middleware'=>['needsPermission'], 'shield' => 'vehicles.checklist']);
//     Route::get('/vehicles-checklist/pdf/{checklist_vehicle}', ["as"=>"vehicles.checklist.checklistPdf","uses" => "VehicleController@checklistPdf",'middleware'=>['needsPermission'], 'shield' => 'vehicles.checklist']);
    

//     //ARCHIVE
//     Route::post('/archive/destory', ["as"=>"archive.destroy","uses" => "ArchiveController@destroy",'middleware'=>['needsPermission'], 'shield' => 'vehicles.destroy']);
    
//     //ITENS CHECKLIST
//     Route::get('/checklist_vechicle_itens', ["as"=>"checklist_vechicle_itens.index","uses" => "ChecklistVehicleItenController@index",'middleware'=>['needsPermission'], 'shield' => 'vehicles.index']);
//     Route::get('/checklist_vechicle_itens/create', ["as"=>"checklist_vechicle_itens.create","uses" => "ChecklistVehicleItenController@create",'middleware'=>['needsPermission'], 'shield' => 'vehicles.index']);
//     Route::post('/checklist_vechicle_itens/store', ["as"=>"checklist_vechicle_itens.store","uses" => "ChecklistVehicleItenController@store",'middleware'=>['needsPermission'], 'shield' => 'vehicles.create']);
//     Route::get('/checklist_vechicle_itens/{checklist_vechicle_itens}', ["as"=>"checklist_vechicle_itens.show","uses" => "ChecklistVehicleItenController@show",'middleware'=>['needsPermission'], 'shield' => 'vehicles.show']);
//     Route::get('/checklist_vechicle_itens/{checklist_vechicle_itens}/edit', ["as"=>"checklist_vechicle_itens.edit","uses" => "ChecklistVehicleItenController@edit",'middleware'=>['needsPermission'], 'shield' => 'vehicles.edit']);
//     Route::put('/checklist_vechicle_itens/{checklist_vechicle_itens}', ["as"=>"checklist_vechicle_itens.update","uses" => "ChecklistVehicleItenController@update",'middleware'=>['needsPermission'], 'shield' => 'vehicles.create']);
//     Route::delete('/checklist_vechicle_itens/{checklist_vechicle_itens}', ["as"=>"checklist_vechicle_itens.destroy","uses" => "ChecklistVehicleItenController@destroy",'middleware'=>['needsPermission'], 'shield' => 'vehicles.destroy']);
    

//     //District
//     //    Route::resource("districts","DistrictController");
//     Route::get('/districts', ["as"=>"districts.index","uses" => "DistrictController@index",'middleware'=>['needsPermission'], 'shield' => 'district.index']);
//     Route::post('/districts', ["as"=>"districts.store","uses" => "DistrictController@store"]);
//     Route::get('/districts/create', ["as"=>"districts.create","uses" => "DistrictController@create",'middleware'=>['needsPermission'], 'shield' => 'district.create']);
//     Route::get('/districts/{district}', ["as"=>"districts.show","uses" => "DistrictController@show",'middleware'=>['needsPermission'], 'shield' => 'district.show']);
//     Route::put('/districts/{district}', ["as"=>"districts.update","uses" => "DistrictController@update"]);
//     Route::get('/districts/{district}/edit', ["as"=>"districts.edit","uses" => "DistrictController@edit",'middleware'=>['needsPermission'], 'shield' => 'district.edit']);
//     Route::delete('/districts/{district}', ["as"=>"districts.destroy","uses" => "DistrictController@destroy",'middleware'=>['needsPermission'], 'shield' => 'district.destroy']);
    
//     //CONTRACTOR DISTRICT
//     //    Route::resource("contractor_districts","ContractorDistrictController");
//     Route::get('/contractor_districts', ["as"=>"contractor_districts.index","uses" => "ContractorDistrictController@index",'middleware'=>['needsPermission'], 'shield' => 'contractor_district.index']);
//     Route::get('/contractor_districts/create', ["as"=>"contractor_districts.create","uses" => "ContractorDistrictController@create",'middleware'=>['needsPermission'], 'shield' => 'contractor_district.index']);
//     Route::post('/contractor_districts/store', ["as"=>"contractor_districts.store","uses" => "ContractorDistrictController@store",'middleware'=>['needsPermission'], 'shield' => 'contractor_district.create']);
//     Route::get('/contractor_districts/{contractor_district}', ["as"=>"contractor_districts.show","uses" => "ContractorDistrictController@show",'middleware'=>['needsPermission'], 'shield' => 'contractor_district.show']);
//     Route::get('/contractor_districts/{contractor_district}/edit', ["as"=>"contractor_districts.edit","uses" => "ContractorDistrictController@edit",'middleware'=>['needsPermission'], 'shield' => 'contractor_district.edit']);
//     Route::put('/contractor_districts/{contractor_district}', ["as"=>"contractor_districts.update","uses" => "ContractorDistrictController@update",'middleware'=>['needsPermission'], 'shield' => 'contractor_district.create']);
//     Route::delete('/contractor_districts/{contractor_district}', ["as"=>"contractor_districts.destroy","uses" => "ContractorDistrictController@destroy",'middleware'=>['needsPermission'], 'shield' => 'contractor_district.destroy']);
    
//     //CONTRACTOR OS
//     //    Route::resource("contractor_occurrence_types","ContractorOccurrenceTypeController");
//     Route::get('/contractor_occurrence_types', ["as"=>"contractor_occurrence_types.index","uses" => "ContractorOccurrenceTypeController@index",'middleware'=>['needsPermission'], 'shield' => 'contractor_occurrence_type.index']);
//     Route::get('/contractor_occurrence_types/create', ["as"=>"contractor_occurrence_types.create","uses" => "ContractorOccurrenceTypeController@create",'middleware'=>['needsPermission'], 'shield' => 'contractor_occurrence_type.index']);
//     Route::post('/contractor_occurrence_types/store', ["as"=>"contractor_occurrence_types.store","uses" => "ContractorOccurrenceTypeController@store",'middleware'=>['needsPermission'], 'shield' => 'contractor_occurrence_type.create']);
//     Route::get('/contractor_occurrence_types/{contractor_occurrence_type}', ["as"=>"contractor_occurrence_types.show","uses" => "ContractorOccurrenceTypeController@show",'middleware'=>['needsPermission'], 'shield' => 'contractor_occurrence_type.show']);
//     Route::get('/contractor_occurrence_types/{contractor_occurrence_type}/edit', ["as"=>"contractor_occurrence_types.edit","uses" => "ContractorOccurrenceTypeController@edit",'middleware'=>['needsPermission'], 'shield' => 'contractor_occurrence_type.edit']);
//     Route::put('/contractor_occurrence_types/{contractor_occurrence_type}', ["as"=>"contractor_occurrence_types.update","uses" => "ContractorOccurrenceTypeController@update",'middleware'=>['needsPermission'], 'shield' => 'contractor_occurrence_type.create']);
//     Route::delete('/contractor_occurrence_types/{contractor_occurrence_type}', ["as"=>"contractor_occurrence_types.destroy","uses" => "ContractorOccurrenceTypeController@destroy",'middleware'=>['needsPermission'], 'shield' => 'contractor_occurrence_type.destroy']);

//     // ALERTS
//     Route::get('/alerts', ["as"=>"alerts.index","uses" => "AlertController@index",'middleware'=>['needsPermission'], 'shield' => 'alerts.index']);
//     Route::get('/alerts/packages', ["as"=>"alerts.show_packages","uses" => "AlertController@show_packages",'middleware'=>['needsPermission'], 'shield' => 'alerts.show_packages']);
//     Route::get('/alerts/routes', ["as"=>"alerts.show_routes","uses" => "AlertController@show_routes",'middleware'=>['needsPermission'], 'shield' => 'alerts.show_routes']);
//     Route::get('/alerts/document/{alert}', ["as"=>"alerts.show_document","uses" => "AlertController@show_document",'middleware'=>['needsPermission'], 'shield' => 'alerts.show_document']);
//     Route::put('/alerts/{alert}/document_close', ["as"=>"alerts.documents_close","uses" => "AlertController@documents_close",'middleware'=>['needsPermission'], 'shield' => 'alerts.documents_close']);
    
//     Route::get("log", [ "as" => "log.index", "uses" => "LogController@index",'middleware'=>['needsPermission'], 'shield' => 'log.index' ]);
//     Route::get("log/{id}", [ "as" => "log.show", "uses" => "LogController@show",'middleware'=>['needsPermission'], 'shield' => 'log.show' ]);
    
//     //Skill
//     //    Route::resource("skills","SkillController");
//     Route::get('/skills', ["as"=>"skills.index","uses" => "SkillController@index",'middleware'=>['needsPermission'], 'shield' => 'skill.index']);
//     Route::post('/skills', ["as"=>"skills.store","uses" => "SkillController@store"]);
//     Route::get('/skills/create', ["as"=>"skills.create","uses" => "SkillController@create",'middleware'=>['needsPermission'], 'shield' => 'skill.create']);
//     Route::get('/skills/{skill}', ["as"=>"skills.show","uses" => "SkillController@show",'middleware'=>['needsPermission'], 'shield' => 'skill.show']);
//     Route::put('/skills/{skill}', ["as"=>"skills.update","uses" => "SkillController@update"]);
//     Route::get('/skills/{skill}/edit', ["as"=>"skills.edit","uses" => "SkillController@edit",'middleware'=>['needsPermission'], 'shield' => 'skill.edit']);
//     Route::delete('/skills/{skill}', ["as"=>"skills.destroy","uses" => "SkillController@destroy",'middleware'=>['needsPermission'], 'shield' => 'skill.destroy']);

//     //ASSOCIACAO DE OS VS SKILL
//     Route::get('/occurrence_types/{occurrence_type}/associate_skill', ["as"=>"occurrence_types.associate.skill","uses" => "OccurrenceTypeSkillController@associate_skill",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.create']);
//     Route::post('/occurrence_types/{occurrence_type}/assigned_skill', ["as"=>"occurrence_types.associate.skill.store","uses" => "OccurrenceTypeSkillController@associate_skill_store",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.create']);
//     Route::get('/occurrence_types/{occurrence_type}/disassociate_skill', ["as"=>"occurrence_types.desassociate.skill","uses" => "OccurrenceTypeSkillController@disassociate_skill",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.create']);
//     Route::put('/occurrence_types/{occurrence_type}/disassociate_skill', ["as"=>"occurrence_types.desassociate.skill.store","uses" => "OccurrenceTypeSkillController@disassociate_skill_store",'middleware'=>['needsPermission'], 'shield' => 'occurrence_type.create']);

//     //ASSOCIACAO DE USUARIO VS SKILL
//     Route::get('/operators/{user}/associate_skill', ["as"=>"users.associate.skill","uses" => "UserSkillController@associate_skill",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::post('/operators/{user}/assigned_skill', ["as"=>"users.associate.skill.store","uses" => "UserSkillController@associate_skill_store",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::get('/operators/{user}/disassociate_skill', ["as"=>"users.desassociate.skill","uses" => "UserSkillController@disassociate_skill",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::put('/operators/{user}/disassociate_skill', ["as"=>"users.desassociate.skill.store","uses" => "UserSkillController@disassociate_skill_store",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
    
//     //ASSOCIACAO DE USUARIO VS ZONE
//     Route::get('/operators/{user}/associate_zone', ["as"=>"users.associate.zone","uses" => "UserZoneController@associate_zone",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::post('/operators/{user}/assigned_zone', ["as"=>"users.associate.zone.store","uses" => "UserZoneController@associate_zone_store",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::get('/operators/{user}/disassociate_zone', ["as"=>"users.desassociate.zone","uses" => "UserZoneController@disassociate_zone",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::put('/operators/{user}/disassociate_zone', ["as"=>"users.desassociate.zone.store","uses" => "UserZoneController@disassociate_zone_store",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);

//     //ASSOCIACAO DE USUARIO VS EQUIPMENT
//     Route::get('/operators/{user}/associate_equipment', ["as"=>"users.associate.equipment","uses" => "UserEquipmentController@associate_equipment",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::post('/operators/{user}/assigned_equipment', ["as"=>"users.associate.equipment.store","uses" => "UserEquipmentController@associate_equipment_store",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::get('/operators/{user}/disassociate_equipment', ["as"=>"users.desassociate.equipment","uses" => "UserEquipmentController@disassociate_equipment",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
//     Route::post('/operators/{user}/disassociate_equipment', ["as"=>"users.desassociate.equipment.store","uses" => "UserEquipmentController@disassociate_equipment_store",'middleware'=>['needsPermission'], 'shield' => 'operator.create']);
    
//     //ASSOCICAO DE USUARIO VS CLIENTE
//     Route::get('/user/{user}/associate_client', ["as"=>"users.associate.client","uses" => "UserController@associate_client",'middleware'=>['needsPermission'], 'shield' => 'users.edit']);
//     Route::post('/user/{user}/associate_client', ["as"=>"users.associate.client.store","uses" => "UserController@associate_client_store",'middleware'=>['needsPermission'], 'shield' => 'users.edit']);
//     //    Route::get('/occurrence_type/getClientAjaxSelect2', ["as"=>"occurrence_client.get_ajax_select2","uses" => "OccurrenceClientController@getClientAjaxSelect2"]);
//     Route::delete('/user/{user}/disassociate_client', ["as"=>"users.disassociate.client.store","uses" => "UserController@disassociate_client_store",'middleware'=>['needsPermission'], 'shield' => 'users.create']);
    
//     //CATEGORIES
//     Route::get('/categories', ["as"=>"categories.index", "uses"=>"CategoryController@index", "middleware"=>["needsPermission"], "shield"=>"product_category.index"]);
//     Route::get('/categories/ajax', ["as"=>"categories.get.ajax", "uses"=>"CategoryController@get_ajax", "middleware"=>["needsPermission"], "shield"=>"product_category.create"]);
//     Route::get('/categories/create', ["as"=>"categories.create", "uses"=>"CategoryController@create", "middleware"=>["needsPermission"], "shield"=>"product_category.create"]);
//     Route::post('/categories', ["as"=>"categories.store", "uses"=>"CategoryController@store", "middleware"=>["needsPermission"], "shield"=>"product_category.create"]);
//     Route::get('/categories/{category}', ["as"=>"categories.show", "uses"=>"CategoryController@show", "middleware"=>["needsPermission"], "shield"=>"product_category.show"]);
//     Route::get('/categories/{category}/edit', ["as"=>"categories.edit", "uses"=>"CategoryController@edit", "middleware"=>["needsPermission"], "shield"=>"product_category.edit"]);
//     Route::put('/categories/{category}', ["as"=>"categories.update", "uses"=>"CategoryController@update", "middleware"=>["needsPermission"], "shield"=>"product_category.edit"]);
//     Route::delete('/categories/{category}', ["as"=>"categories.destroy", "uses"=>"CategoryController@destroy", "middleware"=>["needsPermission"], "shield"=>"product_category.destroy"]);

//     //Products
//     Route::get('/products', ["as"=>"products.index", "uses"=>"ProductController@index", "middleware"=>["needsPermission"], "shield"=>"product_category.index"]);
//     Route::get('/products/create', ["as"=>"products.create", "uses"=>"ProductController@create", "middleware"=>["needsPermission"], "shield"=>"product_category.create"]);
//     Route::post('/products', ["as"=>"products.store", "uses"=>"ProductController@store", "middleware"=>["needsPermission"], "shield"=>"product_category.create"]);
//     Route::get('/products/{product}', ["as"=>"products.show", "uses"=>"ProductController@show", "middleware"=>["needsPermission"], "shield"=>"product_category.show"]);
//     Route::get('/products/{product}/edit', ["as"=>"products.edit", "uses"=>"ProductController@edit", "middleware"=>["needsPermission"], "shield"=>"product_category.edit"]);
//     Route::put('/products/{product}', ["as"=>"products.update", "uses"=>"ProductController@update", "middleware"=>["needsPermission"], "shield"=>"product_category.edit"]);
//     Route::delete('/products/{product}', ["as"=>"products.destroy", "uses"=>"ProductController@destroy", "middleware"=>["needsPermission"], "shield"=>"product_category.destroy"]);

//     //ExpenseTypes
//     Route::get('/expense_types', ["as"=>"expense_types.index", "uses"=>"ExpenseTypesController@index", "middleware"=>["needsPermission"], "shield"=>"expense_type.index"]);
//     Route::get('/expense_types/create', ["as"=>"expense_types.create", "uses"=>"ExpenseTypesController@create", "middleware"=>["needsPermission"], "shield"=>"expense_type.create"]);
//     Route::post('/expense_types', ["as"=>"expense_types.store", "uses"=>"ExpenseTypesController@store", "middleware"=>["needsPermission"], "shield"=>"expense_type.create"]);
//     Route::get('/expense_types/{expense_types}', ["as"=>"expense_types.show", "uses"=>"ExpenseTypesController@show", "middleware"=>["needsPermission"], "shield"=>"expense_type.show"]);
//     Route::get('/expense_types/{expense_types}/edit', ["as"=>"expense_types.edit", "uses"=>"ExpenseTypesController@edit", "middleware"=>["needsPermission"], "shield"=>"expense_type.edit"]);
//     Route::put('/expense_types/{expense_types}', ["as"=>"expense_types.update", "uses"=>"ExpenseTypesController@update", "middleware"=>["needsPermission"], "shield"=>"expense_type.edit"]);
//     Route::delete('/expense_types/{expense_types}', ["as"=>"expense_types.destroy", "uses"=>"ExpenseTypesController@destroy", "middleware"=>["needsPermission"], "shield"=>"expense_type.destroy"]);

//     //Expense
//     Route::get('/expenses', ["as"=>"expense.index", "uses"=>"ExpenseController@index", "middleware"=>["needsPermission"], "shield"=>"expense.index"]);
//     Route::get('/expenses/create', ["as"=>"expense.create", "uses"=>"ExpenseController@create", "middleware"=>["needsPermission"], "shield"=>"expense.create"]);
//     Route::get('/expenses/create-operator/{operator}/{startDate?}/{endDate?}', ["as"=>"expense.create.operator", "uses"=>"ExpenseController@createOperatorExpense", "middleware"=>["needsPermission"], "shield"=>"expense.create"]);
//     Route::post('/expenses', ["as"=>"expense.store", "uses"=>"ExpenseController@store", "middleware"=>["needsPermission"], "shield"=>"expense.create"]);
//     Route::get('/expenses/{expense}', ["as"=>"expense.show", "uses"=>"ExpenseController@show", "middleware"=>["needsPermission"], "shield"=>"expense.show"]);
//     Route::get('/expenses/{expense}/edit', ["as"=>"expense.edit", "uses"=>"ExpenseController@edit", "middleware"=>["needsPermission"], "shield"=>"expense.edit"]);
//     Route::put('/expenses/{expense}', ["as"=>"expense.update", "uses"=>"ExpenseController@update", "middleware"=>["needsPermission"], "shield"=>"expense.edit"]);
//     Route::delete('/expenses/{expense}', ["as"=>"expense.destroy", "uses"=>"ExpenseController@destroy", "middleware"=>["needsPermission"], "shield"=>"expense.destroy"]);
//     Route::post('/expenses/remove_photo', ['as'=>"expense.remove_photo", "uses"=>"ExpenseController@removePhoto"]);
//     Route::post('/expenses/status', ['as'=>"expense.status", "uses"=>"ExpenseController@status", "middleware"=>["needsPermission"], "shield"=>"expense.status"]);
//     Route::post('/expenses/bulk_status', ['as'=>"expense.bulk_status", "uses"=>"ExpenseController@bulkStatus", "middleware"=>["needsPermission"], "shield"=>"expense.status"]);

//     //Repayment
//     Route::get('/repayment', ["as"=>"repayment.index", "uses"=>"RepaymentController@index", "middleware"=>["needsPermission"], "shield"=>"repayment.index"]);
//     //    Route::get('/repayment/pdf/{contractor_id}/{user_id}/{dateIn}/{dateFn}', ["as"=>"repayment.pdf","uses" => "RepaymentController@pdf",'middleware'=>['needsPermission'], 'shield' => 'repayment.index']);
//     Route::get('/repayment/pdf', ["as"=>"repayment.pdf","uses" => "RepaymentController@pdf",'middleware'=>['needsPermission'], 'shield' => 'repayment.index']);
    
    
//     //GENERAL SETTING
//     Route::get("/general_settings", ["as" => "general_setting.index", "uses" => "GeneralSettingController@index", "middleware" => ["needsPermission"], "shield" =>"general_setting.index"]);
//     // Route::get("/general_settings/create", ["as" => "general_setting.create", "uses" => "GeneralSettingController@create", "middleware" => ["needsPermission"], "shield" =>"general_setting.create"]);
//     // Route::post("/general_settings", ["as" => "general_setting.store", "uses" => "GeneralSettingController@store", "middleware" => ["needsPermission"], "shield" =>"general_setting.store"]);
//     // Route::get("/general_settings/{general_setting}", ["as" => "general_setting.show", "uses" => "GeneralSettingController@show", "middleware" => ["needsPermission"], "shield" =>"general_setting.show"]);
//     // Route::get("/general_settings/{general_setting}/edit", ["as" => "general_setting.edit", "uses" => "GeneralSettingController@edit", "middleware" => ["needsPermission"], "shield" =>"general_setting.edit"]);
//     Route::put("/general_settings/{general_setting}", ["as" => "general_setting.update", "uses" => "GeneralSettingController@update", "middleware" => ["needsPermission"], "shield" =>"general_setting.update"]);
//     // Route::delete("/general_settings/{general_setting}", ["as" => "general_setting.destroy", "uses" => "GeneralSettingController@destroy", "middleware" => ["needsPermission"], "shield" =>"general_setting.destroy"]);
    
//     //EVALUATION
//     Route::get('/evaluation/{evaluation}', ['as'=>'evaluation.show', "uses"=>"EvaluationController@show", "middleware" => ["needsPermission"], "shield" =>"occurrence.show"]);

//     //workdays
//     Route::get('/workday', ["as"=>"workday.index", "uses"=>"WorkdayController@index", "middleware"=>["needsPermission"], "shield"=>"workday.index"]);
//     Route::get('/workday/create', ["as"=>"workday.create", "uses"=>"WorkdayController@create", "middleware"=>["needsPermission"], "shield"=>"workday.create"]);
//     Route::post('/workday', ["as"=>"workday.store", "uses"=>"WorkdayController@store", "middleware"=>["needsPermission"], "shield"=>"workday.create"]);
//     Route::get('/workday/{workday}', ["as"=>"workday.show", "uses"=>"WorkdayController@show", "middleware"=>["needsPermission"], "shield"=>"workday.show"]);
//     Route::get('/workday/{workday}/edit', ["as"=>"workday.edit", "uses"=>"WorkdayController@edit", "middleware"=>["needsPermission"], "shield"=>"workday.edit"]);
//     Route::put('/workday/{workday}', ["as"=>"workday.update", "uses"=>"WorkdayController@update", "middleware"=>["needsPermission"], "shield"=>"workday.edit"]);
//     Route::delete('/workday/{workday}', ["as"=>"workday.destroy", "uses"=>"WorkdayController@destroy", "middleware"=>["needsPermission"], "shield"=>"workday.destroy"]);

//     //workday programs
//     Route::get('/workday_programs', ["as"=>"workday_programs.index", "uses"=>"WorkdayProgramsController@index", "middleware"=>["needsPermission"], "shield"=>"workday_program.index"]);
//     Route::get('/workday_programs/create', ["as"=>"workday_programs.create", "uses"=>"WorkdayProgramsController@create", "middleware"=>["needsPermission"], "shield"=>"workday_program.create"]);
//     Route::post('/workday_programs', ["as"=>"workday_programs.store", "uses"=>"WorkdayProgramsController@store", "middleware"=>["needsPermission"], "shield"=>"workday_program.create"]);
//     Route::get('/workday_programs/{workday_program}', ["as"=>"workday_programs.show", "uses"=>"WorkdayProgramsController@show", "middleware"=>["needsPermission"], "shield"=>"workday_program.show"]);
//     Route::get('/workday_programs/{workday_program}/edit', ["as"=>"workday_programs.edit", "uses"=>"WorkdayProgramsController@edit", "middleware"=>["needsPermission"], "shield"=>"workday_program.edit"]);
//     Route::put('/workday_programs/{workday_program}', ["as"=>"workday_programs.update", "uses"=>"WorkdayProgramsController@update", "middleware"=>["needsPermission"], "shield"=>"workday_program.edit"]);
//     Route::delete('/workday_programs/{workday_program}', ["as"=>"workday_programs.destroy", "uses"=>"WorkdayProgramsController@destroy", "middleware"=>["needsPermission"], "shield"=>"workday_program.destroy"]);
    
//     //PLAN OCCURRENCES

//     //Route::resource("plan_occurrences", "PlanOccurrenceController");
//     Route::get('/plan_occurrences', ["as"=>"plan_occurrences.index","uses" => "PlanOccurrenceController@index",'middleware'=>['needsPermission'], 'shield' => 'plan_occurrences.index']);
//     Route::get('/plan_occurrences/create_occurrence', ["as"=>"plan_occurrences.create-occurrence","uses" => "PlanOccurrenceController@createOccurrence"]);
//     Route::post('/plan_occurrences', ["as"=>"plan_occurrences.store","uses" => "PlanOccurrenceController@store",'middleware'=>['needsPermission'], 'shield' => 'plan_occurrences.create']);
//     Route::get('/plan_occurrences/create', ["as"=>"plan_occurrences.create","uses" => "PlanOccurrenceController@create",'middleware'=>['needsPermission'], 'shield' => 'plan_occurrences.create']);
//     Route::get('/plan_occurrences/{plan_occurrence}', ["as"=>"plan_occurrences.show","uses" => "PlanOccurrenceController@show",'middleware'=>['needsPermission'], 'shield' => 'plan_occurrences.show']);
//     Route::put('/plan_occurrences/{plan_occurrence}', ["as"=>"plan_occurrences.update","uses" => "PlanOccurrenceController@update",'middleware'=>['needsPermission'], 'shield' => 'plan_occurrences.edit']);
//     Route::get('/plan_occurrences/{plan_occurrence}/edit', ["as"=>"plan_occurrences.edit","uses" => "PlanOccurrenceController@edit",'middleware'=>['needsPermission'], 'shield' => 'plan_occurrences.edit']);
//     Route::delete('/plan_occurrences/{plan_occurrence}', ["as"=>"plan_occurrences.destroy","uses" => "PlanOccurrenceController@destroy",'middleware'=>['needsPermission'], 'shield' => 'plan_occurrences.destroy']);

//     //ZONES
//     Route::get('/zones', ['as'=>'zones.index', 'uses'=>'ZoneController@index', 'middleware'=>['needsPermission'], 'shield'=>'zone.index']);
//     Route::get('/zones/create', ['as'=>'zones.create', 'uses'=>'ZoneController@create', 'middleware'=>['needsPermission'], 'shield'=>'zone.create']);
//     Route::post('/zones', ['as'=>'zones.store', 'uses'=>'ZoneController@store', 'middleware'=>['needsPermission'], 'shield'=>'zone.create']);
//     Route::get('/zones/{zone}', ['as'=>'zones.show', 'uses'=>'ZoneController@show', 'middleware'=>['needsPermission'], 'shield'=>'zone.show']);
//     Route::get('/zones/{zone}/edit', ['as'=>'zones.edit', 'uses'=>'ZoneController@edit', 'middleware'=>['needsPermission'], 'shield'=>'zone.edit']);
//     Route::put('/zones/{zone}', ['as'=>'zones.update', 'uses'=>'ZoneController@update', 'middleware'=>['needsPermission'], 'shield'=>'zone.edit']);
//     Route::delete('/zones/{zone}', ['as'=>'zones.destroy', 'uses'=>'ZoneController@destroy', 'middleware'=>['needsPermission'], 'shield'=>'zone.destroy']);

//     //CLIENT
//     Route::get('/client', ['as'=>'client.index', 'uses'=>'UserClientController@index', 'middleware'=>['needsPermission'], 'shield'=>'client.index']);
    
//     //GROUP
//     Route::get('/groups', ['as'=>'groups.index', 'uses'=>'GroupController@index', 'middleware'=>['needsPermission'], 'shield'=>'groups.index']);
//     Route::get('/groups/create', ['as'=>'groups.create', 'uses'=>'GroupController@create', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::post('/groups', ['as'=>'groups.store', 'uses'=>'GroupController@store', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::get('/groups/{group}', ['as'=>'groups.show', 'uses'=>'GroupController@show', 'middleware'=>['needsPermission'], 'shield'=>'groups.show']);
//     Route::get('/groups/{group}/edit', ['as'=>'groups.edit', 'uses'=>'GroupController@edit', 'middleware'=>['needsPermission'], 'shield'=>'groups.edit']);
//     Route::put('/groups/{group}', ['as'=>'groups.update', 'uses'=>'GroupController@update', 'middleware'=>['needsPermission'], 'shield'=>'groups.edit']);
//     Route::delete('/groups/{group}', ['as'=>'groups.destroy', 'uses'=>'GroupController@destroy', 'middleware'=>['needsPermission'], 'shield'=>'groups.destroy']);

//     //ASSOCIACAO DE GRUPO VS USUARIO
//     Route::get('/groups/{group}/associate_users', ["as"=>"users.associate","uses" => "GroupUserController@associateUsers",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
//     Route::post('/groups/{group}/assigned_users', ["as"=>"users.associate.store","uses" => "GroupUserController@associateUserStore",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
//     Route::post('/groups/{group}/disassociate_users', ["as"=>"users.desassociate.store","uses" => "GroupUserController@disassociateUsers",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
    
//     //ASSOCIACAO DE USUARIO VS GRUPO
//     Route::get('/user/{user}/associate_groups', ["as"=>"groups.associate","uses" => "UserGroupController@associateGroups",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
//     Route::post('/user/{user}/assigned_groups', ["as"=>"groups.associate.store","uses" => "UserGroupController@associateGroupStore",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
//     Route::post('/user/{user}/disassociate_groups', ["as"=>"groups.desassociate.store","uses" => "UserGroupController@disassociateGroups",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
    
//     //ASSOCIACAO DE CLIENTES VS GRUPO
//     Route::get('/groups/{group}/associate_occurrence_clients', ["as"=>"users.associate.occurrence_clients","uses" => "GroupOccurrenceClientController@associateOccurrenceClients",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
//     Route::post('/groups/{group}/assigned_occurrence_clients', ["as"=>"users.associate.occurrence_clients.store","uses" => "GroupOccurrenceClientController@associateOccurrenceClientStore",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
//     Route::post('/groups/{group}/disassociate_occurrence_clients', ["as"=>"users.desassociate.occurrence_clients.store","uses" => "GroupOccurrenceClientController@disassociateOccurrenceClients",'middleware'=>['needsPermission'], 'shield' => 'groups.create']);
    
//     //TICKET TYPE
//     // Route::get('/ticket_types/{group}', ['as'=>'ticket_types.index', 'uses'=>'TicketTypeController@index', 'middleware'=>['needsPermission'], 'shield'=>'groups.index']);
//     Route::get('/ticket_types/{group}/create', ['as'=>'ticket_types.create', 'uses'=>'TicketTypeController@create', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::post('/ticket_types', ['as'=>'ticket_types.store', 'uses'=>'TicketTypeController@store', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::get('/ticket_types/{ticket_type}', ['as'=>'ticket_types.show', 'uses'=>'TicketTypeController@show', 'middleware'=>['needsPermission'], 'shield'=>'groups.show']);
//     Route::get('/ticket_types/{ticket_type}/edit', ['as'=>'ticket_types.edit', 'uses'=>'TicketTypeController@edit', 'middleware'=>['needsPermission'], 'shield'=>'groups.edit']);
//     Route::put('/ticket_types/{ticket_type}', ['as'=>'ticket_types.update', 'uses'=>'TicketTypeController@update', 'middleware'=>['needsPermission'], 'shield'=>'groups.edit']);
//     Route::delete('/ticket_types/{ticket_type}', ['as'=>'ticket_types.destroy', 'uses'=>'TicketTypeController@destroy', 'middleware'=>['needsPermission'], 'shield'=>'groups.destroy']);

//     // TICKET TYPE SECTION
//     Route::get('/ticket_type_sections/{ticket_type}/create', ['as'=>'ticket_type_sections.create', 'uses'=>'TicketTypeSectionController@create', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::post('/ticket_type_sections', ['as'=>'ticket_type_sections.store', 'uses'=>'TicketTypeSectionController@store', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::get('/ticket_type_sections/{ticket_type_section}/edit', ['as'=>'ticket_type_sections.edit', 'uses'=>'TicketTypeSectionController@edit', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::put('/ticket_type_sections/{ticket_type_section}', ['as'=>'ticket_type_sections.update', 'uses'=>'TicketTypeSectionController@update', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
//     Route::delete('/ticket_type_sections/{ticket_type_section}', ['as'=>'ticket_type_sections.destroy', 'uses'=>'TicketTypeSectionController@destroy', 'middleware'=>['needsPermission'], 'shield'=>'groups.create']);
    
//     //TICKET
//     Route::get('/tickets/{ticket}/create_os', ['as'=>'ticket.create_os', 'uses'=>'TicketController@createOS', 'middleware'=>['needsPermission'], 'shield'=>'occurrence.create']);
//     Route::get('/tickets', ['as'=>'ticket.index', 'uses'=>'TicketController@index', 'middleware'=>['needsPermission'], 'shield'=>'ticket.index']);
//     Route::get('/tickets/create', ['as'=>'ticket.create', 'uses'=>'TicketController@create', 'middleware'=>['needsPermission'], 'shield'=>'ticket.create']);
//     Route::post('/tickets/form_store', ['as'=>'ticket_form.store', 'uses'=>'TicketController@addNewFormTicket', 'middleware'=>['needsPermission'], 'shield'=>'ticket.create']);
//     Route::post('/tickets', ['as'=>'ticket.store', 'uses'=>'TicketController@store', 'middleware'=>['needsPermission'], 'shield'=>'ticket.create']);
//     Route::get('/tickets/{ticket}', ['as'=>'ticket.show', 'uses'=>'TicketController@show', 'middleware'=>['needsPermission'], 'shield'=>'ticket.show']);
//     Route::get('/tickets/{ticket}/edit', ['as'=>'ticket.edit', 'uses'=>'TicketController@edit', 'middleware'=>['needsPermission'], 'shield'=>'ticket.edit']);
//     Route::get('/tickets/{ticket}/cancel', ['as'=>'ticket.cancel', 'uses'=>'TicketController@cancel', 'middleware'=>['needsPermission'], 'shield'=>'ticket.edit']);
//     Route::put('/tickets/{ticket}/cancel/update', ['as'=>'ticket.cancel.update', 'uses'=>'TicketController@cancelUpdate', 'middleware'=>['needsPermission'], 'shield'=>'ticket.edit']);
//     Route::put('/tickets/{ticket}', ['as'=>'ticket.update', 'uses'=>'TicketController@update', 'middleware'=>['needsPermission'], 'shield'=>'ticket.edit']);
//     Route::delete('/tickets/{ticket}', ['as'=>'ticket.destroy', 'uses'=>'TicketController@destroy', 'middleware'=>['needsPermission'], 'shield'=>'ticket.destroy']);
    
//     //TICKET DASH
//     Route::get('/ticket/dashboard', ["as"=>"ticket.dashboard","uses" => "TicketController@dashboard",'middleware'=>['needsPermission'], 'shield' => 'admin.monitoring']);
    
//     //SELECT TICKET TYPE AJAX
//     Route::get('/ticket_type/type_ajax/{id}', ["as"=>"ticket_type.ajax","uses" => "TicketTypeController@listTicketTypeByGroup"]);
//     Route::get('/occurrence_clients/by_group_ajax/{id}', ["as"=>"occurrence_clients.by_group_ajax","uses" => "OccurrenceClientController@listOccurrenceClientByGroup"]);
//     Route::get('/ticket_type_section/ticket_type_section_ajax/{id}', ["as"=>"ticket_type_section.ticket_type_section_ajax","uses" => "TicketTypeSectionController@ticketTypeSectionByTicketType"]);
});

// //APP VERSION OPEN
// Route::get("/app/download",["as"=>"app_versions.latestVersion","uses" => "AppVersionController@latestVersion"]);
// Route::get("/app/{version?}",["as"=>"app_versions.download","uses" => "AppVersionController@download"]);



/**
 * DESCOMENTAR CODIGO ABAIXO PARA VER OS SQLS QUE ESTÃO SENDO EXECUTADOS
 */
//
// \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//     dump($query->sql);
//     dump($query->bindings);
//     dump($query->time);
// });

