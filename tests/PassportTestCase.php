<?php

use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\ClientRepository as PassportClientRepository;

class PassportTestCase extends TestCase
{

    protected $headers = [];
    protected $scopes = [];
    protected $user;
    protected $token;
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    protected  function setupHeader()
    {
        echo $this->token;
        $clientRepository = new PassportClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            $this->baseUrl
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        $this->user = factory('App\User')->create();
        $this->token = $this->user->createToken('TestToken', $this->scopes)->accessToken;

        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer ' . $this->token;
    }

    public function get($uri, array $headers = [])
    {
        if ($this->token) {
            echo $this->token;
            return parent::get($uri, array_merge($this->headers, $headers));
        } else {
            echo $this->token;
            $this->setupHeader();

            return parent::get($uri, array_merge($this->headers, $headers));
        }
    }

    public function post($uri, array $data = [], array $headers = [])
    {
        if ($this->token) {
            return parent::post($uri, $data, array_merge($this->headers, $headers));
        } else {
            $this->setupHeader();
            return parent::post($uri, $data, array_merge($this->headers, $headers));
        }
    }
    public function delete($uri, array $data = [], array $headers = [])
    {
        $this->setupHeader();
        return parent::delete($uri, $data, array_merge($this->headers, $headers));
    }
}
