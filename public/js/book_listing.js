var BOOKS = [
    { id: 1, title: 'To Kill a Mockingbird', author_name: 'Harper Lee' },
    { id: 2, title: 'Sapiens', author_name: 'Yuval Noah Harari' },
    { id: 3, title: 'The Hobbit', author_name: 'J.R.R. Tolkien' },
    { id: 4, title: 'A Brief History of Time', author_name: 'Stephen Hawking'  },
    { id: 5, title: 'Guns, Germs, and Steel', author_name: 'Jared Diamond' },
    { id: 6, title: '1984', author_name: 'George Orwell' },
    { id: 7, title: 'The Selfish Gene', author_name: 'Richard Dawkins' },
    { id: 8, title: 'The Pillars of the Earth', author_name: 'Ken Follett' },
    { id: 9, title: 'A Short History of Nearly Everything', author_name: 'Bill Bryson' },
    { id: 10, title: 'The Alchemist', author_name: 'Paulo Coelho' }
];

function BookListing() {
    this.booksBody = document.getElementById('booksBody');
    this.render();
}

BookListing.prototype.render = function() {
    var html = '';
    for (var i = 0; i < BOOKS.length; i++) {
        var book = BOOKS[i];
        html += '<tr>' +
            '<td>' + book.title + '</td>' +
            '<td>' + book.author_name + '</td>' +
            '</tr>';
    }

    this.booksBody.innerHTML = html;
};

window.onload = function() {
    new BookListing();
};