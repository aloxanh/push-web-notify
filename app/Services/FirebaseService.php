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
            "private_key_id" => "83404842ca2a88848d8d912f55fa9c83554f5df8",
            "private_key" => "\nMIIEugIBADANBgkqhkiG9w0BAQEFAASCBKQwggSgAgEAAoIBAQCwrQFJJQln20fA\n2vo6azG0KQFyCN5yvGuqZUFiexiErnNvNKWujyxyg+NM/C07d+1d20qhTiItDXmO\nEnyjcLflHDi7R9zpxytwDDvpIdjKbmUSngg0LYfxRGwwbum1BsCDti9JyC3hDsud\nQOKR4GgWyM8tc6IgJH3r76yVCsdncok+s9isuE8JysIXavyemVyCbhI/f13KGxYS\nbEX3K/ka3+ntqAdHLJY6xoUfpZ3/370Zs8x+Vt+1/cUI6UZOq0BvYRkTxHUQWGGl\nOl3scjxbtel4NibSiAX1ZfJtTmOkIfUDzjFQvON1EpccYKJrlEbVFOA+bX5Y1JYa\nFUT+CZKtAgMBAAECggEAAtkpvGIlWqxSQfppn3Izw6eM8Yj6lrTeTO2DiELWLaKK\n/ygMxLXUmBeNMa5gswZCGP+WDxD1PtAOKRCZJ2hvUl/HdjPhgllqnw8Z1Ugbc1lN\nEj650qcf+3R+N8i3GChveAcre4R4LgCYlLffomwvgWjFINm9RRAwQ/5eEQgZIo9O\nBC9SwLYNbwtyt/iSYiOmJOz/xitJVIGfC/oC5W5irSvUg2EaTfOgPKt2C0JHB4or\nCq/la7D944a8TXrXIUfpzVUDy24XQQODbWfE+ts2vHN4hPqxLqW9XZ7l4RWRk2ba\nRx5bzXAMwMis1rrUzmLNCOvi+2QeAuZpl7x/y+AySQKBgQD3ZgXWt5O3jCac/ICz\nkExIsltgvMbf4X4fnvyLsncOmoT6lYs3CxOkc6dzGYoa1H724U3j7R4i1YONvXFa\nAOLRKCI0Y1xibQ6+zjJtVGGQF5T9gooZT5mm1aRf2mBZUhzpKiUSm+XbkGLt0lxu\npp6ssahZw5ZH8sKhbKv6CkTSQwKBgQC20YNAsbS2gppa+jZglvyf6g+T14nhEUg6\ni9YJS4KM8mvu71IUK8YccnfyLS9Aq21UZ8vmB/GL4pgRyxqx6QagXboERgmRGb/F\nAQRMnJe9do2zRQudJjpzAvc2RfSWToEfBxPRKbhvm2s2S1s2KzTbC0MHZq/LlLOS\n2cwHsm2QTwJ/aVYHJmUDgCMsTas1IT9PO6S1Q3sdMjXQfaYz4UcbahxgglEp9UXC\nF0MnCNrW8pWHeZZ0k5diPXKrkK4YlTnLWUK9TZEAxOeqX5Nr5SEIaVGhHk92fVBn\nG6HbWvSgEWfk52IKZuH5/IJ9nMT0lihbZyw9gfrFAd1bAWBD2TKGGwKBgFOiIxZM\ndWxs8OofvxKO4ADUFc4/cy8INe+6mu7joVSTbjb/OqBJqjbHUwHyE8TU544OcePI\nzIJ+5ax2Kr8q6EIivn9H/wZnLiiUn3/gvzYIbyiMtJRusZx9xdQJSqwcO8uS9Eji\neiJsii5raM2uFF8EluRi4JcUbtYGVuVKhf7XAoGAXmT9x2PbxPx5d/PwWaS3feRW\nGpNshKrAy5haFUqWxnw/4Rp4MWSSBiqpiZer61nkgYusgJtszYFa+10Q3oUtygGx\no1UB/M4dguMlZ5ywslAxLuqelQHTk+xVl5Zc2aTvtHq6OPowkR8/mibvYXtcN8SK\nPRZ4KmI+Lqair7JIhJY=\n",
            "client_email" => "firebase-adminsdk-7p3zs@laravelapp-43a92.iam.gserviceaccount.com",
            "client_id" => "116604318333544886643",
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