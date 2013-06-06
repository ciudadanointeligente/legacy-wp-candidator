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
    $api_url = 'http://candideit.org/api/v1/election/?format=json&username='. $params['username'] .'&api_key='. $params['api_key'];
    $aElecciones = file_get_contents($api_url);
    $aElecciones = json_decode($aElecciones);

    return $aElecciones;
}

function candideit_getCandidatos($params = array()) {
    $api_url = 'http://candideit.org/api/v1/election/'. $params['election_id'] .'/?format=json&username='. $params['username'] .'&api_key='. $params['api_key'];
    $aCandidatos = file_get_contents($api_url);
    $aCandidatos = json_decode($aCandidatos);

    return $aCandidatos;
}

function candideit_loscandidatos() {
    if (is_front_page()) {
    
        $url = 'http://candideit.org/api/v1/election/'. get_option('candideit_election_id') .'/?format=json&username='. get_option('candideit_username') .'&api_key='. get_option('candideit_api_key');
        $json_info = file_get_contents($url);
        $aElections = json_decode($json_info);

        foreach ($aElections->candidates as $c) {
            $url = 'http://candideit.org/api/v1/candidate/'. $c->id .'/?format=json&username='. get_option('candideit_username') .'&api_key='. get_option('candideit_api_key');
            $json_info = file_get_contents($url);
            $aCandidatos[] = json_decode($json_info);
        }
        
        include "candideit-candidatos-front.php";
    }
}
