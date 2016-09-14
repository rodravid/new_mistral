<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Template\Template;

class HalfBottle extends StaticShowcase
{

    protected $id = '-1';

    protected $title = 'Meias garrafas';

    protected $description = '
 <p>   Várias histórias existem a respeito da quantidade de vinho encontrada em uma garrafa de vinho tradicional,

isto é, as que possuem 750 ml. Alguns afirmam que era o tamanho que o vidraceiro conseguia fazer a partir de

um único sopro, enquanto outros afirmam que é a quantidade ideal para que duas pessoas degustem o

exemplar da melhor maneira.</p>
<p>

No entanto, para algumas ocasiões, as mini e meias garrafas – com 375 ml – acabam sendo uma opção ideal

ao invés de uma garrafa inteira. Sinônimo de praticidade e elegância, as meias garrafas são excelentes para

ocasiões onde você irá degustar sozinho ou, até mesmo, acompanhado de outra pessoa que deseja apenas uma

única taça do vinho.
</p>

<p>

<strong>Além de extremamente práticas e charmosas, as meias garrafas apresentam excelente relação entre

qualidade e preço</strong>, isto é, o vinho apresentará a mesma qualidade e singularidade que a garrafa tradicional,

no entanto, com quantidades menores, que refletirá também nos preços.
</p>

<p>

A produção de vinhos é, desde sempre, movida pela necessidade de conservar, armazenar e transportar da

melhor maneira os exemplares, a fim de que o recipiente seja capaz de mantê-lo em boas condições e

conservar suas características únicas e marcantes.
</p>

<p>

<strong>Antes da invenção das garrafas de vidro, os vinhos eram guardados e transportados em ânforas de

barro</strong>, as quais eram fechadas com a espécie de um lacre. Durante o século XVII, os vinhos na Itália eram

armazenados em garrafas de vidro.
</p>

<p>
No entanto, tais garrafas eram frágeis e necessitavam ser envoltas em palha a fim de evitar que quebrassem,

fazendo com que nascessem as tradicionais garrafas de Chianti, utilizadas até hoje. Por volta de 1630, os

ingleses introduziram as garrafas de vidro mais resistentes, período em que o vinho deixou de ser uma bebida

exclusiva apenas de algumas regiões produtoras e sim, difundiu-se para o mundo inteiro.
</p>
<p>
O formato que as garrafas apresentam é modelado para que as mesmas sejam apropriadas para a

armazenagem e serviço do vinho da melhor maneira. <strong>Cada garrafa é formada por uma base, bojo, ombro

pescoço e gargalo.</strong>
</p>
<p>
A base possui, comumente, um formato côncavo com uma útil função, ou seja, tal formato é utilizado na

decantação de vinhos que que apresentam uma provável formação de borras. A maneira que a garrafa é

armazenada verticalmente, os sedimentos se depositarão ao longo do formato côncavo na base da garrafa e,

dificilmente, voltarão em suspensão.
</p>
<p>
Já o bojo é a principal parte da garrafa, a área onde se manuseia para dar início ao serviço, bem como o ombro

– ambos são importantes durante o manuseio da mesma. O ombro servirá também como uma barreira contra

as borras depositadas ao fundo da garrafa; quanto mais ressaltado, mais difícil sair a borra da garrafa.
</p>
<p>
O pescoço é a parte onde o ombro começa a afinar, favorecendo o escoamento do líquido. Por fim, o gargalo é

a última parte da garrafa, responsável por adicionar maior estrutura e força na região onde a rolha será

alojada.
</p>

<p>

Com base nessas “principais características”, foram surgindo inúmeros formatos de garrafa de vinho que

variam, na maioria das vezes, em cada região vinícola, dependendo do tipo de vinho produzido e da variedade

de uva utilizada. Entre elas, encontram-se as mini e meias garrafas.
</p>

<p>

Aqui na Vinci você encontra excelentes vinhos em garrafas e em mini e meias garrafas, exemplares que visam

proporcionar uma melhor experiência para aqueles que desejam degustar um bom vinho sozinho ou, até

mesmo, acompanhado por quem bebe um pouco menos. Descubra!
</p>    
    ';

    protected $keywords = '375 ml, 187 ml, meia, meias, meias garrafas, meia garrafa';

    protected $slug = 'meias-garrafas';

    public $banner_image_url;

    public function __construct()
    {
        parent::__construct();
        
        $this->banner_image_url = asset_web('images/bg-meia-garrafa.jpg');
    }
    
    public function getTemplate()
    {
        return app('em')->getReference(Template::class, 12);
    }
    
    public function isSatisfiedBy(ProductInterface $product)
    {
        return $product->isWine() && $product->isHalfBottle();
    }
}