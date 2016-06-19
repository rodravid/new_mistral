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

    protected $dollarProvider;

    function let(DollarProvider $dollarProvider, CalculablePrice $calculable)
    {
        $this->subject = $calculable;

        $this->dollarProvider = $dollarProvider;

        $dollarProvider->getCurrentDollarAmount()->willReturn(3.95);

        $this->beConstructedWith($dollarProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Vinci\Domain\Pricing\Calculator\StandardPriceCalculator');
    }

    function it_implements_pricing_calculator_interface()
    {
        return $this->shouldImplement(PriceCalculator::class);
    }

    function it_throws_exception_if_no_price_configuration_is_provided()
    {
        $this->shouldThrow(new PriceCalculatorException('The PriceConfiguration is not defined.'))->duringCalculate($this->subject);
    }

    function it_calculate_price_with_empty_configuration_values(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(null);
        $configuration->getDiscountType()->willReturn(null);
        $configuration->getDiscountAmount()->willReturn(null);

        $this->dollarProvider->getCurrentDollarAmount()->shouldBeCalled();

        $this->skipDiscounts()->calculate($this->subject)->shouldReturn(592.5);
        $this->calculate($this->subject)->shouldReturn(592.5);
    }

    function it_calculate_price_with_discount_type_fixed(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(null);
        $configuration->getDiscountType()->willReturn(DiscountType::FIXED);
        $configuration->getDiscountAmount()->willReturn(25);

        $this->dollarProvider->getCurrentDollarAmount()->shouldBeCalled();

        $this
            ->skipDiscounts()
            ->calculate($this->subject)
            ->shouldReturn(592.5);

        $this
            ->calculate($this->subject)
            ->shouldReturn(567.5);
    }

    function it_calculate_price_with_discount_type_percentage(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(null);
        $configuration->getDiscountType()->willReturn(DiscountType::PERCENTAGE);
        $configuration->getDiscountAmount()->willReturn(10);

        $this->dollarProvider->getCurrentDollarAmount()->shouldBeCalled();

        $this
            ->skipDiscounts()
            ->calculate($this->subject)
            ->shouldReturn(592.5);

        $this
            ->calculate($this->subject)
            ->shouldReturn(533.25);
    }

    function it_calculate_price_with_specific_dollar_amount(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(2);
        $configuration->getDiscountType()->willReturn(null);
        $configuration->getDiscountAmount()->willReturn(null);

        $this->dollarProvider->getCurrentDollarAmount()->shouldNotBeCalled();

        $this
            ->skipDiscounts()
            ->calculate($this->subject)
            ->shouldReturn(300.0);

        $this
            ->calculate($this->subject)
            ->shouldReturn(300.0);
    }

    function it_calculate_price_with_discount_type_exchange_rate(PriceConfiguration $configuration)
    {
        $amount = 150.0;

        $this->subject->getAmount()->willReturn($amount);

        $this->setPriceConfiguration($configuration);

        $configuration->getCurrencyAmount()->willReturn(null);
        $configuration->getDiscountType()->willReturn(DiscountType::EXCHANGE_RATE);
        $configuration->getCurrencyOriginalAmount()->willReturn(3);
        $configuration->getDiscountAmount()->willReturn(2);

        $this->dollarProvider->getCurrentDollarAmount()->shouldNotBeCalled();

        $this
            ->skipDiscounts()
            ->calculate($this->subject)
            ->shouldReturn(450.0);

        $this
            ->calculate($this->subject)
            ->shouldReturn(300.0);
    }

}
