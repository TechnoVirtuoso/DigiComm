<?php

	function enqueue_stuff() {

		$templatedir = get_template_directory_uri();
		$enqueList = [	
			[
				"name" => 'FontAwesome.css', 
				"type" => 'css',
				"path" => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
				"version" => '4.7.0_defer'
			],
			[
				"name" => 'style.css', 
				"type" => 'css',
				"path" => $templatedir . '/style.css',
				"version" => filemtime(get_theme_file_path('/style.css'))
			],
			
			[
				"name" => 'multiselect_dropdown.css', 
				"type" => 'css',
				"path" => 'https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css',
				"version" => '3.3.1',
				
			],
			[
				"name" => 'custom_select.css', 
				"type" => 'css',
				"path" => 'https://cdn.jsdelivr.net/npm/custom-select@1.1.15/build/custom-select.min.css',
				"version" => '1.1.15',
				
			],
		
			[
				"name" => 'jquery.js', 
				"type" => 'js',
				"path" => 'https://code.jquery.com/jquery-3.6.0.min.js',
				"version" => '3.3.1',
				"loadInFooter" => false
			],
			[
				"name" => 'jsPDF.js', 
				"type" => 'js',
				"path" => 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js',
				"version" => '2.5.0',
				"loadInFooter" => false
			],
			[
				"name" => 'custom_select.js', 
				"type" => 'js',
				"path" => 'https://cdn.jsdelivr.net/npm/custom-select@1.1.15/build/custom-select.min.js',
				"version" => '1.1.15',
				"loadInFooter" => false
			],

			[
				"name" => 'custom.js', 
				"type" => 'js',
				"path" => $templatedir . '/js/custom.js',
				"version" => "1.0.0",
				"loadInFooter" => true
			],
			[
				"name" => 'multiselect_dropdown.js', 
				"type" => 'js',
				"path" => 'https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.js',
				"version" => '3.3.1',
				"loadInFooter" => true
			],
			
			[
				"name" => 'TweenMax.js', 
				"type" => 'js',
				"path" => 'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js',
				"version" => '2.1.2_defer',
				"loadInFooter" => true
			],
			[
				"name" => 'Html2canvas.js', 
				"type" => 'js',
				"path" => 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js',
				"version" => '1.0.0',
				"loadInFooter" => true
			],
			
			// [
			// 	"name" => 'jsPDF_autotable.js', 
			// 	"type" => 'js',
			// 	"path" => '"https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"',
			// 	"version" => '2.5.0',
			// 	"loadInFooter" => true
			// ],
			// [
			// 	"name" => 'Html2Pdf.js', 
			// 	"type" => 'js',
			// 	"path" => 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js',
			// 	"version" => '1.0.0',
			// 	"loadInFooter" => true
			// ],
			[
				"name" => 'hammer.js', 
				"type" => 'js',
				"path" => 'https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js',
				"version" => '2.0.8_defer',
				"loadInFooter" => true
			],
			[
				"name" => 'gsap.js', 
				"type" => 'js',
				"path" => 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js',
				"version" => '1.0.0',
				"loadInFooter" => false
			]
		];
		
		foreach($enqueList as $asset) {	
			if ($asset['type'] === 'css') {
				wp_enqueue_style( 
					'victor_'.$asset['name'],  	// handle
					$asset['path'], 			// src
					null, 						// deps
					$asset['version'] 			// ver
				);	
			}	
			if ($asset['type'] === 'js') {
				wp_enqueue_script( 
					'victor_'.$asset['name'],  	// handle
					$asset['path'], 			// src
					array(), 					// deps
					$asset['version'], 			// ver
					$asset['loadInFooter']		// in footer
				);	
			}
		}
	} 
	
	add_action( 'wp_enqueue_scripts', 'enqueue_stuff' );
	
	
	// Function to defer or asynchronously load scripts for SEO Performance
	
	function js_async_attr($tag){	
		if (true == strpos($tag, 'defer') ) {
			 return str_replace( ' src', '  defer="defer" src', $tag ); 
		}
		return $tag;
	}
	add_filter( 'script_loader_tag', 'js_async_attr', 1 );


// ================================================================

// 	add_action( 'wp_enqueue_scripts', 'enqueue_woocommerce_ajax' );

// function enqueue_woocommerce_ajax() {
//     if ( class_exists( 'woocommerce' ) ) {
//         wp_enqueue_script( 'wc-ajax', WC()->plugin_url() . '/assets/js/frontend/ajax.js', array( 'jquery' ), WC_VERSION, true );
//     }
// }



?>
