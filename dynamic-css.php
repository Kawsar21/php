<?php
/**
 * Dynamic CSS for the frontend.
 *
 * @package Agency
 */

defined( 'WPINC' ) || exit;

/**
 * Helper function.
 * Merge and combine the CSS elements.
 *
 * @param  string|array $elements An array of our elements.
 *                                If we use a string then it is directly returned.
 * @return string
 */
function agency_implode( $elements = array() ) {

	if ( ! is_array( $elements ) ) {
		return $elements;
	}

	// Make sure our values are unique.
	$elements = array_unique( $elements );

	// Sort elements alphabetically.
	// This way all duplicate items will be merged in the final CSS array.
	sort( $elements );

	// Implode items and return the value.
	return implode( ',', $elements );

}

/**
 * Maps elements from dynamic css to the selector.
 *
 * @param  array  $elements The elements.
 * @param  string $selector The selector.
 * @return array
 */
function agency_map_selector( $elements, $selector ) {
	$array = array();

	foreach ( $elements as $element ) {
		$array[] = $element . $selector;
	}

	return $array;
}

/**
 * Map CSS selectors from values.
 *
 * @param array $css    Array of dynamic CSS.
 * @param array $values Array of values.
 */
function agency_map_css_selectors( &$css, $values ) {
	if ( isset( $values['css-selectors'] ) ) {
		$elements = $values['css-selectors'];
		unset( $values['css-selectors'] );

		$css[ $elements ] = $values;
	}
}

/**
 * Merge CSS values.
 *
 * @param array $css    Array of dynamic CSS.
 * @param array $values Array of values.
 */
function agency_merge_value( &$css, $values ) {
	foreach ( $values as $id => $val ) {
		$css[ $id ] = $val;
	}
}

/**
 * Format of the $css array:
 * $css['media-query']['element']['property'] = value
 *
 * If no media query is required then set it to 'global'
 *
 * If we want to add multiple values for the same property then we have to make it an array like this:
 * $css[media-query][element]['property'][] = value1
 * $css[media-query][element]['property'][] = value2
 *
 * Multiple values defined as an array above will be parsed separately.
 */
function agency_dynamic_css_array() {

	global $wp_version;

	$css       = array();
	$c_page_id = agency()->get_page_id();

	// Site Background.
	$css['global']['html body, #sidebar .widget h3 span'] = Agency_Sanitize::background( agency_get_settings( 'mts_background' ) );

	// Top bar Background.
	$css['global']['.top-bar'] = Agency_Sanitize::background( agency_get_settings( 'top_bar_background' ) );

	// Header Background.
	$css['global']['.main-header, #header.sticky-navigation-active, .navigation ul ul'] = Agency_Sanitize::background( agency_get_settings( 'header_background' ) );

	// Logo Font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'agency_logo' ) ) );
	// Primary Navigation font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'primary_navigation_font' ) ) );
	// Content Font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'content_font' ) ) );
	// Pagination.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'pagination_font' ) ) );
	// Single post title font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_title_font' ) ) );
	// Single post author info font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_author_meta_info_font' ) ) );
	// Single Page titles font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_page_titles_font' ) ) );
	// Single subscribe box.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_subscribe_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_subscribe_text_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_subscribe_input_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_subscribe_submit_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'single_subscribe_small_text_font' ) ) );
	// Author Box.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'authorbox_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'authorbox_author_name_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'authorbox_text_font' ) ) );
	// Footer Nav.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'footer_nav_font' ) ) );
	// Sidebar widget title font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'sidebar_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'sidebar_buttons_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'submit_button_font' ) ) );
	// Sidebar widget font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'mts_widget_links' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'default_widget_links' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'sidebar_url_bigthumb' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'sidebar_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'sidebar_font_bigthumb' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'sidebar_postinfo_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'sidebar_postinfo_font_bigthumb' ) ) );
	// Tab widget title font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'tabs_title_font' ) ) );
	// Footer widget title font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'top_footer_title_font' ) ) );
	// Footer link font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'top_footer_link_font' ) ) );
	// Footer MTS link font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'mts_footer_widget_links' ) ) );
	// Footer widget font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'top_footer_font' ) ) );
	// Copyrights section font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'copyrights_font' ) ) );
	// Fields font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'fields_font' ) ) );
	// H1 title in the content.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'h1_headline' ) ) );
	// H2 title in the content.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'h2_headline' ) ) );
	// H3 title in the content.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'h3_headline' ) ) );
	// H4 title in the content.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'h4_headline' ) ) );
	// H5 title in the content.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'h5_headline' ) ) );
	// H6 title in the content.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'h6_headline' ) ) );

	// Footer background.
	$css['global']['#site-footer'] = Agency_Sanitize::background( agency_get_settings( 'mts_footer_background' ) );
	// Copyrights background.
	$css['global']['.copyrights'] = Agency_Sanitize::background( agency_get_settings( 'mts_copyrights_background' ) );

	agency_dynamic_css_skin( $css );
	agency_sidebar_position( $css );
	agency_header( $css );
	agency_sidebar_styling( $css );
	agency_homepage_settings( $css );
	agency_pages_title( $css );
	agency_post_layouts( $css );
	agency_post_pagination( $css );
	agency_footer_subscribe( $css );
	agency_footer( $css );
	agency_copyrights( $css );
	agency_single( $css );
	agency_single_social_buttons( $css );
	agency_archive_post( $css );
	agency_misc_css( $css );

	return apply_filters( 'agency_dynamic_css_array', $css );
}

