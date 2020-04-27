<?php

namespace App\Models\Customers\Transformations;

use App\Models\Customers\Customer;

trait CustomerTransformable
{
    protected function transformCustomer(Customer $customer)
    {
        $prop = new Customer;
        $prop->id = (int) $customer->id;
        $prop->name = $customer->name;
        $prop->email = $customer->email;
        $prop->status = (int) $customer->status;

        return $prop;
    }
}
