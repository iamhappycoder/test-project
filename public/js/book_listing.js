function BookListing() {
    this.booksBody = document.getElementById('booksBody');
    this.page = this.getQueryParam('page') || 1;
    this.limit = this.getQueryParam('limit') || 10;
    this.fetchBooks();
}

BookListing.prototype.getQueryParam = function(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
};

BookListing.prototype.fetchBooks = function() {
    var self = this;

    var url = `/api/books/?page=${this.page}&limit=${this.limit}`;

    fetch(url)
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(function(books) {
            self.render(books);
        })
        .catch(function(error) {
            console.error('There was a problem with the fetch operation:', error);
        });
};

BookListing.prototype.render = function(books) {
    var html = '';

    for (var i = 0; i < books.length; i++) {
        html += '<tr>' +
            '<td>' + books[i].name + '</td>' +
            '<td>' + books[i].author_name + '</td>' +
            '</tr>';
    }

    this.booksBody.innerHTML = html;
};

window.onload = function() {
    new BookListing();
};