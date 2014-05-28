<?php
echo '<html>';
	echo '<head>';
		echo '<script>
		echo 'function showUser(str) {';
			echo 'if (str=="") {';
				echo 'document.getElementById("txtHint").innerHTML="";';
				echo 'return;';
			echo '}';
			
			echo 'if (window.XMLHttpRequest) {'; // code for IE7+, Firefox, Chrome, Opera, Safari
				echo 'xmlhttp=new XMLHttpRequest();';
			echo '} else {'; // code for IE6, IE5
				echo 'xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");';
			echo '}';
			
			echo 'xmlhttp.onreadystatechange=function() {';
				echo 'if (xmlhttp.readyState==4 && xmlhttp.status==200) {';
					echo 'document.getElementById("txtHint").innerHTML=xmlhttp.responseText;';
				echo '}';
			echo '}';
			
			echo 'xmlhttp.open("GET","getuser.php?q=" + str, true);';
			echo 'xmlhttp.send();';
		echo '}';
		echo '</script>';
	echo '</head>';
	echo '<body>';
		echo '<form>';
			echo '<select name="users" onchange="showUser(this.value)">';
				echo '<option value="">Select a person:</option>';
			echo '</select>';
		echo '</form>';
<br>
<div id="txtHint"><b>Person info will be listed here.</b></div>

</body>
</html> 
?>