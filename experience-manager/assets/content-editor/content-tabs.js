/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


EXM.Dom.ready(() => {
	document.querySelectorAll(".tab-container").forEach($element => {
		$element.querySelectorAll(".tablinks").forEach($tab_link => {
			$tab_link.addEventListener("click", (event) => {
				event.preventDefault();
				
				$element.querySelectorAll(".tabcontent").forEach($tab_content => {
					$tab_content.style.display = "none";
				});
				$element.querySelectorAll(".tablinks").forEach($tab_link => {
					$tab_link.classList.remove("active");
				});
				
				document.getElementById($tab_link.dataset.exmTabTarget).style.display = "block";
				$tab_link.classList.add("active");
			});
			
			if ($tab_link.dataset.exmTabDefault) {
				// select default tab
				$tab_link.dispatchEvent(new Event('click'));
			}
		});
	});
});