$('#plugin-search-btn').on('click', function() {
	let inputValue = $('#plugin-search-input').val();
	if(inputValue == '') {
		alert("Invalid Input!");
	}
	else {
		
		
		jQuery.ajax({
			url: frontend_ajax_object.ajaxurl,
			type: 'post',
			data: {
				'input': inputValue,
				'action': 'search_posts_function'
			},
			success: function( response ) {
				const obj = JSON.parse(response);
				document.getElementById('results').innerHTML = '';
				obj.forEach(o => {
					let title = o['post_title'];
					let link = o['guid'];
					let description = o['post_excerpt'];
					let postType = o['post_type'];
					let postContent = o['post_content'];
					let div = document.createElement('div');
					let a = document.createElement('a');
					a.setAttribute('style', 'font-size: 18px; text-decoration: underline');
					let br = document.createElement('br');
					let p = document.createElement('p');
					let h5 = document.createElement('p');
					h5.setAttribute('style', 'margin: 0');
					p.setAttribute('style', 'margin-bottom: 50px; margin-top: 0');
					h5.innerHTML = 'Post Type: ' + postType;
					if(description === '') {
						p.innerHTML = postContent.substring(0, 100);
					}
					else {
						p.innerHTML = description;	
					}
					a.innerHTML = title;
					a.setAttribute('href', link);
					if(title !== '' && postContent !== '' || description !== '') {
						div.append(a);
						div.append(h5);
						div.append(p);
						document.getElementById('results').append(div);	
					}
				})
			},
			error: function( err ) {
				console.log(err);
			}
		});
		
		
	}
})