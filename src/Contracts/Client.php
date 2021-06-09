<?php

namespace Butschster\Kraken\Contracts;

use Brick\Math\BigDecimal;
use Butschster\Kraken\Responses\Entities\AccountBalance;
use Butschster\Kraken\Responses\Entities\AssetInfo;
use Butschster\Kraken\Responses\Entities\AddOrder\OrderAdded;
use Butschster\Kraken\Responses\Entities\CancelOrdersAfterTimeout;
use Butschster\Kraken\Responses\Entities\DepositAddresses;
use Butschster\Kraken\Responses\Entities\DepositMethods;
use Butschster\Kraken\Responses\Entities\OrderBook\Orders;
use Butschster\Kraken\Responses\Entities\Orders\ClosedOrders;
use Butschster\Kraken\Responses\Entities\Orders\Order;
use Butschster\Kraken\Responses\Entities\ServerTime;
use Butschster\Kraken\Responses\Entities\SystemStatus;
use Butschster\Kraken\Responses\Entities\TickerInformation;
use Butschster\Kraken\Responses\Entities\TradableAsset;
use Butschster\Kraken\Responses\Entities\TradeBalance;
use Butschster\Kraken\Responses\Entities\WebsocketToken;
use Butschster\Kraken\Responses\Entities\WithdrawalInformation;
use Butschster\Kraken\ValueObjects\AssetClass;
use Butschster\Kraken\ValueObjects\AssetPair;
use Butschster\Kraken\ValueObjects\TradableInfo;
use DateTimeInterface;

interface Client
{
    /**
     * Get the server's time.
     * @see https://docs.kraken.com/rest/#operation/getServerTime
     * @return ServerTime
     */
    public function getServerTime(): ServerTime;

    /**
     * Get System Status
     * @see https://docs.kraken.com/rest/#operation/getSystemStatus
     * @return SystemStatus
     */
    public function getSystemStatus(): SystemStatus;

    /**
     * Get information about the assets that are available for deposit, withdrawal, trading and staking.
     * @see https://docs.kraken.com/rest/#operation/getSystemStatus
     * @param array|string[] $assets List of assets to get info on (Default = all)
     * @param AssetClass|null $class Asset class. (optional, default: currency)
     * @return AssetInfo[]
     */
    public function getAssetInfo(array $assets = ['all'], ?AssetClass $class = null): array;

    /**
     * Get Tradable Asset Pairs
     * @see https://docs.kraken.com/rest/#operation/getTradableAssetPairs
     * @param AssetPair $pair Asset pairs to get data for
     * @param TradableInfo|null $info Info to retrieve. (optional)
     * @return TradableAsset[]
     */
    public function getTradableAssetPairs(AssetPair $pair, ?TradableInfo $info = null): array;

    /**
     * Get Ticker Information
     * @see https://docs.kraken.com/rest/#operation/getTickerInformation
     * @param string[] $pairs Asset pair to get data for (Example: XBTUSD)
     * @return TickerInformation[]
     */
    public function getTickerInformation(array $pairs): array;

    /**
     * Get Order Book
     * @see https://docs.kraken.com/rest/#operation/getOrderBook
     * @param string[] $pairs Asset pair to get data for
     * @param int $count Maximum number of asks/bids [ 1 .. 500 ]
     * @return Orders[]
     */
    public function getOrderBook(array $pairs, int $count = 100): array;

    /**
     * Retrieve all cash balances, net of pending withdrawals.
     * @see https://docs.kraken.com/rest/#operation/getAccountBalance
     * @return AccountBalance[]
     */
    public function getAccountBalance(): array;

    /**
     * Retrieve a summary of collateral balances, margin position valuations, equity and margin level.
     * @see https://docs.kraken.com/rest/#operation/getTradeBalance
     * @param string $asset Base asset used to determine balance
     * @return TradeBalance
     */
    public function getTradeBalance(string $asset = 'ZUSD'): TradeBalance;

    /**
     * Retrieve information about currently open orders.
     * @see https://docs.kraken.com/rest/#operation/getOpenOrders
     * @param bool $trades Whether or not to include trades related to position in output
     * @param int|null $userRef Restrict results to given user reference id
     * @return Order[]
     */
    public function getOpenOrders(bool $trades = false, ?int $userRef = null): array;

