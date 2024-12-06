<?php

namespace Tests\Feature\Api\Books;

use App\Application\UseCases\Book\ListBooksUseCase;
use App\Domain\Book\Services\ListBooksService;
use App\Infrastructure\Logging\Logger;
use App\Infrastructure\Persistence\Book\ListBooksRepository;
use App\Interfaces\Http\Controllers\Api\Books\ListBooksApiController;
use App\Interfaces\Http\Views\JSONView;
use Database\Traits\CanGetPDO;
use Database\Traits\CanRefreshDatabase;
use PHPUnit\Framework\TestCase;
use Tests\Seeders\Book\AuthorsWithBooksSeeder;
use Tests\Trait\CanSeed;

class ListBooksApiFeatureTest extends TestCase
{
    use CanGetPDO;
    use CanRefreshDatabase;
    use CanSeed;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        Logger::setLogFile('php://temp');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    public function testSuccessListOfBooksReturned(): void
    {
        $this->seed([
            AuthorsWithBooksSeeder::class
        ]);

        $listBooksRepository = new ListBooksRepository();
        $listBooksService = new ListBooksService($listBooksRepository);

        ob_start();
        (new ListBooksApiController(
            new ListBooksUseCase($listBooksService),
            new JSONView(),
        ))(2, 2);
        $json = ob_get_clean();

        $this->assertJson($json);

        $data = json_decode($json, true);
        $this->assertCount(2, $data);
        $this->assertSame(['name' => 'The Hobbit','author_name' => 'J.R.R. Tolkien'], $data[0]);
        $this->assertSame(['name' => 'A Brief History of Time','author_name' => 'Stephen Hawking'], $data[1]);
    }
}
