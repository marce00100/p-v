<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('siep/dashboard', 'HomeController@siepRedirect');

/* -----------------------------------------------------------------------------
| Ruta general para llamar a una vista de la carpeta Resources/view , en el parametro
| omitir .blase.php y debe ser separado por puntos ej. modulopdes.dashboard
*/
Route::get(Config::get('app.urlBase') . '/{vista}', 'VistaController@index')->middleware('auth');


Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'moduloadministracion'),
          function() {
              Route::get('dashboard', 'ModuloAdministracion\DashboardController@index');

              Route::get('abm_usuarios', 'ModuloAdministracion\AbmUsuariosController@index');
              Route::get('listausers', 'ModuloAdministracion\AbmUsuariosController@listarUsers');
              Route::get('listaroles_usu', 'ModuloAdministracion\AbmUsuariosController@listarRoles');
              Route::get('listausers2', 'ModuloAdministracion\AbmUsuariosController@listarUsers2');
              Route::post('guardarusuario', 'ModuloAdministracion\AbmUsuariosController@guardarUsuario');
              Route::post('borrarusuario', 'ModuloAdministracion\AbmUsuariosController@borrarUsuario');
              Route::get('autocompletarinst', 'ModuloAdministracion\AbmUsuariosController@autocompletarInstitucion');

              Route::get('abm_modulos', 'ModuloAdministracion\AbmModulosController@index');
              Route::get('listamodulos', 'ModuloAdministracion\AbmModulosController@listarModulos');
              Route::post('guardarmodulo', 'ModuloAdministracion\AbmModulosController@guardarModulo');
              Route::post('borrarmodulo', 'ModuloAdministracion\AbmModulosController@borrarModulo');
              Route::post('imagenupload', 'ModuloAdministracion\AbmModulosController@get_image');

              Route::get('abm_menus', 'ModuloAdministracion\AbmMenusController@index');
              Route::get('listamenus', 'ModuloAdministracion\AbmMenusController@listarMenus');
              Route::get('listamenus2', 'ModuloAdministracion\AbmMenusController@listarMenus2');
              Route::get('listamodulos_mnu', 'ModuloAdministracion\AbmMenusController@listarModulos');
              Route::post('guardarmenu', 'ModuloAdministracion\AbmMenusController@guardarMenu');
              Route::post('borrarmenu', 'ModuloAdministracion\AbmMenusController@borrarMenu');
              Route::get('listasubmenus', 'ModuloAdministracion\AbmMenusController@listarSubmenus');
              Route::post('guardarsubmenu', 'ModuloAdministracion\AbmMenusController@guardarSubmenu');
              Route::post('borrarsubmenu', 'ModuloAdministracion\AbmMenusController@borrarSubmenu');

              Route::get('abm_roles', 'ModuloAdministracion\AbmRolesController@index');
              Route::get('listaroles', 'ModuloAdministracion\AbmRolesController@listarRoles');
              Route::get('listaroles2', 'ModuloAdministracion\AbmRolesController@listarRoles2');
              Route::get('listamenus_rol', 'ModuloAdministracion\AbmRolesController@listarMenus_rol');
              Route::get('listamodulos_rol', 'ModuloAdministracion\AbmRolesController@listarModulos_rol');
              Route::post('listamenusroles', 'ModuloAdministracion\AbmRolesController@listarMenusRoles');
              Route::post('listamodulosroles', 'ModuloAdministracion\AbmRolesController@listarModulosRoles');
              Route::post('guardarrol', 'ModuloAdministracion\AbmRolesController@guardarRol');
              Route::post('borrarrol', 'ModuloAdministracion\AbmRolesController@borrarRol');
              Route::post('guardarmenusroles', 'ModuloAdministracion\AbmRolesController@guardarMenusRoles');
              Route::post('guardarmodulosroles', 'ModuloAdministracion\AbmRolesController@guardarModulosRoles');

              Route::get('abm_dashmenu', 'ModuloAdministracion\AbmDashMenuController@index');
              Route::get('listadashmenu', 'ModuloAdministracion\AbmDashMenuController@listarDashMenu');
              Route::get('listadashconfigs', 'ModuloAdministracion\AbmDashMenuController@listarDashConfigs');
              Route::post('guardardashmenu', 'ModuloAdministracion\AbmDashMenuController@guardarDashMenu');
              Route::post('borrardashmenu', 'ModuloAdministracion\AbmDashMenuController@borrarDashMenu');


          }
      );
      Route::group(
          array('prefix' => 'moduloadministracion/ajax'),
          function() {
              Route::get('prueba', 'ModuloAdministracion\DashboardController@index');
          }
      );
});



Route::group(['middleware' => 'auth'],function(){
      Route::group(
          array('prefix' => 'modulopriorizacion'),
          function() {
              Route::get('dashboard', 'ModuloPriorizacion\DashboardController@index');
              Route::get('tablero', 'ModuloPriorizacion\TableroController@index');
          }
      );
      Route::group(
          array('prefix' => 'modulopriorizacion/ajax'),
          function() {
              Route::get('cargarhijos', 'ModuloPriorizacion\DashboardController@cargarHijos');
              Route::get('configurarfiltrovariable', 'ModuloPriorizacion\DashboardController@configurarFiltroVariable');
              Route::get('generardatosVE0001', 'ModuloPriorizacion\DashboardController@generarDatosVE0001');
              Route::get('generardatosVE0003', 'ModuloPriorizacion\DashboardController@generarDatosVE0003');
              Route::get('generardatosVE0002', 'ModuloPriorizacion\DashboardController@generarDatosVE0002');
              Route::get('obtenerDatosFiltro', 'ModuloPriorizacion\DashboardController@obtenerDatosFiltro');
          }
      );
      Route::group(
          array('prefix' => 'api/modulopriorizacion'),
          function() {
              Route::get('menustablero', 'ModuloPriorizacion\TableroController@menusTablero');
              Route::post('datosVariableEstadistica', 'ModuloPriorizacion\TableroController@datosVariableEstadistica');
              Route::post('tablero/guardaconfiguracion', 'ModuloPriorizacion\TableroController@guardaConfiguracion');
              Route::get('datosIndicadoresMeta', 'ModuloPriorizacion\TableroController@datosIndicadoresMeta');

          }
      );
});


