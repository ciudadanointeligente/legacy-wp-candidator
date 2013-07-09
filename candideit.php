<?php

/*
  Plugin Name: Candideit.org
  Plugin URI: https://github.com/ciudadanointeligente/candideit.org-wp
  Description: Retorna información de Candideit.org
  Author: Fundación Ciudadano Inteligente
  Version: 1.0
  Author URI: http://www.ciudadanointeligente.org
  License: Copyleft
 */
define('URLBASE','http://candideit.org/api/v1/');

function activate() 
{
  $_name      = 'candideitorg';
  $page_title = 'Candideitorg';
  $page_name  = $_name;
  $page_id    = '0';

  delete_option($_name.'_page_title');
  add_option($_name.'_page_title', $page_title, '', 'yes');

  delete_option($_name.'_page_name');
  add_option($_name.'_page_name', $page_name, '', 'yes');

  delete_option($_name.'_page_id');
  add_option($_name.'_page_id', $page_id, '', 'yes');

  $the_page = get_page_by_title($page_title);
  
  if (!$the_page)
  {
    // Create post object
    $_p = array();
    $_p['post_title']     = $page_title;
    $_p['post_content']   = '';
    $_p['post_status']    = 'publish';
    $_p['post_type']      = 'page';
    $_p['comment_status'] = 'closed';
    $_p['ping_status']    = 'closed';
    $_p['post_category'] = array(1); // the default 'Uncatrgorised'

    // Insert the post into the database
    $page_id = wp_insert_post($_p);
  }
  else
  {
    // the plugin may have been previously active and the page may just be trashed...
    $page_id = $the_page->ID;

    //make sure the page is not trashed...
    $the_page->post_status = 'publish';
    $page_id = wp_update_post($the_page);
  }

  delete_option($_name.'_page_id');
  add_option($_name.'_page_id', $page_id);
}

register_activation_hook( __FILE__, 'activate' );

function deactivate() 
{
  deletePage();
  deleteOptions();
}

register_deactivation_hook( __FILE__, 'deactivate' );

function uninstall()
{
  deletePage(true);
  deleteOptions();
}

register_uninstall_hook( __FILE__, 'uninstall' );

function deletePage($hard = false)
{
  global $wpdb;
  $_name      = 'candideitorg';

  $id = get_option($_name.'_page_id');
  if($id && $hard == true)
    wp_delete_post($id, true);
  elseif($id && $hard == false)
    wp_delete_post($id);
}

function deleteOptions()
{
  $_name      = 'candideitorg';

  delete_option($_name.'_page_title');
  delete_option($_name.'_page_name');
  delete_option($_name.'_page_id');
}

function admin_action() {
  add_management_page( "Candideit.org", "Candideit.org", 1, "candideitorg", 'configuracion' );
}

add_action('admin_menu', 'admin_action' );

function configuracion() {
  if (!current_user_can('manage_options')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));
  }
  
  $msj = '';
  $msj_class = '';

  if ($_POST['candideit_update']) {
      ( $_POST['candideit_api_key'] ) ? update_option('candideit_api_key', $_POST['candideit_api_key']) : update_option('candideit_api_key', '');
      ( $_POST['candideit_username'] ) ? update_option('candideit_username', $_POST['candideit_username']) : update_option('candideit_username', '');
      ( $_POST['candideit_election_id'] ) ? update_option('candideit_election_id', $_POST['candideit_election_id']) : update_option('candideit_election_id', '');

      if ( ($_POST['candideit_api_key']) && ($_POST['candideit_username']) ) {
          $msj = 'Datos actualizados correctamente :)';
          $msj_class = 'updated';
      }
  }

  include "candideit-form-config.php";
}

function getElecciones($params = array()) {
  $api_url = URLBASE.'election/?format=json&username='. $params['username'] .'&api_key='. $params['api_key'];
  $aElecciones = file_get_contents($api_url);
  $aElecciones = json_decode($aElecciones);

  return $aElecciones;
}

function getCandidatos($params = array()) {
  $api_url = URLBASE.'election/'. $params['election_id'] .'/?format=json&username='. $params['username'] .'&api_key='. $params['api_key'];
  $aCandidatos = file_get_contents($api_url);
  $aCandidatos = json_decode($aCandidatos);

  return $aCandidatos;
}

function loscandidatos() {
  if ( $_SERVER["REQUEST_URI"] == '/candideitorg/' ) {
  
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

add_filter( 'the_content', 'loscandidatos' );

function theme_styles() { 
  // Register the style ike this for a theme:  
  // (First the unique name for the style (custom-style) then the src, 
  // then dependencies and ver no. and media type)
  $url_plugin = plugins_url('/css/candideit.org.css', __FILE__);
  wp_register_style( 'custom-style', $url_plugin , array(), date('Ymd'), 'all' );

  // enqueing:
  wp_enqueue_style( 'custom-style' );
}
add_action('wp_enqueue_scripts', 'theme_styles');

function my_scripts_method() {
  wp_enqueue_script(
    'custom-script',
    plugins_url('/js/ajax.js', __FILE__),
    array( 'jquery' )
  );
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