/**
 * Skin CSS
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_dynamic_css_skin( &$css ) {

	// Colors.
	$primary_color_scheme = Agency_Sanitize::color( agency_get_settings( 'primary_color_scheme' ) );

	// Text Color.
	$elements = array(
		'a',
		'body a:hover',
		'.reply a:hover',
		'.reply a .fa',
		'.latestPost .title a:hover',
		'.related-posts .title a:hover',
		'.woocommerce ul.products li.product .price',
		'.product_list_widget .amount',
		'.woocommerce div.product p.price, .woocommerce div.product span.price',
		'.shareit-circular.standard .fa:hover',
		'.textwidget a',
		'#wp-calendar td#today',
		'.pnavigation2 a',
		'#sidebar .widget li a:hover',
		'#sidebar .widget li.horizontal-small .post-title a:hover',
		'#tabber .inside li a:hover',
		'.fn a',
		'.widget .wp_review_tab_widget_content a',
		'.sidebar .wpt_widget_content a',
		'.related-posts .title a:hover',
		'blockquote:after',
		'article ul li::before',
		'.single .pagination a .current:hover',
		'blockquote::before',
		'.postauthor h5 a:hover',
		'#primary-navigation li a:hover',
		'#sidebar .widget .vertical-small .widget-readmore a',
		'.related-readmore a',
		'.toggle-menu .toggle-caret .fa',
		'#primary-navigation li.current-menu-item a',
		'.widget .wpt_widget_content #tags-tab-content ul li a',
		'.widget .sbutton',
		'.shareit-circular.standard .share-text',
		'.f-widget .widget li.horizontal-small .post-title a:hover',
		'.services-section li .fa',
		'.menu-item-has-children > a:after',
		'.layout-default .latestPost .title a:hover',
		'.layout-1 .latestPost .title a:hover',
	);

	$css['global'][ agency_implode( $elements ) ]['color'] = $primary_color_scheme;
	$css['global']['#sidebar .widget a:hover']['color']    = $primary_color_scheme;
	//social svg hover color
	$css['global']['.shareit-circular.standard svg:hover']['fill'] = $primary_color_scheme;

	// Text Color Important.
	$elements = array(
		'.widget .review_thumb_large .review-result',
		'.widget .review_thumb_large .review-total-only.large-thumb',
		'.review-total-only.small-thumb .review-result-wrapper i',
		'.latestPost .post-info a:hover',
		'#sidebar .social-profile-icons ul li a:hover',
	);
	$css['global'][ agency_implode( $elements ) ]['color'] = $primary_color_scheme . '!important';

	// Background Color.
	$elements = array(
		'.pace .pace-progress',
		'#mobile-menu-wrapper ul li a:hover',
		'.pagination a:hover',
		'.single .pagination a:hover .current',
		'.navigation #wpmm-megamenu .wpmm-pagination a',
		'.wpmm-megamenu-showing.wpmm-light-scheme',
		'.widget #wp-subscribe input.submit:hover',
		'#move-to-top:hover',
		'#tabber ul.tabs li a.selected',
		'.navigation ul .sfHover a',
		'.widget-slider .slide-caption',
		'.owl-prev:hover, .owl-next:hover',
		'.widget .wp-subscribe-wrap h4.title span.decor:after',
		'#wpmm-megamenu .review-total-only',
		'#searchsubmit',
		'.woocommerce .widget_price_filter .ui-slider .ui-slider-handle',
		'.woocommerce .widget_price_filter .ui-slider .ui-slider-range',
		'.woocommerce nav.woocommerce-pagination ul li a:focus',
		'.woocommerce nav.woocommerce-pagination ul li a:hover',
		'.woocommerce nav.woocommerce-pagination ul li span.current',
		'.latestPost-review-wrapper',
		'.latestPost .review-type-circle.latestPost-review-wrapper',
		'.woocommerce span.onsale',
		'.widget .widget_wp_review_tab .review-total-only.large-thumb',
		'.post-info > span::after',
		'#wp-calendar caption',
		'.single-subscribe .widget #wp-subscribe input.submit:hover',
		'.error404 .article .sbutton',
		'.search .article .sbutton',
		'#sidebar .widget .tagcloud a:hover',
		'.f-widget .tagcloud a:hover',
		'.widget .wp_review_tab_widget_content ul.wp-review-tabs li.selected a::before',
		'.widget .wpt_widget_content ul.wpt-tabs li.selected a::before',
		'.tags a:hover',
	);

	$css['global'][ agency_implode( $elements ) ]['background-color'] = $primary_color_scheme;

	$css['@media screen and (max-width: 865px)']['.navigation.mobile-menu-wrapper']['background-color'] = $primary_color_scheme;

	// WooCommerce Background Gradient Color.
	$woo_gradient_classes = array(
		'.woocommerce a.button',
		'.woocommerce-page a.button',
		'.woocommerce button.button',
		'.woocommerce-page button.button',
		'.woocommerce input.button',
		'.woocommerce-page input.button',
		'.woocommerce #respond input#submit',
		'.woocommerce-page #respond input#submit',
		'.woocommerce #content input.button',
		'.woocommerce-page #content input.button',
		'.woocommerce .bypostauthor:after',
		'.woocommerce a.button',
		'.woocommerce-page a.button',
		'.woocommerce button.button',
		'.woocommerce-page button.button',
		'.woocommerce input.button',
		'.woocommerce-page input.button',
		'.woocommerce #respond input#submit',
		'.woocommerce-page #respond input#submit',
		'.woocommerce #content input.button',
		'.woocommerce-page #content input.button',
		'.woocommerce #respond input#submit.alt.disabled',
		'.woocommerce #respond input#submit.alt.disabled:hover',
		'.woocommerce #respond input#submit.alt:disabled',
		'.woocommerce #respond input#submit.alt:disabled:hover',
		'.woocommerce #respond input#submit.alt:disabled[disabled]',
		'.woocommerce #respond input#submit.alt:disabled[disabled]:hover',
		'.woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover',
		'.woocommerce a.button.alt:disabled',
		'.woocommerce a.button.alt:disabled:hover',
		'.woocommerce a.button.alt:disabled[disabled]',
		'.woocommerce a.button.alt:disabled[disabled]:hover',
		'.woocommerce button.button.alt.disabled',
		'.woocommerce button.button.alt.disabled:hover',
		'.woocommerce button.button.alt:disabled',
		'.woocommerce button.button.alt:disabled:hover',
		'.woocommerce button.button.alt:disabled[disabled]',
		'.woocommerce button.button.alt:disabled[disabled]:hover',
		'.woocommerce input.button.alt.disabled',
		'.woocommerce input.button.alt.disabled:hover',
		'.woocommerce input.button.alt:disabled',
		'.woocommerce input.button.alt:disabled:hover',
		'.woocommerce input.button.alt:disabled[disabled]',
		'.woocommerce input.button.alt:disabled[disabled]:hover',
		'#add_payment_method .wc-proceed-to-checkout a.checkout-button',
		'.woocommerce-cart .wc-proceed-to-checkout a.checkout-button',
		'.woocommerce-checkout .wc-proceed-to-checkout a.checkout-button',
		'.woocommerce #respond input#submit.alt',
		'.woocommerce a.button.alt',
		'.woocommerce button.button.alt',
		'.woocommerce input.button.alt',
		'.woocommerce-account .woocommerce-MyAccount-navigation li.is-active',
		'.woocommerce .woocommerce-widget-layered-nav-dropdown__submit',
	);
	agency_merge_value( $css['global'][ agency_implode( $woo_gradient_classes ) ], Agency_Sanitize::background( agency_get_settings( 'gradient_setting' ) ) );

	// Background Color Important.
	$elements = array(
		'.widget .wpt_widget_content #tags-tab-content ul li a:hover ',
	);
	$css['global'][ agency_implode( $elements ) ]['background-color'] = $primary_color_scheme . '!important';

	// Border Color.
	$elements = array(
		'.page-numbers.current',
		'.pagination a:hover',
		'.tags a:hover',
		'.widget .wpt_widget_content #tags-tab-content ul li a',
		'.widget #wp-subscribe input.submit',
		'.header-layout2 .header-search #s:focus',
		'.tagcloud a:hover',
	);

	$css['global'][ agency_implode( $elements ) ]['border-color'] = $primary_color_scheme;

	$css['global']['.feature-section .play-icon span']['border-left-color'] = $primary_color_scheme;

	// Gradient.
	$gradient_classes = array(
		'.button',
		'.readMore a',
		'.footer-subscribe-section #wp-subscribe input.submit',
		'.feature-section .play-button-wrap',
		'.widget #wp-subscribe input.submit',
		'.widget.widget_categories li span',
		'.instagram-button a',
		'.aboutme-widget .aboutme-social a',
		'#commentform input#submit',
		'#mtscontact_submit',
		'.sbutton, #searchsubmit',
		'.mts-subscribe input[type="submit"]',
		'.widget_product_search button[type="submit"]',
	);

	agency_merge_value( $css['global'][ agency_implode( $gradient_classes ) ], Agency_Sanitize::background( agency_get_settings( 'gradient_setting' ) ) );

	// Buttons hover.
	$gradient_classes = array(
		'.button:hover::after',
		'.readMore a:hover::after',
		'.aboutme-widget .aboutme-social a:hover::after',
		'.social-profile-icons ul li a:hover::after',
	);

	agency_merge_value( $css['global'][ agency_implode( $gradient_classes ) ], Agency_Sanitize::background( agency_get_settings( 'button_hover_color' ) ) );

}

/**
 * Sidebar Position
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_sidebar_position( &$css ) {

	// Sidebar position.
	$sidebar_position = agency_get_settings( 'mts_layout' );

	$sidebar_metabox_location = '';
	if ( is_page() || is_single() ) {
		$sidebar_metabox_location = get_post_meta( get_the_ID(), '_mts_sidebar_location', true );
	}

	if ( 'right' !== $sidebar_metabox_location && ( 'sclayout' === $sidebar_position || 'left' === $sidebar_metabox_location ) ) {
		$css['global']['.article']['float']                = 'right';
		$css['global']['.sidebar.c-4-12']['float']         = 'left';
		$css['global']['.sidebar.c-4-12']['padding-right'] = 0;

		if ( null !== agency_get_settings( 'mts_social_button_position' ) && 'floating' === agency_get_settings( 'mts_social_button_position' ) ) {

			$shareit_class = array(
				'.right .shareit.shareit-default.floating',
				'.right .shareit.standard.floating',
				'.right .shareit.shareit-circular.floating',
			);

			$css['global'][ agency_implode( $shareit_class ) ]['left']  = 'auto';
			$css['global'][ agency_implode( $shareit_class ) ]['right'] = '0px';

			$css['global'][ agency_implode( $shareit_class ) ]['margin-left']  = '0px';
			$css['global'][ agency_implode( $shareit_class ) ]['margin-right'] = '50px';
		}
	}
	if ( 'mts_nosidebar' == mts_custom_sidebar() ) {
		$css['global']['.single-full-header']['width'] = '100%';
	}
}

/**
 * Header
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_header( &$css ) {

	$header_styles = agency_get_settings( 'header_styles' );
	$header_icons  = agency_get_settings( 'header_social_icons' );

	// Header.
	$header_class = array(
		'#header',
	);
	agency_merge_value( $css['global'][ agency_implode( $header_class ) ], Agency_Sanitize::margin( agency_get_settings( 'header_margin' ) ) );
	agency_merge_value( $css['global'][ agency_implode( $header_class ) ], Agency_Sanitize::padding( agency_get_settings( 'header_padding' ) ) );

	// Header Border.
	$header_border = Agency_Sanitize::border( agency_get_settings( 'header_border' ) );
	$css['global'][ agency_implode( $header_class ) ][ $header_border['direction'] ] = $header_border ['value'];

	// Nav styling.
	// Nav color.
	$css['global']['#primary-navigation .navigation ul ul a']['color'] = Agency_Sanitize::color( agency_get_settings( 'main_navigation_dropdown_color' ) );

	$css['global']['#primary-navigation .navigation ul ul a:hover']['color'] = Agency_Sanitize::color( agency_get_settings( 'main_navigation_dropdown_hover_color' ) );

	// Nav Padding.
	agency_merge_value( $css['global']['#primary-navigation'], Agency_Sanitize::padding( agency_get_settings( 'header_nav_padding' ) ) );

	// Header Ad.
	agency_merge_value( $css['global']['.widget-header, .small-header .widget-header'], Agency_Sanitize::margin( agency_get_settings( 'mts_header_adcode_margin' ) ) );

	// Ad-Blocker.
	$css['global']['.navigation-banner']['background'] = Agency_Sanitize::color( agency_get_settings( 'navigation_ad_background' ) );
}

/**
 * Social Share Styling
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_single_social_buttons( &$css ) {

	// Social share.
	$css['global']['.shareit.floating'] = Agency_Sanitize::background( agency_get_settings( 'social_styling_background' ) );
	agency_merge_value( $css['global']['.shareit.floating'], Agency_Sanitize::margin( agency_get_settings( 'social_styling_margin' ) ) );

	// Social share border.
	$social_border = Agency_Sanitize::border( agency_get_settings( 'social_styling_border' ) );
	$css['global']['.shareit.floating'][ $social_border ['direction'] ] = $social_border ['value'];

	$social_button_layout   = agency_get_settings( 'social_button_layout' );
	$social_button_position = agency_get_settings( 'social_floating_button_position' );
	if ( 'default' === $social_button_layout ) {
		$share_class = '.shareit.shareit-' . $social_button_layout . '.floating';
	} else {
		$share_class = '.shareit.' . $social_button_layout . '.floating';
	}
	if ( ! empty( $social_button_position ) && is_array( $social_button_position ) ) {
		foreach ( $social_button_position as $key => $position ) {
			$css['global'][ $share_class ][ $key ] = $position;
		}
	}
}

/**
 * Sidebar styling
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_sidebar_styling( &$css ) {

	// Sidebar.
	agency_merge_value( $css['global']['.widget, .f-widget .widget'], Agency_Sanitize::background( agency_get_settings( 'sidebar_styling_background' ) ) );
	agency_merge_value( $css['global']['.widget, .f-widget .widget'], Agency_Sanitize::margin( agency_get_settings( 'sidebar_styling_margin' ) ) );
	agency_merge_value( $css['global']['.widget, .f-widget .widget'], Agency_Sanitize::padding( agency_get_settings( 'sidebar_styling_padding' ) ) );

	// Sidebar border.
	$sidebar_border = Agency_Sanitize::border( agency_get_settings( 'sidebar_styling_border' ) );
	$css['global']['.widget, .f-widget .widget'][ $sidebar_border['direction'] ] = $sidebar_border['value'];

	// Sidebar title.
	$sidebar_title                   = '#sidebar .widget h3';
	$css['global'][ $sidebar_title ] = Agency_Sanitize::background( agency_get_settings( 'sidebar_title_styling_background' ) );
	agency_merge_value( $css['global'][ $sidebar_title ], Agency_Sanitize::padding( agency_get_settings( 'sidebar_title_styling_padding' ) ) );
	agency_merge_value( $css['global'][ $sidebar_title ], Agency_Sanitize::margin( agency_get_settings( 'sidebar_title_styling_margin' ) ) );

	// Sidebar Title border.
	$sidebar_title_border = Agency_Sanitize::border( agency_get_settings( 'widget_title_border' ) );
	$css['global'][ $sidebar_title ][ $sidebar_title_border['direction'] ] = $sidebar_title_border['value'];

}

/**
 * HomePage Sections CSS
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_homepage_settings( &$css ) {

	/**
	 * Featured Section
	 */

	// Styling.
	agency_merge_value( $css['global']['.featured-section'], Agency_Sanitize::background( agency_get_settings( 'featured_background' ) ) );

	agency_merge_value( $css['global']['.featured-section'], Agency_Sanitize::margin( agency_get_settings( 'featured_margin' ) ) );
	agency_merge_value( $css['global']['.featured-section'], Agency_Sanitize::padding( agency_get_settings( 'featured_padding' ) ) );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'featured_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'featured_content_font' ) ) );

	/**
	 * Services Section
	 */
	$i        = 0;
	$services = agency_get_settings( 'services_list' );

	// Styling.
	agency_merge_value( $css['global']['.services-section'], Agency_Sanitize::background( agency_get_settings( 'services_background' ) ) );

	foreach ( $services as $service ) {
		++$i;

		agency_merge_value( $css['global'][ '.services-section li.service-' . $i ], Agency_Sanitize::background( $service['service_gradient'] ) );

		agency_merge_value( $css['global'][ '.services-section li.service-' . $i ], Agency_Sanitize::margin( $service['service_list_margin'] ) );
		agency_merge_value( $css['global'][ '.services-section li.service-' . $i ], Agency_Sanitize::padding( $service['service_list_padding'] ) );

		$css['global'][ '.services-section li.service-' . $i . ' .service-icon .fa' ]['color']   = Agency_Sanitize::color( $service['service_icon_color'] );
		$css['global'][ '.services-section li.service-' . $i . ' .service-content h3' ]['color'] = Agency_Sanitize::color( $service['service_title_color'] );
		$css['global'][ '.services-section li.service-' . $i . ' .service-content p' ]['color']  = Agency_Sanitize::color( $service['service_text_color'] );

		$css['global'][ '.services-section li.service-' . $i . ' .button-wrap a, .services-section li.service-' . $i . ' .button-wrap .fa' ]['color'] = Agency_Sanitize::color( $service['service_button_color'] );

		$css['global'][ '.services-section li.service-' . $i . ' .button-wrap .fa' ]['border-color'] = Agency_Sanitize::color( $service['service_button_color'] );

	}

	agency_merge_value( $css['global']['.services-section'], Agency_Sanitize::margin( agency_get_settings( 'services_margin' ) ) );
	agency_merge_value( $css['global']['.services-section'], Agency_Sanitize::padding( agency_get_settings( 'services_padding' ) ) );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'services_small_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'services_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'services_big_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'services_list_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'services_list_text_font' ) ) );

	/**
	 * Feature Section
	 */
	$count                = 0;
	$features             = agency_get_settings( 'feature_list' );
	$primary_color_scheme = Agency_Sanitize::color( agency_get_settings( 'primary_color_scheme' ) );

	if ( $features && is_array( $features ) ) {

		foreach ( $features as $feature ) {

			++$count;

			if ( 'left' === $feature['feature_alignment'] ) {
				foreach ( $feature['img_position_left'] as $key => $position ) {
					$css['global']['.feature-section .left .feature-img'][ $key ] = $position;
				}
			} else {
				foreach ( $feature['img_position_right'] as $key => $position ) {
					$css['global']['.feature-section .right .feature-img'][ $key ] = $position;
				}
			}

			agency_merge_value( $css['global'][ '.feature-section li.feature-' . $count . ' .content-area' ], Agency_Sanitize::padding( $feature['feature_content_padding'] ) );

			agency_merge_value( $css['global'][ '.feature-section li.feature-' . $count ], Agency_Sanitize::margin( $feature['feature_margin'] ) );
			agency_merge_value( $css['global'][ '.feature-section li.feature-' . $count ], Agency_Sanitize::padding( $feature['feature_padding'] ) );

		}
	}

	// Styling.
	agency_merge_value( $css['global']['.feature-section li'], Agency_Sanitize::background( agency_get_settings( 'feature_background' ) ) );

	$css['global']['.feature-section .play-button-wrap']['box-shadow']                    = '0 0 0 10px ' . hex2rgba( $primary_color_scheme, 0.2 );
	$css['global']['.feature-section .play-button:hover .play-button-wrap']['box-shadow'] = '0 0 0 14px ' . hex2rgba( $primary_color_scheme, 0.2 );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'feature_small_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'feature_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'feature_content_font' ) ) );

	/**
	 * Counter Section
	 */
	$count        = 0;
	$counter_list = agency_get_settings( 'counter_list' );

	if ( $counter_list && is_array( $counter_list ) ) {

		foreach ( $counter_list as $counter ) {

			++$count;

			agency_merge_value( $css['global'][ '.counter-section li.counter-' . $count ], Agency_Sanitize::margin( $counter['counter_margin'] ) );
			agency_merge_value( $css['global'][ '.counter-section li.counter-' . $count ], Agency_Sanitize::padding( $counter['counter_padding'] ) );

			agency_merge_value( $css['global'][ '.counter-section li.counter-' . $count ], Agency_Sanitize::background( $counter['counter_gradient'] ) );

			$css['global'][ '.counter-section li.counter-' . $count ]['height'] = Agency_Sanitize::size( $counter['counter_height'] . 'px' );

			$css['global'][ '.counter-section li.counter-' . $count ]['border-radius'] = $counter['counter_border_radius'];

		}
	}

	// Styling.
	agency_merge_value( $css['global']['.counter-section'], Agency_Sanitize::background( agency_get_settings( 'counter_background' ) ) );

	agency_merge_value( $css['global']['.counter-section .right'], Agency_Sanitize::padding( agency_get_settings( 'counter_content_padding' ) ) );

	agency_merge_value( $css['global']['.counter-section'], Agency_Sanitize::margin( agency_get_settings( 'counter_section_margin' ) ) );
	agency_merge_value( $css['global']['.counter-section'], Agency_Sanitize::padding( agency_get_settings( 'counter_section_padding' ) ) );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'counter_number_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'counter_text_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'counter_small_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'counter_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'counter_content_font' ) ) );

	/**
	 * Client & Team Section
	 */

	// Client & Team Sections Settings.
	if ( 'single' === agency_get_settings( 'client_team_background_switch' ) ) {
		agency_merge_value( $css['global']['.client-team-sections'], Agency_Sanitize::background( agency_get_settings( 'client_team_background' ) ) );
	} else {
		agency_merge_value( $css['global']['.client-sections'], Agency_Sanitize::background( agency_get_settings( 'client_background' ) ) );
		agency_merge_value( $css['global']['.team-sections'], Agency_Sanitize::background( agency_get_settings( 'team_background' ) ) );
	}

	agency_merge_value( $css['global']['.client-team-sections'], Agency_Sanitize::margin( agency_get_settings( 'client_team_margin' ) ) );
	agency_merge_value( $css['global']['.client-team-sections'], Agency_Sanitize::padding( agency_get_settings( 'client_team_padding' ) ) );

	// Client Section.
	// Styling.
	agency_merge_value( $css['global']['.client-section'], Agency_Sanitize::padding( agency_get_settings( 'client_padding' ) ) );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'client_small_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'client_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'client_big_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'author_name_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'author_designation_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'author_content_font' ) ) );

	// Team Section.
	// Styling.
	agency_merge_value( $css['global']['.team-section'], Agency_Sanitize::padding( agency_get_settings( 'team_padding' ) ) );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'team_small_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'team_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'team_big_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'member_name_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'member_designation_font' ) ) );

	/**
	 * Table Section
	 */
	$i          = 0;
	$table_list = agency_get_settings( 'table_list' );

	// Styling.
	agency_merge_value( $css['global']['.table-section'], Agency_Sanitize::background( agency_get_settings( 'table_background' ) ) );

	if ( $table_list && is_array( $table_list ) ) {

		foreach ( $table_list as $table ) {

			++$i;

			$css['global'][ '.table-section li.table-' . $i . ' .table-heading' ]['color'] = Agency_Sanitize::color( $table['table_title_color'] );

			$css['global'][ '.table-section li.table-' . $i . ' .price' ]['color'] = Agency_Sanitize::color( $table['table_price_color'] );

			$css['global'][ '.table-section li.table-' . $i . ' .validity, .table-section li.table-' . $i . ' .table-text' ]['color'] = Agency_Sanitize::color( $table['table_text_color'] );

			agency_merge_value( $css['global'][ '.table-section li.table-' . $i ], Agency_Sanitize::background( $table['table_gradient'] ) );

		}
	}

	agency_merge_value( $css['global']['.table-section'], Agency_Sanitize::margin( agency_get_settings( 'table_margin' ) ) );
	agency_merge_value( $css['global']['.table-section'], Agency_Sanitize::padding( agency_get_settings( 'table_padding' ) ) );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'table_small_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'table_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'table_big_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'table_desc_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'table_list_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'table_list_price_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'table_list_text_font' ) ) );
}

