(function () {
	'use strict';

	let searchField = document.querySelector('.search-input'),
	    resultList  = document.querySelector('.result-list'),
	    content;

	function showResults(e) {
		let srchString       = e.currentTarget.value;
		resultList.innerHTML = '';

		if (srchString.length === 0) {
			resultList.classList.remove('active');
			return;
		}

		if (srchString != null) {
			let url = '/search?str=' + srchString;

			srchString = srchString.trim().toLowerCase();

			fetch(url)
				.then(function (response) {
					return response.json();

				}).then(function (data) {
				resultList.classList.add('active');

				if (data.length === 0) {
					resultList.innerHTML = '<div class="column-small-12 py-2">No Items Match your Query</div>';
				}

				data.forEach(function (item) {
					content = '<li class="list-group-item list-group-item-action">' +
					          '<a href="/products/show/' + item.id + '" id="' + item.id + '">' +
					          '<img src="/uploads/products/' + item.images[0].file_name + '" class="product-thumbnail" />' + item.title + '</a>' +
					          '</li>';

					resultList.innerHTML += content;
				});

			}).catch(function (err) {
				console.log(err);
			});
		}
	}

	if(searchField) {
		searchField.addEventListener('keyup', showResults, false);
	}
})();