// Goes 1 step back in browsing history
function goBack() {
  window.history.back();
}

// Toggles posts from other authors
function togglePosts(author) {

	let list = document.getElementById('posts-list');
	let listItem = list.getElementsByClassName('list-item');
	let authorPosts = list.getElementsByClassName(author);

	for (let i = 0; i < listItem.length; i++) {
		if (!authorPosts[i]) {
			listItem[i].style.display = listItem[i].style.display === 'none' ? '' : 'none';
		}		
	}

}