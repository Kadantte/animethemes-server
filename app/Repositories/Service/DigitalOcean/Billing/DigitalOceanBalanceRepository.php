<?php

declare(strict_types=1);

namespace App\Repositories\Service\DigitalOcean\Billing;

use App\Contracts\Repositories\Repository;
use App\Enums\Http\Api\Filter\AllowedDateFormat;
use App\Enums\Models\Billing\BalanceFrequency;
use App\Enums\Models\Billing\Service;
use App\Models\Billing\Balance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class DigitalOceanBalanceRepository.
 */
class DigitalOceanBalanceRepository implements Repository
{
    /**
     * Get models from the repository.
     *
     * @param  array  $columns
     * @return Collection
     *
     * @throws RequestException
     */
    public function get(array $columns = ['*']): Collection
    {
        // Do not proceed if we do not have authorization to the DO API
        $doBearerToken = Config::get('services.do.token');
        if ($doBearerToken === null) {
            throw new RuntimeException('DO_BEARER_TOKEN must be configured in your env file.');
        }

        $response = Http::withToken($doBearerToken)
            ->contentType('application/json')
            ->get('https://api.digitalocean.com/v2/customers/my/balance')
            ->throw()
            ->json();

        $balance = new Balance([
            Balance::ATTRIBUTE_BALANCE => -1.0 * floatval(Arr::get($response, 'month_to_date_balance')),
            Balance::ATTRIBUTE_DATE => Date::now()->firstOfMonth()->format(AllowedDateFormat::YMD),
            Balance::ATTRIBUTE_FREQUENCY => BalanceFrequency::MONTHLY,
            Balance::ATTRIBUTE_SERVICE => Service::DIGITALOCEAN,
            Balance::ATTRIBUTE_USAGE => Arr::get($response, 'month_to_date_usage'),
        ]);

        return collect([$balance]);
    }

    /**
     * Save model to the repository.
     *
     * @param  Model  $model
     * @return bool
     */
    public function save(Model $model): bool
    {
        // Billing API is not writable
        return false;
    }

    /**
     * Delete model from the repository.
     *
     * @param  Model  $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        // Billing API is not writable
        return false;
    }

    /**
     * Update model in the repository.
     *
     * @param  Model  $model
     * @param  array  $attributes
     * @return bool
     */
    public function update(Model $model, array $attributes): bool
    {
        // Billing API is not writable
        return false;
    }

    /**
     * Validate repository filter.
     *
     * @param  string  $filter
     * @param  mixed  $value
     * @return bool
     */
    public function validateFilter(string $filter, mixed $value = null): bool
    {
        // not supported
        return false;
    }

    /**
     * Filter repository models.
     *
     * @param  string  $filter
     * @param  mixed  $value
     * @return void
     */
    public function handleFilter(string $filter, mixed $value = null): void
    {
        // not supported
    }
}
