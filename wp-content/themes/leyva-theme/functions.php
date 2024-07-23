<?php
/**
 * leyva-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package leyva-theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

require get_template_directory() . '/functions/functions-ajax.php';
require get_template_directory() . '/functions/functions-woocommerce.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function leyva_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on leyva-theme, use a find and replace
		* to change 'leyva-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'leyva-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'leyva-theme' ),
			'footer_menu_left'      => esc_html__('Footer Menu Left', 'leyva-theme'),
			'footer_menu_right'      => esc_html__('Footer Menu Right', 'leyva-theme'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'leyva_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'leyva_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function leyva_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'leyva_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'leyva_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function leyva_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'leyva-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'leyva-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Woo Sidebar', 'leyva-theme' ),
			'id'            => 'sidebar-woo',
			'description'   => esc_html__( 'Add widgets here.', 'leyva-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'leyva_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function leyva_theme_scripts() {

	global $template; 

	wp_enqueue_style( 'leyva-theme-style', get_stylesheet_uri(), array(), rand(1,9999) );
	wp_style_add_data( 'leyva-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'leyva-theme-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), rand(1,9999) );

	// swiper JS
	wp_enqueue_style('swiper-style', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', array(), rand(1, 9999));
	wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), rand(1, 9999));
	wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), rand(1, 9999)); 

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_tag())){
		if(!is_shop()){
			wp_enqueue_style('blog-style', get_template_directory_uri() . '/assets/css/blog-style.css', array(), rand(1,9999));
			wp_enqueue_script('blog-scripts', get_template_directory_uri() . '/assets/js/blog-scripts.js', array('jquery'), rand(1,9999), true ); 
		}
	}

	if (is_single()){
		if(!is_shop() && (!is_woocommerce())){
			wp_enqueue_style('single-style', get_template_directory_uri() . '/assets/css/single-style.css', array(), rand(1,9999));
			wp_enqueue_script('single-scripts', get_template_directory_uri() . '/assets/js/single-scripts.js', array('jquery'), rand(1,9999), true ); 
		}
	}

	if ((basename($template) =='home-template.php')){
		wp_enqueue_style('home-style', get_template_directory_uri() . '/assets/css/home-style.css', array(), rand(1,9999));
		wp_enqueue_script('home-scripts', get_template_directory_uri() . '/assets/js/home-scripts.js', array('jquery'), rand(1,9999), true );    
	}
	
	if ((basename($template) =='about-template.php')){
		wp_enqueue_style('about-style', get_template_directory_uri() . '/assets/css/about-style.css', array(), rand(1,9999));
		wp_enqueue_script('about-scripts', get_template_directory_uri() . '/assets/js/about-scripts.js', array('jquery'), rand(1,9999), true );
	}

	if ((basename($template) =='contacts-template.php')){
		wp_enqueue_style('contacts-style', get_template_directory_uri() . '/assets/css/contacts-style.css', array(), rand(1,9999));
		wp_enqueue_script('contacts-scripts', get_template_directory_uri() . '/assets/js/contacts-scripts.js', array('jquery'), rand(1,9999), true );
	}

	if ((basename($template) =='404.php')){
		wp_enqueue_style('404-style', get_template_directory_uri() . '/assets/css/404-style.css', array(), rand(1,9999));
	}

	if (is_woocommerce()){
		wp_enqueue_script('shop-scripts', get_template_directory_uri() . '/assets/js/shop-scripts.js', array('jquery'), rand(1,9999), true );
		wp_enqueue_script('jquery-ui-js', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', array('jquery'), rand(1, 9999));
		wp_enqueue_style('jquery-ui-style', get_template_directory_uri() . '/assets/css/jquery-ui.min.css', array(), rand(1, 9999));
		wp_enqueue_style('wc-shop-style', get_template_directory_uri() . '/assets/css/wc-shop-style.css', array(), rand(1,9999));
		wp_enqueue_style('wc-main-style', get_template_directory_uri() . '/assets/css/woocommerce-style.css', array(), rand(1,9999));
	}

	if(is_cart() || is_checkout()){
		wp_enqueue_style('wc-main-style', get_template_directory_uri() . '/assets/css/woocommerce-style.css', array(), rand(1,9999));
		wp_enqueue_style('wc-cart-style', get_template_directory_uri() . '/assets/css/wc-cart-style.css', array(), rand(1,9999));
		wp_enqueue_script('wc-cart-scripts', get_template_directory_uri() . '/assets/js/cart-scripts.js', array('jquery'), rand(1,9999), true );
	}

	if (is_product()){
		wp_enqueue_style('wc-product-style', get_template_directory_uri() . '/assets/css/wc-product-style.css', array(), rand(1,9999));
		wp_enqueue_script('wc-product-scripts', get_template_directory_uri() . '/assets/js/single-product-scripts.js', array('jquery'), rand(1, 9999));
	}

	if (is_page(3)){
		wp_enqueue_style('template-style', get_template_directory_uri() . '/assets/css/template-style.css', array(), rand(1,9999));
	}

	if (is_page(194) || (basename($template) =='cart-empty-template.php')){
		wp_enqueue_style('empty-cart-style', get_template_directory_uri() . '/assets/css/empty-cart-style.css', array(), rand(1,9999));
		wp_enqueue_script('wc-cart-scripts', get_template_directory_uri() . '/assets/js/cart-scripts.js', array('jquery'), rand(1,9999), true );
	}

}
add_action( 'wp_enqueue_scripts', 'leyva_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Remove cookies chekbox.
 */
