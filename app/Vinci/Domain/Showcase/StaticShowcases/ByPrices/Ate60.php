<?php

namespace Vinci\Domain\Showcase\StaticShowcases\ByPrices;

use stdClass;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcase;
use Vinci\Domain\Template\Template;

class Ate60 extends StaticShowcase
{

    protected $id = -10;

    protected $title = 'Até R$60,00';
    protected $description = '
    
<p>      Como escolher um vinho? Como pedir um vinho para acompanhar sua comida? Saiba que o primeiro

passo é decidir, por exemplo, a comida que será degustada. A partir daí você já começa a ter uma ideia

de qual tipo de qual vinho escolher, tinto ou branco, leve ou encorpado e assim por diante. Prato mais

leve combina com vinho mais leve e delicado, podendo ser tinto ou branco. Prato mais forte pede um

vinho mais encorpado, tinto ou branco. Depois vem a questão do preço.
</p>

<p>

Quanto se está disposto a pagar por uma garrafa em determinada ocasião? Hoje em dia existem bons

vinhos em todas as faixas de preços. E diversos produtores que se esmeram em oferecer ótimos vinhos

com uma bela relação entre preço e qualidade. Depois que foram definidos o tipo de vinho e o preço, as

opções já são muito menos numerosas, e aí entra a sua preferência, o seu momento financeiro atual e,

claro, a ocasião.
</p>

<p>

Saiba que, além da qualidade dos vinhos, o que define seus preços é a famosa Lei de Oferta e Procura.

Como os grandes vinhos são, geralmente, feitos em uma quantidade pequena e muitas pessoas querem

prova-lo, a demanda fica maior do que a oferta. Os preços acabam subindo. Outros fatores que podem

influenciar nos preços do seu vinho são a escassez natural ou uma praga, por exemplo.
</p>

<p>

A tradição também é um ponto a ser considerado na hora de analisar o preço de um vinho, pois a

reputação da bebida pesa no momento da compra. Lugares e produtores famosos, como Borgonha,

Bordeaux ou Champagne sempre saem na frente das outras. Geralmente, a qualidade faz jus à fama do

vinho.
</p>

<p>

Outros fatores como o terroir, a seleção de uvas, as críticas especializadas, a tributação, o transporte e a

matéria-prima também alteram o preço do vinho que você compra, porém, um dos mais importantes é o

chamado “variação de ativos” que costuma ser enorme, já que vinhos são produzidos no mundo todo,

em regiões completamente distintas. Por exemplo, enquanto um hectare de terra em Napa Valley, na

Califórnia custa 700 mil dólares, na Espanha o mesmo pedaço de terra poderá custar cerca de 40 mil

dólares. E essas despesas completamente discrepantes podem gerar preços tão diversos quanto.

</p>
<p>
Existem vinhos que chegam a custar milhares de dólares pelo simples fato de se tornarem itens de

colecionador, ou seja, se tornam objeto de disputa e desejo entre pessoas que não medem esforços para

colocar a mão em um de seus exemplares. Geralmente são excelentes vinhos de fato.
</p>
    
    ';

    protected $keywords = '60, 60 reais, ate 60';

    protected $slug = 'por-preco-ate-60';

    public $parent_breadcrumb;

    public $banner_image_url;

    public function __construct()
    {
        parent::__construct();

        $this-> banner_image_url = asset_web('images/bg-por-preco.jpg');
        $this->parent_breadcrumb = new stdClass();
        $this->parent_breadcrumb->url = '#';
        $this->parent_breadcrumb->title = 'Por Preços';
    }

    public function getTemplate()
    {
        return app('em')->getReference(Template::class, 7);
    }
    
    public function isSatisfiedBy(ProductInterface $product)
    {

        if ($product->getSalePrice() <= 60) {
            return true;
        }

        return false;
    }
}