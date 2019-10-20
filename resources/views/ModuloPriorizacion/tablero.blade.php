@extends('layouts.plataforma')

@section('header')

<link rel="stylesheet" href="/css/visores.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="/plugins/modify/pivot___.css">
<link rel="stylesheet" href="/plugins/bower_components/bootstrap-urban-master/urban.css" type="text/css" />



    <link rel="stylesheet" type="text/css" href="/sty-mode-2/vendor/plugins/magnific/magnific-popup.css">
    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="/sty-mode-2/assets/admin-tools/admin-forms/css/admin-forms.css">
    <!-- Admin Modals CSS -->
    <link rel="stylesheet" type="text/css" href="/sty-mode-2/assets/admin-tools/admin-plugins/admin-modal/adminmodal.css">
    <!-- Theme CSS -->
    {{-- TODO habilitar theme.css --}}
    {{-- <link rel="stylesheet" type="text/css" href="/sty-mode-2/assets/skin/default_skin/css/theme.css"> --}}
    <link rel="stylesheet" type="text/css" href="/sty-mode-2/vendor/plugins/slick/slick.css" />
<style>
.popup-basic {
    position: relative;
    background: #FFF;
    width: auto;
    max-width: 700px;
    margin: 40px auto;
}
.sidenav {
    position: absolute;
    z-index: 1;
    background-color: #fff;
    overflow-x: hidden;
    transition: 1s;
    margin: 0px 0px 0px -20px;
}
.menuDetail{
    margin: 0px 0px 0px -20px;
    padding: 55px 2px 5px 72px ;
    overflow-y: scroll;
    /*transition: width 1s, margin-left 1s;*/
    font-size: 12px;
}
.sidenav a {
    text-decoration: none;
    color: #818181;
    display: block;
    transition: 1s;
}

.sidenav a:hover, .menuDetail a:hover {
    /*color: #f1f1f1;*/
    background-color: #F5F5DC;
}

.tituloDetail{
    color: #333;
}

.activoPri{
   background-color: #444449 !important; /* 4c5064 dark-dark */
   color: #f1f1f1 !important;
   border-color: #aed248;
}
.activoSub{
   background-color: #ABEBC6   !important;
   border-color: #aed248;
}

/*#contenido {
    transition: margin-left 1s;
    margin-left: 70px;
}*/
/*
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 12px;}
}*/

#chartdiv {
    width   : 100%;
    height  : 500px;
} 

.jqx-pivotgrid{
    background-color: #fff;
}

.oculta_pvt .pvtTdForRender, .oculta_pvt .pvtAxisContainer, .oculta_pvt  .pvtVals{
    display: none}

.activo{
    font-weight: bolder;
}
/*.pvtTotal, .pvtTotalLabel, .pvtGrandTotal {display: none}*/
</style>
@endsection


@section('content')
<div class='container-fluid'>
    <div class=row>
        {{-- ================================================ MENU  =========================================================== --}}
        <div class="col-md-3">
            <div class="input-group ">
                <input type="text" id="txtBuscaMenu" class="form-control" placeholder="buscar ..." style="border-radius: 8px 0 0 0">
                <span class="input-group-addon" style="border-radius:  0 8px 0px 0">
                    <i class="fa fa-search"></i>
                </span>
            </div>
            <div id="menuPrincipal"  class="sidenav list-group bordered border-default rounded-right w300" style="height: 720px" hidden="">
                <div href="#" id='btnmenu' class="p5" style="cursor: pointer;">
                    <i class="fa fa-bars fa-3x pull-right"></i>
                </div>   
            </div>
            <div id="menuDetalle" class="menuDetail " style="height: 720px; margin: 0; padding: 0" >
            </div>
        </div> 


        <div class="col-md-9 ">

            {{--  ===============================      VISTA INICIO  ========================--}}
            <div id="vistaInicio" style="width: 100%; height: 750px; background: white; overflow: hidden; position: relative;" >
                <h1 style="color:#eee; margin: 5px 25px">Pivot Visualizer</h1>
                <img src="/img/pivot-fondo-1.png" style=" opacity: 0.1; width: 90%; margin: 0px 0 0 50px ; position: absolute;"> 
            </div>


            {{-- ===============================       LOADING     ===============================================--}}
            <div id="loading" class="bg-white" style="width: 100%; height: 1000px; background: white" hidden="" > 
                <div style="left: 40%; top: 200px; width: 100%; position: absolute;">
                    <div  style="width: 20%; padding: 0 25px">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class=""> Cargango...</span>
                    </div>
                    <div class="progress progress-striped active" style="margin-top: 20px; width: 20%;height: 20px"><div class="progress-bar" style="width: 100%"></div></div>                   
                </div>
            </div>


            <div id="contenedor" hidden="">

                <div class="row m-0">
                    {{-- ============================= CONTENEDOR ====================================== --}}
                    <div id="contenedorDatos" style="height: 1300px; max-height: auto; width: 100%; "  class="bg-white p15 mt-1" > 

                         {{-- ===========================    BOTONES DE PANTALLAS y CONFIGURACION  ===========================  --}}
                        <div id="divTitulo" class="row mb5">
                            <div id="titulo" class="col-sm-9"></div>
                            <div class="col-sm-3">      

                                <a href="javascript:void(0)" id="btn_grafico" class="btn btn-default btn-xs  " hidden="" ><i class="fa fa-lg fa-bar-chart"></i></a>
                                <a href="javascript:void(0)" id="btn_tabla" class="btn btn-default btn-xs " hidden=""><i class="fa fa-lg fa-table"></i></a>
                                
                                <div class="pull-right">
                                    <a href="#" id="btn_vista_Usuario" class="text-default"  title ="Cambiar el modo de vista Administrador / Solo Lectura" >
                                        <i class="fa fa-lg fa-user-plus   pr5 pl5  round"></i><span ></span>
                                    </a>
                                    <a id="btn_menuconfig_acciones" class="dropdown-toggle text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                                        <i class="fa fa-lg fa-cog  pr5 pl5  round"></i><span ></span>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <h5 class="ml10"><b>Sets predefinidos</b></h5>
                                        <li><a href="javascript:void(0)" id="predef_new"><i class="fa fa-clone fa-lg p2"></i><span> Guardar como Nueva  </span></a></li>
                                        <li><a href="javascript:void(0)" id="predef_update"><i class="fa fa-save fa-lg p2"></i><span> Guardar/actualizar Cambios</span></a></li>
                                        <li><a href="javascript:void(0)" id="predef_del"><i class="fa fa-trash-o fa-lg p2 text-danger"></i><span> Eliminar actual  </span></a></li>
                                        <h5 class="ml10"><b>Anexos externos</b></h5>
                                        <li><a href="javascript:void(0)" id="anexar_archivo_ext"><i class="fa fa-stack-overflow fa-lg p2"></i><span> Archivos para Descargas </span></a></li>
                                        <li><a href="javascript:void(0)" id="anexar_dashboard_ext"><i class="fa fa-external-link fa-lg p2"></i><span> Dashboard Externo </span></a></li>
                                    </ul>
                                    
                                </div>
                                
                            </div>

                            <div id="submenus_pv" class="topbar-left ml30">                                
                                <ul class="nav nav-list nav-list-topbar pull-left pbn mn">
                                    <li id="pv_submenu_1">
                                        <span style="cursor: pointer; margin-left: 40px"  id="1">Visualizador  </span>
                                    </li>
                                    <li id="pv_submenu_2">
                                        <span style="cursor: pointer; margin-left: 40px"  id="2">Descargas  </span>
                                    </li>
                                    <li id="pv_submenu_3">
                                        <span style="cursor: pointer; margin-left: 40px"  id="3">Dashboards</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr class="mb5 mt5">

                        
                        <div id="contenido_principal">

                            {{-- =========================================== CONTENIDO PIVOT ============================================================--}}
                            <div class="col-md-12 slick-slide" id="contenido_pivot">
                                {{-- ===============================     Iconos y Sets Predefinidos   ===========================  --}}
                                <div class="row bg-dark-dark">
                                    <div id="contenedorPredefinidos" class="col-sm-12 stats-row m-0 p-3" >
                                    </div>
                                    <hr>
                                </div>

                                {{-- *============================================   PIVOT  PARA ADMIN *====================================================== --}}
                                <div id='divDatosUI' class="divPivot">
                                    <div id=tituloDatosUI class="mb15 tituloDatos"></div>
                                    <div class="row m-0 bg-white mt-2" style="overflow: auto; width: 100%; max-height: 600px; padding: 2px">
                                        <div id="pvtTableUI" ></div>                
                                    </div>
                                    <hr style="margin: 25px 0">
                                </div>
                                
                                {{-- ============================================ CHARTS ==================--}}
                                <div id='divGrafico'>
                                    <div id="tituloGrafico" class="mb15"></div>
                                    <div class="row" >
                                        <div class="col-sm-2" id="configuracionGrafico">
                                            <h5>OPCIONES DE GRAFICO</h5>
                                            <label >Tipo Gráfico</label>
                                            <select id="opcionesGrafico"  style="width: 100%">
                                                <option value="spline">Linea</option>
                                                <option value="column">Columnas</option>
                                                <option value="column-stacked">Columnas apiladas</option>    
                                                <option value="column-stackedp">Columnas apiladas en proporcion</option>
                                                <option value="bar">Barras</option> 
                                                <option value="bar-stacked">Barras apiladas</option>    
                                                <option value="bar-stackedp">Barras apiladas en proporcion</option>
                                                <option value="area">Area</option>
                                                <option value="area-stacked">Areas apiladas</option>    
                                                <option value="area-stackedp" >Areas apiladas en proporcion</option>
                                                <option value="pie" >Dona</option> 
                                            </select>
                                            <hr>                                    
                                            <label class="block"  ><input type="checkbox" id="viewlabel" name="viewlabel" /> Ver Datos</label>
                                            <label class="block" ><input type="checkbox" id="view3d" name="view3d" /> 3D</label>
                                        </div>
                                        <div class="col-sm-10" style="height: 400px">
                                            <div id="divChart" style="font-family: arial; width: 60%; min-height: 100%; margin: 0 auto"></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ===========================       PIVOT PARA SOLO VER    =========================== --}}
                                <div id='divDatosRead' class="divPivot oculta_pvt " >
                                    <hr style="margin: 25px 0">
                                    <div id=tituloDatos class="mb15 tituloDatos"></div>
                                    <div class="row m-0 bg-white mt-2" style="overflow: auto; width: 100%; max-height: 600px; padding: 2px">
                                        <div id="pvtTableUIRead"  ></div>                
                                    </div>
                                </div>

                            </div>

                            {{-- =========================== Contenidooo de Archivos Externos Descargas ===================== --}}
                            <div id="archivos_ext" class="col-md-12 slick-slide">
                                <h4>Archivos</h4>
                                <div class="m25"></div>
                                
                            </div>

                            {{-- =========================== Contenidooo de Dash externos =========================== --}}
                            <div id="contenido_ext" class="col-md-12 slick-slide">
                                <h4>Otras fuentes (dashboards)</h4>
                                <select class="form-control" id="iframe_combo"></select>

                                <iframe style="width: 98%; height: 900px; " id="iframe_url" src="">
                                    
                                </iframe>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <div id="predefModal" class="modal  " role="dialog"> --}}
