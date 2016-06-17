<?php

namespace spec\Vinci\Domain\Pricing\Calculator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vinci\Domain\Dollar\DollarProvider;
use Vinci\Domain\Pricing\Calculator\Exceptions\PriceCalculatorException;
use Vinci\Domain\Pricing\Calculator\PriceCalculator;
use Vinci\Domain\Pricing\Contracts\CalculablePrice;
use Vinci\Domain\Pricing\Contracts\DiscountType;
use Vinci\Domain\Pricing\Contracts\PriceConfiguration;

class StandardPriceCalculatorSpec extends ObjectBehavior
{

    protected $subject;

    function let(DollarProvider $dollarProvider, CalculablePrice $calculable)
    {
        $this->subject = $calculable;

        $dollarProvider->getCurrentDollarAmount()->willReturn(3.95);

        $this->beConstructedWith($dollarProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Vinci\Domain\Pricing\Calculator\StandardPriceCalculator');
    }

    public function it_implements_pricing_calculator_interface()
    {
        return $this->shouldImplement(PriceCalculator::class);
    }

    public function it_throws_exception_if_no_price_configuration_is_provided()
    {
        $this->shouldThrow(new PriceCalculatorException('The PriceConfiguration is not defined.'))->duringCalculate($this->subject);
    }

    public function it_calculate_price_with_empty_configuration_values(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(null);
        $configuration->getDiscountType()->willReturn(null);
        $configuration->getDiscountAmount()->willReturn(null);

        $this->skipDiscounts()->calculate($this->subject)->shouldReturn(592.5);
        $this->calculate($this->subject)->shouldReturn(592.5);
    }

    public function it_calculate_price_with_discount_type_fixed(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(null);
        $configuration->getDiscountType()->willReturn(DiscountType::FIXED);
        $configuration->getDiscountAmount()->willReturn(25);

        $this
            ->skipDiscounts()
            ->calculate($this->subject)
            ->shouldReturn(592.5);

        $this
            ->calculate($this->subject)
            ->shouldReturn(567.5);
    }

    public function it_calculate_price_with_discount_type_percentage(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(null);
        $configuration->getDiscountType()->willReturn(DiscountType::PERCENTAGE);
        $configuration->getDiscountAmount()->willReturn(10);

        $this
            ->skipDiscounts()
            ->calculate($this->subject)
            ->shouldReturn(592.5);

        $this
            ->calculate($this->subject)
            ->shouldReturn(533.25);
    }

}
