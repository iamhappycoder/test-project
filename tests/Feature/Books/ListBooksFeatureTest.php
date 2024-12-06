<?php

namespace Tests\Feature\Books;

use App\Interfaces\Http\Controllers\Books\ListBooksController;
use App\Interfaces\Http\Views\HTMLView;
use PHPUnit\Framework\TestCase;

class ListBooksFeatureTest extends TestCase
{
    public function testSuccessListOfBooksRendered(): void
    {
        ob_start();
        (new ListBooksController(new HTMLView()))();
        $response = ob_get_clean();

        $doc = new \DOMDocument();
        $doc->loadHTML($response);

        $xpath = new \DOMXPath($doc);

        $this->assertTrue($xpath->query('//head/title[text()="Books"]')->length > 0);
        $this->assertTrue($xpath->query('//table[@id="booksTable"]')->length > 0);
        $this->assertTrue($xpath->query('//table[@id="booksTable"]/thead//th[text()="Title"]')->length > 0);
        $this->assertTrue($xpath->query('//table[@id="booksTable"]/thead//th[text()="Author"]')->length > 0);
        $this->assertTrue($xpath->query('//tbody[@id="booksBody"]')->length > 0);
        $this->assertTrue($xpath->query('//script[@src="js/book_listing.js"]')->length > 0);
    }
}
