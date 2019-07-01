<?php

namespace Leadvertex\External\Export\Core\FieldDefinitions;


use Exception;
use Leadvertex\External\Export\Core\Components\MultiLang;
use PHPUnit\Framework\TestCase;

class IntegerDefinitionTest extends TestCase
{
    /** @var array */
    private $name;
    /** @var array */
    private $descriptions;
    /** @var string */
    private $default;
    /** @var bool */
    private $required;
    /** @var StringDefinition */
    private $integerDefinition;

    /**
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->name = new MultiLang(array('en' => 'Organization name', 'ru' => 'Название организации'));
        $this->descriptions = new MultiLang(array('en' => 'Description', 'ru' => 'Описание'));
        $this->default = 5;
        $this->required = true;

        $this->integerDefinition = new IntegerDefinition(
            $this->name,
            $this->descriptions,
            $this->default,
            $this->required
        );

    }

    public function testDefinition()
    {
        $this->assertEquals('integer', $this->integerDefinition->definition());
    }

    /**
     * @dataProvider dataProviderForValidate
     * @param bool $required
     * @param $value
     * @param bool $expected
     * @throws Exception
     */
    public function testValidateValue(bool $required, $value, bool $expected)
    {
        $integerDefinition = new IntegerDefinition(
            $this->name,
            $this->descriptions,
            $this->default,
            $required
        );

        $this->assertEquals($expected, $integerDefinition->validateValue($value));
    }

    /**
     * @return array
     * @throws Exception
     */
    public function dataProviderForValidate()
    {
        return [
            ['required' => true, 'value' => null, 'expected' => false],
            ['required' => true, 'value' => '   ', 'expected' => false],
            ['required' => true, 'value' => random_int(1,100), 'expected' => true],
            ['required' => true, 'value' => [95,49], 'expected' => false],

            ['required' => false, 'value' => null, 'expected' => true],
            ['required' => false, 'value' => '   ', 'expected' => false],
            ['required' => false, 'value' => random_int(1,100), 'expected' => true],
            ['required' => false, 'value' => [95,49], 'expected' => false],
        ];
    }
}