/**
 * Pages Titles CSS
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_pages_title( &$css ) {

	// Background.
	$css['global']['.pages-title-section'] = Agency_Sanitize::background( agency_get_settings( 'pages_title_background' ) );

	// Padding and Margin.
	agency_merge_value( $css['global']['.pages-title-section'], Agency_Sanitize::padding( agency_get_settings( 'pages_title_padding' ) ) );
	agency_merge_value( $css['global']['.pages-title-section'], Agency_Sanitize::margin( agency_get_settings( 'pages_title_margin' ) ) );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'pages_title_font' ) ) );
	// Breadcrumbs font.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'breadcrumb_font' ) ) );

}

/**
 * Layout CSS
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_post_layouts( &$css ) {

	// Post Layouts.
	$features = agency_get_settings( 'featured_categories' );
	foreach ( $features as $feature ) :

		if ( ! isset( $feature['unique_id'] ) ) {
			continue;
		}

		$category     = $feature['mts_featured_category'];
		$posts_layout = isset( $feature['blog_layout'] ) ? $feature['blog_layout'] : 'layout-default';
		$unique_id    = $feature['unique_id'];

		if ( 'layout-default' === $posts_layout ) :
			$posts_layout = 'default';
		endif;

		// Section title align.
		$post_title_align = agency_get_settings( 'post_title_alignment_' . $unique_id );

		// Post area.
		$cat_class = 'cat-latest';
		if ( 'latest' !== $category ) {
			$category  = get_term_by( 'slug', $category, 'category' );
			$cat_class = sanitize_key( $category->name );
		}

		$title_class = '.title-container.title-id-' . $unique_id . ' h3';

		$css['global'][ $title_class ] = Agency_Sanitize::background( agency_get_settings( 'featured_category_title_background_' . $unique_id ) );
		agency_merge_value( $css['global'][ $title_class ], Agency_Sanitize::margin( agency_get_settings( 'featured_category_title_margin_' . $unique_id ) ) );
		agency_merge_value( $css['global'][ $title_class ], Agency_Sanitize::padding( agency_get_settings( 'featured_category_title_padding_' . $unique_id ) ) );
		// Section title border.
		$post_title_border = Agency_Sanitize::border( agency_get_settings( 'post_title_border_' . $unique_id ) );
		$css['global'][ $title_class ][ $post_title_border['direction'] ] = $post_title_border['value'];

		// Title alignment.
		$align_class = '.title-container.title-id-' . $unique_id;
		if ( 'center' === $post_title_align ) :
			$css['global'][ $align_class ]['text-align'] = 'center';
		elseif ( 'right' === $post_title_align ) :
			$css['global'][ $align_class ]['text-align']              = 'right';
			$css['global'][ $align_class . ' + .view-more' ]['left']  = '0';
			$css['global'][ $align_class . ' + .view-more' ]['right'] = 'auto';
		endif;

		agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'featured_category_title_font_' . $unique_id ) ) );

		if ( 'layout-default' === $posts_layout ) {
			$post_class = '.layout-' . $unique_id . '.default-container';
		} else {
			$post_class = '.layout-' . $unique_id;
		}

		// Post border.
		$post_border = Agency_Sanitize::border( agency_get_settings( 'post_border_' . $unique_id ) );
		$css['global'][ $post_class ][ $post_border['direction'] ] = $post_border['value'];

		/**
		 * Meta info
		 */
		agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'meta_info_font_' . $unique_id ) ) );

		agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'post_title_font_' . $unique_id ) ) );
		agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'post_excerpt_font_' . $unique_id ) ) );

		if ( 'layout-1' === $posts_layout || 'layout-2' === $posts_layout ) {
			agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'post_small_title_font_' . $unique_id ) ) );
		}

		// Border.
		$meta_info_border = Agency_Sanitize::border( agency_get_settings( 'meta_info_border_' . $unique_id ) );
		$css['global'][ '.layout-' . $unique_id . ' .latestPost .post-info' ][ $meta_info_border['direction'] ] = $meta_info_border['value'];

		// All Posts Margin and Padding.
		agency_merge_value( $css['global'][ $post_class ], Agency_Sanitize::margin( agency_get_settings( 'post_margin_' . $unique_id ) ) );
		agency_merge_value( $css['global'][ $post_class ], Agency_Sanitize::padding( agency_get_settings( 'post_padding_' . $unique_id ) ) );

	endforeach;
}

