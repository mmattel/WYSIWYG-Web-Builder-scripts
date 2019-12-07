function my_em_script() {
	var email = 'noreply@<your domain>';
	var subject = 'Contact Request';
	var emailBody = '';
	document.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody;
};
