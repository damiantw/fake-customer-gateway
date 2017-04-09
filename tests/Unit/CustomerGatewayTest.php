<?php

namespace DamianTW\FakeCustomerGateway\Tests\Unit;

use DamianTW\FakeCustomerGateway\Customer;
use DamianTW\FakeCustomerGateway\CustomerGateway;
use DamianTW\FakeCustomerGateway\Exceptions\CustomerNotFoundException;
use DamianTW\FakeCustomerGateway\Exceptions\RequiredFieldMissingException;
use PHPUnit\Framework\TestCase;

class CustomerGatewayTest extends TestCase
{
    const TEST_DATA_FILE = __DIR__.'/../stubs/test-customer-data.json';

    const NAMES_ALPHABETICAL = [
        'Aimee Weissnat',
        'Herminia Jakubowski DDS',
        'Kelvin Greenholt',
        'Linda Runolfsdottir Sr.',
        'Ned Kulas',
    ];

    /** @test */
    public function it_returns_all_of_the_customers()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $customers = $customerGateway->all();

        $json = json_decode(file_get_contents(static::TEST_DATA_FILE));

        $this->assertEquals(collect($json)->pluck('id')->all(), collect($customers)->pluck('id')->all());

        $this->assertTrue(collect($customers)->every(function ($customer) {
            return get_class($customer) === Customer::class;
        }));
    }

    /** @test */
    public function it_returns_all_of_the_customers_paginated()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $json = json_decode(file_get_contents(static::TEST_DATA_FILE));

        $customers = $customerGateway->paginate(1, 2);

        $this->assertEquals(
            collect($json)->slice(0, 2)->pluck('id'), collect($customers)->pluck('id')
        );

        $customers = $customerGateway->paginate(2, 2);

        $this->assertEquals(
            collect($json)->slice(2, 2)->pluck('id'), collect($customers)->pluck('id')
        );
    }

    /** @test */
    public function it_returns_all_customers_sorted_by_a_field_ascending()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $customers = $customerGateway->sortByAsc('name');

        $this->assertEquals(
            static::NAMES_ALPHABETICAL,
            collect($customers)->pluck('name')->all()
        );
    }

    /** @test */
    public function it_returns_all_customers_sorted_by_a_field_descending()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $customers = $customerGateway->sortByDesc('name');

        $this->assertEquals(
            collect(static::NAMES_ALPHABETICAL)->reverse()->values()->all(),
            collect($customers)->pluck('name')->all()
        );
    }

    /** @test */
    public function it_returns_all_customers_sorted_by_a_field_ascending_paginated()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $customers = $customerGateway->sortByPaginatedAsc('name', 1, 2);

        $this->assertEquals(
            collect(static::NAMES_ALPHABETICAL)->slice(0, 2)->values()->all(),
            collect($customers)->pluck('name')->all()
        );

        $customers = $customerGateway->sortByPaginatedAsc('name', 2, 2);

        $this->assertEquals(
            collect(static::NAMES_ALPHABETICAL)->slice(2, 2)->values()->all(),
            collect($customers)->pluck('name')->all()
        );
    }

    /** @test */
    public function it_returns_all_customers_sorted_by_a_field_descending_paginated()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $customers = $customerGateway->sortByPaginatedDesc('name', 1, 2);

        $this->assertEquals(
            collect(static::NAMES_ALPHABETICAL)->reverse()->slice(0, 2)->values()->all(),
            collect($customers)->pluck('name')->all()
        );

        $customers = $customerGateway->sortByPaginatedDesc('name', 2, 2);

        $this->assertEquals(
            collect(static::NAMES_ALPHABETICAL)->reverse()->slice(2, 2)->values()->all(),
            collect($customers)->pluck('name')->all()
        );
    }

    /** @test */
    public function it_returns_a_customer_given_an_id()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $customer = $customerGateway->get(1);

        $json = json_decode(file_get_contents(static::TEST_DATA_FILE));

        $this->assertEquals($json[0]->id, $customer->id);
    }

    /** @test */
    public function it_can_add_a_customer_with_an_incrementing_id()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $expectedId = count(json_decode(file_get_contents(static::TEST_DATA_FILE))) + 1;

        $actualId = $customerGateway->add('John Smith');

        $this->assertEquals($expectedId, $actualId);

        $customer = $customerGateway->get($expectedId);

        $this->assertEquals('John Smith', $customer->name);
    }

    /** @test */
    public function it_can_update_a_customer_with_a_given_id()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->assertTrue($customerGateway->update(1, 'Damian Crisafulli'));

        $this->assertEquals($customerGateway->get(1)->name, 'Damian Crisafulli');
    }

    /** @test */
    public function it_can_remove_a_customer_given_an_id()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->assertTrue($customerGateway->delete(1));

        $this->assertFalse(collect($customerGateway->all())->contains('id', 1));
    }

    /** @test */
    public function it_saves_a_json_representation_of_customers_to_disk()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $tmpFilePath = __DIR__.'/tmp.json';

        $this->assertTrue($customerGateway->saveDataFile($tmpFilePath));

        $this->assertTrue(file_exists(__DIR__.'/tmp.json'));

        $this->assertEquals(
            collect(json_decode(file_get_contents(static::TEST_DATA_FILE)))->pluck('id'),
            collect(json_decode(file_get_contents($tmpFilePath)))->pluck('id')
        );

        $this->assertEquals(
            collect(json_decode(file_get_contents(static::TEST_DATA_FILE)))->pluck('name'),
            collect(json_decode(file_get_contents($tmpFilePath)))->pluck('name')
        );

        unlink($tmpFilePath);
    }

    /** @test */
    public function it_recreates_the_customer_collection_from_a_provided_json_file_if_the_file_exists()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $loadFilePath = __DIR__.'/../stubs/test-load-customer-data.json';

        $customerGateway->loadDataFileIfExists($loadFilePath);

        $this->assertEquals(
            collect(json_decode(file_get_contents($loadFilePath)))->pluck('id')->all(),
            collect($customerGateway->all())->pluck('id')->all()
        );

        $this->assertEquals(
            collect(json_decode(file_get_contents($loadFilePath)))->pluck('name')->all(),
            collect($customerGateway->all())->pluck('name')->all()
        );

        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $customerGateway->loadDataFileIfExists('./SomeFileThatDoesntExist.beer');

        $this->assertEquals(
            collect(json_decode(file_get_contents(static::TEST_DATA_FILE)))->pluck('id')->all(),
            collect($customerGateway->all())->pluck('id')->all()
        );

        $this->assertEquals(
            collect(json_decode(file_get_contents(static::TEST_DATA_FILE)))->pluck('name')->all(),
            collect($customerGateway->all())->pluck('name')->all()
        );
    }

    /** @test */
    public function it_throws_an_exception_if_there_is_an_attempt_to_get_a_model_that_does_not_exist()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->expectException(CustomerNotFoundException::class);

        $customerGateway->get(9999);
    }

    /** @test */
    public function it_throws_an_exception_if_there_is_an_attempt_to_update_a_model_that_does_not_exist()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->expectException(CustomerNotFoundException::class);

        $customerGateway->update(9999, 'Damian Crisafulli');
    }

    /** @test */
    public function it_throws_an_exception_if_there_is_an_attempt_to_delete_a_model_that_does_not_exist()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->expectException(CustomerNotFoundException::class);

        $customerGateway->delete(9999);
    }

    /** @test */
    public function it_requires_the_name_field_be_given_to_create_a_customer()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->expectException(RequiredFieldMissingException::class);

        $customerGateway->add();

        $this->expectException(RequiredFieldMissingException::class);

        $customerGateway->add('');
    }

    /** @test */
    public function it_requires_all_customer_data_fields_be_strings_or_null_when_creating_a_customer()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->expectException(\InvalidArgumentException::class);

        $customerGateway->add('Damian', new \stdClass());
    }

    /** @test */
    public function it_requires_all_customer_data_fields_be_strings_or_null_when_updating_a_customer()
    {
        $customerGateway = new CustomerGateway(static::TEST_DATA_FILE);

        $this->expectException(\InvalidArgumentException::class);

        $customerGateway->update(1, new \stdClass());
    }
}
