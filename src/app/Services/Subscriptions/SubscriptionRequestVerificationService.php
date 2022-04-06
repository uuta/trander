<?php

namespace App\Services\Subscriptions;

use Illuminate\Database\Eloquent\Collection;

class SubscriptionRequestVerificationService
{
    public $body;
    public $request_limit;

    public function __construct(
        array $body,
        Collection $request_limit
    ) {
        $this->body = $body;
        $this->request_limit = $request_limit;
    }

    public function handle(): bool
    {
        // Check subscription keeps alive
        if ($this->_isNoSubscriptionHistory()) {
            if ($this->_isSubscriptionExpired()) {
                return false;
            }
        }

        // Check subscription yearly keeps alive
        if ($this->_isNoSubscriptionYearlyHistory()) {
            if ($this->_isSubscriptionYearlyExpired()) {
                return false;
            }
        }

        if ($this->_isEmptyRequestLimit()) {
            return true;
        }

        if ($this->_isRequestLimitExpired()) {
            return true;
        }

        return false;
    }

    private function _isNoSubscriptionHistory(): bool
    {
        return (array_key_exists('subscription', $this->body['subscriber']['subscriptions']));
    }

    private function _isNoSubscriptionYearlyHistory(): bool
    {
        return (array_key_exists('subscription_yearly', $this->body['subscriber']['subscriptions']));
    }

    private function _isSubscriptionExpired(): bool
    {
        return !($this->body['subscriber']['subscriptions']['subscription']['expires_date'] < $this->body['request_date']);
    }


    private function _isSubscriptionYearlyExpired(): bool
    {
        return !($this->body['subscriber']['subscriptions']['subscription_yearly']['expires_date'] < $this->body['request_date']);
    }

    private function _isEmptyRequestLimit(): bool
    {
        return ($this->request_limit->isEmpty());
    }

    /**
     * Check request limit is expired
     *
     * @return boolean
     */
    private function _isRequestLimitExpired(): bool
    {
        return ($this->request_limit[0]->request_limit <= 0);
    }
}
