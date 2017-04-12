<?php

namespace ForestPay\Services\Filters;

use Illuminate\Http\Request;

abstract class BaseOwnerFilter implements OwnerFilterInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \User
     */
    protected $user;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user = \Auth::user();
    }

    /**
     * @return mixed
     */
    public function filter()
    {
        $inputValue = $this->getInputValue($this->request);
        $allowedValues = $this->getAllowedValuesFromUser($this->user);

        if (!in_array($inputValue, $allowedValues)) {
            return \Response::make('Unauthorized', 401);
        }
    }
}
