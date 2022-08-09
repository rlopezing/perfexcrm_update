<?php
hooks()->add_action('admin_init', 'my_menu');

function my_menu() {
  $CI = &get_instance();
  
	/////
	/// MENU COMMERCIALS VISITS.
  if (has_permission('commercials_visits', '', 'view') || has_permission('commercials_visits', '', 'view_own')) {
	  $CI->app_menu->add_sidebar_menu_item('commercials_visits', [
	    'name'     => _l('commercials_visits_menu'), // The name if the item
	    'position' => 20, // The menu position, see below for default positions.
	    'icon'     => 'fa fa-address-book', // Font awesome icon
	  ]);
    
	  $CI->app_menu->add_sidebar_children_item('commercials_visits', [
	    'slug'     => 'commercials_visits_visits', // Required ID/slug UNIQUE for the child menu
	    'name'     => _l('commercials_visits_visits'), // The name if the item
	    'href'     => ''.admin_url().'commercials_visits', // URL of the item
	    'position' => 1, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
	  $CI->app_menu->add_sidebar_children_item('commercials_visits', [
	    'slug'     => 'commercials_visits_geolocation', // Required ID/slug UNIQUE for the child menu
	    'name'     => _l('commercials_visits_geolocation'), // The name if the item
	    'href'     => ''.admin_url().'commercials_visits/geolocations', // URL of the item
	    'position' => 15, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
  }
    
	/////
	/// MENU OPERATIONS LIST.
  if (has_permission('operations', '', 'view') || has_permission('operations', '', 'view_own')) {
	  $CI->app_menu->add_sidebar_menu_item('operations', [
	    'name'     => _l('operations_list_menu'), // The name if the item
	    'position' => 22, // The menu position, see below for default positions.
	    'icon'     => 'fa fa-list-ol', // Font awesome icon
	  ]);
	  $CI->app_menu->add_sidebar_children_item('operations', [
	    'slug'     => 'operations_list_operations', // Required ID/slug UNIQUE for the child menu
	    'name'     => _l('operations_list_operations'), // The name if the item
	    'href'     => ''.admin_url().'operations', // URL of the item
	    'position' => 5, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
  }

	/////
	/// MENU COMISIONES.
	if (has_permission('commissions', '', 'view') || has_permission('commissions', '', 'view_own')) {
	  $CI->app_menu->add_sidebar_menu_item('menu_commissions', [
	    'name'     => 'COMISIONES', // The name if the item
	    'href'     => '', // URL of the item
	    'position' => 25, // The menu position, see below for default positions.
	    'icon'     => 'fa fa-money', // Font awesome icon
	  ]);
	    
	  $CI->app_menu->add_sidebar_children_item('menu_commissions', [
	    'slug'     => 'commissions', // Required ID/slug UNIQUE for the child menu
	    'name'     => 'Alta Contratos', // The name if the item
	    'href'     => ''.admin_url().'commissions', // URL of the item
	    'position' => 1, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
	  $CI->app_menu->add_sidebar_children_item('menu_commissions', [
	    'slug'     => 'generals_maps', // Required ID/slug UNIQUE for the child menu
	    'name'     => 'Mapa General', // The name if the item
	    'href'     => ''.admin_url().'generals_maps', // URL of the item
	    'position' => 5, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
	  $CI->app_menu->add_sidebar_children_item('menu_commissions', [
	    'slug'     => 'distributors_partners', // Required ID/slug UNIQUE for the child menu
	    'name'     => 'Distribuidor Socio', // The name if the item
	    'href'     => ''.admin_url().'distributors_partners', // URL of the item
	    'position' => 10, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
	  $CI->app_menu->add_sidebar_children_item('menu_commissions', [
	    'slug'     => 'distributors_commercials', // Required ID/slug UNIQUE for the child menu
	    'name'     => 'Distribuidor Comercial', // The name if the item
	    'href'     => ''.admin_url().'distributors_commercials', // URL of the item
	    'position' => 15, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
	}
  
	/////
	/// MENU SIMULATORS.
	if (has_permission('simulators', '', 'view') || has_permission('simulators', '', 'view_own')) {
	  $CI->app_menu->add_sidebar_menu_item('menu_simulator', [
	    'name'     => 'SIMULADOR', // The name if the item
	    'href'     => '', // URL of the item
	    'position' => 25, // The menu position, see below for default positions.
	    'icon'     => 'fa fa-exchange', // Font awesome icon
	  ]);
	    
	  $CI->app_menu->add_sidebar_children_item('menu_simulator', [
	    'slug'     => 'simulators', // Required ID/slug UNIQUE for the child menu
	    'name'     => 'Electricidad', // The name if the item
	    'href'     => ''.admin_url().'simulators', // URL of the item
	    'position' => 1, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
	  $CI->app_menu->add_sidebar_children_item('menu_simulator', [
	    'slug'     => 'gass', // Required ID/slug UNIQUE for the child menu
	    'name'     => 'Gas', // The name if the item
	    'href'     => ''.admin_url().'gass', // URL of the item
	    'position' => 5, // The menu position
	    'icon'     => '', // Font awesome icon
	  ]);
	}
  
}