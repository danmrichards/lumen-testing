<?php
/**
 * @file
 * Contains \MicroServiceBaseTest.
 */

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

/**
 * Test the User microservice functionality.
 */
class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test users data.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $testUsers;

    /**
    * Generate a number of test users.
    *
    * @param int $numberOfUsers
    * @param bool $persist
    */
    protected function generateTestUsers($numberOfUsers, $persist = true)
    {
        // If the $persist flag is passed we need to save the fake products to
        // the database.
        if ($persist) {
            $this->testUsers = factory(App\User::class, $numberOfUsers)->create();
        } else {
            // No persistence needed.
            $this->testUsers = factory(App\User::class, $numberOfUsers)->make();
        }
    }

    /**
     * Remove any test users before the next test.
     */
    public function tearDown()
    {
        if (!empty($this->testUsers)) {
            // Delete test users.
            foreach ($this->testUsers as $testUser) {
                $item = User::find($testUser['id']);

                if (!empty($item)) {
                    $item->delete();
                }
            }
            $this->testUsers = null;
        }

        parent::tearDown();
    }

    /**
     * Test the user listing endpoint.
     */
    public function testUserListing()
    {
        // Create test users.
        $this->generateTestUsers(10, true);

        foreach ($this->testUsers as $testUser) {
            $this->get('/users');
            $this->assertResponseStatus(200);
            $this->seeJson($testUser->toArray());
        }
    }
}