/**
 * Pagination
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_post_pagination( &$css ) {

	// Pagination Active class.
	$pagination_class_active = array(
		'.pace .pace-progress',
		'.page-numbers.current',
		'#mobile-menu-wrapper ul li a:hover',
		'.pagination a:hover',
	);
	$pagination_class        = array(
		'.pagination a',
		'.single .pagination > .current .currenttext',
		'.pagination .page-numbers.dots',
	);
	agency_merge_value( $css['global'][ agency_implode( array_merge( $pagination_class_active, $pagination_class ) ) ], Agency_Sanitize::margin( agency_get_settings( 'mts_pagenavigation_margin' ) ) );
	if ( '2' !== agency_get_settings( 'mts_pagenavigation_type' ) ) {
		$css['global'][ agency_implode( $pagination_class ) ]['background-color'] = Agency_Sanitize::color( agency_get_settings( 'mts_pagenavigation_bgcolor' ) );

		$css['global'][ agency_implode( $pagination_class_active ) ] = Agency_Sanitize::background( agency_get_settings( 'mts_pagenavigation_hover_bgcolor' ) );

		$css['global'][ agency_implode( $pagination_class ) ]['color'] = Agency_Sanitize::color( agency_get_settings( 'mts_pagenavigation_color' ) );

		$css['global'][ agency_implode( $pagination_class_active ) ]['color'] = Agency_Sanitize::color( agency_get_settings( 'mts_pagenavigation_hover_color' ) );

		agency_merge_value( $css['global'][ agency_implode( array_merge( $pagination_class_active, $pagination_class ) ) ], Agency_Sanitize::padding( agency_get_settings( 'mts_pagenavigation_padding' ) ) );
	} else {
		$css['global']['#load-posts a']['background-color'] = Agency_Sanitize::color( agency_get_settings( 'load_more_bgcolor' ) );

		$css['global']['#load-posts a:hover'] = Agency_Sanitize::background( agency_get_settings( 'load_more_hover_bgcolor' ) );

		$css['global']['#load-posts a']['color'] = Agency_Sanitize::color( agency_get_settings( 'load_more_color' ) );

		$css['global']['#load-posts a:hover']['color'] = Agency_Sanitize::color( agency_get_settings( 'load_more_hover_color' ) );

		agency_merge_value( $css['global']['#load-posts a'], Agency_Sanitize::padding( agency_get_settings( 'load_more_padding' ) ) );
	}

	$border_radius_class   = $pagination_class;
	$border_radius_class[] = '#load-posts a';

	// Border radius.
	$css['global'][ agency_implode( $border_radius_class ) ]['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'mts_pagenavigation_border_radius' ) . 'px' );

	$css['global'][ agency_implode( $pagination_class_active ) ]['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'mts_pagenavigation_border_radius' ) . 'px' );

	// Pagination border.
	$pagination_border = Agency_Sanitize::border( agency_get_settings( 'pagenavigation_border' ) );
	$css['global'][ agency_implode( $pagination_class ) ][ $pagination_border ['direction'] ] = $pagination_border ['value'];

	// Pagination Alignment.
	$pagenavigation_align = agency_get_settings( 'pagenavigation_alignment' );
	if ( 'left' === $pagenavigation_align ) :
		$css['global']['.pagination']['text-align'] = 'left';
	elseif ( 'right' === $pagenavigation_align ) :
		$css['global']['.pagination']['text-align'] = 'right';
	endif;

	// Load more Alignment.
	$load_more_align = agency_get_settings( 'load_more_alignment' );
	if ( 'left' === $load_more_align ) :
		$css['global']['#load-posts']['text-align'] = 'left';
	elseif ( 'right' === $load_more_align ) :
		$css['global']['#load-posts']['text-align'] = 'right';
	elseif ( 'full' === $load_more_align ) :
		$css['global']['#load-posts a']['width'] = '100%';
	endif;
}

/**
 * Single
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_single( &$css ) {

	// Single Page auto padding.
	$single_padding = Agency_Sanitize::padding( agency_get_settings( 'mts_single_styling_padding' ) );

	$css['global']['.single-featured-wrap']['margin-top']   = '-' . $single_padding['padding-top'];
	$css['global']['.single-featured-wrap']['margin-right'] = '-' . $single_padding['padding-right'];
	$css['global']['.single-featured-wrap']['margin-left']  = '-' . $single_padding['padding-left'];

	// Single, Page and 404 Page Background.
	$page_classes = array(
		'.single_post',
		'.page .article',
		'.error404 .article',
	);

	$css['global'][ agency_implode( $page_classes ) ] = Agency_Sanitize::background( agency_get_settings( 'single_background' ) );

	// Margin, Padding, Border and Box Shadow.
	agency_merge_value( $css['global']['.article'], Agency_Sanitize::margin( agency_get_settings( 'mts_single_styling_margin' ) ) );
	agency_merge_value( $css['global'][ agency_implode( $page_classes ) ], Agency_Sanitize::padding( agency_get_settings( 'mts_single_styling_padding' ) ) );

	// Single border.
	$single_border = Agency_Sanitize::border( agency_get_settings( 'single_styling_border' ) );
	$css['global']['.article'][ $single_border ['direction'] ] = $single_border ['value'];

	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'mts_single_meta_info_font' ) ) );

	// Tags.
	$css['global']['.tags a, .tagcloud a, .widget .wpt_widget_content #tags-tab-content ul li a']['background-color'] = Agency_Sanitize::color( agency_get_settings( 'tags_bgcolor' ) );

	// Related Posts.
	$css['global']['.related-posts'] = Agency_Sanitize::background( agency_get_settings( 'related_posts_background' ) );

	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'related_posts_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'related_posts_meta_font' ) ) );

	agency_merge_value( $css['global']['.related-posts'], Agency_Sanitize::margin( agency_get_settings( 'related_posts_margin' ) ) );
	agency_merge_value( $css['global']['.related-posts'], Agency_Sanitize::padding( agency_get_settings( 'related_posts_padding' ) ) );

	$related_posts_border = Agency_Sanitize::border( agency_get_settings( 'related_posts_border' ) );
	$css['global']['.related-posts'][ $related_posts_border ['direction'] ] = $related_posts_border ['value'];

	// Related Posts articles.
	$css['global']['.related-posts article'] = Agency_Sanitize::background( agency_get_settings( 'related_article_background' ) );
	agency_merge_value( $css['global']['.related-posts article'], Agency_Sanitize::padding( agency_get_settings( 'related_article_padding' ) ) );
	agency_merge_value( $css['global']['.related-posts article header'], Agency_Sanitize::padding( agency_get_settings( 'related_article_text_padding' ) ) );

	// Subscribe Box.
	$css['global']['.single-subscribe .widget.wp_subscribe'] = Agency_Sanitize::background( agency_get_settings( 'single_subscribe_background' ) );
	agency_merge_value( $css['global']['.single-subscribe .widget.wp_subscribe'], Agency_Sanitize::margin( agency_get_settings( 'single_subscribe_margin' ) ) );
	agency_merge_value( $css['global']['.single-subscribe .widget.wp_subscribe'], Agency_Sanitize::padding( agency_get_settings( 'single_subscribe_padding' ) ) );
	$css['global']['.single-subscribe .widget.wp_subscribe']['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'single_subscribe_border_radius' ) . 'px' );

	// Subscribe border.
	$subscribe_border = Agency_Sanitize::border( agency_get_settings( 'single_subscribe_border' ) );
	$css['global']['.single-subscribe .widget.wp_subscribe'][ $subscribe_border ['direction'] ] = $subscribe_border ['value'];

	// Subscribe Box Input fields.
	$subscribe_input_class = array(
		'.single-subscribe #wp-subscribe input.email-field',
		'.single-subscribe #wp-subscribe input.name-field',
	);
	$css['global'][ agency_implode( $subscribe_input_class ) ]['background-color'] = Agency_Sanitize::color( agency_get_settings( 'single_subscribe_input_background' ) );

	$css['global'][ agency_implode( $subscribe_input_class ) ]['height'] = Agency_Sanitize::size( agency_get_settings( 'single_subscribe_input_height' ) . 'px' );

	$css['global']['.single-subscribe .widget #wp-subscribe input.submit']['height'] = Agency_Sanitize::size( agency_get_settings( 'single_subscribe_input_height' ) . 'px' );

	$css['global'][ agency_implode( $subscribe_input_class ) ]['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'single_subscribe_input_border_radius' ) . 'px' );

	// Subscribe Box Input border.
	$subscribe_box_input_border = Agency_Sanitize::border( agency_get_settings( 'single_subscribe_input_border' ) );
	$css['global'][ agency_implode( $subscribe_input_class ) ][ $subscribe_box_input_border ['direction'] ] = $subscribe_box_input_border ['value'];

	// Subscribe Box Submit button.
	$css['global']['.single-subscribe .widget #wp-subscribe input.submit']['background']    = Agency_Sanitize::color( agency_get_settings( 'single_subscribe_submit_backgroud' ) );
	$css['global']['.single-subscribe .widget #wp-subscribe input.submit']['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'single_subscribe_submit_border_radius' ) . 'px' );

	// Subscribe Box Submit border.
	$subscribe_box_submit_border = Agency_Sanitize::border( agency_get_settings( 'single_subscribe_submit_border' ) );
	$css['global']['.single-subscribe .widget #wp-subscribe input.submit'][ $subscribe_box_submit_border ['direction'] ] = $subscribe_box_submit_border ['value'];

	agency_merge_value( $css['global']['.single-subscribe .widget #wp-subscribe input.submit'], Agency_Sanitize::padding( agency_get_settings( 'single_subscribe_submit_padding' ) ) );

	// Author Box.
	$css['global']['.postauthor'] = Agency_Sanitize::background( agency_get_settings( 'authorbox_background' ) );

	agency_merge_value( $css['global']['.postauthor'], Agency_Sanitize::margin( agency_get_settings( 'authorbox_margin' ) ) );

	agency_merge_value( $css['global']['.postauthor'], Agency_Sanitize::padding( agency_get_settings( 'authorbox_padding' ) ) );

	$css['global']['.postauthor']['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'authorbox_border_radius' ) . 'px' );

	$authorbox_border = Agency_Sanitize::border( agency_get_settings( 'authorbox_border' ) );
	$css['global']['.postauthor'][ $authorbox_border ['direction'] ] = $authorbox_border ['value'];

	// Author image.
	agency_merge_value( $css['global']['.postauthor img'], Agency_Sanitize::margin( agency_get_settings( 'single_author_image_margin' ) ) );

	$css['global']['.postauthor img']['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'single_author_image_border_radius' ) . 'px' );

	// Single Page titles Styling.
	$titles_align = agency_get_settings( 'single_title_alignment' );

	$titles_align_class = array(
		'.comment-title',
		'#respond',
		'.related-posts-title',
	);
	$titles_class       = array(
		'#respond h4',
		'.total-comments',
		'.related-posts h4',
	);

	$css['global'][ agency_implode( $titles_class ) ] = Agency_Sanitize::background( agency_get_settings( 'single_title_background' ) );
	agency_merge_value( $css['global'][ agency_implode( $titles_class ) ], Agency_Sanitize::padding( agency_get_settings( 'single_title_padding' ) ) );
	// Single title border.
	$single_titles_border = Agency_Sanitize::border( agency_get_settings( 'single_title_border' ) );
	$css['global'][ agency_implode( $titles_class ) ][ $single_titles_border ['direction'] ] = $single_titles_border ['value'];

	if ( 'left' === $titles_align ) :
		$css['global'][ agency_implode( $titles_class ) ]['display'] = 'inline-block';
	elseif ( 'center' === $titles_align ) :
		$css['global'][ agency_implode( $titles_align_class ) ]['text-align'] = 'center';
		$css['global'][ agency_implode( $titles_class ) ]['display']          = 'inline-block';
	elseif ( 'right' === $titles_align ) :
		$css['global'][ agency_implode( $titles_align_class ) ]['text-align'] = 'right';
		$css['global'][ agency_implode( $titles_class ) ]['display']          = 'inline-block';
	endif;

	// Comments.
	// Margin and Padding.
	agency_merge_value( $css['global']['#comments'], Agency_Sanitize::margin( agency_get_settings( 'comments_margin' ) ) );
	agency_merge_value( $css['global']['#comments'], Agency_Sanitize::padding( agency_get_settings( 'comments_padding' ) ) );
	agency_merge_value( $css['global']['#comments li'], Agency_Sanitize::margin( agency_get_settings( 'comments_list_margin' ) ) );
	agency_merge_value( $css['global']['#comments li'], Agency_Sanitize::padding( agency_get_settings( 'comments_list_padding' ) ) );
	agency_merge_value( $css['global']['#comments .avatar'], Agency_Sanitize::margin( agency_get_settings( 'comments_list_image_margin' ) ) );

	// Author Comment.
	agency_merge_value( $css['global']['#comments li.bypostauthor'], Agency_Sanitize::padding( agency_get_settings( 'comments_list_author_padding' ) ) );
	$css['global']['#comments li.bypostauthor']['background-color'] = Agency_Sanitize::color( agency_get_settings( 'author_comment_bg' ) );

	// Comment list.
	// Border.
	$single_titles_border = Agency_Sanitize::border( agency_get_settings( 'comments_list_border' ) );
	$css['global']['#comments li'][ $single_titles_border ['direction'] ] = $single_titles_border ['value'];

	$css['global']['#comments .avatar']['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'comments_list_image_border_radius' ) . 'px' );

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'comments_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'comments_meta_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'comments_text_font' ) ) );

}

/**
 * Copyrights
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_copyrights( &$css ) {

	// copyrights border.
	$copyrights_border = Agency_Sanitize::border( agency_get_settings( 'copyrights_border' ) );
	$css['global']['.copyrights'][ $copyrights_border ['direction'] ] = $copyrights_border ['value'];

}

/**
 * Footer Subscribe
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_footer_subscribe( &$css ) {

	// Typography.
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'footer_subscribe_big_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'footer_subscribe_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'footer_subscribe_text_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'footer_subscribe_input_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'footer_subscribe_small_text_font' ) ) );

	// Styling.
	$css['global']['.footer-subscribe-section'] = Agency_Sanitize::background( agency_get_settings( 'footer_subscribe_background' ) );
	agency_merge_value( $css['global']['.footer-subscribe-section'], Agency_Sanitize::margin( agency_get_settings( 'footer_subscribe_margin' ) ) );
	agency_merge_value( $css['global']['.footer-subscribe-section'], Agency_Sanitize::padding( agency_get_settings( 'footer_subscribe_padding' ) ) );

	$css['global']['.footer-subscribe-section #wp-subscribe input.email-field, .footer-subscribe-section #wp-subscribe input.name-field']['background-color'] = Agency_Sanitize::color( agency_get_settings( 'footer_subscribe_input_background' ) );

}

/**
 * Footer
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_footer( &$css ) {

	// Footer.
	if ( agency_get_settings( 'mts_top_footer' ) ) {
		agency_merge_value( $css['global']['#site-footer'], Agency_Sanitize::margin( agency_get_settings( 'mts_top_footer_margin' ) ) );
		agency_merge_value( $css['global']['#site-footer'], Agency_Sanitize::padding( agency_get_settings( 'mts_top_footer_padding' ) ) );
	}

}

/**
 * Archive
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_archive_post( &$css ) {

	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'archive_post_title_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'archive_post_excerpt_font' ) ) );
	agency_map_css_selectors( $css['global'], Agency_Sanitize::typography( agency_get_settings( 'archive_meta_info_font' ) ) );

}

/**
 * Misc
 *
 * @param array $css Array of dynamic CSS.
 */
