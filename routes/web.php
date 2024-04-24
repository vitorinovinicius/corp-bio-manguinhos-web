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

Route::group(['prefix' => 'admin','middleware'=>['auth','systemConfiguration', 'checkStatus', 'tenant', 'bindings']], function () {

    Route::group(['prefix' => 'documentos'], function () {
        Route::get('/', ["as"=>"word.index","uses" => "WordController@index",'middleware'=>['needsPermission'], 'shield' => 'admin.index']);
        Route::get('/show/{document}', ["as"=>"word.show","uses" => "WordController@show",'middleware'=>['needsPermission'], 'shield' => 'admin.show']);
        Route::get('/create', ["as"=>"word.create","uses" => "WordController@create",'middleware'=>['needsPermission'], 'shield' => 'admin.create']);
        Route::get('/store', ["as"=>"word.store","uses" => "WordController@store",'middleware'=>['needsPermission'], 'shield' => 'admin.store']);
        Route::get('/edit/{document}', ["as"=>"word.edit","uses" => "WordController@edit",'middleware'=>['needsPermission'], 'shield' => 'admin.edit']);
        Route::put('/update', ["as"=>"word.update","uses" => "WordController@update",'middleware'=>['needsPermission'], 'shield' => 'admin.update']);
        Route::delete('/delete/{document}', ["as"=>"word.delete","uses" => "WordController@delete",'middleware'=>['needsPermission'], 'shield' => 'admin.destroy']);
    });

    Route::group(['prefix' => 'setores'], function () {
        Route::get('/',         [App\Http\Controllers\TeamController::class, 'index',   'middleware'=>['needsPermission'], 'shield' => 'team.index' ])->name('teams.index');
        Route::get('/create',   [App\Http\Controllers\TeamController::class, 'create',  'middleware'=>['needsPermission'], 'shield' => 'team.create'])->name('teams.create');
        Route::get('/{team}',   [App\Http\Controllers\TeamController::class, 'show',    'middleware'=>['needsPermission'], 'shield' => 'team.show'  ])->name('teams.show');
        Route::post('/',        [App\Http\Controllers\TeamController::class, 'store',    'middleware'=>['needsPermission'], 'shield' => 'team.create'])->name('teams.store');
        // Route::post('/', ["as"=>"teams.store","uses" => "TeamController@store",'middleware'=>['needsPermission'], 'shield' => 'team.create']);
        // Route::get('/{team}', ["as"=>"teams.show","uses" => "TeamController@show",'middleware'=>['needsPermission'], 'shield' => 'team.show']);
        // Route::get('/', ["as"=>"teams.index","uses" => "TeamController@index",'middleware'=>['needsPermission'], 'shield' => 'team.index']);
        // Route::get('/gantt', ["as"=>"teams.gantt","uses" => "TeamController@gantt",'middleware'=>['needsPermission'], 'shield' => 'team.edit']);
        // Route::get('/create', ["as"=>"teams.create","uses" => "TeamController@create",'middleware'=>['needsPermission'], 'shield' => 'team.create']);
        // Route::put('/{team}', ["as"=>"teams.update","uses" => "TeamController@update",'middleware'=>['needsPermission'], 'shield' => 'team.edit']);
        // Route::get('/{team}/edit', ["as"=>"teams.edit","uses" => "TeamController@edit",'middleware'=>['needsPermission'], 'shield' => 'team.edit']);
        // Route::delete('/{team}', ["as"=>"teams.destroy","uses" => "TeamController@destroy",'middleware'=>['needsPermission'], 'shield' => 'team.destroy']);
    });

    Route::group(['prefix' => 'formularios'], function () {
        Route::get('/',                 [App\Http\Controllers\FormularioController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'form.index'])->name('forms.index');
        Route::get('/create',           [App\Http\Controllers\FormularioController::class, 'create', 'middleware'=>['needsPermission'], 'shield' => 'form.create'])->name('forms.create');
        Route::post('/',                [App\Http\Controllers\FormularioController::class, 'store'])->name('forms.store');
        Route::get('/preenchimento',    [App\Http\Controllers\FormularioController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'form.index'])->name('forms.preenchimento');
        // Route::get('/', ["as"=>"forms.index","uses" => "FormController@index",'middleware'=>['needsPermission'], 'shield' => 'form.index']);
        // Route::get('/preenchimento', ["as"=>"forms.preenchimento","uses" => "FormController@index",'middleware'=>['needsPermission'], 'shield' => 'form.index']);
        // Route::post('/', ["as"=>"forms.store","uses" => "FormController@store"]);
        // Route::get('/create', ["as"=>"forms.create","uses" => "FormController@create",'middleware'=>['needsPermission'], 'shield' => 'form.create']);
        // Route::get('/{form}', ["as"=>"forms.show","uses" => "FormController@show",'middleware'=>['needsPermission'], 'shield' => 'form.show']);
        // Route::put('/{form}', ["as"=>"forms.update","uses" => "FormController@update"]);
        // Route::get('/{form}/edit', ["as"=>"forms.edit","uses" => "FormController@edit",'middleware'=>['needsPermission'], 'shield' => 'form.edit']);
        // Route::delete('/{form}', ["as"=>"forms.destroy","uses" => "FormController@destroy",'middleware'=>['needsPermission'], 'shield' => 'form.destroy']);
    });

    Route::group(['prefix' => 'configurations'], function () {
        // Route::get('/', ["as"=>"configurations.index","uses" => "ConfigurationController@index",'middleware'=>['needsPermission'], 'shield' => 'configuration.index']);
        Route::get('/create', ["as"=>"configurations.create","uses" => "ConfigurationController@create",'middleware'=>['needsPermission'], 'shield' => 'configuration.create']);
        Route::post('/', ["as"=>"configurations.store","uses" => "ConfigurationController@store",'middleware'=>['needsPermission'], 'shield' => 'configuration.create']);
        Route::get('/{configuration}', ["as"=>"configurations.show","uses" => "ConfigurationController@show",'middleware'=>['needsPermission'], 'shield' => 'configuration.show']);
        Route::get('/{configuration}/edit', ["as"=>"configurations.edit","uses" => "ConfigurationController@edit",'middleware'=>['needsPermission'], 'shield' => 'configuration.edit']);
        Route::put('/{configuration}', ["as"=>"configurations.update","uses" => "ConfigurationController@update",'middleware'=>['needsPermission'], 'shield' => 'configuration.edit']);
        Route::delete('/{configuration}', ["as"=>"configurations.destroy","uses" => "ConfigurationController@destroy",'middleware'=>['needsPermission'], 'shield' => 'configuration.destroy']);

        Route::get('/',         [App\Http\Controllers\ConfigurationController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'configuration.index'])->name('configurations.index');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/',         [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/create',   [App\Http\Controllers\UserController::class, 'create', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.create');
        Route::post('/',        [App\Http\Controllers\UserController::class, 'store'])->name('users.store');

        Route::get('/{user}', [App\Http\Controllers\UserController::class, 'show', 'middleware'=>['needsPermission'], 'shield' => 'user.show'])->name('users.show');
        Route::get('/', [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/', [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/', [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/', [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/', [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/', [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/', [App\Http\Controllers\UserController::class, 'index', 'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');

        Route::get('/client', ["as"=>"users.clients","uses" => "UserController@clients",'middleware'=>['needsPermission'], 'shield' => 'users.index']);
        Route::get('/create', ["as"=>"users.create","uses" => "UserController@create",'middleware'=>['needsPermission'], 'shield' => 'users.create']);
        Route::post('/', ["as"=>"users.store","uses" => "UserController@store"]);

        Route::get('/{user}', ["as"=>"users.show","uses" => "UserController@show",'middleware'=>['needsPermission'], 'shield' => 'users.show']);
        Route::put('/theme_color_update', ["as"=>"users.themeColor","uses" => "UserController@updateThemeColor"]);
        Route::put('/{user}', ["as"=>"users.update","uses" => "UserController@update"]);
        Route::get('/{user}/edit', ["as"=>"users.edit","uses" => "UserController@edit",'middleware'=>['needsPermission'], 'shield' => 'users.edit']);
        Route::delete('/{user}', ["as"=>"users.destroy","uses" => "UserController@destroy",'middleware'=>['needsPermission'], 'shield' => 'users.destroy']);
        Route::get('/change_password/{user}', ["as"=>"users.change_password","uses" => "UserController@changePassword",'middleware'=>['needsPermission'], 'shield' => 'users.change_password']);
        Route::put('/update_password/{user}', ["as"=>"users.update_password","uses" => "UserController@updatePassword",'middleware'=>['needsPermission'], 'shield' => 'users.change_password']);
    });

    Route::group(['prefix' => 'permissions'], function () {    
        Route::get('/', ["as"=>"permissions.index","uses" => "PermissionController@index",'middleware'=>['needsPermission'], 'shield' => 'permissions.index']);
        Route::post('/', ["as"=>"permissions.store","uses" => "PermissionController@store"]);
        Route::get('/create', ["as"=>"permissions.create","uses" => "PermissionController@create",'middleware'=>['needsPermission'], 'shield' => 'permissions.create']);
        Route::get('/{permission}', ["as"=>"permissions.show","uses" => "PermissionController@show",'middleware'=>['needsPermission'], 'shield' => 'permissions.show']);
        Route::put('/{permission}', ["as"=>"permissions.update","uses" => "PermissionController@update"]);
        Route::get('/{permission}/edit', ["as"=>"permissions.edit","uses" => "PermissionController@edit",'middleware'=>['needsPermission'], 'shield' => 'permissions.edit']);
        Route::delete('/{permission}', ["as"=>"permissions.destroy","uses" => "PermissionController@destroy",'middleware'=>['needsPermission'], 'shield' => 'permissions.destroy']);
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', ["as"=>"roles.index","uses" => "RoleController@index",'middleware'=>['needsPermission'], 'shield' => 'roles.index']);
        Route::post('/', ["as"=>"roles.store","uses" => "RoleController@store"]);
        Route::get('/create', ["as"=>"roles.create","uses" => "RoleController@create",'middleware'=>['needsPermission'], 'shield' => 'roles.create']);
        Route::get('/{role}', ["as"=>"roles.show","uses" => "RoleController@show",'middleware'=>['needsPermission'], 'shield' => 'roles.show']);
        Route::put('/{role}', ["as"=>"roles.update","uses" => "RoleController@update"]);
        Route::get('/{role}/edit', ["as"=>"roles.edit","uses" => "RoleController@edit",'middleware'=>['needsPermission'], 'shield' => 'roles.edit']);
        Route::delete('/{role}', ["as"=>"roles.destroy","uses" => "RoleController@destroy",'middleware'=>['needsPermission'], 'shield' => 'roles.destroy']);
        Route::put('/permission/{id}', ["as"=>"roles.permission.update","uses" => "RoleController@permissionUpdate"]);
    });


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

