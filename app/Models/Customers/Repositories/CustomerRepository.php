<?php

namespace App\Models\Customers\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Models\Customers\Customer;
use App\Models\Customers\Exceptions\CreateCustomerInvalidArgumentException;
use App\Models\Customers\Exceptions\CustomerNotFoundException;
use App\Models\Customers\Exceptions\UpdateCustomerInvalidArgumentException;
use App\Models\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection as Support;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
        $this->model = $customer;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function listCustomers(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Support
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the customer
     *
     * @param array $params
     * @return Customer
     * @throws CreateCustomerInvalidArgumentException
     */
    public function createCustomer(array $params) : Customer
    {
        try {
            $data = collect($params)->except('password')->all();

            $customer = new Customer($data);
            if (isset($params['password'])) {
                $customer->password = bcrypt($params['password']);
            }

            $customer->save();

            return $customer;
        } catch (QueryException $e) {
            throw new CreateCustomerInvalidArgumentException($e->getMessage(), 500, $e);
        }
    }

    /**
     * Update the customer
     *
     * @param array $params
     *
     * @return bool
     * @throws UpdateCustomerInvalidArgumentException
     */
    public function updateCustomer(array $params) : bool
    {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateCustomerInvalidArgumentException($e);
        }
    }

    /**
     * Find the customer or fail
     *
     * @param int $id
     *
     * @return Customer
     * @throws CustomerNotFoundException
     */
    public function findCustomerById(int $id) : Customer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CustomerNotFoundException($e);
        }
    }

    /**
     * Delete a customer
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteCustomer() : bool
    {
        return $this->delete();
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchCustomer(string $text = null) : Collection
    {
        if (is_null($text)) {
            return $this->all();
        }
        return $this->model->searchCustomer($text)->get();
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function saveCoverImage(UploadedFile $file) : string
    {
        return $file->store('customers', ['disk' => 'public']);
    }

    /**
     * Destroye File on Storage
     *
     * @param string $get_data
     *
     */
    public function deleteFile(string $get_data)
    {
        return File::delete("storage/{$get_data}");
    }
}
