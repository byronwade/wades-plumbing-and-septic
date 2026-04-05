/**
 * Field Shorts feed — viewport-based playback, lazy reveal, modal viewer.
 */
(function () {
	"use strict";

	document.addEventListener("DOMContentLoaded", function () {
		var feed = document.getElementById("shorts-feed");
		if (!feed) {
			return;
		}

		var cards        = Array.prototype.slice.call(feed.querySelectorAll("[data-short-item]"));
		var sentinel     = document.getElementById("shorts-load-sentinel");
		var loadStatus   = document.getElementById("shorts-load-status");
		var searchToggle = document.getElementById("wps-search-toggle");
		var searchBar    = document.getElementById("wps-search-bar");
		var searchInput  = document.getElementById("wps-search-input");

		var modal        = document.getElementById("shorts-modal");
		var modalMedia   = document.getElementById("shorts-modal-media");
		var modalCity    = document.getElementById("shorts-modal-city");
		var modalTitle   = document.getElementById("shorts-modal-title");
		var modalCaption = document.getElementById("shorts-modal-caption");

		var initialBatch = 4;
		var batchSize    = 3;
		var revealed     = 0;

		var observedVideos   = [];
		var videoVisibility  = new Map();
		var videoObserver    = null;
		var sentinelObserver = null;

		/* ---- Batch reveal ---- */
		function revealBatch(count) {
			var max = Math.min(revealed + count, cards.length);
			for (var i = revealed; i < max; i++) {
				cards[i].hidden = false;
				var vid = cards[i].querySelector("video");
				if (vid && videoObserver) {
					videoObserver.observe(vid);
					observedVideos.push(vid);
				}
			}
			revealed = max;
			updateStatus();
		}

		function updateStatus() {
			if (!loadStatus) return;
			loadStatus.textContent = revealed >= cards.length ? "You\u2019re all caught up." : "";
		}

		/* ---- Video: only play the most-visible one ---- */
		function setupVideoObserver() {
			if (!("IntersectionObserver" in window)) return;

			videoObserver = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					var ratio = entry.isIntersecting ? entry.intersectionRatio : 0;
					videoVisibility.set(entry.target, ratio);
				});
				pickAndPlay();
			}, { threshold: [0, 0.25, 0.5, 0.75, 1] });
		}

		function pickAndPlay() {
			var best = null;
			var bestRatio = 0;

			observedVideos.forEach(function (v) {
				var card = v.closest("[data-short-item]");
				if (card && card.hidden) return;
				var r = videoVisibility.get(v) || 0;
				if (r > bestRatio) { bestRatio = r; best = v; }
			});

			observedVideos.forEach(function (v) {
				var card = v.closest("[data-short-item]");
				if (card && card.hidden) { v.pause(); return; }
				var shouldPlay = v === best && bestRatio >= 0.5 && (!modal || modal.hidden);
				if (shouldPlay) {
					v.play().catch(function () { return null; });
				} else {
					v.pause();
				}
			});
		}

		/* ---- Load more on scroll ---- */
		function setupSentinel() {
			if (!sentinel || !("IntersectionObserver" in window)) return;

			sentinelObserver = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting && revealed < cards.length) {
						revealBatch(batchSize);
					}
				});
			}, { rootMargin: "0px 0px 600px 0px", threshold: 0 });

			sentinelObserver.observe(sentinel);
		}

		/* ---- Modal ---- */
		function clearModal() {
			if (!modalMedia) return;
			while (modalMedia.firstChild) modalMedia.removeChild(modalMedia.firstChild);
		}

		function openModal(type, src, title, caption, city) {
			clearModal();
			if (!src) return;

			if (type === "video") {
				var v = document.createElement("video");
				v.setAttribute("controls", "controls");
				v.setAttribute("playsinline", "playsinline");
				v.setAttribute("autoplay", "autoplay");
				v.src = src;
				modalMedia.appendChild(v);
			} else {
				var img = document.createElement("img");
				img.src = src;
				img.alt = title || "Field short";
				modalMedia.appendChild(img);
			}

			if (modalCity)    modalCity.textContent    = city    || "";
			if (modalTitle)   modalTitle.textContent   = title   || "";
			if (modalCaption) modalCaption.textContent = caption || "";

			modal.hidden = false;
			document.body.classList.add("wps-modal-open");
			pickAndPlay();
		}

		function closeModal() {
			clearModal();
			modal.hidden = true;
			document.body.classList.remove("wps-modal-open");
			pickAndPlay();
		}

		/* ---- Search toggle ---- */
		if (searchToggle && searchBar) {
			searchToggle.addEventListener("click", function () {
				var open = !searchBar.hidden;
				searchBar.hidden = open;
				if (!open && searchInput) {
					searchInput.focus();
				}
			});
		}

		if (searchInput) {
			searchInput.addEventListener("input", function () {
				var term = searchInput.value.trim().toLowerCase();
				cards.forEach(function (card) {
					if (card.hidden && revealed <= cards.indexOf(card)) return;
					var title   = (card.getAttribute("data-title")   || "").toLowerCase();
					var caption = (card.getAttribute("data-caption") || "").toLowerCase();
					var city    = (card.getAttribute("data-city")    || "").toLowerCase();
					var match   = !term || title.indexOf(term) !== -1 || caption.indexOf(term) !== -1 || city.indexOf(term) !== -1;
					card.style.display = match ? "" : "none";
				});
			});
		}

		/* ---- Event delegation ---- */
		document.addEventListener("click", function (e) {
			var opener = e.target.closest("[data-short-open]");
			if (opener) {
				var card  = opener.closest("[data-short-item]");
				openModal(
					(opener.getAttribute("data-media-type") || "image").toLowerCase(),
					opener.getAttribute("data-media-src") || "",
					card ? card.getAttribute("data-title")   : "",
					card ? card.getAttribute("data-caption") : "",
					card ? card.getAttribute("data-city")    : ""
				);
				return;
			}

			if (e.target.closest("[data-short-close]")) {
				closeModal();
			}
		});

		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape" && modal && !modal.hidden) closeModal();
		});

		/* ---- Boot ---- */
		cards.forEach(function (c) { c.hidden = true; });
		setupVideoObserver();
		revealBatch(initialBatch);
		setupSentinel();
	});
})();
