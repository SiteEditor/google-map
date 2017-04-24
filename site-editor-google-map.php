<?php
/*
Plugin Name: Site Editor Google Map
Plugin URI: http://www.siteeditor.org/
Description: Site Editor Google Map added simple google map to your site with site editor
Author: Site Editor Team
Author URI: http://www.siteeditor.org/site-editor-team
Version: 0.1
*/

if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

if ( ! defined( 'SED_GOOGLE_MAP_PLUGIN_BASENAME' ) )
    define( 'SED_GOOGLE_MAP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'SED_GOOGLE_MAP_PLUGIN_NAME' ) )
    define( 'SED_GOOGLE_MAP_PLUGIN_NAME', trim( dirname( SED_GOOGLE_MAP_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'SED_GOOGLE_MAP_PLUGIN_DIR' ) )
    define( 'SED_GOOGLE_MAP_PLUGIN_DIR', WP_PLUGIN_DIR . DS . SED_GOOGLE_MAP_PLUGIN_NAME );

if ( ! defined( 'SED_GOOGLE_MAP_PLUGIN_URL' ) )
    define( 'SED_GOOGLE_MAP_PLUGIN_URL', WP_PLUGIN_URL . '/' . SED_GOOGLE_MAP_PLUGIN_NAME );

if ( ! defined( 'SED_GOOGLE_MAP_MODULE_DIR' ) )
    define( 'SED_GOOGLE_MAP_MODULE_DIR', SED_GOOGLE_MAP_PLUGIN_DIR . DS . 'modules' );

if ( ! defined( 'SED_GOOGLE_MAP_MODULES_URL' ) )
    define( 'SED_GOOGLE_MAP_MODULES_URL', SED_GOOGLE_MAP_PLUGIN_URL . '/modules' );

/**
 * Class SiteEditorGoogleMap
 */
final class SiteEditorGoogleMap{

    /**
     * @var object instance of SedGoogleMapProductsModules Class
     */
    public $products_modules;

    /**
     * @var array
     */
    public $modules = array();
    
    /**
     * The single instance of the class.
     *
     * @var SiteEditor
     * @since 0.9
     */
    protected static $_instance = null;

    /**
     * Main SiteEditor Instance.
     *
     * Ensures only one instance of SiteEditor is loaded or can be loaded.
     *
     * @since 0.9
     * @static
     * @see WC()
     * @return SiteEditor - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * SiteEditorGoogleMap constructor.
     */
    public function __construct(){

        //localize
        add_action( 'plugins_loaded', array(&$this, 'localization') );

        add_action( 'plugins_loaded', array($this, 'includes') );

        add_filter("sed_modules" , array( $this , "add_modules" ) );

    }

    public function localization() {

        load_plugin_textdomain( "sed-google-map" , false, dirname( plugin_basename( __FILE__ ) ) . "/languages" );

    }

    public function includes(){

    }

    private function get_module( $module_name ){

        $module = "plugins/" . SED_GOOGLE_MAP_PLUGIN_NAME . "/modules/{$module_name}/{$module_name}.php";

        return $module;

    }

    private function get_module_path( $module_name ){

        return SED_GOOGLE_MAP_MODULE_DIR . DS . $module_name . DS . $module_name . ".php";

    }

    public function add_modules( $modules ){

        global $sed_pb_modules;

        $module_name = "google-map";

        $modules[$this->get_module( $module_name )] = $sed_pb_modules->get_module_data($this->get_module_path( $module_name ), true, true);

        return $modules;
    }

}

/**
 * Main instance of SiteEditor.
 *
 * Returns the main instance of SED to prevent the need to use globals.
 *
 * @since  0.9
 * @return SiteEditor
 */
function SedGMap() {
    return SiteEditorGoogleMap::instance();
}

SedGMap();