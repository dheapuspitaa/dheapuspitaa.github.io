function showContent(id) {
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.style.display = 'none');
    document.getElementById(id).style.display = 'block';
}

window.onload = function() {
    showContent('events');
};