    /**
     * Retrieve information about orders that have been closed (filled or cancelled). 50 results are returned at a time, the most recent by default.
     * Note: If an order's tx ID is given for start or end time, the order's opening time (opentm) is used
     * @see https://docs.kraken.com/rest/#operation/getClosedOrders
     * @param DateTimeInterface|string|null $start Starting unix timestamp or order tx ID of results (exclusive)
     * @param DateTimeInterface|string|null $end Ending unix timestamp or order tx ID of results (inclusive)
     * @param string|null $closeTime Which time to use to search Enum: "open" "close" "both"
     * @param int|null $offset Result offset for pagination
     * @param bool $trades Whether or not to include trades related to position in output
     * @param int|null $userRef Restrict results to given user reference id
     * @return ClosedOrders
     */
    public function getClosedOrders(
        DateTimeInterface|string|null $start = null,
        DateTimeInterface|string|null $end = null,
        ?string $closeTime = null,
        ?int $offset = null,
        bool $trades = false,
        ?int $userRef = null
    ): ClosedOrders;

    /**
     * Retrieve information about specific orders.
     * @see https://docs.kraken.com/rest/#operation/getClosedOrders
     * @param array $txIds List of transaction IDs to query info about (20 maximum)
     * @param bool $trades Whether or not to include trades related to position in output
     * @param int|null $userRef Restrict results to given user reference id
     * @return Order[]
     */
    public function queryOrdersInfo(array $txIds, bool $trades = false, ?int $userRef = null): array;

    /**
     * Place a new order.
     * Note: See the AssetPairs endpoint for details on the available trading pairs, their price and quantity
     * precisions, order minimums, available leverage, etc.
     * @see https://docs.kraken.com/rest/#operation/addOrder
     * @param AddOrderRequest $request
     * @return OrderAdded
     */
    public function addOrder(AddOrderRequest $request): OrderAdded;

    /**
     * Cancel a particular open order (or set of open orders) by txid or userref
     * @see https://docs.kraken.com/rest/#operation/cancelOrder
     * @param string|int $txId Open order transaction ID (txid) or user reference (userref)
     * @return int Number of orders cancelled.
     */
    public function cancelOrder(string|int $txId): int;

    /**
     * Cancel all open orders
     * @see https://docs.kraken.com/rest/#operation/cancelAllOrders
     * @return int Number of orders that were cancelled
     */
    public function cancelAllOrders(): int;

    /**
     * CancelAllOrdersAfter provides a "Dead Man's Switch" mechanism to protect the client from network malfunction,
     * extreme latency or unexpected matching engine downtime. The client can send a request with a timeout (in seconds),
     * that will start a countdown timer which will cancel all client orders when the timer expires. The client has to
     * keep sending new requests to push back the trigger time, or deactivate the mechanism by specifying a timeout of 0.
     * If the timer expires, all orders are cancelled and then the timer remains disabled until the client provides a
     * new (non-zero) timeout.
     *
     * The recommended use is to make a call every 15 to 30 seconds, providing a timeout of 60 seconds. This allows
     * the client to keep the orders in place in case of a brief disconnection or transient delay, while keeping them
     * safe in case of a network breakdown. It is also recommended to disable the timer ahead of regularly scheduled
     * trading engine maintenance (if the timer is enabled, all orders will be cancelled when the trading engine comes
     * back from downtime - planned or otherwise).
     *
     * @see https://docs.kraken.com/rest/#operation/cancelAllOrdersAfter
     * @param int $timeout Duration (in seconds) to set/extend the timer by (0 - disable)
     */
    public function cancelAllOrdersAfter(int $timeout): CancelOrdersAfterTimeout;

    /**
     * An authentication token must be requested via this REST API endpoint in order to connect to and authenticate
     * with our Websockets API. The token should be used within 15 minutes of creation, but it does not expire once a
     * successful Websockets connection and private subscription has been made and is maintained.
     */
    public function getWebsocketsToken(): WebsocketToken;

    /**
     * Retrieve methods available for depositing a particular asset.
     * @see https://docs.kraken.com/rest/#operation/getDepositMethods
     * @param string $asset Asset being deposited
     * @return DepositMethods|null
     */
    public function getDepositMethods(string $asset): ?DepositMethods;

    /**
     * Retrieve (or generate a new) deposit addresses for a particular asset and method.
     * @see https://docs.kraken.com/rest/#operation/getDepositAddresses
     * @param string $asset Asset being deposited
     * @param string $method Name of the deposit method
     * @param bool $new Whether or not to generate a new address
     * @return DepositAddresses[]
     */
    public function getDepositAddresses(string $asset, string $method, bool $new = false): array;

    /**
     * Retrieve fee information about potential withdrawals for a particular asset, key and amount.
     * @see https://docs.kraken.com/rest/#operation/getWithdrawalInformation
     * @param string $asset Asset being withdrawn
     * @param string $key Withdrawal key name, as set up on your account
     * @param BigDecimal $amount Amount to be withdrawn
     * @return WithdrawalInformation
     */
    public function getWithdrawalInformation(string $asset, string $key, BigDecimal $amount): WithdrawalInformation;
}
