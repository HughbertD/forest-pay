<?php

namespace ForestPay\Services\Filters;

use Illuminate\Http\Request;

/**
 * Class BankOwnerFilter
 * @package ForestPay\Services\Filters
 * Filter down to bank_id in user's banks
 */
class BankOwnerFilter extends BaseOwnerFilter
{
    public function getInputValue(Request $request)
    {
        return $request->input('bank_id');
    }

    public function getAllowedValuesFromUser(\User $user)
    {
        $banks = $user->bankAccounts()->get()->toArray();
        if (empty($banks)) {
            return [];
        }
        return array_column($banks, 'id');
    }
}