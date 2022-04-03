<script type="text/javascript" defer>
	function is_orga(that){
		if(that.value == "orga"){
			document.getElementById("for_orga").style.display = "block";
			document.getElementById("for_orga").required = true;
		} else {
			document.getElementById("for_orga").style.display = "none";
			document.getElementById("for_orga").required = false;
		}
	}

	// <?php
	// echo "let x = {$_GET['id']}";
	// ?>
	
	// let modal_img = open_modal(x);
	// modal_img.showModal();
	// // OPEN MODAL
	// function open_modal(x){
	// 	return document.querySelector("#modal-img"+x);	
	// }
	// // CLOSE MODAL
	// function close_modal(){
	// 	modal_img.close();	
	// }

</script>
</body>
</html>

<?php
ob_end_flush();