function agency_misc_css( &$css ) {

	// Nav hover color position.
	$padding        = Agency_Sanitize::padding( agency_get_settings( 'header_padding' ) );
	$padding_bottom = (int) $padding['padding-bottom'];

	// Show Logo.
	$show_logo = agency_get_settings( 'hide_logo' );

	if ( 0 === $show_logo ) {
		$css['global']['.logo-wrap']['display'] = 'none';
	}

	// Back to top.
	$css['global']['#move-to-top']              = Agency_Sanitize::background( agency_get_settings( 'top_button_background' ) );
	$css['global']['#move-to-top:hover::after'] = Agency_Sanitize::background( agency_get_settings( 'top_button_background_hover' ) );

	// Border.
	$top_button_border = Agency_Sanitize::border( agency_get_settings( 'top_button_border' ) );
	$css['global']['#move-to-top'][ $top_button_border ['direction'] ] = $top_button_border ['value'];
	// Font-size, Padding and Position.
	$css['global']['#move-to-top .fa']['font-size'] = Agency_Sanitize::size( agency_get_settings( 'top_button_font_size' ) . 'px' );
	agency_merge_value( $css['global']['#move-to-top'], Agency_Sanitize::padding( agency_get_settings( 'top_button_padding' ) ) );
	$top_button_position = agency_get_settings( 'top_button_position' );
	foreach ( $top_button_position as $key => $position ) {
		$css['global']['#move-to-top'][ $key ] = $position;
	}
	// Border-radius.
	$css['global']['#move-to-top']['border-radius']        = Agency_Sanitize::size( agency_get_settings( 'top_button_border_radius' ) . 'px' );
	$css['global']['#move-to-top::after']['border-radius'] = Agency_Sanitize::size( agency_get_settings( 'top_button_border_radius' ) . 'px' );
	// Colors.
	$css['global']['#move-to-top']['color']       = Agency_Sanitize::color( agency_get_settings( 'top_button_color' ) );
	$css['global']['#move-to-top:hover']['color'] = Agency_Sanitize::color( agency_get_settings( 'top_button_color_hover' ) );

	// Full width Related Posts.
	if ( 'full' === agency_get_settings( 'related_posts_position' ) ) {
		$css['global']['.single .article']['margin-bottom'] = '0px';
	}

}
