<?php

namespace Vinci\App\Core\Services\Logging;

use Illuminate\Database\Eloquent\Model;

class OrderImporterLogger extends Model
{

    public $timestamps = false;

    protected $table = 'old_orders_import_error_log';

    protected $dates = ['created_at'];

    protected $fillable = [
        'resource_id',
        'error_message',
        'error_trace'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public static function log(array $data)
    {
        return static::create($data);
    }

}