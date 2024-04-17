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


Route::group(['prefix' => 'admin','middleware'=>['auth','systemConfiguration', 'checkStatus', 'authUnique', 'tenant', 'bindings']], function () {

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
    
});

/**
 * DESCOMENTAR CODIGO ABAIXO PARA VER OS SQLS QUE ESTÃO SENDO EXECUTADOS
 */
//
// \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//     dump($query->sql);
//     dump($query->bindings);
//     dump($query->time);
// });

