<?php

namespace Vinci\App\Website\Http\Region;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
use Vinci\Domain\Region\RegionRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class RegionController extends BaseTaxonomyController
{

    private $regionRepository;

    public function __construct(
        EntityManagerInterface $em,
        RegionRepository $regionRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->regionRepository = $regionRepository;
    }

    public function show($slug, Request $request)
    {
        $region = $this->getRegion($slug);

        $filters = [
            'regiao' => [$region->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('region.index', compact('region', 'result'));
    }

    public function index(Request $request)
    {
        $regions = new TaxonomyCollection($this->regionRepository->getAll());

        $pageDescription = '
           
  <p>       Uma das principais características e vantagens no mundo do vinho é a <strong>enorme variedade e diversidade de

estilos, tipos e denominações</strong> encontradas. Isso se deve, em especial, às inúmeras regiões vinícolas situadas ao

redor do globo, possibilitando que o amante do mundo vinícola experimente vinhos produzidos em diferentes

regiões, tornando-se assim, um “consumidor cosmopolita”.</p>

<p>

Apesar das singularidades encontradas em vinhos de cada região, existem particularidades que os “conectam”, ou

seja, exemplares conhecidos também como vinhos do Novo Mundo e do Velho Mundo. Essas duas expressões

aparecem com elevada frequência no universo vinícola e possuem significados diferentes.
</p>
<p>
As <strong>regiões do Velho Mundo situam-se em países da Europa</strong>, principalmente, países que se especializaram na

cultura vinícola ao longo dos anos e recebem amplo prestígio e notoriedade nos dias de hoje, como Portugal, Itália,

França e Espanha, por exemplo.
</p>
<p>

Já o <strong>Novo Mundo é representado por países mais jovens</strong>, especialmente, os que foram colonizados por

europeus, e países que se especializaram na vitivinicultura recentemente, como os Estados Unidos, Austrália,

Argentina, Chile, Nova Zelândia e África do Sul.
</p>

<p>
Contudo, tanto no Velho quanto no Novo Mundo, encontram-se <strong>regiões vinícolas que produzem vinhos de

excelente qualidade</strong>, que agradam a diferentes paladares. Quando alguém se refere a rótulos do Velho Mundo,

possui como objetivo atribuir singularidades e características que se relacionam com a tradição. Isto é, os

exemplares são elaborados com base em conceitos e práticas passadas de geração para geração ao longo do

tempo. Para os produtores do Velho Mundo, o principal objetivo está em encontrar a especificidade e singularidade

do terroir, denotando tais características aos vinhos.
</p>
<p>
Entre os países europeus de maior prestígio no mundo do vinho, algumas regiões merecem destaque. A região

portuguesa do Douro é o lar do tradicional vinho do Porto e de excelentes vinhos não fortificados, enquanto na

Itália, Piemonte é a região que dá origem a vinhos bastante finos e famosos, tais como os prestigiados Barolo,

Barbaresco e Barbera d’Asti. Na França, a região francesa que recebe amplo prestígio perante o mundo do vinho é

Bordeaux, uma das áreas mais prolíferas da Europa, graças aos vinhos com excelente qualidade e finesse que

elabora.
</p>
<p>

Já os vinhos do Novo Mundo apresentam um estilo mais flexível que, no entanto, não deixam de ser vinhos de alta

qualidade. Os produtores dessa região utilizam alta tecnologia, a fim de chegar nas condições de cultivo ideal das

uvas e, assim, bons exemplares. As práticas de vinificação são mais flexíveis porque não necessitam ser baseadas

em tradições, fazendo com que os produtores se adaptem ao cultivo de determinada casta em diferentes regiões.

Nos Estados Unidos, uma região vinícola que merece destaque é a Califórnia, que oferece diferentes características

geográficas e climáticas, proporcionando aos produtores e enólogos terroirs complexos e singulares. Já na

Argentina, a região de Mendoza é a de maior prestígio, dando origem a excelentes vinhos com a uva francesa

Malbec, considerado vinhos tintos de grande concentração e intensidade.
</p>
<p>

A região australiana de McLaren Vale é, tradicionalmente, conhecida pela ampla diversidade de castas cultivadas,

onde os melhores vinhos são elaborados a partir de vinhas antigas. Na Nova Zelândia, uma das regiões vinícolas

mais importantes é Marlborough, particularmente famosa pelos excelentes e picantes vinhos Sauvignon Blanc. Por

fim, Stellenbosch, na África do Sul, é a região com ampla notoriedade no cultivo da uva Cabernet Sauvignon, dando

origem a vinhos que, muitas vezes, são comparados aos bons exemplares de Bordeaux.
</p>
<p>

Aqui na Vinci, você encontra uma <strong>seleção com os melhores vinhos produzidos no mundo</strong>, entre os melhores

produtores e regiões vinícolas. A ampla variedade de regiões concentrada no catálogo da Vinci encontra-se listada

em ordem alfabética logo abaixo. Confira!
</p>';

        return $this->view('layouts.pages.list')
                    ->with([
                        'metaTitle' => 'Os maiores vinhos das principais regiões vinícolas do mundo - Vinci',
                        'metaDescription' => $pageDescription,
                        'resources' => $regions,
                        'resourceType' => 'region',
                        'pageTitle' => 'Vinhos por região',
                        'pageDescription' => $pageDescription,
                        'template' => 'template2',
                        'imageTitle' => 'bg-regiao.jpg'
                    ]);
    }

    protected function getRegion($slug)
    {
        $country = $this->regionRepository->getOneBySlug($slug);

        $country = $this->presenter->model($country, RegionPresenter::class);

        return $country;
    }

}