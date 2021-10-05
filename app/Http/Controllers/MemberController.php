<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Account;
use App\Models\Score;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Member as MemberResource;

class MemberController extends Controller
{
    /**
     *  Displays the list of all members
     *
     */
    public function index()
    {
        /**
            Data stored and served here is taken from the Cache Member Provider
            Cached data will be stored on redis depending on the TTL set
            Through this, instead of requesting on the database again, the application will get the data from the cache until the 
            time expires requiring it to cache data again

            This feature is very helpful when dealing with concurrent users and huge database as it helps optimize the application performance and reduces work load

            See : https://laravel.com/docs/8.x/cache
         */

        $members = \App\Providers\Cache\Member::all();
        return Inertia::render('Admin/Member/List', [
            'members' => $members,
        ]);
    }



    /** The following functions are added to test application optimization**/

    /** Generates 10 new Members **/
    public function generateNewMembers()
    {
        $value = 10;
        $members = $this->generateData($value);
        return response()->json($members);

    }

    /** Clears the current members and generates 10 new Members **/
    public function clearMembers()
    {
        $value = 10;
        $this->clearData();
        $members = $this->generateData($value);
        return response()->json($members);
    }

    /** Clears the current members and generates 100 new Members **/
    public function dumpMembers()
    {
        $value = 100;
        $this->clearData();
        $members =  $this->generateData($value);
        return response()->json($members);
    }


    /** Reuseable function that generates member data **/
    public function generateData($value)
    {
        /** Clears the stored data in order to retrieve and pass the new ones **/
        \App\Providers\Cache\Member::clearAll();

        /** Generates new Members List **/
        Member::factory()->count($value)->create();
        $members = \App\Providers\Cache\Member::all();

        return $members;
    }

    /** Reuseable function that clears member data **/
    public function clearData()
    {
        /** Empties the corresponding tables **/
        Member::query()->delete();
        Account::query()->delete();
        Score::query()->delete();
    }

}
