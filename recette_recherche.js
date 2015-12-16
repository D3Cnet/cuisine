<script type="text/javascript" charset="utf-8">
//<script type="text/javascript" charset="iso-8859-1">

//conteneur = id du bloc (<div>, <p> ...) contenant les checkbox
//a_faire = '0' pour tout décocher
//a_faire = '1' pour tout cocher
//a_faire = '2' pour inverser la sélection
function GereCheckbox(conteneur, a_faire) {
var blnEtat=null;
var Chckbox = document.getElementById(conteneur).firstChild;
	while (Chckbox!=null) {
		if (Chckbox.nodeName=="INPUT")
			if (Chckbox.getAttribute("type")=="checkbox") {
				blnEtat = (a_faire=='0') ? false : (a_faire=='1') ? true : (document.getElementById(Chckbox.getAttribute("id")).checked) ? false : true;
				document.getElementById(Chckbox.getAttribute("id")).checked=blnEtat;
			}
		Chckbox = Chckbox.nextSibling;
	}
}

</script>
