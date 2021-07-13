<?php


namespace PetraAfrica\Petra;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PetraAfrica\Petra\Exceptions\NotFoundException;
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
            $request = $this->client->post("/transaction",[
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
     * @throws UnAuthorizedException
     */
    public function fetchTransactions($page=1, $perPage=50){
        try {
            $request = $this->client->get("/transaction?page={$page}&perPage={$perPage}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            }  else if ($request->getStatusCode() === 200) {
                return $payload;
            }

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function retrieveTransaction($id){
        try {
            $request = $this->client->get("/transaction/{$id}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function verifyTransaction($reference){
        try {
            $request = $this->client->get("/transaction/verify/{$reference}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     */
    public function createCustomer($email, $first_name =null,$last_number=null, $phone_number=null){
        try {
            $request = $this->client->post("/customer", [
                "body" => json_encode([
                    'email' => $email,
                    'first_name' => $first_name,
                    'last_name' => $last_number,
                    'phone_number'=>$phone_number
                ])
            ]);

            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     */
    public function fetchCustomers($page=1, $perPage=20){
        try {
            $request = $this->client->get("/customer?page={$page}&perPage={$perPage}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            }  else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function retrieveCustomer($reference){
        try {
            $request = $this->client->get("/customer/{$reference}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     */
    public function updateCustomer($reference, array $payload){
        try {
            $request = $this->client->put("/customer/{$reference}");

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     */
    public function createPaymentPage($name, $amount){
        try {
            $request = $this->client->post("/page", [
                "body" => json_encode([
                    'name' => $name,
                    'amount' => $amount,
                ])
            ]);

            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            }  else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     */
    public function fetchPaymentPages($page=1, $perPage=50){
        try {
            $request = $this->client->get("/page?page={$page}&perPage={$perPage}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            }  else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function retrievePaymentPage($id){
        try {
            $request = $this->client->get("/page/{$id}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function publishPaymentPage($id){
        try {
            $request = $this->client->put("/page/{$id}");
            $payload = json_decode($request->getBody()->getContents());
            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function updatePaymentPage($id, array $payload){
        try {
            $request = $this->client->put("/page/{$id}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     */
    public function createInvoice($email, $amount, $note=''){
        try {
            $request = $this->client->post("/invoice", [
                "body" => json_encode([
                    'email' => $email,
                    'amount' => $amount,
                    'note'=>$note
                ])
            ]);

            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     */
    public function fetchInvoices($page=1, $perPage=50){
        try {
            $request = $this->client->get("/invoice?page={$page}&perPage={$perPage}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            }  else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function retrieveInvoice($reference){
        try {
            $request = $this->client->get("/invoice/{$reference}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }
        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }

    /**
     * @throws SeverErrorException
     * @throws UnAuthorizedException
     * @throws NotFoundException
     */
    public function archiveInvoice($reference){
        try {
            $request = $this->client->get("/invoice/{$reference}");
            $payload = json_decode($request->getBody()->getContents());

            if ($request->getStatusCode() === 401) {
                throw new UnAuthorizedException($payload->message);
            } else if ($request->getStatusCode() === 404) {
                throw new NotFoundException($payload->message);
            } else if ($request->getStatusCode() === 200) {
                return $payload;
            }

        }catch (GuzzleException $e){
            throw new SeverErrorException($e->getMessage());
        }
    }


}