<div id="predefModal" class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide " >
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-dark-light">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title bg-dark-light" id="modal_titulo"></h4>
                <input class="hidden"  id="accion">
            </div>
            <div class="modal-body" >
                <div>
                    <div class="stat-item item_campo_predefinido containertipoimg col-sm-2 offset-5"  title=''  style="cursor:pointer;">
                        <img id="predef_imagen_previsualizacion"  src='' alt='' class="image" style="width:80px;height:60px">
                        <div class="filt" >
                            <div id='dixTextoImagen' class="text"></div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-horizontal" role="form" id='predefNewUpdate'>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="predef_etiqueta">Etiqueta visible</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="predef_etiqueta" placeholder="Etiqueta visible ">
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-md-12">Imágenes</label>   <input type="hidden" id="predef_imagen">
                        <div id="selectImagenes" style="width: 90%; margin: 0px auto; overflow-x: scroll;">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-md-3" for="predef_posicion">Posicion</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="predef_posicion" placeholder="Posicion 1,2,3.. ">
                        </div>
                    </div> 
                </div>

                <div id="predefDel">
                    <div class="bg-danger-dark row m25" style="border-radius: 6px">
                        <div class="col-sm-2">
                            <i class="fa fa-exclamation-triangle fa-3x mt15"></i>
                        </div>
                        <div class="col-sm-9">
                            <h5 style="color: white">Se va a Eliminar la configuración que esta actualmente visualizando. Si elimina se perdará definitivamente dicha configuracion de visualizacion, pero no los datos.</h5>
                        </div>
                    </div>
                    <h5 class=""><span><b>Está seguro que desea eliminar la configuarcion de visualizacion de datos actual ?</b></span></h5>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnGuardar" type="submit" class="btn btn-primary "   ><i class="fa fa-check"></i><span> Guardar</span></button>
                <button id="btnCancelar" class="btn btn-warning pv_cancel" ><i class="fa fa-times"></i><span> Cancelar</span></button>
                
            </div>
        </div>
    </div>
</div>


{{-- ANEXAR MODAL --}}
<div id="anexarModal" class="white-popup-block popup-basic admin-form mfp-with-anim mfp-hide w500" >
    <div class="">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-dark-light">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title bg-dark-light" id="modal_titulo"></h4>
                
            </div>
            <div class="modal-body" >
                <form id="form_anexos"  method="post" action="/" enctype="multipart/form-data">
                    <div class="form" role="form" id=''>
                        <input class="hidden"  id="accion">
                        <div class="form-group div_anexar_dashboard" >
                            <label class="control-label" for="anx_dashboard">Url o tag del dashboard</label>
                            <div class="">
                                <textarea class="form-control" id="anx_dashboard" placeholder="Url / tag "></textarea>
                            </div>
                        </div>                      


                        <div class="section div_anexar_archivo">
                            <label class="field prepend-icon file">
                                <span class="button bg-warning "><i class="fa fa-search"></i> Buscar archivo</span>
                                <input name="anx_archivo" id="anx_archivo" class="gui-file" onchange="document.getElementById('uploader').value = this.value;" type="file">
                                <input class="gui-input" id="uploader" type="text" placeholder="Archivo ...">
                                <label class="field-icon"><i class="fa fa-upload"></i>
                                </label>
                            </label>
                        </div>  

                        <div class="form-group mb2" id="" >
                            <label class="control-label" for="descripcion">Descripción</label>
                            <div class="">
                                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="breve descripción">
                            </div>
                        </div>



                        <div class="form-group"><button class="btn btn-sm btn-success w300" id="btn_anexar" style="margin:0 25%"> <i class="fa fa-plus"></i> <span> Agregar</span> </button></div>

                        <label class="col-md-12 bg-bluegrey text-white">Elementos existentes</label>
                        <div id="elementos" class="bordered" style="height: 300px; margin: 0px auto;" >
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnGuardar" type="submit" class="btn btn-primary pv_guardar "   ><i class="fa fa-check"></i><span> Guardar</span></button>
                <button id="btnCancelar" class="btn btn-warning pv_cancel ml15" ><i class="fa fa-times"></i><span> Cancelar</span></button>
                
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-head')
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/highcharts.js"></script>
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/highcharts-3d.js"></script>
<script type="text/javascript" src="/plugins/Highcharts-6.0.4/code/modules/exporting.js"></script>
{{-- <script type="text/javascript" src="/plugins/moCdify/hightcharts/themes/dark-unica_.src.js"></script> --}}
<script type="text/javascript" src="/plugins/modify/hightcharts/themes/grid_.src.js"></script>
{{-- <script type="text/javascript" src="/plugins/modify/hightcharts/themes/sand-signika_.src.js"></script> --}}

