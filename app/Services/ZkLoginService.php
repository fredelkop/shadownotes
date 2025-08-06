<?php
namespace App\Services;

use GuzzleHttp\Client;
use JsonRPC2\Client as RpcClient;
use JsonRPC2\Request;

class ZkLoginService
{
    protected Client       $http;
    protected RpcClient    $rpc;

    public function __construct()
    {
        // Guzzle for generic HTTP if needed
        $this->http = new Client([
            'base_uri' => env('SUI_RPC_URL'),
            'headers'  => ['Content-Type' => 'application/json']
        ]);

        // json-rpc-2.0 client for structured calls
        $this->rpc = new RpcClient(env('SUI_RPC_URL'));
    }

    /**
     * Verify a zkLogin proof against a claimed Sui address.
     */
    public function verifyProof(string $proof, string $expectedAddress): bool
    {
        // Build a JSON-RPC request:
        $req = new Request(
          'suix_verifyZkLoginProof',
          [$proof, $expectedAddress],
          1  // any id
        );

        // Send & decode
        $response = $this->rpc->send($req);
        return isset($response->result) && $response->result === true;
    }
}
