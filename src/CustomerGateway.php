<?php

namespace DamianTW\FakeCustomerGateway;

use DamianTW\FakeCustomerGateway\Exceptions\CustomerNotFoundException;
use DamianTW\FakeCustomerGateway\Exceptions\RequiredFieldMissingException;
use Illuminate\Support\Collection;

class CustomerGateway
{
    protected $customers;

    const DEFAULT_DATA_FILE = __DIR__.'/../data/customer-data-1.json';

    public function __construct($dataFile = null)
    {
        $this->customers = $this->createCustomersCollectionFromDataFile($dataFile);
    }

    public function all()
    {
        return $this->customers->values()->all();
    }

    public function paginate(int $pageNumber, int $perPage = 10)
    {
        return $this->customers->forPage($pageNumber, $perPage);
    }

    public function sortByAsc($field)
    {
        return $this->customers->sortBy($field)->values()->all();
    }

    public function sortByDesc($field)
    {
        return $this->customers->sortByDesc($field)->values()->all();
    }

    public function sortByPaginatedAsc($field, $pageNumber, $perPage)
    {
        return $this->customers->sortBy($field)->forPage($pageNumber, $perPage)->values()->all();
    }

    public function sortByPaginatedDesc($field, $pageNumber, $perPage)
    {
        return $this->customers->sortByDesc($field)->forPage($pageNumber, $perPage)->values()->all();
    }


    public function get(int $id)
    {
        return $this->customers->get($id, function () use (&$id) {
            throw new CustomerNotFoundException("No customer found with id: $id");
        });
    }

    public function add($name = null, $company = null, $email = null, $phone_number = null)
    {
        if (is_null($name) || $name === '') {
            throw new RequiredFieldMissingException('Name field is required to create a customer');
        }

        if (!$this->isAllStringsOrNull(func_get_args())) {
            throw new \InvalidArgumentException('Customer data fields must be a string or null.');
        }

        $id = $this->customers->max('id') + 1;

        $this->customers->put($id, new Customer($id, $name, $company, $email, $phone_number));

        return $id;
    }

    public function update(int $id, $name = null, $company = null, $email = null, $phone_number = null)
    {
        if (!$this->isAllStringsOrNull(array_slice(func_get_args(), 1))) {
            throw new \InvalidArgumentException('Customer data fields must be a string or null.');
        }

        if(!$this->customers->has($id)) {
            throw new CustomerNotFoundException("No customer found with id: $id");
        }

        $this->customers->put($id, new Customer($id, $name, $company, $email, $phone_number));

        return true;
    }

    public function delete(int $id)
    {
        if(!$this->customers->has($id)) {
            throw new CustomerNotFoundException("No customer found with id: $id");
        }

        $this->customers->forget($id);

        return true;
    }

    public function saveDataFile($filePath)
    {
        file_put_contents($filePath, json_encode($this->customers->all(), JSON_PRETTY_PRINT));

        return file_exists($filePath);
    }

    public function loadDataFileIfExists($filePath)
    {
        $dataFileExists = file_exists($filePath);

        if($dataFileExists) {
            $this->customers = $this->createCustomersCollectionFromDataFile($filePath);
        }

        return $dataFileExists;
    }

    public function collection()
    {
        return $this->customers;
    }

    protected function createCustomersCollectionFromDataFile($dataFile)
    {
        return Collection::make(
            json_decode(
                file_get_contents(
                    is_null($dataFile) ? static::DEFAULT_DATA_FILE : $dataFile
                )
            )
        )->mapWithKeys(function ($customer) {
            return [
                $customer->id => new Customer(
                    $customer->id,
                    $customer->name,
                    isset($customer->company) ? $customer->company : null,
                    isset($customer->email) ? $customer->email : null,
                    isset($customer->phone_number) ? $customer->phone_number : null
                ),
            ];
        });
    }

    private function isAllStringsOrNull($args)
    {
        return Collection::make($args)->every(function ($arg) {
            return is_string($arg) || is_null($arg);
        });
    }
}
