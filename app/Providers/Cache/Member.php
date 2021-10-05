<?php

namespace App\Providers\Cache;
use App\Http\Resources\Member as MemberResource;

class Member extends CacheBase
{
    /** Constructor sets the cache key and the TTL **/
    public function __construct($key, $ttl = null)
    {
        $ttl = $ttl ?? now()->addHour();
        parent::__construct($key, $ttl);
    }

    /**
     * Get all members order by :
            Active
            Partial
            Failed
            Alphanumeric  
        With the related tables accounts and score 
     */
    public static function all()
    {
        $key = 'members.all';
        $ins = new static($key);
        if (! $ins->hasData()) {
            $members = \App\Models\Member::with('accounts', 'score')->orderByRaw("FIELD(status, 'active', 'partial', 'failed')")->orderBy('last_name')->get();
            $members = MemberResource::collection($members);  /** Used resource collection to safely send api data, please see attached details.pdf **/
            if($members) $ins->setData($members);
        }
        return $ins->getData();
    }

    /* Clears all cached data with the key members.all */
    public static function clearAll()
    {
        $key = 'members.all';
        $ins = new static($key);
        if ($ins->hasData()) $ins->clear();
    }
}
