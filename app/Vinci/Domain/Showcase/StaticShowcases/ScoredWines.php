<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Template\Template;

class ScoredWines extends StaticShowcase
{

    protected $id = -2;

    protected $title = 'Vinhos pontuados';

    protected $description = '
    
   
 
<p> <strong>A pontuação de vinhos é um tema, de certa forma, complexo e, eventualmente, pode causar alguma confusão.</strong>

Como existem diversos critérios de avaliação e muitas variantes envolvidas: sensibilidade de cada crítico a

determinado tipo de vinho, as características olfativas e gustativas, coloração, origem da uva, tipicidade de cada

região, entre outras, <strong>tudo pode parecer bem subjetivo</strong>.
</p>
<p>
Porém, se existem milhares de tipos de vinho no mundo, cada um deles possui suas especificidades que precisam

ser organizadas por categorias, facilitando a procura do consumidor que tem dúvidas sobre o produto que está

buscando. Nesse momento entendemos a importância do trabalho do crítico enólogo e do sistema de pontuação, já

que ele pode ajudar o comprador nessa busca pelo vinho perfeito, levando em conta determinadas características e

ocasiões em que ele será degustado.
</p>
<p>

<strong>Existem alguns críticos no segmento que são mundialmente conhecidos</strong> por avaliar e pontuar vinhos e, por conta

desse reconhecimento gerado pela sua alta especialização, tem opiniões que servem como guia para os

apreciadores comuns. Atualmente, <strong>os conhecedores com maior credibilidade são Jancis Robinson e Robert Parker.</strong>

Críticos que têm suas opiniões levadas como garantia de qualidade (quando aprovam os exemplares) e servem

como guias aos milhares de consumidores ao redor do mundo.
</p>
<p>
A primeira avalia exemplares do mundo todo e utiliza um sistema de nota que chega até 20 pontos. O segundo,

desenvolveu um sistema inovador de avaliação com um princípio de 100 pontos ostensivamente aceito no

segmento - passando inclusive a ser utilizado por outros especialistas.
</p>

<p>

No sistema de pontos de Parker, os vinhos avaliados começam a ser analisados a partir dos 50 pontos, que servem

como uma base mínima de pontuação. Posteriormente, a análise acrescenta até 5 pontos para visual, 15 para o

olfato, 20 para o paladar e 10 para capacidade de envelhecimento e a qualidade de modo geral. A princípio, todo

vinho avaliado já possui alguma relevância, até mesmo os que possuem pontuação abaixo de 90. Nesse sistema, é

possível dividir as pontuações nas categorias a seguir:
</p>
<p>
<strong>
- 50-59: vinhos com grandes falhas, inaceitáveis (geralmente não entram na lista)
<br>
- 60-69: vinhos com grandes falhas, não recomendáveis (geralmente não entram na lista)
<br>
- 70-79 vinhos com falhas aceitáveis
<br>
- 80-84 vinhos acima da média a bons
<br>
- 85-90 vinhos bons a muito bons
<br>
- 90-94 vinhos superiores a excepcionais
<br>
- 95-100 vinhos referência ou clássicos
</strong>
</p>
<p>
É importante reiterar que a avaliação do vinho, apesar de todos os critérios técnicos e da relevância dos

profissionais para o segmento, não deixa de possuir a subjetividade do gosto pessoal. Dessa forma, os quesitos

avaliados levam mais em conta a qualidade de produção e se tudo está em conformidade do que se espera de um

vinho fabricado em determinada região e com determinada uva. Sendo assim, não precisamos nos tornar reféns de

vinhos com pontuação muito alta: o vinho ideal é aquele que verdadeiramente nos agrada, independente do preço

ou avaliação.
</p>
    ';

    protected $keywords = 'pontuados, vinhos pontuados, pontuado';

    protected $slug = 'vinhos-pontuados';

    public $banner_image_url;

    public function __construct()
    {
        parent::__construct();

        $this->banner_image_url = asset_web('images/bg-pontuados.jpg');
    }

    public function getTemplate()
    {
        return app('em')->getReference(Template::class, 9);
    }
    
    public function isSatisfiedBy(ProductInterface $product)
    {
        return $product->isWine() && $product->hasScores();
    }
}