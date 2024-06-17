<?php

use Artesaos\Defender\Facades\Defender;

Route::get('/', function () {
//    return view('auth.login');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', function(){
    if(Defender::hasRole('colaborador') || Defender::hasRole('gestor')){
        return redirect()->route('forms.index');
    }else{
        return redirect()->route('admin.index');
    }
});
// Route::get('/home', function(){
//     return redirect()->route('word.index');
// });

Route::group(['prefix' => 'admin','middleware'=>['auth','systemConfiguration', 'checkStatus', 'tenant', 'bindings']], function () {

    //Rotas
    // - Relatorio
    // - Formulario
    // - Usuario
    // - Email
    // - Setores

    Route::group(['prefix' => 'documentos'], function () {        
        Route::get('/',                             [App\Http\Controllers\WordController::class,            'index',            'middleware'=>['needsPermission'], 'shield' => 'admin.index' ])->name('admin.index');
        Route::get('/show/{document}',              [App\Http\Controllers\WordController::class,            'show',             'middleware'=>['needsPermission'], 'shield' => 'admin.show' ])->name('word.show');
        Route::get('/create',                       [App\Http\Controllers\WordController::class,            'create',           'middleware'=>['needsPermission'], 'shield' => 'admin.create' ])->name('word.create');
        Route::post('/{form}',                      [App\Http\Controllers\WordController::class,            'store',            'middleware'=>['needsPermission'], 'shield' => 'admin.store' ])->name('word.store');
        Route::get('/edit/{document}',              [App\Http\Controllers\WordController::class,            'edit',             'middleware'=>['needsPermission'], 'shield' => 'admin.edit' ])->name('word.edit');
        Route::put('/update',                       [App\Http\Controllers\WordController::class,            'update',           'middleware'=>['needsPermission'], 'shield' => 'admin.edit' ])->name('word.update');
        Route::delete('/delete/{document}',         [App\Http\Controllers\WordController::class,            'delete',           'middleware'=>['needsPermission'], 'shield' => 'admin.destroy' ])->name('word.destroy');
    });

    Route::group(['prefix' => 'emails'], function(){
        Route::get('/todos',                        [App\Http\Controllers\SecaoFormularioController::class, 'todos_email',      'middleware'=>['needsPermission'], 'shield' => 'form.mail'])->name('emails.todos');
        Route::get('/enviados',                     [App\Http\Controllers\SecaoFormularioController::class, 'enviado',          'middleware'=>['needsPermission'], 'shield' => 'form.send'])->name('emails.envio');
        Route::get('/confirmados',                  [App\Http\Controllers\SecaoFormularioController::class, 'confirmado',       'middleware'=>['needsPermission'], 'shield' => 'form.confirmed'])->name('emails.confirma');
    });

    Route::group(['prefix' => 'setores'], function () {
        Route::get('/',                                 [App\Http\Controllers\SetorController::class,           'index',            'middleware'=>['needsPermission'], 'shield' => 'team.index' ])->name('teams.index');
        Route::get('/create',                           [App\Http\Controllers\TeamController::class,            'create',           'middleware'=>['needsPermission'], 'shield' => 'team.create'])->name('teams.create');
        Route::get('/{team}',                           [App\Http\Controllers\TeamController::class,            'show',             'middleware'=>['needsPermission'], 'shield' => 'team.show'  ])->name('teams.show');
        Route::post('/',                                [App\Http\Controllers\TeamController::class,            'store',            'middleware'=>['needsPermission'], 'shield' => 'team.create'])->name('teams.store');
        Route::post('/{team}',                          [App\Http\Controllers\TeamController::class,            'destroy',          'middleware'=>['needsPermission'], 'shield' => 'team.destroy'])->name('teams.destroy');
    });

    Route::group(['prefix' => 'formularios'], function () {
        Route::get('/',                                 [App\Http\Controllers\FormularioController::class,      'index',            'middleware'=>['needsPermission'], 'shield' => 'form.index'])->name('forms.index');
        Route::get('/create',                           [App\Http\Controllers\FormularioController::class,      'create',           'middleware'=>['needsPermission'], 'shield' => 'form.create'])->name('forms.create');
        Route::post('/',                                [App\Http\Controllers\FormularioController::class,      'store',            'middleware'=>['needsPermission'], 'shield' => 'form.store'])->name('forms.store');
        Route::get('/preenchimento/{form}',             [App\Http\Controllers\FormularioController::class,      'preenchimento',    'middleware'=>['needsPermission'], 'shield' => 'form.edit'])->name('forms.preenchimento');
        Route::get('/vincula/{form}',                   [App\Http\Controllers\FormularioController::class,      'vincula',          'middleware'=>['needsPermission'], 'shield' => 'form.edit'])->name('forms.vincula');
        Route::get('/{form}/edit',                      [App\Http\Controllers\FormularioController::class,      'edit',             'middleware'=>['needsPermission'], 'shield' => 'form.edit'])->name('forms.edit');
        Route::get('/{form}',                           [App\Http\Controllers\FormularioController::class,      'show',             'middleware'=>['needsPermission'], 'shield' => 'form.show'])->name('forms.show');
        Route::delete('/{form}',                        [App\Http\Controllers\FormularioController::class,      'destroy',          'middleware'=>['needsPermission'], 'shield' => 'form.destroy'])->name('forms.destroy');
        Route::get('/inicia_ajax/{form}',               [App\Http\Controllers\FormularioController::class,      'inicia_ajax',      'middleware'=>['needsPermission'], 'shield' => 'form.index'])->name('forms.inicia_ajax');
        Route::get('/confirmation/{user}/{sec_form}',   [App\Http\Controllers\FormularioController::class,      'confirmacao',      'middleware'=>['needsPermission'], 'shield' => 'form.store'])->name('sec_forms.confirmacao');
    });

    Route::group(['prefix' => 'secoes'], function () {
        Route::get('/preencher/{form}',                 [App\Http\Controllers\SecaoFormularioController::class, 'preencher',        'middleware'=>['needsPermission'], 'shield' => 'form.edit'])->name('sec_forms.preencher');
        Route::put('/{sec_form}',                       [App\Http\Controllers\SecaoFormularioController::class, 'update',           'middleware'=>['needsPermission'], 'shield' => 'form.update'])->name('sec_forms.update');
        Route::put('/{sec_form}/ajax',                  [App\Http\Controllers\SecaoFormularioController::class, 'atualiza_texto',   'middleware'=>['needsPermission'], 'shield' => 'form.update'])->name('sec_forms.atualiza_texto');
        Route::get('/status/{sec_form}/{status}',       [App\Http\Controllers\SecaoFormularioController::class, 'status',           'middleware'=>['needsPermission'], 'shield' => 'form.update'])->name('sec_forms.status');
        Route::get('/correcao/{sec_form}/{user}',       [App\Http\Controllers\SecaoFormularioController::class, 'correcao',         'middleware'=>['needsPermission'], 'shield' => 'form.index'])->name('sec_forms.correcao');
        Route::post('/ajax',                            [App\Http\Controllers\SecaoFormularioController::class, 'store',            'middleware'=>['needsPermission'], 'shield' => 'form.store'])->name('sec_forms.ajax');
        Route::post('/{sec_form}/{destinatario}',       [App\Http\Controllers\SecaoFormularioController::class, 'email_correcao',   'middleware'=>['needsPermission'], 'shield' => 'form.store'])->name('sec_forms.email_correcao');
        Route::get('/consultar/{form}',                 [App\Http\Controllers\SecaoFormularioController::class, 'consulta_ajax',    'middleware'=>['needsPermission'], 'shield' => 'form.index'])->name('sec_forms.consultar');
    });

    Route::group(['prefix' => 'imagens'], function(){
        Route::get('/{imagem}/edit',                    [App\Http\Controllers\ImagemController::class,          'edit',             'middleware'=>['needsPermission'], 'shield' => 'imagem.edit'])->name('imagens.edit');
        Route::put('/{imagem}',                         [App\Http\Controllers\ImagemController::class,          'update',           'middleware'=>['needsPermission'], 'shield' => 'imagem.update'])->name('imagens.update');
        Route::post('/ajax',                            [App\Http\Controllers\ImagemController::class,          'store',            'middleware'=>['needsPermission'], 'shield' => 'imagem.store'])->name('imagens.ajax');
        Route::delete('/ajax/{imagem}/delete',          [App\Http\Controllers\ImagemController::class,          'destroy',          'middleware'=>['needsPermission'], 'shield' => 'imagem.destroy'])->name('imagens.destroy');
    });

    Route::group(['prefix' => 'configurations'], function () {
        Route::get('/',                                 [App\Http\Controllers\ConfigurationController::class,   'index',            'middleware'=>['needsPermission'], 'shield' => 'configuration.index'])->name('configurations.index');
        Route::get('/create',                           [App\Http\Controllers\ConfigurationController::class,   'create',           'middleware'=>['needsPermission'], 'shield' => 'configuration.create'])->name('configurations.create');
        Route::post('/',                                [App\Http\Controllers\ConfigurationController::class,   'store',            'middleware'=>['needsPermission'], 'shield' => 'configuration.store'])->name('configurations.store');
        Route::get('/{configuration}',                  [App\Http\Controllers\ConfigurationController::class,   'show',             'middleware'=>['needsPermission'], 'shield' => 'configuration.show'])->name('configurations.show');
        Route::get('/{configuration}/edit',             [App\Http\Controllers\ConfigurationController::class,   'edit',             'middleware'=>['needsPermission'], 'shield' => 'configuration.edit'])->name('configurations.edit');
        Route::put('/{configuration}',                  [App\Http\Controllers\ConfigurationController::class,   'update',           'middleware'=>['needsPermission'], 'shield' => 'configuration.edit'])->name('configurations.update');
        Route::delete('/{configuration}',               [App\Http\Controllers\ConfigurationController::class,   'destroy',          'middleware'=>['needsPermission'], 'shield' => 'configuration.destroy'])->name('configurations.destroy');

    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/',                                 [App\Http\Controllers\UserController::class,            'index',            'middleware'=>['needsPermission'], 'shield' => 'user.index'])->name('users.index');
        Route::get('/create',                           [App\Http\Controllers\UserController::class,            'create',           'middleware'=>['needsPermission'], 'shield' => 'user.create'])->name('users.create');
        Route::post('/',                                [App\Http\Controllers\UserController::class,            'store',            'middleware'=>['needsPermission'], 'shield' => 'user.store'])->name('users.store');
        Route::get('/{user}',                           [App\Http\Controllers\UserController::class,            'show',             'middleware'=>['needsPermission'], 'shield' => 'user.show'])->name('users.show');



        Route::get('/client',                   ["as"=>"users.clients","uses" => "UserController@clients",'middleware'=>['needsPermission'], 'shield' => 'users.index']);
        Route::get('/create',                   ["as"=>"users.create","uses" => "UserController@create",'middleware'=>['needsPermission'], 'shield' => 'users.create']);
        Route::post('/',                        ["as"=>"users.store","uses" => "UserController@store"]);

        Route::get('/{user}',                   ["as"=>"users.show","uses" => "UserController@show",'middleware'=>['needsPermission'], 'shield' => 'users.show']);
        Route::put('/theme_color_update',       ["as"=>"users.themeColor","uses" => "UserController@updateThemeColor"]);
        Route::put('/{user}',                   ["as"=>"users.update","uses" => "UserController@update"]);
        Route::get('/{user}/edit',              ["as"=>"users.edit","uses" => "UserController@edit",'middleware'=>['needsPermission'], 'shield' => 'users.edit']);
        Route::delete('/{user}',                ["as"=>"users.destroy","uses" => "UserController@destroy",'middleware'=>['needsPermission'], 'shield' => 'users.destroy']);
        Route::get('/change_password/{user}',   ["as"=>"users.change_password","uses" => "UserController@changePassword",'middleware'=>['needsPermission'], 'shield' => 'users.change_password']);
        Route::put('/update_password/{user}',   ["as"=>"users.update_password","uses" => "UserController@updatePassword",'middleware'=>['needsPermission'], 'shield' => 'users.change_password']);
    });

    Route::group(['prefix' => 'permissions'], function () {    
        Route::get('/',                         ["as"=>"permissions.index","uses" => "PermissionController@index",'middleware'=>['needsPermission'], 'shield' => 'permissions.index']);
        Route::post('/',                        ["as"=>"permissions.store","uses" => "PermissionController@store"]);
        Route::get('/create',                   ["as"=>"permissions.create","uses" => "PermissionController@create",'middleware'=>['needsPermission'], 'shield' => 'permissions.create']);
        Route::get('/{permission}',             ["as"=>"permissions.show","uses" => "PermissionController@show",'middleware'=>['needsPermission'], 'shield' => 'permissions.show']);
        Route::put('/{permission}',             ["as"=>"permissions.update","uses" => "PermissionController@update"]);
        Route::get('/{permission}/edit',        ["as"=>"permissions.edit","uses" => "PermissionController@edit",'middleware'=>['needsPermission'], 'shield' => 'permissions.edit']);
        Route::delete('/{permission}',          ["as"=>"permissions.destroy","uses" => "PermissionController@destroy",'middleware'=>['needsPermission'], 'shield' => 'permissions.destroy']);
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/',                         ["as"=>"roles.index","uses" => "RoleController@index",'middleware'=>['needsPermission'], 'shield' => 'roles.index']);
        Route::post('/',                        ["as"=>"roles.store","uses" => "RoleController@store"]);
        Route::get('/create',                   ["as"=>"roles.create","uses" => "RoleController@create",'middleware'=>['needsPermission'], 'shield' => 'roles.create']);
        Route::get('/{role}',                   ["as"=>"roles.show","uses" => "RoleController@show",'middleware'=>['needsPermission'], 'shield' => 'roles.show']);
        Route::put('/{role}',                   ["as"=>"roles.update","uses" => "RoleController@update"]);
        Route::get('/{role}/edit',              ["as"=>"roles.edit","uses" => "RoleController@edit",'middleware'=>['needsPermission'], 'shield' => 'roles.edit']);
        Route::delete('/{role}',                ["as"=>"roles.destroy","uses" => "RoleController@destroy",'middleware'=>['needsPermission'], 'shield' => 'roles.destroy']);
        Route::put('/permission/{id}',          ["as"=>"roles.permission.update","uses" => "RoleController@permissionUpdate"]);
    });
    
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

