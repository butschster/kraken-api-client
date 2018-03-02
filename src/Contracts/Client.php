<?php

namespace Butschster\Kraken\Contracts;

use Butschster\Kraken\Objects\{
    BalanceCollection, Balance, OrdersCollection, Pair, OrderStatus, PairCollection, Ticker, TickerCollection
};
use Butschster\Kraken\Exceptions\KrakenApiErrorException;
use Carbon\Carbon;

interface Client
{
    /**
     * Get tradable asset pairs
     *
     * @param string|array $pair
     * @param string $info Info to retrieve
     *                      info = all info (default),
     *                      leverage = leverage info,
     *                      fees = fees schedule,
     *                      margin = margin info
     *
     * @return PairCollection|Pair[]
     * @throws KrakenApiErrorException
     */
    public function getAssetPairs($pair = null, string $info = 'info'): PairCollection;

    /**
     * Get ticker information
     *
     * @param string|array $pair comma delimited list of asset pairs to get info on
     * @return TickerCollection|Ticker[]
     * @throws KrakenApiErrorException
     */
    public function getTicker($pair): TickerCollection;

    /**
     * Make API call
     *
     * @param string $method
     * @param array $parameters
     * @param bool $isPublic
     * @return array
     *
     * @throws KrakenApiErrorException
     */
    public function request(string $method, array $parameters = [], bool $isPublic = true): array;

    /**
     * Get account balance
     *
     * @return BalanceCollection|Balance[]
     * @throws KrakenApiErrorException
     */
    public function getAccountBalance(): BalanceCollection;

    /**
     * Get trade balance
     *
     * @return array
     * @throws KrakenApiErrorException
     */
    public function getTradeBalance(): array;

    /**
     * Add standard order
     *
     * @param Order $order
     * @return OrderStatus
     * @throws KrakenApiErrorException
     */
    public function addOrder(Order $order): OrderStatus;

    /**
     * Cancel open order
     *
     * @param string $transactionId
     * @return array
     * @throws KrakenApiErrorException
     */
    public function cancelOrder(string $transactionId): array;

    /**
     * Get open orders
     *
     * @param bool $trades Whether or not to include trades in output
     * @return OrdersCollection
     * @throws KrakenApiErrorException
     */
    public function getOpenOrders(bool $trades = false): OrdersCollection;

    /**
     * Get closed orders
     *
     * @param bool $trades Whether or not to include trades in output
     * @param Carbon|null $start Starting date
     * @param Carbon|null $end Ending date
     * @return OrdersCollection
     * @throws KrakenApiErrorException
     */
    public function getClosedOrders(bool $trades = false, Carbon $start = null, Carbon $end = null): OrdersCollection;
}