remove_action( 'set_comment_cookies', 'wp_set_comment_cookies' );

add_action( 'admin_menu', 'add_new_options_page', 25 );

function add_new_options_page() {

	add_options_page(
		'API Setting Page',
		'API Setting',
		'manage_options',
		'api_page',
		'display_options_page_func',
		1
	);

}

function display_options_page_func() {

	$reqCurl = curl_init();
	$postFields = array('codigoFabricante' => '943', 'codigoCliente' => '99973', 'baseDatosCliente' => 'FS943', 'password' => base64_encode('OQAOIe79hl1X'));
	curl_setopt_array($reqCurl, array(
			CURLOPT_URL => 'https://api.sdelsol.com/login/Autenticar',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($postFields)
	));
	$response = curl_exec($reqCurl);
	curl_close($reqCurl);
	// print_r(json_decode($response)->resultado);
	$bearer = json_decode($response)->resultado;
	// echo '</br></br>';

	// Carga Tabla
	$reqCurl = curl_init();

	curl_setopt_array($reqCurl, array(
		CURLOPT_URL => 'https://api.sdelsol.com/admin/CargaTabla',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"ejercicio": "2024",
			"tabla": "F_ART",
			"filtro": "CODART LIKE \'%001%\' ORDER BY CODART DESC"
	}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $bearer
		),
	));

	$response = curl_exec($reqCurl);

	curl_close($reqCurl);
	$table_arr = json_decode($response)->resultado;
	// print_r($table_arr);
	// echo '</br></br>';
	$product_massive = array();
	foreach($table_arr as $key => $product_arr){
			foreach($product_arr as $prod_pos){
				switch ($prod_pos->columna) {
					case 'CODART':
						$product_sku = $prod_pos->dato;
						break;
					case 'DESART':
						$product_name = $prod_pos->dato;
						break;
					case 'IMGART':
						$product_img = $prod_pos->dato;
						break;
				}
			}
			$product_massive[$key] = ['product_sku' => $product_sku, 'product_name' => $product_name, 'product_image' => $product_img];
	}

	// print_r($product_massive);
	$reqCurl = curl_init();

	curl_setopt_array($reqCurl, array(
		CURLOPT_URL => 'https://api.sdelsol.com/admin/CargaTabla',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"ejercicio": "2024",
			"tabla": "F_LTA",
			"filtro": "ARTLTA LIKE \'%001%\' ORDER BY ARTLTA DESC"
	}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $bearer
		),
	));
	$response = curl_exec($reqCurl);

	curl_close($reqCurl);
	$table_price = json_decode($response, true);

	foreach($product_massive as $key => $product){
		foreach($table_price['resultado'] as $num => $price){
			if($price[1]['dato'] == $product['product_sku']){
				$product_massive[$key] += ['product_price' => $price[3]['dato']];
				break;
			}
		}
	}

	$sku_array = array();

	$args = array(
		'limit' => -1,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$query = new WC_Product_Query($args);
	$products = $query->get_products();

	if(!empty($products)){
		foreach ($products as $query_product) {			
			if($query_product->get_sku()){
				$sku_array[] = ['sku' => $query_product->get_sku(), 'id' => $query_product->get_id()];
			} 
		}
	}

	print_r($sku_array);

	foreach($product_massive as $num => $product_part){
		$add = false;
		$product_name = $product_part['product_name'];
		$product_sku = $product_part['product_sku'];
		$product_price = $product_part['product_price'];
		$product_img_url = $product_part['product_image'];

		// if($product_part['product_image']){
		// 	echo '</br></br>';
		// 	echo $product_img_url;
		// 	echo '</br></br>';
		// }

		foreach($sku_array as $sku){
			if($sku['sku'] == $product_sku){
				$add = false;
				$product_id = $sku['id'];
				break;
			} else {
				$add = true;
				$product_id = '';
			}
		}

		if($add == true){
			$product = new WC_Product_Simple();
			$product->set_name($product_name);
			$product->set_regular_price(number_format($product_price, 2));
			$product->set_category_ids(array(18));
			$product->set_sku($product_sku);
			$product->save();
		} else {
			$product = new WC_Product($product_id);
			$product->set_name($product_name);
			$product->set_regular_price(number_format($product_price, 2));
			$product->set_sku($product_sku);
			$product->save();
		}
	}

	echo '</br></br></br>';

	$args = array(
		'limit' => -1,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$query = new WC_Product_Query($args);
	$products = $query->get_products();
	$sku_array = array();
	$sku_taba = array();

	foreach($product_massive as $key => $product_taba){
		$sku_taba[$key] = $product_taba['product_sku'];
	}

	if(!empty($products)){
		foreach ($products as $query_product) {
			$delete = true;
			foreach	($sku_taba as $single_sku){
				if($single_sku == $query_product->get_sku()){
					$delete = false;
					echo $query_product->get_id();
					break;
				}
			}
			if($delete){
				wp_update_post(array(
					'ID' => $query_product->get_id(),
					'post_status' => 'draft',
				));
				echo 'Delete: ID-' . $query_product->get_id() . ' | SKU-' . $query_product->get_sku() . '</br>';
			}
		}
	}

	// Carga Tabla
	$reqCurl = curl_init();

	curl_setopt_array($reqCurl, array(
		CURLOPT_URL => 'https://api.sdelsol.com/admin/CargaTabla',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"ejercicio": "2024",
			"tabla": "F_CFG",
			"filtro": "TBDCFG LIKE \'%001%\' ORDER BY TBDCFG DESC"
	}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $bearer
		),
	));

	$response = curl_exec($reqCurl);

	curl_close($reqCurl);

	$table_arr = json_decode($response)->resultado;
	echo '</br></br></br></br>';
	print_r($response);
	print_r($table_arr);
	
	// echo '</br></br></br>';
	// print_r($sku_taba);
}

