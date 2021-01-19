<?php
 namespace App\Http\Controllers;
 use Log;
use Exception;
class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userRef = null;
        $userRef = [
            'name' => 'le.thi.thu',
            'email' => 'le.thi.thu@sun-asterisk.com',
        ];
         try {
            $this->database->getReference('users')->push($testData);
             $userRef = $this->database->getReference('users')
                ->orderByKey()
                ->getSnapshot();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
         dd($userRef->getValue());
    }
}