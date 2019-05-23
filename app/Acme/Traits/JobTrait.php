<?php

namespace App\Acme\Traits;

use App\Acme\Models\ApplyType;
use App\Acme\Models\Brand;
use App\Acme\Models\Category;
use App\Acme\Models\Location;
use App\Acme\Models\NotificationFrequency;
use App\Acme\Models\PayType;
use App\Acme\Models\SeekerApplies;

trait JobTrait
{
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function applyType()
    {
        return $this->belongsTo(ApplyType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function payType()
    {
        return $this->belongsTo(PayType::class);
    }

    public function notificationFrequency()
    {
        return $this->belongsTo(NotificationFrequency::class);
    }

    public function applications()
    {
        return $this->hasMany(SeekerApplies::class, 'job_uuid', 'uuid')->whereIn('apply_type_id', [ApplyType::$APPLY_TYPE_ONSITE_ID, ApplyType::$APPLY_TYPE_EMAIL_ID]);
    }

    public function applyClicks()
    {
        return $this->hasMany(SeekerApplies::class, 'job_uuid', 'uuid')->whereIn('apply_type_id', [ApplyType::$APPLY_TYPE_OFFSITE_APPLY_ID, ApplyType::$APPLY_TYPE_OFFSITE_JOBVIEW_ID]);
    }

    public function scopeUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeSearchByAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId)->whereNotNull('account_id');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now())->orderBy('expires_at', 'DESC');
    }
}