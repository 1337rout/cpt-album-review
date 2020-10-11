(function( $ ) {
	'use strict';
	$(function() {
		let timeout;
		const { apiKey } = brAlbum;
		if(apiKey){
			console.log(apiKey);
			$('#titlediv').append('<div class="lastFmAlbums"></div>');
			$('.lastFmAlbums').hide();
			$('#title').keyup(function(){
				if(timeout) clearTimeout(timeout);
				timeout = setTimeout(doSearch($(this).val()), 500);
			});
			function doSearch(searchTerm) {
				$.ajax({
					url: `https://ws.audioscrobbler.com/2.0/?method=album.search&album=${searchTerm}&api_key=${apiKey}&format=json`,
					success: function(data){
						const albums = data.results.albummatches.album.map(({name, artist, image}) =>{
							return(`
								<div class="album" role="button" data-img="${image[2]['#text']}" data-name="${name}" data-artist="${artist}">
									<img class="albumimage" src="${image[2]['#text']}">
									<div class="album-info">
										<strong>${name}</strong>
										${artist}
									</div>
								</div>
							`);
						});
						$('.lastFmAlbums').show();
						$('.lastFmAlbums').html(albums); 
					},
					timeout: 1000 //in milliseconds
				});
			}
			$(".lastFmAlbums").on("click",".album", function(){
				$('#acf-field_5f7800aa58e3c').val($(this).data('img'));
				$('#title').val($(this).data('name'));
				$('#acf-field_5f77ffa658e3a').val($(this).data('artist'));
				$('.lastFmAlbums').hide();
				$('.lastFmAlbums').html('');
			  });
		}	
	});
})( jQuery );
