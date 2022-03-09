<script type="text/javascript">
	function is_orga(that){
		if(that.value == "orga"){
			document.getElementById("for_orga").style.display = "block";
			document.getElementById("for_orga").required = true;
		} else {
			document.getElementById("for_orga").style.display = "none";
			document.getElementById("for_orga").required = false;
		}
	}
</script>