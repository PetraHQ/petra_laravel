<?php


namespace PetraAfrica\Petra;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use PetraAfrica\Petra\Exceptions\SeverErrorException;
use PetraAfrica\Petra\Exceptions\UnAuthorizedException;

class Petra
{
    private $secretKey;

    private $client;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
        $this->client = new Client([
            'base_uri' => 'https://petra-staging.herokuapp.com',
            'headers' => [
                'Authorization' => "Bearer ".$secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'http_errors' => false
        ]);
    }

    /**
     * @throws UnAuthorizedException
     * @throws SeverErrorException
     */
    public function initializeTransaction(string $email, $amount, $type){
        try {
            $request = $this->client->post("/transaction/initialize",[
                "body"=>json_encode([
                    'email'=>$email,
                    'amount'=>$amount,
                    'type'=>$type
                ])
            ]);
            $payload = json_decode($request->getBody()->getContents());
            if ($request->getStatusCode() ===401){
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 200 || $request->getStatusCode() ===201) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function fetchTransactions($page=1, $perPage=50){
        try {
            $request = $this->client->get("/transaction?page={$page}&perPage={$perPage}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function retrieveTransaction($id){
        try {
            $request = $this->client->get("/transaction/{$id}");
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function verifyTransaction($reference){
        try {
            $request = $this->client->get("/transaction/verify/{$reference}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function createCustomer(){
        try {

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function fetchCustomers($page=1, $perPage=20){
        try {
            $request = $this->client->get("/customer?page={$page}&perPage={$perPage}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function retrieveCustomer($reference){
        try {
            $request = $this->client->get("/customer/{$reference}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function updateCustomer($reference, array $payload){
        try {
            $request = $this->client->get("/customer/{$reference}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function createPaymentPage(array $payload){
        try {

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function fetchPaymentPages($page=1, $perPage=50){
        try {
            $request = $this->client->get("/page?page={$page}&perPage={$perPage}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function retrievePaymentPage($id){
        try {
            $request = $this->client->get("/page/{$id}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function publishPaymentPage($id){
        try {
            $request = $this->client->get("/page/{$id}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function updatePaymentPage($id, array $payload){
        try {
            $request = $this->client->get("/page/{$id}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function createInvoice($email, $amount, $note=''){
        try {
            $request = $this->client->get("/invoice");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function fetchInvoices($page=1, $perPage=50){
        try {
            $request = $this->client->get("/invoice?page={$page}&perPage={$perPage}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function retrieveInvoice($reference){
        try {
            $request = $this->client->get("/invoice/{$reference}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function archiveInvoice($reference){
        try {
            $request = $this->client->get("/invoice/{$reference}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }


}
