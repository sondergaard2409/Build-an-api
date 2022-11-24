<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/assets/incl/init.php";

/**
 * Hent liste af sange (GET)
 */
Route::add('/api/artist/', function() {
	$artist = new Artist;
	$result = $artist->list();
	echo Tools::jsonParser($result);
});

/**
 * Hent en sangs detaljer ud fra id (GET)
 */
Route::add('/api/artist/([0-9]*)', function($id) {
	$artist = new Artist;
	$result = $artist->details($id);
	echo Tools::jsonParser($result);
});

/**
 * Opret en ny sang (POST)
 */
Route::add('/api/artist/', function() {
	$artist = new Artist;
	$artist->title = isset($_POST['title']) && !empty($_POST['title']) ? $_POST['title'] : null;
	$artist->content = isset($_POST['content']) && !empty($_POST['content']) ? $_POST['content'] : null;
	$artist->artist_id = isset($_POST['artist_id']) && !empty($_POST['artist_id']) ? (int)$_POST['artist_id'] : null;

	if($artist->title && $artist->content && $artist->artist_id) {
		echo $artist->create();
	} else {
		echo "Kan ikke oprette sangen.";
	}
}, 'post');

/**
 * Opdater en sang ud fra id (PUT)
 */
Route::add('/api/artist/', function() {
	$data = file_get_contents("php://input");
	parse_str($data, $parsed_data);

	$artist = new Artist;
	$artist->id = isset($parsed_data['id']) && !empty($parsed_data['id']) ? (int)$parsed_data['id'] : null;
	$artist->title = isset($parsed_data['title']) && !empty($parsed_data['title']) ? $parsed_data['title'] : null;
	$artist->content = isset($parsed_data['content']) && !empty($parsed_data['content']) ? $parsed_data['content'] : null;
	$artist->artist_id = isset($parsed_data['artist_id']) && !empty($parsed_data['artist_id']) ? (int)$parsed_data['artist_id'] : null;

	if($artist->id && $artist->title && $artist->content && $artist->artist_id) {
		echo $artist->update();
	} else {
		echo false;
	}
}, 'put');

/**
 * Slet sang ud fra id (DELETE)
 */
Route::add('/api/artist/([0-9]*)', function($id) {
	$artist = new Artist;
	echo $artist->delete($id);
}, 'delete');

Route::run('/');
?>