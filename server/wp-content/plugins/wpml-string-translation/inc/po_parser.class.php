<?php

class po_parser {

	private static function find_closing_bracket( $input_string, $opening_pos ) { //finds the closing bracket in a string for an opening bracket at $opening_pos

		$opens                  = 1;
		$flag_single_quote_open = false; // we have to check if we're in brackets, otherwise smileys could kill the script
		$flag_double_quote_open = false;

		for ( $i = $opening_pos; $i < strlen( $input_string ); $i ++ ) { //loop through string and count open brackets

			if ( $input_string[ $i ] == "\"" ) {
				$flag_double_quote_open = ! $flag_double_quote_open;
			} elseif ( $input_string[ $i ] == "'" ) {
				$flag_single_quote_open = ! $flag_single_quote_open;
			} else {
				if ( ! $flag_double_quote_open && ! $flag_single_quote_open ) {

					if ( $input_string[ $i ] == ')' ) {
						$opens --;
					} elseif ( $input_string[ $i ] == '(' ) {
						$opens ++;
					}

					if ( $opens == 0 ) {
						return $i;
					}
				}
			}
		}

		return false;
	}

	private static function find_date_strings( $po_array ) {
		$line_number = 0;

		$findings = array();

		while ( $line_number < sizeof( $po_array ) ) {
			$current_line = $po_array[ $line_number ];
			$line_number ++;
			$current_line = sprintf( '"%s\"', $current_line );

			$start_tokens  = array( //this could potentially be simplified but would allow for adding compatibility for aliases of date_i18n
			                        'date_i18n( __'
			);
			$strpos_offset = 0;
			foreach ( $start_tokens as $key => $start ) {
				while ( $start_pos = strpos( $current_line, $start . '(', $strpos_offset ) ) { //add the opening bracket to the starter
					$end_pos = self::find_closing_bracket( $current_line, ( $start_pos + strlen( $start ) + 1 ) ); //appropriately query for closing bracket
					if ( $end_pos ) {
						$call_content       = substr( $current_line, $start_pos + strlen( $start ) + 1, ( $end_pos - $start_pos - strlen( $start ) - 1 ) ); //everything between opening and final closing bracket is input to textdomain call
						$call_content_array = explode( ',', $call_content );

						$strpos_offset = $end_pos;
						if ( sizeof( $call_content_array ) > 1 ) { //actuale datetime call has two elements in the gettext string at least
							$findings[ ] = array( $line_number, $call_content_array );
						}
					} else {
						break;
					}
				}
			}
		}

		return $findings;
	}

