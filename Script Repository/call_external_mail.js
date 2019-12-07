function my_em_script() {
	var email = 'noreply@otomo.at';
	var subject = 'Kontaktaufnahme';
	var emailBody = '';
	document.location = "mailto:"+email+"?subject="+subject+"&body="+emailBody;
};
