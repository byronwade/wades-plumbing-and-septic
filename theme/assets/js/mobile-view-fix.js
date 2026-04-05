(function () {
	const desktopPattern = /Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
	const isDesktop = window.innerWidth >= 1024 && !desktopPattern.test(navigator.userAgent);

	if (!isDesktop) {
		return;
	}

	document.addEventListener("DOMContentLoaded", function () {
		document.body.classList.remove("mobile", "is-mobile", "wp-is-mobile");
	});
})();
