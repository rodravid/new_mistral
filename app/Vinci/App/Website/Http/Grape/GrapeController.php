<?php

namespace Vinci\App\Website\Http\Grape;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
use Vinci\Domain\Grape\GrapeRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class GrapeController extends BaseTaxonomyController
{

    private $grapeRepository;

    public function __construct(
        EntityManagerInterface $em,
        GrapeRepository $grapeRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->grapeRepository = $grapeRepository;
    }

    public function show($slug, Request $request)
    {
        $grape = $this->getGrape($slug);

        $filters = [
            'tipo-de-uva' => [$grape->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['pais', 'regiao', 'produtor', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('grape.index', compact('grape', 'result'));
    }

    public function index(Request $request)
    {
        $grapes = new TaxonomyCollection($this->grapeRepository->getAll());

        $grapes = $grapes->filter(function ($grape) {
            return ! in_array($grape->getName(), ['Acessório', 'Embalagem']);
        });

        $pageDescription = '
   
  <p> As Vitis vinifera são as variedades de uva utilizadas na elaboração de vinhos ao redor do mundo. Algumas castas ou

cepas – como também são conhecidas – se tornaram um <strong>ícone na cultura vinícola e produzem excelentes

vinhos</strong> em inúmeras regiões.
</p>
<p>

As uvas de mesa, como a variedade denominada Isabel, por exemplo, servem apenas na elaboração de receitas e

sucos. No entanto, também se produzem vinhos a partir dessas uvas, isto é, exemplares mais simples, conhecidos

como vinhos de mesa.
</p>

<p>

Uma das principais diferenças entre as uvas de mesa e as Vitis vinifera é o tamanho e a espessura das cascas, visto

que a pele das variedades proporciona aos vinhos características únicas e marcantes. Assim como a coloração e a

qualidade – principais fatores que as uvas adicionam aos vinhos – essa proporção é ótima para a produção.
</p>
<p>

Algumas <strong>castas recebem ampla notoriedade ao redor do mundo</strong>, como é o caso das uvas tintas Cabernet

Sauvignon, Cabernet Franc, Merlot, Pinot Noir, Syrah, Nebbiolo, Sangiovese, Grenache, Barbera, Malbec, Baga,

Pinotage, Tannat, Montepulciano e Zinfandel.
</p>
<p>
Além, é claro, das variedades brancas Chardonnay, Riesling, Sauvignon Blanc, Muscadet, Trebbiano, Grüner

Veltliner, Gewürztraminer, Alvarinho/Albariño, Pinot Grigio, Viogner, Sémillon, Chenin Blanc, Muscat, Pinot Blanc e

Torrontés, que desempenham um papel importante no universo dos vinhos.
</p>
<p>

Algumas castas, como já citadas acima, tornaram-se <strong>internacionalmente famosas</strong>, isto é, se adaptaram com

facilidade em diferentes regiões, enquanto outras são <strong>típicas de uma área específica</strong> e relacionadas

intrinsicamente com o terroir de origem.
</p>
<p>

A variedade com que se produz o vinho é um conceito importante em regiões do Novo Mundo, bem como o

surgimento de vinhos varietais, isto é, <strong>exemplares que indicam claramente no rótulo o nome da uva com

que são elaborados.</strong>
</p>
<p>

Com o “surgimento” do Novo Mundo, as regiões não possuíam longa história e tradição no universo dos vinhos que

pudesse ser inserido no rótulo do exemplar, como a indicação geográfica, por exemplo. A partir dessa premissa, os

produtores começaram a rotular os vinhos de acordo com as uvas utilizadas na composição. Isto é, os varietais

utilizam apenas uma uva, mas existem também os vinhos de corte, quando o produtor opta por utilizar duas ou

mais variedades.
</p>
<p>

<strong>Os vinhos varietais tornaram-se uma parcela extremamente importante na cultura vinícola do Novo

Mundo</strong>. Em regiões do Velho Mundo também se encontram exemplares elaborados apenas com uma variedade,

como por exemplo, os vinhos de Borgonha, que, no entanto, não são considerados como varietais. Geralmente, os

vinhos europeus são rotulados apenas com o nome da denominação de origem e não com o nome da casta.
</p>
<p>

Grande parte dos consumidores acha mais fácil escolher um vinho quando o nome da casta aparece especificado no

rótulo. Contudo, vinhos elaborados com a mesma uva podem apresentar <strong>diferentes características e

singularidades</strong>, dependendo do produtor e da região onde a variedade é cultivada.
</p>
<p>

Utilize essa seção disponibilizada pela Vinci para encontrar vinhos produzidos com uma casta específica ou então,

com uma combinação de uvas. Além disso, clique na uva desejada para descobrir mais sobre ela. Aqui na Vinci você

encontra uma diversa variedade de uvas icônicas no universo do vinho. Descubra!
</p>
        
        ';

        return $this->view('layouts.pages.list')
            ->with([
                'metaTitle' => 'Encontre o tipo de uva ideal para cada ocasião - Vinci',
                'metaDescription' => $pageDescription,
                'resources' => $grapes,
                'resourceType' => 'grape',
                'pageTitle' => 'Tipos de Uva',
                'pageDescription' => $pageDescription,
                'template' => 'template5',
                'imageTitle' => 'bg-tipo-uva.jpg'
            ]);
    }

    protected function getGrape($slug)
    {
        $grape = $this->grapeRepository->getOneBySlug($slug);

        $grape = $this->presenter->model($grape, GrapePresenter::class);

        return $grape;
    }

}