<?php
	require_once 'conf.php';

	$link	= null;

	$is_web	= true;
	if( php_sapi_name() === 'cli' ) {
		$is_web = false;
	} else {
		session_start();
	}

	if( IMPORT_DEBUG ) {
		error_reporting(E_ALL);
	} else {
		error_reporting(0);
	}

	function print_debug($msg) {
		global $is_web;

		if( IMPORT_DEBUG ) {
			$dbg	= '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n";

			if( IMPORT_DEBUG_CONSOLE ) {
				print $dbg;

				if( $is_web ) {
					print "<br>";
				}
			}

			if( IMPORT_DEBUG_FILE ) {
				file_put_contents(DEBUG_LOG_FILE, $dbg, FILE_APPEND);
			}
		}
	}

	function get_import_content($file_name) {
		if( file_exists(IMPORT_FILES_PATH . '/' . $file_name) ) {
			return file_get_contents(IMPORT_FILES_PATH . '/' . $file_name);
		} else {
			print_debug('Az import file nem talalhato.');
		}

		return false;
	}

	function parse_import_data($content) {
		if( $content !== '' ) {
			$_content	= explode(';', trim($content));

			return array(
				'saxon_id'	=> isset($_content[0]) ? get_saxon_id(trim($_content[0])) : '',
				'operation'	=> isset($_content[1]) ? strtoupper(trim($_content[1])) : '',
				'name'	=> isset($_content[2]) ? trim($_content[2]) : '',
				'type'	=> isset($_content[3]) ? trim($_content[3]) : '',
				'depot'	=> isset($_content[4]) ? trim($_content[4]) : '',
				'sub_depot'	=> isset($_content[5]) ? trim($_content[5]) : '',
			);
		}

		return false;
	}

	function get_saxon_id($text) {
		return substr($text, 0, 1) . '-' . str_pad(substr($text, 1, 4), 4, '0', STR_PAD_LEFT);
	}

	function import($content) {
		$import_data	= parse_import_data($content);

		$done	= false;
		if( $import_data !== false ) {
			switch($import_data['operation']) {
				case 'U':
					if( dbf_new_truck($import_data) ) {
						print_debug('Ok.');
						$done	= true;
					} else {
						print_debug('Mar letezik.');
					}
					break;
				case 'M':
				case 'B':
				case 'A':
					if( dbf_modify_truck($import_data) ) {
						print_debug('Ok.');
						dbf_set_truck($import_data, 'A');
						$done	= true;
					} else {
						print_debug('Nem talalhato.');
					}
					break;
				case 'T':
					if( dbf_set_truck($import_data, 'D') ) {
						print_debug('Ok. Torolve.');
						$done	= true;
					} else {
						print_debug('Error.');
					}
					break;
				case 'R':
					if( dbf_modify_truck($import_data) ) {
						print_debug('Ok. Modositva');
						$done	= true;
					} else {
						print_debug('Error.');
					}
					break;
				case 'K':
					$td	= get_truck_data($import_data);

					if( $td && $td['truck_cost'] > 0 ) {
						if( dbf_set_truck($import_data, 'S') ) {
							print_debug('Ok. S - beállítva');
							$done	= true;
						} else {
							print_debug('Hiba.');
						}
					} else {
						if( dbf_set_truck($import_data, 'H') ) {
							print_debug('Ok. H - beállítva');
							$done	= true;
						} else {
							print_debug('Hiba.');
						}
					}
					break;

				default:
					print_debug('Ismeretlen parancs.');
			}
		} else {
			print_debug('Hibas import adatok.');
		}

		return $done;
	}

	function get_last_update() {
		global $link;

		$res	= mysqli_query($link, "SELECT value FROM truck_imports WHERE name = 'last_update' LIMIT 1");
		if( $res ) {
			$data	= mysqli_fetch_assoc($res);

			return (int)$data['value'];
		}

		return 0;
	}

	function get_truck_data($data) {
		global $link;

		$res	= mysqli_query($link, 'SELECT * FROM trucks WHERE `truck_saxon-id` = \'' . mysqli_real_escape_string($link, $data['saxon_id']) . '\'');

		if( $res ) {
			return mysqli_fetch_assoc($res);
		}

		return false;
	}

	function set_last_update($number) {
		global $link;

		$num	= (int)$number;

		mysqli_query($link, "UPDATE truck_imports SET value = $num, date = NOW() WHERE name = 'last_update'");
	}

	function dbf_new_truck($data) {
		global $link;

		print_debug('Uj Termék');

		$params	= array(
			"'" . mysqli_real_escape_string($link, $data['saxon_id']) . "'",
			(int)$data['depot'],
			(int)$data['sub_depot'],
			0,
			"'" . mysqli_real_escape_string($link, $data['type']) . "'",
			"''"
		);
		$sparams	= implode(',', $params);

		$res	= mysqli_query($link, 'SELECT dbfNewTruck(' . $sparams . ')');

		if( $res ) {
			$data	= mysqli_fetch_row($res);

			if( (int)$data[0] == 1 ) {
				return true;
			}
		}

		return false;
	}

	function dbf_modify_truck($data) {
		global $link;

		print_debug('Termék modositas');

		$params	= array(
			"'" . mysqli_real_escape_string($link, $data['saxon_id']) . "'",
			(int)$data['depot'],
			(int)$data['sub_depot']
		);
		$sparams	= implode(',', $params);

		$res	= mysqli_query($link, 'SELECT dbfModTruckDepot(' . $sparams . ')');

		if( $res ) {
			$data	= mysqli_fetch_row($res);

			if( (int)$data[0] == 1 ) {
				return true;
			}
		}

		return false;
	}

	function dbf_set_truck($data, $value) {
		global $link;

		print_debug('Termék beallitasa - ' . $value);

		$params	= array(
			"'" . mysqli_real_escape_string($link, $data['saxon_id']) . "'",
			"'" . mysqli_real_escape_string($link, $value) . "'",
		);
		$sparams	= implode(',', $params);

		$res	= mysqli_query($link, 'SELECT dbfSetTruckState(' . $sparams . ')');

		if( $res ) {
			$data	= mysqli_fetch_row($res);

			if( (int)$data[0] == 1 ) {
				return true;
			}
		}

		return false;
	}

	function db_connect() {
		global $link;

		$link	= @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
		if( !$link ) {
			print_debug('Adatbazis csatlakozasi hiba.');
			print_debug('## Import vege.');
			exit();
		}
	}

	function db_close() {
		global $link;

		@mysqli_close($link);
	}

	function file_rename($file) {
		rename(IMPORT_FILES_PATH . '/' . $file, IMPORT_FILES_PATH . '/' . $file . '.done');
	}

	function is_logged() {
		if( isset($_SESSION['logged']) && $_SESSION['logged'] == 1 ) {
			return true;
		} else {
			return false;
		}
	}

	if( isset($_POST['action']) && $_POST['action'] === 'login' ) {
		if( isset($_POST['name']) && $_POST['name'] === LOGIN_NAME && isset($_POST['pwd']) && $_POST['pwd'] == LOGIN_PASSWORD ) {
			$_SESSION['logged']	= 1;
		}
	}

	$start	= false;
	if( $is_web ) {
		if( isset($_GET['action']) ) {
			if( $_GET['action'] === 'logout' ) {
				$_SESSION['logged']	= 0;
				unset($_SESSION['logged']);
			}
			if( $_GET['action'] === 'start' ) {
				$start	= true;
			}
		}

		if( !is_logged() ) {
			header('Location: login.php');
			exit();
		}
	}

	if( !$is_web || $start ) {
		/*
		 *  Az import fo resze
		 */
		print_debug('## Import kezdete.');
		db_connect();
		$files	= scandir(IMPORT_FILES_PATH);

		$last_update	= get_last_update();

		$max	= 0;
		foreach($files as $file) {
			if( $file == '.' || $file == '..' ) {
				continue;
			}
			$file_number	= (int)$file;
			if( $file_number <= $last_update ) {
				continue;
			}

			if( $file_number > $max ) {
				$max	= $file_number;
			}

			print_debug('Feldolgozott file: ' . $file);
			$content = get_import_content($file);
			$ret	= import($content);

		}

		if( $max > $last_update ) {
			set_last_update($max);
		}

		db_close();
		print_debug('## Import vege.');

		if( $is_web ) {
			print '<br /><a href="log.txt">A webupdate befejez&#337;d&ouml;tt, tov&aacute;bb a log megtekint&eacute;s&eacute;hez &gt;&gt;</a>';
		}
	}
	else {
		header('Location: start.php');
		exit();
	}
?>