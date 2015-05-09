<form action="mailer.php" method="GET">
<table>
<tr><td>Meeting Subject:</td><td><input name="subject" value="Meeting title" /></td></tr>
<tr><td>Location:</td><td><input name="location" value="My Office" /></td></tr>
<tr><td>To address:</td><td><input name="toaddr" value="aarondigital@gmail.com" /></td></tr>
<tr><td>To name:</td><td><input name="toname" value="An Attendee" /></td></tr>
<tr><td>From address:</td><td><input name="fromaddr" value="aarondigital@gmail.com" /></td></tr>
<tr><td>From name:</td><td><input name="fromname" value="An Important Person" /></td></tr>
<tr><td>Bounces to:</td><td><input name="bounces" value="aarondigital@gmail.com" /></td></tr>
<tr><td>Start Time:</td><td><input name="start" value="20140901T020000Z" /></td></tr>
<tr><td>End Time:</td><td><input name="end" value="20140901T030000Z" /></td></tr>
<tr><td>Meeting Body:</td><td><textarea cols="25" rows="5" type="textarea" name="body">This is a message body.</textarea></td></tr>
<tr><td>Attachment Method:</td><td><select name="attmeth">
                                      <option value="attached">As attachment (good for everyone)</option>
                                      <option value="inline">Inline (better for Outlook users)</option>
                                   </select> 
</td></tr>
</table>
<input type="hidden" name="action" value="none" />
<input type="hidden" name="p" value="mailer" />
<input type="submit" />
