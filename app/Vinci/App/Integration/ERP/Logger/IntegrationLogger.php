<?php

namespace Vinci\App\Integration\ERP\Logger;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\App\Integration\ERP\Customer\CustomerIntegrationLogger;
use Vinci\App\Integration\ERP\Order\AddressIntegrationLogger;
use Vinci\App\Integration\ERP\Order\OrderIntegrationLogger;
use Vinci\App\Integration\ERP\Order\OrderItemIntegrationLogger;

class IntegrationLogger extends Model implements Presentable
{

    use PresentableTrait;

    public $timestamps = false;

    protected $dates = ['created_at'];

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

    protected static $types = [
        'customer' => CustomerIntegrationLogger::class,
        'order' => OrderIntegrationLogger::class,
        'order_item' => OrderItemIntegrationLogger::class,
        'address' => AddressIntegrationLogger::class
    ];

    protected $presenter = IntegrationLogPresenter::class;

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

    public static function type($type)
    {
        if (isset(self::$types[$type])) {
            return new self::$types[$type];
        }

        throw new Exception(sprintf('Logger for type "%s" not found.', $type));
    }

    public function getByResourceId($id, $limit = 10)
    {
        return static::newQuery()
            ->where('resource_id', $id)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getByResourceOwnerId($id, $limit = 10)
    {
        return static::newQuery()
            ->where('resource_owner_id', $id)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getOneById($id)
    {
        return static::newQuery()
            ->where('id', $id)
            ->firstOrFail();
    }

}