<script type="text/javascript" src="/plugins/pivottable/dist/jquery-ui.min.js"></script>
<script type="text/javascript" src="/plugins/modify/pivot___.js"></script>
<script type="text/javascript" src="/plugins/modify/pivot___.es.js"></script>

<script type="text/javascript" src="{{ asset('sty-mode-2/vendor/plugins/magnific/jquery.magnific-popup.js') }}"></script>
<script type="text/javascript" src="/sty-mode-2/vendor/plugins/slick/slick.min.js"></script>
<script type="text/javascript" src="/plugins/underscore/underscore-min.js"></script>


{{-- *********************  MAIN APP ************************ --}}
<script type="text/javascript">
    /*-----------------------------------------------------------------------
     *      cnf variables de configuracion  del modulo, como coleres, iconos y otros
     */
    var cnf = {
        rutabase: '/api/modulopriorizacion',
        m : {   // m menu
            activoPri : 'activoPri',
            activoSub : 'activoSub',
            bgSub : 'bg-dark-dark',
            bgHeaderSub : 'bg-dark-light',
            bgTituloSub : 'bg-default-light tituloDetail',
            img : {
                '01' : '/img/priori-1.png',
                '02' : '/img/priori-2.png',
                '03' : '/img/priori-3.png',
                '04' : '/img/priori-4.png',
                '05' : '/img/priori-5.png',
                '06' : '/img/priori-6.png',
                '11' : '/img/priori-1.png',

                '21' : '/img/priori-1.png',
                '22' : '/img/priori-5.png',
                '23' : '/img/priori-4.png',
                '24' : '/img/priori-3.png',
                '25' : '/img/priori-2.png',
                '26' : '/img/priori-6.png',
                '27' : '/img/priori-1.png',
            },
        },
        c : {  // c contenido
            img: {  
                'imagen_por_default':'/img/icon-graf/3.png',
                '1':'/img/icon-graf/1.png',
                '2':'/img/icon-graf/2.png',
                '3':'/img/icon-graf/3.png',
                '4':'/img/icon-graf/4.png',
                '5':'/img/icon-graf/5.png',
                '6':'/img/icon-graf/6.png',
                '7':'/img/icon-graf/7.png',
                '8':'/img/icon-graf/8.png',
                '9':'/img/icon-graf/9.png',
                '10':'/img/icon-graf/10.png',
                '11':'/img/icon-graf/11.png',
                '12':'/img/icon-graf/12.png',
                '13':'/img/icon-graf/13.png',
                '14':'/img/icon-graf/14.png',
                '15':'/img/icon-graf/15.png',
                '16':'/img/icon-graf/16.png',
                '17':'/img/icon-graf/17.png',
                '18':'/img/icon-graf/18.png',
                '19':'/img/icon-graf/19.png',
                '20':'/img/icon-graf/20.png',
                '21':'/img/icon-graf/21.png',
                '22':'/img/icon-graf/22.png',
                '23':'/img/icon-graf/23.png',
                '24':'/img/icon-graf/24.png',
                '25':'/img/icon-graf/25.png',
                '26':'/img/icon-graf/26.png',
                '27':'/img/icon-graf/27.png',
                '28':'/img/icon-graf/28.png',
                '29':'/img/icon-graf/29.png',
                '30':'/img/icon-graf/30.png',
                '31':'/img/icon-graf/31.png',
                '32':'/img/icon-graf/32.png',
                '33':'/img/icon-graf/33.png',
                '34':'/img/icon-graf/34.png',
                '35':'/img/icon-graf/35.png',
                '36':'/img/icon-graf/36.png',
                'departamento':'/img/icon-graf/r_departamento.png',  
                'urbano_rural':'/img/icon-graf/r_urbano_rural.png',
                'genero':'/img/icon-graf/genero.png',
                'pobreza_extrema':'/img/icon-graf/pex.png',
                'pobreza_moderada':'/img/icon-graf/pmo.png',
                'desempleo':'/img/icon-graf/desem.png',
            },            
        },

    }

    /*-----------------------------------------------------------------------
     *      ctxG variable que contiene el contexto global, variables globales
     */
    var ctxG = {
        nodos : [],
        nodoSel : {},  // elemento menu  nodo seleccionado
        varEstActual : {},    // objeto JSON VariableEstadisticaActual del nodoSel.configuracion 
        varEstActual_Unidades:{}, // objeto de las unidades de medida
        varEstActual_ArchivosExt: {},
        collection : [],
        pivotInstancia:{},
        pivot:{
            data : [], // Datos del pivot  en formato collection 
            dataGraph : [],
            dimColumna : [],
            dimFila : [],
            total: 0, t_cols : {}, t_filas : {}, total_p : 0, tp_cols : {}, tp_filas: {},
        },
        showModal : function(modal){
            $(".state-error").removeClass("state-error")
            // $(modal + " em").remove();
            $.magnificPopup.open({
                removalDelay: 500, 
                // focus: '#pmra_id_pilar',
                items: {
                    src: modal
                },
                // overflowY: 'hidden', //
                callbacks: {
                    beforeOpen: function(e) {
                        var Animation = "mfp-zoomIn";
                        this.st.mainClass = Animation;
                    }
                },
                midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
            });
        }, 
    }

    /*-----------------------------------------------------------------------
     *      ctxM variable que contiene el contexto del menu , 
     */
    var ctxM = {
        menuPrincipal : $("#menuPrincipal"), 
        menuDetalle : $("#menuDetalle"),
        buscadorMenu: $("#txtBuscaMenu"),
        btnmenu : $("#btnmenu"), // boton de abrir y cerrar
        menup_estado : 1, // { 1: abierto, 2: cerrado}
        abrirCerrarMenu : function(){
            if(ctxM.menup_estado == 1)
                ctxM.menuPrincipal.css('width', "70px");        
            else if(ctxM.menup_estado == 0)        
                ctxM.menuPrincipal.css('width', "300px");
            ctxM.menup_estado = Math.abs(ctxM.menup_estado - 1);
        },
        creaMenuBaseHtml : function(){
            $.get(cnf.rutabase + '/menustablero', function(res){
                ctxG.nodos = res.nodosMenu;                
                for(i=0; i< ctxG.nodos.length; i++ )
                {
                    var menu = ctxG.nodos[i];
                    var html = '<a href="#" id="' + menu.cod_str + '"  cod_str="' +  menu.cod_str + '" \
                                    class="list-group-item m-0 row p-0 p-t-10 p-b-10 w300 nodo_menu" style="overflow:hidden;" title="' + menu.nombre + '">\
                                        <div class="col-md-3">\
                                            <img src="' + cnf.m.img[menu.cod_str] + '" class="img-circle" style="width:50px; height:50px">\
                                        </div>\
                                        <div class="col-md-9" ><span class="align-middle">' + menu.nombre + '</span></div>\
                                </a>';
                    $("#menuPrincipal").append(html);
                }
                ctxM.menuDetalle.addClass(cnf.m.bgSub);
                ctxC.workspace(res.mensaje.split('_')[1]);

                //TODO es para el uso exclusivo de los indicadores, que se carguen por defeto
                    ctxG.nodoSel = ctxM.obtenerNodo('11');
                    ctxM.crearSubmenusHtml(ctxG.nodoSel);
                    ctxM.buscadorMenu.val('');
            })                     
        },
        crearSubmenusHtml : function(itemSel){
            if(itemSel != null)
            {
                ctxM.menuDetalle.html('');
                var submenusN2 = itemSel.hijos;
                htmlHeaderCollapse = (submenusN2.length > 1) ? 'collapse' : '';
                for(i=0; i< submenusN2.length; i++)
                {
                    subN2 = submenusN2[i];
                    // cabecera del menu desplegable
                    var htmlHeader = "<div class='panel-heading p-t-10 p-b-10 mt-1  " + cnf.m.bgHeaderSub +" ' style='cursor:pointer;'\
                                        data-toggle='collapse' href='#" + subN2.id + "' > " + subN2.nombre + "\
                                      </div>"
                    // contenido de cada menu desplegable , elementos nivel 3 que pueden ser del tipo titulo o link
                    htmlContent = "<div id='" + subN2.id + "' class='panel-collapse " + htmlHeaderCollapse + " ' >\
                                        <ul class='list-group m-0'>";

                    for(j=0; j< subN2.hijos.length; j++)
                    {
                        var elem = subN2.hijos[j];
                        if (elem.tipo == 'titulo')
                            htmlContent += "<div class='list-group-item " + cnf.m.bgTituloSub + " ' >" + elem.nombre + "</div>";
                        else if (elem.tipo == 'link')
                        {
                            htmlContent += "<a class='list-group-item nodo_menu bg-white " + ((elem.id_dash_config) ? "" : "disabled" ) + " ' href='#'  id='" + elem.cod_str + "' >" + elem.nombre + ((elem.id_dash_config)? "<i class='fa fa-tags  pull-right'></i>" : "" ) + "</a>" ;
                        }
                    }
                    htmlContent += "</ul></div>";
                    ctxM.menuDetalle.append(/*"<div class='panel panel-info m-b-5'>"  + */ htmlHeader + htmlContent /* + "</div>" */ );
                }
            }
        },
        activarElem: function(elem)
        {
            if(elem.nivel == 1)
            {
                $("#menuPrincipal a.nodo_menu").removeClass(cnf.m.activoPri);
                $("#menuPrincipal #" + elem.cod_str).addClass(cnf.m.activoPri);
            }
            else if(elem.nivel == 3)
            {
                $("#menuDetalle a.nodo_menu").removeClass(cnf.m.activoSub);
                $("#menuDetalle #" + elem.cod_str).addClass(cnf.m.activoSub);
            }
        },
        obtenerNodo :  function(cod_str){
            interacciones = cod_str.length / 2;
            var elem = {};
            arr = ctxG.nodos;
            for(i = 0 ; i< interacciones; i++ ) {
                elem = arr.find(function(item){                  
                    return  (item.cod_str == cod_str.substring(0, item.nivel * 2 ))
                });
                if(elem.cod_str == cod_str)
                    return elem;

                if(elem && elem.hijos && elem.hijos.length > 0)
                    arr = elem.hijos;
            }
            return null;

        },
        buscaMenu: function(){
            var filtro = ctxM.buscadorMenu.val().toUpperCase();
            var elems = $("#menuDetalle ul a");   
            for (i = 0; i < elems.length; i++) {
                var elem = elems.eq(i);
                if (elem.html().toString().toUpperCase().indexOf(filtro) > -1) {
                    elem.show();
                } else {
                    elem.hide();

                }
            }
        }
    }

    /*-----------------------------------------------------------------------
     *      ctxC variable que contiene el contexto del Contenido, contenedorPredefinidos, titulos, new update del config
     */
    var ctxC = {
        contenedorPredefinidos: $("#contenedorPredefinidos"),
        contenedorDatos : $("#contenedorDatos"),
        divDatos : $(".divPivot"), // los dos pivot de admin y consulta
        divGrafico : $("#divGrafico"),
        titulo: $("#titulo"),
        tituloGrafico: $("#tituloGrafico"),
        tituloDatos: $(".tituloDatos"),  //son dos uno de admin y otro de consulta       
        cargarHTMLPredefinidos: function(variableEst){
            ctxC.contenedorPredefinidos.html('');
            predef = variableEst.sets_predefinidos;
            for(i=0; i< predef.length; i++)
            {
                item = predef[i];
                imagen = cnf.c.img['imagen_por_default'];
                for(key in cnf.c.img)
                {                     
                    // if(key.indexOf(item.imagen) !== -1 && item.imagen != '')  //Si existe la coincidencia que alguna imagen en cnf.c.img contenga la imagen del predefido entonces se asigna esa imagen
                    if(item.imagen != '' && key == item.imagen)
                        imagen = cnf.c.img[key]; 
                }

                var divImghtml = '<div id="' + i + '" class="item_campo_predefinido containertipoimg ml15"  title="' + item.etiqueta + '"  style="cursor:pointer; float:left">\
                                        <img  src="' + imagen +'" alt="' + item.etiqueta + '" class="image" style="width:50px;height:40px">\
                                        <div class="filt" >\
                                            <div style="font-size:9px" class="text text-default">' + item.etiqueta + '</div>\
                                        </div>\
                                    </div>';
                ctxC.contenedorPredefinidos.append(divImghtml);
            }            
        },
        cargarAnexosExternos: function(variableEst, archivos_ext){
            dashboards_ext = variableEst.dashboards_ext;
            var pv_m = 0;

            if(dashboards_ext && dashboards_ext.length > 0){

                var opts =  dashboards_ext.reduce(function(carry, elem){
                    return carry + `<option value="${elem.url}">${elem.descripcion}</option>`;
                },'');
                $("#iframe_combo").html(opts);
                $("#iframe_url").attr('src', $("#iframe_combo").val());
                $("#pv_submenu_3").show();
                pv_m ++;
            }
            else{
                $("#iframe_combo").html('<option>SIN INFO</option>');
                $("#pv_submenu_3").hide();
            }


            if(archivos_ext && archivos_ext.length > 0){
                var html = archivos_ext.reduce(function(carry, elem){
                    return carry + `<div class="row bb m-b-10">
                                        <div class="col-sm-1"><i class="fa fa-square-o " ></i></div>
                                        <div class="col-sm-8  ">Archivo: <a href="/archivos/archivos_anexos/${elem.nombre}" target="_blank">${elem.nombre} </a><br>
                                            ${elem.descripcion}
                                        </div>
                                                    
                                        
                                    </div>`
                },'');
                $("#archivos_ext div").html(html);
                $("#pv_submenu_2").show();
                pv_m ++;
            }
            else{
                $("#pv_submenu_2").hide();
            }

            (pv_m == 0) ? $("#submenus_pv").hide(150) : $("#submenus_pv").show(150);

        },
        submenu_pv_activo :  function(index){
            $("#submenus_pv li").removeClass('activo');            
            $("#pv_submenu_" + (index)).addClass('activo');
            $("#contenido_principal").slickGoTo(index-1);
        },
        obtenerData: function(nodoSel){
            ctxC.showLoading(1);            
            $.post(cnf.rutabase + '/datosVariableEstadistica', 
                    {
                        id_dash_config: nodoSel.id_dash_config, 
                        _token : $('input[name=_token]').val(),
                    }, function(res){   

                ctxG.varEstActual = res.configuracionObj;
                ctxG.set_predef_actual = ctxG.varEstActual.sets_predefinidos[0]; // por defecto el primero
                ctxG.set_predef_actual.index = 0;
                ctxC.actualizaTitulos();
                ctxC.cargarHTMLPredefinidos(ctxG.varEstActual);   
                $.get(cnf.rutabase + '/datosVariableEstadistica/archivosext_varest', {id_dash_config: nodoSel.id_dash_config,}, function(res){
                    ctxG.varEstActual_ArchivosExt = res.data;
                    ctxC.cargarAnexosExternos(ctxG.varEstActual, ctxG.varEstActual_ArchivosExt ); 

                    if((ctxG.varEstActual_ArchivosExt && ctxG.varEstActual_ArchivosExt.length > 0) || (ctxG.varEstActual.dashboards_ext && ctxG.varEstActual.dashboards_ext.length > 0 ))
                    {
                        $("#pv_submenu_1").show();
                        if(ctxG.varEstActual_ArchivosExt && ctxG.varEstActual_ArchivosExt.length > 0)
                            $("#pv_submenu_2").show()
                        else
                            $("#pv_submenu_2").hide();


                        if(ctxG.varEstActual.dashboards_ext && ctxG.varEstActual.dashboards_ext.length > 0 )
                            $("#pv_submenu_3").show()
                        else
                            $("#pv_submenu_3").hide()

                    }
                    else
                    {
                        $("#pv_submenu_1, #pv_submenu_2, #pv_submenu_1").hide();
                    }

                });
                  
                ctxG.collection = res.collection;
                ctxG.varEstActual_Unidades.valor_unidad_medida = res.unidad_medida.valor_defecto_um;
                ctxG.varEstActual_Unidades.valor_tipo = res.unidad_medida.valor_tipo;

                ctxC.mostrarData(ctxG.collection);
                // ctxC.submenu_pv_activo(2);
                ctxC.submenu_pv_activo(1);
                ctxC.showLoading(0);

                
                
            });

        },
        mostrarData: function(collection){
            ctxPiv.pivottableUI();
            ctxGra.colocarOpcionesPredefinidas();
            // ctxGra.graficarH();
        },
        actualizaTitulos: function(){
            this.titulo.html('<h4>'  + ctxG.nodoSel.padre + ': ' + ctxG.nodoSel.nombre + '</h4>');
            this.tituloDatos.html('');
            this.tituloGrafico.html( '');
        },
        mostrarPantallas: function(op){
            // $("#divTitulo a").removeClass('disabled');
            // $("#btn_" + op).addClass('disabled'); 
            // if(op == 'grafico')
            // {                
            //     this.contenedorDatos.show();
            //     this.divGrafico.show();
            //     this.divDatos.hide();
            // }
            // else if (op=='tabla')
            // {
            //     this.contenedorDatos.show();
            //     this.divGrafico.hide();
            //     this.divDatos.show();
            // }
            // else
            // {
            //     ctxC.contenedorDatos.hide();
            // }
        },  
        workspace: function (usr = '') {
            if(usr=='success') ocultar = false;
            if(usr=='access') ocultar = true;
            if(usr=='')
                ocultar = $("#btn_vista_Usuario i").hasClass('fa-user-plus');
            $("#divDatosUI").attr('hidden', ocultar);
            $("#divDatosRead").attr('hidden',!ocultar);
            $("#configuracionGrafico").attr('hidden', ocultar);
            $("#btn_menuconfig_acciones").attr('hidden', ocultar);

            $("#btn_vista_Usuario i").removeClass('fa-user-plus fa-user');
            $("#btn_vista_Usuario i").addClass( ocultar ? 'fa-user' : 'fa-user-plus');      
        },
        showLoading : function(op){
            $("#vistaInicio").attr('hidden', true);
            $("#loading").attr('hidden', ( op == 0) );
            $("#contenedor").attr('hidden', ( op == 1 ) );
        }    
    };

    /*----------------  Modal para predefinidos   ---------------------------  */
    var ctxmodPred = {
        predefModal : $("#predefModal"),
        tituloModal : $("#predefModal #modal_titulo"),
        mostrarModal: function(op)
        {
            var oculta = op == 'del';
            $('#predefNewUpdate').attr('hidden', oculta);            
            $('#predefDel').attr('hidden', !oculta);
            this.cargarImagenes(); 

            function cargaPredef(predef){
                $("#predefModal #predef_imagen_previsualizacion").attr("src",cnf.c.img[predef.imagen] || '');
                $("#predefModal #divTextoImagen").html(predef.etiqueta || '');  
                $("#predefModal #predef_etiqueta").val(predef.etiqueta || '');
                $("#predefModal #predef_posicion").val( parseInt(predef.index) + 1 || '');
                $("#predefModal #predef_imagen").val(predef.imagen || '');
                $("#predefModal #accion").val(op);
            }

            if(op == 'del') {
                cargaPredef(ctxG.set_predef_actual);
                this.tituloModal.html("Eliminar Visualización");
            }
            if(op =='update') {
                cargaPredef(ctxG.set_predef_actual);
                this.tituloModal.html("Guardar Visualización Actual");
            }
            if(op == 'new') {
                cargaPredef({});
                this.tituloModal.html("Nueva Visualización");
                $("#predefModal #predef_posicion").val(ctxG.varEstActual.sets_predefinidos.length + 1);
            }
            // this.predefModal.fadeIn(500).modal();
            ctxG.showModal(ctxmodPred.predefModal);

        },
        guardarPredef: function(){
            var op = $("#predefModal #accion").val();
            var config = {
                etiqueta : $("#predefModal #predef_etiqueta").val(),
                imagen : $("#predefModal #predef_imagen").val(),
                x: ctxG.pivotInstancia.cols,
                y: ctxG.pivotInstancia.rows,
                agregacion:  ctxG.pivotInstancia.aggregatorName,
                filtros: (function(){
                    var filtro = [];
                    _.mapObject(ctxG.pivotInstancia.inclusions,function(val, key){
                        val.map(function(elem){
                            filtro.push(key + " = '" + elem + "'");
                        })                         
                    })
                    return filtro;
                })(),
                grafico: {
                    tipo : $("#opcionesGrafico").val()
                }
            }

            var setsPredef = ctxG.varEstActual.sets_predefinidos;
            var predef = ctxG.set_predef_actual;
            var posicion = isNaN($("#predef_posicion").val() ) ? 999 : $("#predef_posicion").val() - 1 ;
            if(op == 'del')
                setsPredef.splice(predef.index, 1);
            if(op == 'new'){
                setsPredef.splice(posicion, 0, config);
            };
            if(op == "update"){
                setsPredef.splice(predef.index, 1);
                setsPredef.splice(posicion, 0, config);
            };
            var configuracionString = JSON.stringify(ctxG.varEstActual);
            var objReq = {
                id_dash_menu : ctxG.nodoSel.id,
                configuracionString : configuracionString,
                _token : $('input[name=_token]').val(),
            };
            $.post(cnf.rutabase + "/tablero/guardaconfiguracion", objReq, function(res){
                ctxC.cargarHTMLPredefinidos(ctxG.varEstActual);  
                $.magnificPopup.close();
            });
        },
        cargarImagenes : function(){
            var divImagenes = '<table><tr>';
            _.mapObject(cnf.c.img, function(val, key){
                divImagenes += '<td><div class="ml5 mr5" style="cursor:pointer; border: 1px solid #fff; " onMouseOver= "this.style.border = \'#aaa 1px solid\'"  onMouseOut= "this.style.border = \'1px solid #fff\'">\
                <img id="' + key + '"  src="'+ val + '" alt="" class="image" style="width:80px;height:60px"></div>\
                </td>';                    
            });
            divImagenes += '</tr></table>'
            $("#selectImagenes").html(divImagenes);
        },
    }

    /*----------------  Modal anexar externos ----------------------------  ----------------------------- ----------------------------------------------- -----------------------------------------   */
    var ctxmodAnx = {
        tituloModal : $("#anexarModal #modal_titulo"),

        mostrarModal: function(op)
        {
            var ocultar = op == 'anexar_archivo_ext';
            $('.div_anexar_dashboard').attr('hidden', ocultar);            
            $('.div_anexar_archivo').attr('hidden', !ocultar);

            this.tituloModal.html( (op == 'anexar_archivo_ext') ? 'Agregar archivos anexos descargables' : 'Vincular con otra fuente');
            $("#btn_anexar span").html( (op == 'anexar_archivo_ext') ? 'Agregar y Guardar archivo' : 'Agregar link externo' );
            $("#anexarModal input, #anexarModal textarea").val('');
            $("#anexarModal #elementos").html('');
            ctxmodAnx.archivos = [];
            var elems =  (op == "anexar_archivo_ext") ?  ctxG.varEstActual.archivos_ext : ctxG.varEstActual.dashboards_ext            
            
            if(elems && elems.length > 0)  {
                var html = elems.reduce(function(carry, elem){
                    return carry + ctxmodAnx.generaDivs(elem);
                }, '');
                $("#anexarModal #elementos").html(html);
            }
            $("#anexarModal #accion").val(op);

            ctxG.showModal("#anexarModal");

        },
        generaDivs: function(elem){
            return  `<div class="mt5 bb p5 pv_anexo">
                        <div><span class="pv_anx_url">${elem.url}</span> <a href="javascript:void(0)" class="pull-right pv_del_anx"><i class="text-danger fa fa-minus-circle "></i></a></div>
                        <div><b><span class="pv_anx_desc">${elem.descripcion}</span></b></div>
                    </div>`;
        },
        anexarElemento : function(){    
            var elem = {};
            elem.descripcion = $("#anexarModal #descripcion").val();

            if($("#anexarModal #accion").val() == 'anexar_archivo_ext'){                
                elem.url = $("#anx_archivo").val();
                elem.archivo = $('#anx_archivo').prop('files')[0];
                elem.descripcion = $("#anexarModal #descripcion").val();
                ctxmodAnx.guardar(elem);
            }
            else{                
                elem.url = $("#anexarModal #anx_dashboard").val();
                if(elem.url.substring(0,7).toLowerCase() == '<iframe' || elem.url.substring(0,6).toLowerCase() == '<frame' ) {
                    elem.url = $(elem.url).attr('src') || 'error: No valido';
                }
            }

            $("#anexarModal #elementos").append(ctxmodAnx.generaDivs(elem));
            //limpia inputs
            $("#anexarModal #descripcion, #anexarModal textarea").val('');
        },
        guardar: function(elemArch){
            var op = $("#anexarModal #accion").val();

            var anexos = [];
            var files=[];
            $("#anexarModal #elementos .pv_anexo").each(function(){
                var anx = {
                    'url' : $(this).find('.pv_anx_url').html(),
                    'descripcion' : $(this).find('.pv_anx_desc').html(),
                };
                anexos.push(anx);
            });
            
            if(op == 'anexar_archivo_ext'){

                var objReq = {
                   archivos_anexos : anexos,
                   id_dash_config : ctxG.nodoSel.id_dash_config,
                   _token : $('input[name=_token]').val(),
                };
                /*primer post que envia los archivos existentes (los que no se eliminaron)*/
                $.post(cnf.rutabase + '/tablero/saveannexedfiles',objReq, function(res){
                    if(elemArch){
                        var formData = new FormData($("#form_anexos")[0]);
                        formData.append('_token', $('input[name=_token]').val());
                        formData.append('descripcion', elemArch.descripcion);
                        formData.append('archivo_nuevo', elemArch.archivo);
                        formData.append('id_dash_config', ctxG.nodoSel.id_dash_config);
                        
                        /* segundo post que envia el archivo seleccionado */
                        $.ajax({
                            url: cnf.rutabase + '/tablero/saveannexedfiles', 
                            type: "POST",
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            success: function(res){
                                console.log(res.mensaje);
                            }
                        });

                        $.get(cnf.rutabase + '/datosVariableEstadistica/archivosext_varest', {id_dash_config: ctxG.nodoSel.id_dash_config}, function(res){
                            ctxG.varEstActual_ArchivosExt = res.data;
                            ctxC.cargarAnexosExternos(ctxG.varEstActual, ctxG.varEstActual_ArchivosExt ); 

                        });
                    }
                });               
            }
            if(op == 'anexar_dashboard_ext'){
                ctxG.varEstActual.dashboards_ext = anexos;
                ctxG.varEstActual.archivos_ext = null;

                var configuracionString = JSON.stringify(ctxG.varEstActual);
                var objReq = {
                    id_dash_menu : ctxG.nodoSel.id,
                    configuracionString : configuracionString,
                    _token : $('input[name=_token]').val(),
                };

                $.post(cnf.rutabase + "/tablero/guardaconfiguracion", objReq, function(res){
                    ctxC.cargarAnexosExternos(ctxG.varEstActual);                     
                });

            };  
            $.magnificPopup.close();         

        },

    }

    /*------------------------- ctxPiv variable que contiene el contexto del Pivot   */
    var ctxPiv = {
        pvtTableUI: $("#pvtTableUI"),
        pvtTableUIRead: $("#pvtTableUIRead"),
        configParaPivotT : function(set_predefinido){
            var config = {}
            config.columns = set_predefinido.x;
            config.rows = set_predefinido.y;
            config.inclusions = _.chain(set_predefinido.filtros)
                                    .map(function(item){                    
                                        condicion =  item.split("=").map(function(s){ return s.toString().trim().replace(/'/g,"");});
                                        var obj = { 'key': condicion[0], 'value' : condicion[1] };
                                        return obj;   
                                    }).groupBy(function(item){
                                        return item.key;
                                    }).mapObject(function(items, key){
                                        var arr = _.map(items, function(elem){ return elem.value; });
                                        return arr
                                    }).value();
            var existeAgregacion = $.pivotUtilities.locales.es.aggregators[set_predefinido.agregacion]; 
            config.aggregatorName = existeAgregacion ?  set_predefinido.agregacion : "Suma de enteros";
            config.vals = ["valor"];         
            return config;
        },
        pivottableUI: function()
        {
            var pivotConfig = ctxPiv.configParaPivotT(ctxG.set_predef_actual);
            ctxPiv.pvtTableUI.pivotUI(ctxG.collection, {
                cols: pivotConfig.columns, 
                rows: pivotConfig.rows,
                aggregatorName: pivotConfig.aggregatorName,
                vals: pivotConfig.vals,
                inclusions: pivotConfig.inclusions,
                onRefresh: function(p) {
                    ctxG.pivotInstancia = p;
                    ctxPiv.trnDatosDePivot();
                    ctxGra.graficarH();
                    ctxPiv.pivottableUIRead(p);
                }
            }, true, "es");
        }, 
        pivottableUIRead: function(instanciaP)
        {
            ctxPiv.pvtTableUIRead.pivotUI(ctxG.collection, {
                cols: ctxG.pivotInstancia.cols, 
                rows: ctxG.pivotInstancia.rows,
                aggregatorName: ctxG.pivotInstancia.aggregatorName,
                vals: ctxG.pivotInstancia.vals,
                inclusions: ctxG.pivotInstancia.inclusions,
            }, true, "es");
        }, 
        trnDatosDePivot: function(){
            var tree = ctxG.pivotInstancia.pivotData.tree;
            dim_columna = ctxG.pivotInstancia.cols.join('-');
            dim_fila = ctxG.pivotInstancia.rows.join('-');
            ctxG.pivot.data = [];
            for (row in tree){
                for(col in tree[row])
                {
                    var item = {};  
                    arg =   tree[row][col];                   
                    item['valor'] =arg.value();
                    item[dim_columna] = col;
                    item[dim_fila] = row;
                    ctxG.pivot.data.push(item); 
                }
            }
            ctxG.pivot.dimColumna = dim_columna;
            ctxG.pivot.dimFila = dim_fila;
            ctxPiv.obtenerTotales();
            ctxGra.transformarDatosParaGrafico();            
        },
        obtenerTotales: function(){
            var t_cols = {},  t_filas = {}, tp_cols = {}, tp_filas = {};            
            total = ctxG.pivot;
            dimCol = ctxG.pivot.dimColumna;
            dimFil = ctxG.pivot.dimFila;
            _.each(ctxG.collection, function(item){
                t_cols[item[dimCol]] = ( isNaN( t_cols[item[dimCol]])  ? 0 : t_cols[item[dimCol]]) + Number(item.valor );
                t_filas[item[dimFil]] = ( isNaN(t_filas[item[dimFil]]) ? 0 : t_filas[item[dimFil]] ) + Number(item.valor); 
            });
            total.t_cols = t_cols;
            total.t_filas = t_filas;
            total.total = Object.keys(t_cols).reduce(function(total, key){
                return total + t_cols[key];
            }, 0);

            /* Totales Sumas parciales */
            _.each(ctxG.pivot.data, function(item){
                tp_cols[item[dimCol]] = ( isNaN( tp_cols[item[dimCol]])  ? 0 : tp_cols[item[dimCol]]) + Number(item.valor );
                tp_filas[item[dimFil]] = ( isNaN(tp_filas[item[dimFil]]) ? 0 : tp_filas[item[dimFil]] ) + Number(item.valor); 
            });
            total.tp_cols = tp_cols;
            total.tp_filas = tp_filas;
            total.total_p =  Object.keys(tp_cols).reduce(function(total, key){
                return total + tp_cols[key];
            }, 0);
        }, 
    }

    /*------------------------- ctxGra variable que contiene el contexto del grafico  */
    var ctxGra = {
        colocarOpcionesPredefinidas: function()
        {
            try { 
                $("#opcionesGrafico").val(ctxG.set_predef_actual.grafico.tipo);
                if($("#opcionesGrafico").val() == null)
                    $("#opcionesGrafico").val('spline');
            }
            catch(e)/* si no existe le asigna el primer grafico*/           
                { $('#opcionesGrafico option')[0].selected = true;}
        },
        transformarDatosParaGrafico: function()
        {
            var datosGraph = {};
            var pivotData = ctxG.pivotInstancia.pivotData;            
            var pivot = ctxG.pivot;
            // var factorPorcentual = ctxG.pivotInstancia.aggregatorName[0] == '%' ? 100 : 1;
            datosGraph.categorias = pivotData.colKeys.map(function(cat, key){
                return cat.join('-');
            });
            
            datosGraph.series = _.chain(pivot.data).groupBy(function(item){
                                        return item[pivot.dimFila]
                                    }).map(function(setDatos, key){
                                        serie = {};
                                        serie.name = key;

                                        /* con valores ceros los discontinuos */
                                        serie.data = datosGraph.categorias.map(function(elem){
                                            var s = { name : elem, y: 0};
                                            setDatos.forEach(function(sd){
                                                if(sd[pivot.dimColumna] == elem){
                                                    var num;
                                                    if(ctxG.pivotInstancia.aggregatorName[0] == "%")                
                                                        num =  parseFloat((Math.round( sd.valor * 100 * 10 )/10 ).toString()) ;
                                                    else 
                                                        num = sd.valor;
                                                    
                                                    s.y = num;
                                                }
                                            });
                                            return s;
                                        });
                                        return serie;

                                        /*Series discontinuadas */
                                        // serie.data = setDatos.map(function(elem){  
                                        //     var num;
                                        //     if(ctxG.pivotInstancia.aggregatorName[0] == "%")                
                                        //         num =  parseFloat((Math.round( elem.valor * 100 * 10 )/10 ).toString()) ;
                                        //     else 
                                        //         num = elem.valor;
                                        //     return { name : elem[pivot.dimColumna], y: num};
                                        // });
                                        // return serie;
                                    }).value();
            ctxG.pivot.dataGraph = datosGraph;

        },
        graficarH : function()   {
            var tituloChart = ctxG.varEstActual.variable_estadistica;
            var unidadMedida = ctxG.varEstActual.porcentaje  ? ' (porcentaje) ' : '(' + ctxG.varEstActual_Unidades.valor_tipo +': ' + ctxG.varEstActual_Unidades.valor_unidad_medida + ') ';
            var subtituloChart = ctxG.pivot.dimFila + ' vs. ' + ctxG.pivot.dimColumna;
            var tipo = $("#opcionesGrafico").val().split('-');
            var stacked = (tipo[1]  == 'stacked') ? 'normal' : (tipo[1]  == 'stackedp') ? 'percent': '';
            var ifLabel = $("#viewlabel").prop("checked");
            var tipo3d = $("#view3d").prop("checked");;

            var vale = tipo[0];
            var tool = '{series.name}: <b>{point.y:.1f} (' +  ctxG.varEstActual_Unidades.valor_unidad_medida +') </b> ';            
            if(tipo[1]){
                tool += '<br>porcentaje: <b>{point.percentage:.1f} %</b>';
            }

            // colores= [
            // '#E86D00', '#FFB97F', '#E8E400', '#80699B', '#00E820',
            // '#4572A7', '#AA4643', '#89A54E', '#70E800', '#3D96AE',      
            // '#00E8D6', '#00A5E8', '#0054E8', '#A013E6', '#E800CF', 
            // '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92', '#E80000',
            // '#E8007B', '#FF766D', '#EDFF6D', '#8AFF6D', '#89FFEA',
            // '#FF72F4', '#84345E', '#348445', '#C4D21C', '#9C0000'
            // ];

            // colores= [
            // '#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572',
            //     '#FF9655', '#FFF263', '#6AF9C4',
            //     '#E86D00', '#FFB97F', '#E8E400', '#80699B', '#00E820',
            //     '#4572A7', '#AA4643', '#89A54E', '#70E800', '#3D96AE', 
            //     '#00E8D6', '#00A5E8', '#0054E8', '#A013E6', '#E800CF', 
            //     '#E8007B', '#FF766D', '#EDFF6D', '#8AFF6D', '#89FFEA',
            // ],
            // colores = _.chain(colores)
            //                 .map(function(color){ 
            //                     return { id : _.random(100), color:color    }
            //                 }).sortBy('id')
            //                 .map(function(obj){
            //                     return obj.color
            //                 })
            //                 .value();

            // Highcharts.setOptions({
            //     colors: colores,
            // });

            var json = {   
                chart : {
                    type: tipo[0],
                    options3d: {
                        enabled: tipo3d,
                        alpha: tipo=='pie' ? 45 : 23, 
                        beta: 0, depth: 60
                    },
                    zoomType: 'xy',
                },
                title : {
                    text: tituloChart   
                },   
                subtitle :{
                    text: subtituloChart
                }, 
                xAxis :{
                    type: 'category',
                    categories: ctxG.pivot.dataGraph.categorias,
                    // max:  ctxG.pivot.dataGraph.categorias.length
                },
                yAxis : {
                    title: {
                        text: unidadMedida
                    }
                },
                tooltip:  {
                    pointFormat: tool,
                },

                plotOptions : {
                    series: {
                        marker : { 
                            symbol:'circle',
                            // radius: 3,
                        },
                        stacking: stacked,
                        dataLabels: {
                            enabled: ifLabel,
                            format: '{y:.1f}'
                            // color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || '#ccc'
                        }
                    },
                    column: {
                        stacking: stacked,
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || '#ccc'
                        }
                    },
                    area: {
                        stacking: stacked,
                        lineColor: '#eee',
                        lineWidth: 1,
                    },
                    pie: {
                        innerSize: 100,
                        depth: 45,
                        allowPointSelect: true,
                        cursor: 'pointer',
                        // depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.category}'
                        }
                    },                    
                },
                series : ctxG.pivot.dataGraph.series, 
            }
            $('#divChart').highcharts(json);
        }
    }

</script>

<script>
$(function(){

    ctxM.creaMenuBaseHtml();
    ctxC.mostrarPantallas();

    ctxM.btnmenu.click(function() {
        ctxM.abrirCerrarMenu();
    });

    $( "form" ).submit(function( event ) {
          event.preventDefault();
      });


    /*  Click sobre elemento del menu 
    */
    $("#menuPrincipal, #menuDetalle").on('click', 'a.nodo_menu', function(event){
        str_cod = $(this).attr('id');
        ctxG.nodoSel = ctxM.obtenerNodo(str_cod);
        ctxM.activarElem(ctxG.nodoSel);
        if(ctxG.nodoSel.nivel == 1)
        {
            ctxM.crearSubmenusHtml(ctxG.nodoSel);
            if(ctxM.menup_estado == 1) //si esta abierto el menu al presionar que se cierre
                ctxM.abrirCerrarMenu();
        }
        else
        {
            ctxC.obtenerData(ctxG.nodoSel);
            ctxC.mostrarPantallas('grafico');
        }
        
    }); 

    ctxM.buscadorMenu.keyup(function(){
        ctxM.buscaMenu();
    })

    /* Click sobre menu de predefinidos
    */
    ctxC.contenedorPredefinidos.on('click', '.item_campo_predefinido', function(e){
        index =  $(this).attr('id');
        ctxG.set_predef_actual = ctxG.varEstActual.sets_predefinidos[index];
        ctxG.set_predef_actual.index = index;
        ctxC.actualizaTitulos();
        ctxC.mostrarData(ctxG.collection);
    });

    /* Click sobre los botones de mostrar tabla o grafico o geo
    */
    $("#btn_tabla, #btn_grafico").click(function(){
        var op = $(this).attr('id').replace('btn_',''); // == 'btn_tabla' ? 'tabla' : 'grafico';
        ctxC.mostrarPantallas(op);
    });

    /*  ------------- Cambia config del grafico */
    $("#configuracionGrafico ").change(function(){
        ctxGra.graficarH();
    });

    /* ------------- Click guardar, modificar, o eliminar predefinidos (new, update, del)   */
    $("#predef_update, #predef_new, #predef_del").click(function(){
        var op = $(this).attr('id').replace('predef_','');
        ctxmodPred.mostrarModal(op);        
    });


    /* Click sobre una imagen de la ventana modal */
    $("#selectImagenes").on('click', 'img', function(){
        id_imagen = $(this).attr('id');
        $("#predefModal #predef_imagen_previsualizacion").attr("src",cnf.c.img[id_imagen]);
        $("#predef_imagen").val(id_imagen)
    })

    /* --------- Guardar Predefinido de modal */
    $("#predefModal #btnGuardar").click(function(){
        ctxmodPred.guardarPredef();
    });


    /* --------- click menu Anexos ---------*/
    $("#anexar_archivo_ext, #anexar_dashboard_ext").click(function(){
        ctxmodAnx.mostrarModal($(this).attr('id'));        
    });

    /* ---------      En boton anexar ----------*/
    $("#anexarModal #btn_anexar").click(function(){
       ctxmodAnx.anexarElemento();
    });
    /* --------- Al remover quitar elemento dashboard o excel ---------*/
    $("#anexarModal").on('click', '.pv_del_anx', function(){
        $(this).parent().parent().remove();
    });
    /* ------   Guardar Anexo --------------------*/
    $("#anexarModal .pv_guardar").click(function(){
        ctxmodAnx.guardar();
    });


    /* Click Boton de vista usuario Admin , usuariop normal
    TODO QUITAR function click  y volver el botton span 
    */
    $("#btn_vista_Usuario").click(function(){
        ctxC.workspace();

    })

    /* De los Bpotones Cancelar*/
    $(".pv_cancel").click(function(){
         $.magnificPopup.close();
    });


    $("#iframe_combo").change(function(){
        url = $(this).val();
        $("#iframe_url").attr('src', url);
    })

    $('#contenido_principal').slick({
        dots: false,
        infinite: false,
        speed: 500,
        arrows:false,
        touchMove:false,
        swipe:false,
    });

    /* De los submenus de arriba */            
    $("#submenus_pv span").click(function(){
        index = $(this).attr('id');
        ctxC.submenu_pv_activo(index);
    });


});

</script>


{{-- FUNCION POR DEFECTO: OCULTA MENU MENU LATERAL DE SISTEMA Y ACTIVA BOTON MODULO  --}}
<script type="text/javascript">
 $(function() {
     function activarMenu(id,aux){
        $('#'+id).addClass('active');
        $('#'+aux).addClass('activeaux');
    }

    function menuModulosHideShow(ele){
        //1 hide
        //2 show
        switch (ele) {
            case 1:
                $("body").addClass("content-wrapper")
                $(".open-close i").removeClass('icon-arrow-left-circle');
                $(".sidebar").css("overflow", "inherit").parent().css("overflow", "visible");
            break;
            case 2:
                $("body").removeClass('content-wrapper');
                $(".open-close i").addClass('icon-arrow-left-circle');
                $(".logo span").show();
            break;
        }
    }
    // activarMenu('x','mp-9');
    menuModulosHideShow(1)
}) 
</script>
@endpush
