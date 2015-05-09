<?php 
include_once('../classes/File.php'); 
include_once('../classes/db.php');
$meetingid = $_POST['meetingId'] or die("Internal error occured");

/* Replace this with db object */
$connstr = "mysql:Host= 127.0.0.1;dbname=tawazzne_appointmate'";

try {
  $conn = new PDO('mysql:Host= 127.0.0.1;dbname=tawazzne_appointmate','tawazzne_admin','9lV2TDfJHfet');
} catch (PDOException $pe) {
  die($pe->getMessage());
}
/* end replace */

if (isset($_FILES['userfile'])) {
  $sql = "INSERT INTO Note (MeetingId, Document, FileName, MimeType) VALUES (:meetingid, :data, :filename, :mimetype)";

  // Create file object from upload
  $upload = new File($_FILES['userfile']);

  // Here we should do some checks
  $upload->setAllowed(array('docx','xlsx','txt','pdf'));
  if (!$upload->isAllowed())
    die("File type not allowed");

  // Basic Mime matching
  $mimetypes = array(
		     'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                     'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		     'txt' => 'text/plain',
                     'pdf' => 'application/pdf'
		     );

  $mimetype = $mimetypes[$upload->getFileExt()];  // this assumes all allowed file types are in the mimetypes array

  // Create file variable to read from
  $filecontents = fopen($upload->getFileTempName(),'rb');

  //  echo "Attempting to upload file ".$upload->getFileTempName();

  // Upload to database
  $filename = $upload->getFileName();
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':meetingid',$meetingid);
  $stmt->bindParam(':data',$filecontents,PDO::PARAM_LOB);
  $stmt->bindParam(':filename',$filename);
  $stmt->bindParam(':mimetype',$mimetype);
 
  $result = $stmt->execute();

  if ($result == 0)
    die("DB Error: ".$stmt->errorInfo()[2]);

?>
<div id="result">File uploaded.</div>

<?php
} else die ("I can't find the file!");
?>
