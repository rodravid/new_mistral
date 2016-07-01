<?php

namespace Vinci\Domain\Order\History;

class OrderHistoryEntryType
{

    const ORDER_STATUS_CHANGE = 'order_status_change';
    const ORDER_TRACKING_STATUS_CHANGE = 'order_tracking_status_change';
    const ORDER_PAYMENT_STATUS_CHANGE = 'order_payment_status_change';

}