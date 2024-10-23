function showSection(sectionId) {
    var sections = document.getElementsByClassName('main-content');
    for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove('active');
    }
    
    document.getElementById(sectionId).classList.add('active');
}