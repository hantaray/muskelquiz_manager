<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include("../lib/db.php");
include("../models/muskel.php");
  
// initialize object

// query Muskeln
$stmt = Muskel::read($db);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // muskeln array
    $muskeln_array=array();
    $muskeln_array["muskeln"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $muskel_item=array(
            "id" => $id,
            "reihenfolge" => $reihenfolge,
            "name" => $name,
            "ursprung" => html_entity_decode($ursprung),
            "ansatz" => $ansatz,
            "innervation" => $innervation,
            "kategorie" => $kategorie
        );
  
        array_push($muskeln_array["muskeln"], $muskel_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show musklen data in json format
    echo json_encode($muskeln_array);
}
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no musklen found
    echo json_encode(
        array("message" => "Keine Muskeln gefunden.")
    );
}