	public static function create_po( $strings, $potonly = false ) {
		global $wpdb;

		$po = "";
		$po .= '# This file was generated by WPML' . PHP_EOL;
		$po .= '# WPML is a WordPress plugin that can turn any WordPress or WordPressMU site into a full featured multilingual content management system.' . PHP_EOL;
		$po .= '# https://wpml.org' . PHP_EOL;
		$po .= 'msgid ""' . PHP_EOL;
		$po .= 'msgstr ""' . PHP_EOL;
		$po .= '"Content-Type: text/plain; charset=utf-8\n"' . PHP_EOL;
		$po .= '"Content-Transfer-Encoding: 8bit\n"' . PHP_EOL;

		$po_title = 'WPML_EXPORT';

		$context = filter_input(INPUT_GET, 'context' );
		if ( $context !== null ) {
			$po_title .= '_' . $context;
		}

		$po .= '"Project-Id-Version:' . $po_title . '\n"' . PHP_EOL;
		$po .= '"POT-Creation-Date: \n"' . PHP_EOL;
		$po .= '"PO-Revision-Date: \n"' . PHP_EOL;
		$po .= '"Last-Translator: \n"' . PHP_EOL;
		$po .= '"Language-Team: \n"' . PHP_EOL;

		$translation_language  = filter_input(INPUT_GET, 'translation_language', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$translation_language = $translation_language ? $translation_language : 'en';

		$po .= '"Language:' . $translation_language . '\n"' . PHP_EOL;

		$po .= '"MIME-Version: 1.0\n"' . PHP_EOL;

		foreach ( $strings as $s ) {
			$ids[ ] = $s[ 'string_id' ];
		}
		if ( ! empty( $ids ) ) {
			$res = $wpdb->get_results( $wpdb->prepare("
	            SELECT string_id, position_in_page 
	            FROM {$wpdb->prefix}icl_string_positions 
	            WHERE kind = %d AND string_id IN(" . wpml_prepare_in( $ids, '%d' ) . ")", ICL_STRING_TRANSLATION_STRING_TRACKING_TYPE_SOURCE ) );
			foreach ( $res as $row ) {
				$positions[ $row->string_id ] = $row->position_in_page;
			}
		}
		foreach ( $strings as $s ) {
			$po .= PHP_EOL;
			if ( ! $potonly && isset( $s[ 'translations' ] ) && isset( $s[ 'translations' ][ key( $s[ 'translations' ] ) ][ 'value' ] ) ) {
				$translation = $s[ 'translations' ][ key( $s[ 'translations' ] ) ][ 'value' ];
				if ( $translation != '' && $s[ 'translations' ][ key( $s[ 'translations' ] ) ][ 'status' ] != ICL_STRING_TRANSLATION_COMPLETE ) {
					$po .= '#, fuzzy' . PHP_EOL;
				}
			} else {
				$translation = '';
			}
			if ( isset( $positions[ $s[ 'string_id' ] ] ) ) {
				$exp  = @explode( '::', $positions[ $s[ 'string_id' ] ] );
				$file = @file( $exp[ 0 ] );
			}

			$po_single = '#: ' . @trim( $file[ $exp[ 1 ] - 2 ] ) . PHP_EOL;
			$po_single .= '#: ' . @trim( $file[ $exp[ 1 ] - 1 ] ) . PHP_EOL;
			$po_single .= '#: ' . @trim( $file[ $exp[ 1 ] ] ) . PHP_EOL;

			$po_single .= '# wpml-name: ' . $s[ 'name' ] . PHP_EOL;
			// we need to figure out if our string is in a date_i18n call first in order to decide how we want to escape!

			$date_time_flag = '';
			if ( strpos( $po_single, 'date_i18n' ) ) {
				$date_time_flag = 'wpmldatei18 ';
			}

			$po_single .=
				'msgctxt "'
				. $date_time_flag
				. md5( @trim( $file[ $exp[ 1 ] - 2 ] ) . @trim( $file[ $exp[ 1 ] - 1 ] ) . $s[ 'name' ] )
				. '"'
				. PHP_EOL; //create an additional line that is skipped by us but used by poedit to uniquely identify the string
			$po_single .= 'msgid "' . str_replace( '"', '\"', $s[ 'value' ] ) . '"' . PHP_EOL;
			$po_single .= 'msgstr "' . str_replace( '"', '\"', $translation ) . '"' . PHP_EOL;
			$po .= $po_single;
		}

		$po = self::main_parser( $po );

		return $po;
	}

	private static function main_parser( $po ) {

		$po_array                      = explode( PHP_EOL, $po );
		$excluded_lines                = array();
		$potential_need_escape_strings = array();

		foreach ( self::find_date_strings( $po_array ) as $key => $value ) {
			$excluded_lines[ ]                 = $value[ 0 ]; // line of the occurence
			$potential_need_escape_strings [ ] = trim( preg_replace( '/\'/', '', $value[ 1 ][ 0 ] ) ); //datetimestring
		}
		$po_array_escaped = self::escape_date_time_strings( $excluded_lines, $potential_need_escape_strings, $po_array );

		return implode( PHP_EOL, $po_array_escaped );
	}

	private static function escape_date_time_strings( $excluded_lines, $potential_need_escape_strings, $po_array ) {
		$line_number      = 0;
		$po_array_escaped = array();
		while ( $line_number < sizeof( $po_array ) ) {
			$current_line = $po_array[ $line_number ];
			$line_number ++;

			if ( ! in_array( $line_number, $excluded_lines ) ) {
				$strpos_offset = 0;
				foreach ( $potential_need_escape_strings as $key => $start ) {
					while ( $start_pos = strpos( $current_line, $start, $strpos_offset ) ) {

						$end_pos = $start_pos + strlen( $start ) + 1; // end is just end ...

						if ( $end_pos ) {
							$date_time_string_unescaped = substr( $current_line, $start_pos, strlen( $start ) ); //everything between opening and final closing bracket is the date_time string

							$date_time_string_escaped = addslashes( $date_time_string_unescaped );

							$current_line = str_replace( $date_time_string_unescaped, $date_time_string_escaped, $current_line );

							$strpos_offset = $end_pos;
						} else {
							break;
						}
					}
				}
			}
			$po_array_escaped [ ] = $current_line;
		}

		return $po_array_escaped;
	}
}
