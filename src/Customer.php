<?php

namespace DamianTW\FakeCustomerGateway;


class Customer
{
    public $id;
    public $name;
    public $company;
    public $email;
    public $phone_number;

    function __construct($id, $name, $company = null, $email = null, $phone_number = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->company = $company;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }
}