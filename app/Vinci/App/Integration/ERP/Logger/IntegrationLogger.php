<?php

namespace Vinci\App\Integration\ERP\Logger;

use Illuminate\Database\Eloquent\Model;

class IntegrationLogger extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'user',
        'type',
        'resource_id',
        'message',
        'error_message',
        'error_trace',
        'request_body',
        'response_body'
    ];

    protected $dates = ['created_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public static function success(array $data)
    {
        $data = array_merge($data, ['type' => 'success']);
        return static::log($data);
    }

    public static function error(array $data)
    {
        $data = array_merge($data, ['type' => 'error']);
        return static::log($data);
    }

    public static function log(array $data)
    {
        return static::create($data);
    }

}