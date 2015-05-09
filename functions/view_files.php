<?php 
include_once('../classes/File.php'); 
include_once('../classes/db.php');
$meetingid = $_GET['meetingId'] or die("Internal error occured");

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
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':meetingid',$meetingid);
  $stmt->bindParam(':data',$filecontents,PDO::PARAM_LOB);
  $stmt->bindParam(':filename',$upload->getFileName());
  $stmt->bindParam(':mimetype',$mimetype);
 
  $result = $stmt->execute();

  if ($result == 0)
    die("DB Error: ".$stmt->errorInfo()[2]);
}

/* Show file contents for download */
$stmt = $conn->prepare("SELECT * FROM Note where MeetingId = :meetingid");
$stmt->bindParam(':meetingid',$meetingid);
$result = $stmt->execute();

if ($result) {
  echo "Number of attachments: ".$stmt->rowCount();
?>

<table>
<tr><th style="width: 75%">File Name</th><th>File Type</th></tr>
<?php

   $nicefiletype = array(
			 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word Document',
			 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Excel Document',
			 'text/plain' => 'Text Document',
			 'application/pdf' => 'PDF'
			 );

  foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $rec) { 
    echo "<tr><td style=\"padding: 2px 10px\"><a href=\"functions/download_file.php?fileid=".$rec->NoteId."\">".$rec->FileName."</a></td><td>".$nicefiletype[$rec->MimeType]."</td></tr>";
  }
} else {
  die("Error getting attachments: ".$stmt->errorInfo()[2]);
}
			    
?>


</table>



