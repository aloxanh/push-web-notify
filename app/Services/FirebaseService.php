<?php

namespace App\Services;

use Exception;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Exception\Auth\EmailExists as FirebaseEmailExists;
 
class FirebaseService
{

    /**
     * @var Firebase
     */
    protected $firebase;

    public function __construct()
    {
    

       // $factory = (new Factory)->withServiceAccount('laravelapp-43a92-firebase-adminsdk-7p3zs-83404842ca.json');
        $serviceAccount = ServiceAccount::fromArray([
            "type" => "service_account",
            "project_id" => "laravelapp-43a92",
            "private_key_id" => "",
            "private_key" => "",
            "client_email" => "firebase-adminsdk-7p3zs@laravelapp-43a92.iam.gserviceaccount.com",
            "client_id" => "",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-7p3zs%40laravelapp-43a92.iam.gserviceaccount.com"
        ]);

        // $serviceAccount = ServiceAccount::fromArray([
        //     "type" => "service_account",
        //     "project_id" => config('services.firebase.project_id'),
        //     "private_key_id" => config('services.firebase.private_key_id'),
        //     "private_key" => config('services.firebase.private_key'),
        //     "client_email" => config('services.firebase.client_email'),
        //     "client_id" => config('services.firebase.client_id'),
        //     "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
        //     "token_uri" => "https://oauth2.googleapis.com/token",
        //     "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
        //     "client_x509_cert_url" => config('services.firebase.client_x509_cert_url')
        // ]);

        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri(config('services.firebase.database_url'))
            ->create();
    }

    /**
     * Verify password agains firebase
     * @param $email
     * @param $password
     * @return bool|string
     */
    public function verifyPassword($email, $password)
    {
        try {
            $response = $this->firebase->getAuth()->verifyPassword($email, $password);
            return $response->uid;

        } catch(FirebaseEmailExists $e) {
            logger()->info('Error login to firebase: Tried to create an already existent user');
        } catch(Exception $e) {
            logger()->error('Error login to firebase: ' . $e->getMessage());
        }
        return false;
    }
}