if(!wp_next_scheduled('cron_product_update_hook')){
	wp_schedule_event(time(), 'twicedaily', 'cron_product_update_hook');
}

add_action( 'cron_product_update_hook', 'product_update_func', 10, 3 );

function product_update_func(){
	$reqCurl = curl_init();
	$postFields = array('codigoFabricante' => '943', 'codigoCliente' => '99973', 'baseDatosCliente' => 'FS943', 'password' => base64_encode('OQAOIe79hl1X'));
	curl_setopt_array($reqCurl, array(
			CURLOPT_URL => 'https://api.sdelsol.com/login/Autenticar',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($postFields)
	));
	$response = curl_exec($reqCurl);
	curl_close($reqCurl);

	$bearer = json_decode($response)->resultado;

	$reqCurl = curl_init();

	curl_setopt_array($reqCurl, array(
		CURLOPT_URL => 'https://api.sdelsol.com/admin/CargaTabla',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"ejercicio": "2024",
			"tabla": "F_ART",
			"filtro": "CODART LIKE \'%001%\' ORDER BY CODART DESC"
	}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $bearer
		),
	));

	$response = curl_exec($reqCurl);

	curl_close($reqCurl);
	$table_arr = json_decode($response)->resultado;
	$product_massive = array();
	foreach($table_arr as $key => $product_arr){
			foreach($product_arr as $prod_pos){
				switch ($prod_pos->columna) {
					case 'CODART':
						$product_sku = $prod_pos->dato;
						break;
					case 'DESART':
						$product_name = $prod_pos->dato;
						break;
				}
			}
			$product_massive[$key] = ['product_sku' => $product_sku, 'product_name' => $product_name];
	}

	$reqCurl = curl_init();

	curl_setopt_array($reqCurl, array(
		CURLOPT_URL => 'https://api.sdelsol.com/admin/CargaTabla',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>'{
			"ejercicio": "2024",
			"tabla": "F_LTA",
			"filtro": "ARTLTA LIKE \'%001%\' ORDER BY ARTLTA DESC"
	}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $bearer
		),
	));
	$response = curl_exec($reqCurl);

	curl_close($reqCurl);
	$table_price = json_decode($response, true);

	foreach($product_massive as $key => $product){
		foreach($table_price['resultado'] as $num => $price){
			if($price[1]['dato'] == $product['product_sku']){
				$product_massive[$key] += ['product_price' => $price[3]['dato']];
				break;
			}
		}
	}

	$sku_array = array();

	$args = array(
		'limit' => -1,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$query = new WC_Product_Query($args);
	$products = $query->get_products();

	if(!empty($products)){
		foreach ($products as $query_product) {			
			if($query_product->get_sku()){
				$sku_array[] = ['sku' => $query_product->get_sku(), 'id' => $query_product->get_id()];
			} 
		}
	}

	foreach($product_massive as $num => $product_part){
		$add = false;

		$product_name = $product_part['product_name'];
		$product_sku = $product_part['product_sku'];
		$product_price = $product_part['product_price'];

		foreach($sku_array as $sku){
			if($sku['sku'] == $product_sku){
				$add = false;
				$product_id = $sku['id'];
				break;
			} else {
				$add = true;
				$product_id = '';
			}
		}

		if($add == true){
			$product = new WC_Product_Simple();
			$product->set_name($product_name);
			$product->set_regular_price(number_format($product_price, 2));
			$product->set_category_ids(array(18));
			$product->set_sku($product_sku);
			$product->save();
		} else {
			$product = new WC_Product($product_id);
			$product->set_name($product_name);
			$product->set_regular_price(number_format($product_price, 2));
			$product->set_sku($product_sku);
			$product->save();
		}
	}

	$args = array(
		'limit' => -1,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$query = new WC_Product_Query($args);
	$products = $query->get_products();
	$sku_array = array();
	$sku_taba = array();

	foreach($product_massive as $key => $product_taba){
		$sku_taba[$key] = $product_taba['product_sku'];
	}

	if(!empty($products)){
		foreach ($products as $query_product) {
			$delete = true;
			foreach	($sku_taba as $single_sku){
				if($single_sku == $query_product->get_sku()){
					$delete = false;
					break;
				}
			}
			if($delete){
				wp_update_post(array(
					'ID' => $query_product->get_id(),
					'post_status' => 'draft',
				));
			}
		}
	}
}

