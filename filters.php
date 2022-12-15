<?php

if( ! defined( 'ABSPATH' ) ) {
	die;
}


/**
 * Adds content after the $paragraph paragraph, functional style
 * @param $content string the original content
 * @param $additional_content string the additional content to add
 * @param $paragraph int the paragraph number to add the content after
 *
 * @return string The content with the additional content
 */
function add_content_after_nth_paragraph(string $content, string $additional_content, int $paragraph = 4): string {
	$paragraphs = explode('</p>', $content);

	if (count($paragraphs) >= $paragraph) {
		$paragraphs[$paragraph - 1] .= "</p><p>$additional_content</p>";
	}

	return implode('</p>', $paragraphs);
}

add_filter('the_content', static function ($content) {
	if(!get_option('cta_enabled')) { // Early return
		return $content;
	}

	$filter_tags = explode(',', get_option('cta_tag_filter'));
	$post_tags = array_map(static function ($tag) {
		return trim($tag->name);
	}, get_the_tags());

	if ( is_single() && count(array_intersect( $post_tags, $filter_tags )) > 0 ) {
		// Retrieving options here saves a lot of queries to the database
		$cta = get_option('cta_text');
		$paragraph_index = get_option('cta_paragraph');

		$content = add_content_after_nth_paragraph($content, $cta, $paragraph_index ?? 4);
	}

	return $content;
});