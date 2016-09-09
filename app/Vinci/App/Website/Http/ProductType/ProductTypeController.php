<?php

namespace Vinci\App\Website\Http\ProductType;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
use Vinci\Domain\ProductType\ProductTypeRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class ProductTypeController extends BaseTaxonomyController
{

    private $productTypeRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProductTypeRepository $productTypeRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->productTypeRepository = $productTypeRepository;
    }

    public function show($slug, Request $request)
    {
        $productType = $this->getProductType($slug);

        $filters = [
            'tipo-de-vinho' => [$productType->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['pais', 'regiao', 'produtor', 'tipo-de-uva', 'tamanho', 'preco']);

        return $this->view('product-type.index', compact('productType', 'result'));
    }

    public function index(Request $request)
    {
        $productsType = new TaxonomyCollection($this->productTypeRepository->getAll());

        $productsType = $productsType->filter(function ($productType) {
            return ! in_array($productType->getName(), ['Acessório', 'Embalagem', 'Kits', 'Outros']);
        });

        $pageDescription = '
   <p>     Qual a diferença entre vinhos tintos e brancos? E os rosé, porque têm esse nome? Porto, Madeira,

Marsala, Jerez, existe diferença entre eles? Quantos tipos de vinhos existem? Antes de escolher o seu

vinho, reserve um tempo para conhecer alguns detalhes que poderão ser uteis no momento de

desvendar segredos dessa bebida sublime.</p>

<p>

Antigamente, um bom <strong>vinho tinto</strong> demorava alguns anos para ficar pronto e no ponto correto de ser

bebido. Quando ainda muito jovem, era normalmente muito tânico, duro, difícil de agradar. Hoje em dia,

graças aos avanços da enologia, a maioria já pode ser bebida logo que chega ao mercado. Mas isso não

muda o fato de que os melhores vinhos tintos continuam evoluindo por anos na garrafa.
</p>

<p>

Os tintos mais leves, como os <strong>italianos Bardolino e Valpolicella</strong> e os chilenos mais simples, não ganham

nada sendo guardados na garrafa. O melhor é consumi-los logo que são lancados. Porém, isso não quer

dizer que eles não possam ser guardados durante uns 4 ou 5 anos. Os tintos de corpo médio ficam

melhor se guardados até uns quatro anos após a colheita e depois de conservam bem por mais uns dois

ou três anos. Já os grandes tintos, como os Barolo e Bordeaux, por exemplo, ficam excelentes se

guardados por uns oito ou dez anos. Depois, os das melhores safras podem ser conservados por mais

uns cinco ou dez anos. Mas tudo isso só é válido quando o vinho é conservado da maneira correta, com

as garrafas mantidas na posição horizontal, num local escuro e com temperatura inferior a 18° ou 20° C.

Se armazenados a 25° C duram a metade do tempo.
</p>

<p>

Já a maioria dos <strong>vinhos brancos</strong> pode ser bebida logo que chega ao mercado e não precisa envelhecer,

ou melhor, não melhora com o tempo. Os brancos mais simples, como o italiano Francati, o Salvignon

Blanc chileno ou a maior parte dos brancos nacionais, duram bem uns dois ou três anos após a colheita.

Os que têm mais acidez e maior teor alcoólico duram mais.
</p>

<p>

Já os grandes vinhos brancos, principalmente os elaborados com as <strong>uvas Chardonnay, Riesling e Chenin

Blanc</strong>, melhoram bastante com o envelhecimento em garrafa. Os melhores Borgonha brancos e os

melhores Riesling alemães ou alsacianos costumam melhorar por até dez anos, desde que bem

conservados, é claro.
</p>

<p>

Muita gente acredita que os <strong>vinhos rosé</strong> são, simplesmente, a mistura de um vinho tinto e branco. Isso,

inclusive é proibido na maioria dos países produtores. O melhor método de produção é aquele em que as

uvas tintas são prensadas e a fermentação alccolica é feita no mosto em presença das cascas. Após

dezoito a vinte quatro horas, as cascas são retiradas e o mosto continua a fermentar como se fosse um

vinho branco. O resultado em um rosé de bela coloração, bastante aromático. Os rosés geralmente são

envelhecidos em barricas de carvalho porque são mais leves, feitos para serem bebidos jovens.

Os melhores vinhos rosé são aromáticos e muito charmosos, combinando bem com pratos da cozinha

mediterrânea. O mais famoso da França é o ótimo Tavel, produzido no sul da região do Rhône. Há

também o Resé d’Anjou, mais simples e informal, produzido no vale do rio Loire. Na Itália, são

denominados Rosato e, embora não tenham tanta projeção, um deles se destaca como um dos melhores

do mundo. Na Toscana os melhores rosados são acompanhamento perfeito para massa ao molho

vermelho e carnes grelhadas.
</p>

<p>

Para produzir <strong>vinhos secos</strong> utilizam-se uvas maduras que são colocadas para fermentar até que

praticamente todo o açúcar se transforme em álcool. É o processo mais natural e simples de produzir

vinho.
</p>

<p>

Existem basicamente duas formas de produzir <strong>vinhos doces</strong>, com uvas supermaduras ou pela adição de

álcool para interromper a fermentação. Quando se adiciona álcool, consegue-se o chamado vinho doce

natural, como o francês Muscat de Beaumes de Venise. Mas os melhores vinhos doces são produzidos

mesmo com as uvas com alta concentração de açúcar.
</p>

<p>

Todo vinho é produzido pela fermentação das uvas, que transforma o açúcar da uva em álcool. E nesse

processo acontece a liberação de gás carbônico, que normalmente se perde na atmosfera porque a

fermentação acontece em tanques ou toneis abertos. Entretanto, se o gás for aprisionado no líquido,

temos <strong>vinhos espumantes</strong>!
</p>

<p>

Existem duas maneiras de segurar o gás. A melhor é a utilizada na produção do champagne e outros

espumantes finos. Primeiro se produz e engarrafa um vinho branco normal, depois se coloca um pouco

de açúcar e fermento dentro da garrafa, arrolha-se e as garrafas são guardadas. Com isso, uma nova

fermentação começa dentro da garrafa. A outra forma consiste em produzir um vinho branco normal e

depois adicionara mistura de açúcar e fermento dentro do tanque, hermeticamente fechado, onde

começa a segunda fermentação.
</p>
        
        ';

        return $this->view('layouts.pages.list')
                    ->with([
                        'metaTitle' => 'Encontre o tipo de vinho ideal para cada ocasião - Vinci',
                        'metaDescription' => $pageDescription,
                        'resources' => $productsType,
                        'resourceType' => 'product-type',
                        'pageTitle' => 'Tipos de vinho',
                        'pageDescription' => $pageDescription,
                        'template' => 'template4',
                        'imageTitle' => 'bg-tipo-vinho.jpg'
                    ]);
    }

    protected function getProductType($slug)
    {
        $productType = $this->productTypeRepository->getOneBySlug($slug);

        $productType = $this->presenter->model($productType, ProductTypePresenter::class);

        return $productType;
    }

}