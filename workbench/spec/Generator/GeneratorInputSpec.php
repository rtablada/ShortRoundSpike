<?php

namespace spec\Rtablada\ShortRound\Generator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorInputSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Rtablada\ShortRound\Generator\GeneratorInput');
    }

    function it_should_find_controller_path()
    {
        $this->beConstructedWith(['modelUpperPlural' => 'Employees']);

        $this->getControllerPath()->shouldReturn('Http/Controllers/Admin/EmployeesController.php');
    }

    function it_should_find_model_path()
    {
        $this->beConstructedWith(['modelUpper' => 'Employee']);

        $this->getModelPath()->shouldReturn('Models/Employee.php');
    }

    function it_should_find_gateway_path()
    {
        $this->beConstructedWith(['modelUpper' => 'Employee']);

        $this->getGatewayPath()->shouldReturn('Gateways/DbEmployeeGateway.php');
    }

    function it_should_find_table_name_with_contructor()
    {
        $this->beConstructedWith(['tableName' => 'create_employees_name']);

        $this->__get('tableName')->shouldReturn('create_employees_name');
    }

    function it_should_find_table_name_with_class_name()
    {
        $this->beConstructedWith(['modelUpper' => 'One']);

        $this->__get('tableName')->shouldReturn('ones');
    }

    function it_should_find_table_name_with_two_word_class_name()
    {
        $this->beConstructedWith(['modelUpper' => 'OneTwo']);

        $this->__get('tableName')->shouldReturn('one_twos');
    }

    function it_should_find_migration_name()
    {
        $this->beConstructedWith(['modelUpper' => 'One']);

        $this->__get('migrationName')->shouldReturn('create_ones_table');
    }

    function it_should_find_views_dir()
    {
        $this->beConstructedWith(['modelUpper' => 'Employee']);

        $this->__get('viewsDir')->shouldReturn('resources/views/admin/employees');
    }

    function it_should_find_attachments_array()
    {
        $this->beConstructedWith(['fields' => [
            [
                "name"  => "photo",
                "type"  => "file",
                "label" => "Photo",
            ],
            [
                "name"    => "active",
                "type"    => "boolean",
                "label"   => "Active",
                "default" => 1
            ]
        ]]);

        $this->__get('attachments')->shouldReturn([
            [
                "name"  => "photo",
                "type"  => "file",
                "label" => "Photo",
            ]
        ]);
    }

    function it_should_find_columns_array()
    {
        $this->beConstructedWith(['fields' => [
            [
                "name"  => "photo",
                "type"  => "file",
                "label" => "Photo",
            ],
            [
                "name"    => "active",
                "type"    => "boolean",
                "label"   => "Active",
                "default" => "1",
            ]
        ]]);

        $this->__get('columns')->shouldReturn([
            [
                "name"    => "active",
                "type"    => "boolean",
                "label"   => "Active",
                "default" => "1",
            ]
        ]);
    }

    function it_should_have_magic_accessor()
    {
        $this->beConstructedWith(['modelUpperPlural' => 'Employees']);

        $this->__get('controllerPath')->shouldReturn('Http/Controllers/Admin/EmployeesController.php');
    }
}
