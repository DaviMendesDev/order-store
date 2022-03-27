<?php

namespace App\Models\Utils\Discount;

interface OrderDiscountConstants
{
    /**
     * The max number os units to get a Discount, if greater, the discount can't be made
     */
    const MAX_QUANTITY = 9;

    /**
     * The min number os units to get a Discount, if lesser, the discount can't be made
     */
    const MIN_QUANTITY = 5;

    /**
     * The max brute (total) amount to get a Discount, if greater, the discount can't be made
     */
    const MAX_AMOUNT = 500;

    /**
     * The discount's percentage
     */
    const PERCENTAGE = 15;
}
