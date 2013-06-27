<?php

/*
  Plugin Name: Candideit.org
  Plugin URI: https://github.com/ciudadanointeligente/candideit.org-wp
  Description: Retorna los candidatos creados por un usuario
  Author: Fundación Ciudadano Inteligente
  Version: 1.0
  Author URI: http://www.ciudadanointeligente.org
  License: Copyleft
 */

define('URLBASE','http://candideit.org/api/v1/');

// enqueue and localise scripts
 wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'js/ajax.js', array( 'jquery' ) );
 wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 // THE AJAX ADD ACTIONS
 add_action( 'wp_ajax_the_ajax_hook', 'the_action_function' );
 add_action( 'wp_ajax_nopriv_the_ajax_hook', 'the_action_function' ); // need this to serve non logged in users
// THE FUNCTION
 function the_action_function(){
     /* this area is very simple but being serverside it affords the possibility of retreiving data from the server and passing it back to the javascript function */
     $name = $_POST['name'];
     echo "Hello World, " . $name;// this is passed back to the javascript function
     die();// wordpress may print out a spurious zero without this - can be particularly bad if using json
 }

function candideit_admin_action() {
    add_management_page("Candideit", "Candideit", 1, "candideit", "candideit_configuracion");
}

add_action('admin_menu', 'candideit_admin_action');

function candideit_configuracion() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    $msj = '';
    $msj_class = '';

    if ($_POST['candideit_update']) {
        ( $_POST[candideit_api_key] ) ? update_option('candideit_api_key', $_POST[candideit_api_key]) : update_option('candideit_api_key', '');
        ( $_POST[candideit_username] ) ? update_option('candideit_username', $_POST[candideit_username]) : update_option('candideit_username', '');
        ( $_POST[candideit_election_id] ) ? update_option('candideit_election_id', $_POST[candideit_election_id]) : update_option('candideit_election_id', '');

        if ( ($_POST[candideit_api_key]) && ($_POST[candideit_username]) ) {
            $msj = 'Datos actualizados correctamente :)';
            $msj_class = 'updated';
        }
    }

    include "candideit-form-config.php";
}

function candideit_getElecciones($params = array()) {
    $api_url = URLBASE.'election/?format=json&username='. $params['username'] .'&api_key='. $params['api_key'];
    $aElecciones = file_get_contents($api_url);
    $aElecciones = json_decode($aElecciones);

    return $aElecciones;
}

function candideit_getCandidatos($params = array()) {
    $api_url = URLBASE.'election/'. $params['election_id'] .'/?format=json&username='. $params['username'] .'&api_key='. $params['api_key'];
    $aCandidatos = file_get_contents($api_url);
    $aCandidatos = json_decode($aCandidatos);

    return $aCandidatos;
}

function candideit_loscandidatos() {
    if (is_front_page()) {
    
        $url = URLBASE.'election/'. get_option('candideit_election_id') .'/?format=json&username='. get_option('candideit_username') .'&api_key='. get_option('candideit_api_key');
        $json_info = file_get_contents($url);
        $aElections = json_decode($json_info);

        foreach ($aElections->candidates as $c) {
            $url = URLBASE.'candidate/'. $c->id .'/?format=json&username='. get_option('candideit_username') .'&api_key='. get_option('candideit_api_key');
            $json_info = file_get_contents($url);
            $aCandidatos[] = json_decode($json_info);
        }
        
        include "candideit-candidatos-front.php";
    }
}

function theme_styles()  
{ 
    // Register the style like this for a theme:  
    // (First the unique name for the style (custom-style) then the src, 
    // then dependencies and ver no. and media type)
    $url_plugin = plugins_url('/candideit.org/css/candideit.org.css');
    wp_register_style( 'custom-style', $url_plugin , array(), date('Ymd'), 'all' );

    // enqueing:
    wp_enqueue_style( 'custom-style' );
}
add_action('wp_enqueue_scripts', 'theme_styles');
