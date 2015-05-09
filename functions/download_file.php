<?php
include_once('../classes/db.php');
if (!isset($_GET['fileid']))
  die ('Invalid parameters.');


/* Replace this with db object */
$connstr = "mysql:Host= 127.0.0.1;dbname=tawazzne_appointmate'";

try {
  $conn = new PDO('mysql:Host= 127.0.0.1;dbname=tawazzne_appointmate','tawazzne_admin','9lV2TDfJHfet');
} catch (PDOException $pe) {
  die($pe->getMessage());
}
/* end replace */

$sql = "SELECT MimeType, Document, FileName FROM Note WHERE NoteId = :noteid";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':noteid' => $_GET['fileid']));
$stmt->bindColumn(1, $mimetype);
$stmt->bindColumn(2, $document, PDO::PARAM_LOB);
$stmt->bindColumn(3, $filename);
$rowCount = $stmt->rowCount();
$stmt->fetch(PDO::FETCH_BOUND);

if ($result==0) {
  if ($rowCount > 0) {
    header('Content-Type:'. $mimetype);
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    echo $document;
  } else {
    http_response_code(404);
  }
} else {
  echo "An error occured: ".$stmt->errorInfo()[2];
}
