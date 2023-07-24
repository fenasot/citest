// JavaScript (jQuery)
$(function () {
	$(".dropdown-toggle").on("click", function (e) {
		e.stopPropagation(); // Prevent the dropdown from closing immediately after opening
		$(".dropdown-item").toggleClass("show");
	});

	$(document).on("click", function (e) {
		if (
			!$(".dropdown").is(e.target) &&
			$(".dropdown").has(e.target).length === 0
		) {
			$(".dropdown-item").removeClass("show");
		}
	});
});
