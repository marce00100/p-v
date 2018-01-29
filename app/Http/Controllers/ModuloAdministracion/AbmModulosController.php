<?php

namespace App\Http\Controllers\ModuloAdministracion;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Models\ModuloAdministracion\Modulos;


class AbmModulosController extends Controller
{
  public function index()
  {
    return view('ModuloAdministracion.abm_modulos');
  }

// ======================================================================================================
// ======================================================================================================
// ======================================================================================================
  public function listarModulos(Request $request)
  {
   //if($request->ajax()) {
        $modls = Modulos::all();
        return \Response::json($modls);
   // }
  }

  public function guardarModulo(Request $request)
  {
    
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $descripcion = $request->input('descripcion');
      $url = $request->input('url');
      $activo = ($request->input('activo')? $request->input('activo'):'false');
      $titulo = $request->input('titulo');
      $icono = $request->input('icono');
      $tipo_menu = $request->input('tipo_menu');
      $orden = $request->input('orden');
      $created_at = date('Y-m-d H:i:s');
      $updated_at = date('Y-m-d H:i:s');

      if ( intval($id) > 0 ) {
          $affected = \DB::update('UPDATE modulos SET descripcion = ?, url = ?, activo = ?, titulo = ?, icono = ?, tipo_menu = ?, orden = ?, updated_at = ? WHERE id = ?', [$descripcion, $url, $activo, $titulo,  $icono, $tipo_menu, $orden, $updated_at, $id]);
          echo "Se actualizó satisfactoriamente ($affected)...<br/>";
      } elseif( $id == '' ) {
          \DB::insert('insert into modulos (descripcion, url, activo, titulo, icono, tipo_menu, orden, created_at) values(?, ?, ?, ?, ?, ?, ?, ?)', [$descripcion, $url, $activo, $titulo, $icono, $tipo_menu, $orden, $created_at]);
          $lastInsertId = app('db')->getPdo()->lastInsertId();

          echo "ID=$lastInsertId\nSe guardó satisfactoriamente ($lastInsertId)...<br/>";
      } else {
          echo "No se guardó nada :(<br/>";
      }

      if ( file_exists("./img/" . str_replace("uploads/", "uploads/tmp/", $icono)) ){ // Si aun sigue como archivo temporal
          rename( "./img/" . str_replace("uploads/", "uploads/tmp/", $icono), "./img/" . $icono );// Movemos el archivo temporal si es posible
      }
  }

  public function borrarModulo(Request $request)
  {
   
      if ( \Auth::user()->permisos_abm == 'false') {
        return "¡No Autorizado!";
      }

      $id = $request->input('id');
      $affected = \DB::delete('delete from modulos where id = ?', [$id]);
      echo "ID=OK\nSe borro satisfactoriamente ($affected)...<br/>";
  }  

  public function get_image(Request $request){

      $name = '';
      
      $image = request()->file('imagen_modulo'); // lo mismo: $image = Input::file('imagen_modulo');
/*
        $validator = $this->validate($request, [
            'imagen_modulo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
*/
      $validator = \Validator::make(
            [
                'image' => $image,
                'format'   => $image->getClientOriginalExtension()
            ],[
                'image' => 'required',
                'format'   => 'in:png,gif,jpeg,jpg' 
            ]
        );

      if ($validator->fails()) {
          $url_imagen = "uploads/invalid.png";
          $status = 'ERROR';
      } else {
          $Extencion = $image->getClientOriginalExtension();
          //$NombreArchivo = $image->getClientOriginalName();
          date_default_timezone_set('America/La_Paz');  // por si acaso no está configurado          
          $NombreArchivo = date("Y") . date("m") . date("d") . "_" . date("G")  . date("i")   . date("s") . "." . $Extencion;
          $file_dir = $request->file('imagen_modulo')->storeAs('uploads/tmp', $NombreArchivo, 'public_images_folder' ); // public_images_folder está en filesystems.php

          // directorio actual:  getcwd ();
          //borrar_tmps_antiguos("./img/uploads/tmp");  // no deja llamar a esta funcion por alguna razon :(((
          $directorio = "./img/uploads/tmp";
          if ($handle = opendir("$directorio")){
              while ((($file=readdir($handle))!==false) ){  
                  if ($file!='.' && $file!='..'){  // evitamos los directorios raiz
                      if (!is_dir("$directorio/$file")){
                          $horaAntes = time() - ( 1 * 60 * 60); // 0 días; 1 horas; 60 minutos; 60 segundos
                          $timeArchivo = filectime("$directorio/$file");  // creacion
                          if ( $timeArchivo < $horaAntes ) {// es mas antiguo q una hora
                              unlink("$directorio/$file");  // Borramos archivo
                          }
                      }
                  }
              }
              closedir($handle);
          }

          $url_imagen = $file_dir; //$image->getRealPath() ;
          $status = 'OK';
      }


      $data = array('url_imagen' => str_replace("/tmp", "", $url_imagen), 'url_imagen_tmp' =>  $url_imagen, 'status' => $status);
      echo json_encode($data);

  }

  // por alguna razon no puedo llamarlo desde la funcion get_image(Request $request) :((((
  public function borrar_tmps_antiguos($directorio) {  // borrará archivos de la carpera que sean mas antiguos que una hora atras
    if ($handle = opendir("$directorio")){
        while ((($file=readdir($handle))!==false) ){  
            if ($file!='.' && $file!='..'){  // evitamos los directorios raiz
                if (!is_dir("$directorio/$file")){
                    $horaAntes = time() - ( 1 * 60 * 60); // 0 días; 1 horas; 60 minutos; 60 segundos
                    $timeArchivo = filectime("$directorio/$file");  // creacion
                    if ( $timeArchivo < $horaAntes ) {// es mas antiguo q una hora
                        unlink("$directorio/$file");  // Borramos archivo
                    }
                }
            }
        }
        closedir($handle);
    }
  }


// ======================================================================================================
// ======================================================================================================
// ======================================================================================================

  public function __construct()
  {
      // $this->middleware('auth');
      $this->middleware(function ($request, $next) {
      $this->user= \Auth::user();
      $rol = (int) $this->user->id_rol;
      $sql = \DB::select("SELECT  m.* FROM roles_modulos um INNER JOIN modulos m ON um.id_modulo = m.id WHERE um.id_rol = ".$rol." ORDER BY orden ASC");
      $this->modulos = array();
      foreach ($sql as $mn) {
          array_push($this->modulos, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html));
      }


      $sql = \DB::select("SELECT m.* FROM menus m INNER JOIN roles_menu rm ON m.id = rm.id_menu WHERE rm.id_rol = ".$rol." AND id_modulo = 3 ORDER BY m.orden ASC");
      $this->menus = array();
      foreach ($sql as $mn) {

          $submenu = \DB::select("SELECT * FROM sub_menus WHERE id_menu = ".$mn->id." ORDER BY orden ASC");
          array_push($this->menus, array('id' => $mn->id,'titulo' => $mn->titulo,'descripcion' => $mn->descripcion,'url' => $mn->url,'icono' => $mn->icono,'id_html' => $mn->id_html,'submenus' => $submenu));
      }

      \View::share(['modulos'=> $this->modulos,'menus'=>$this->menus]);

      return $next($request);

      });

  }

}
