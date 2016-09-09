<?php

namespace Vinci\App\Website\Http\Producer;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
use Vinci\Domain\Producer\ProducerRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class ProducerController extends BaseTaxonomyController
{

    private $producerRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProducerRepository $producerRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->producerRepository = $producerRepository;
    }

    public function show($slug, Request $request)
    {
        $producer = $this->getProducer($slug);

        $filters = [
            'produtor' => [$producer->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('producer.index', compact('producer', 'result'));
    }

    public function index(Request $request)
    {
        $producers = new TaxonomyCollection($this->producerRepository->getAll());

        $pageDescription = '
  
<p>     
        <strong>A produção mundial de vinhos tem aumentado sensivelmente nos últimos anos</strong> e o surgimento

de novos produtores torna esse mercado ainda mais competitivo, resultando no desenvolvimento de

novas técnicas de cultivo e o investimento em tecnologias que refinam ainda mais os processos

produtivos.
</p>
<p>
Entretanto, <strong>alguns produtores ganharam destaque no mercado por conta da alta qualidade da

produção</strong>, a aliança entre profissionais da rede local, uma gestão corporativa forte e eficiente, além da

criação de uma marca única, forte e de valor, que integre recursos e beneficie a região como um todo.
</p>
<p>

Entre as produtoras do chamado Novo Mundo, designação que engloba vinícolas da América e Oceania,

destaca-se a região de Mendoza e o famoso produtor Catena Zapata, comandada pelo casal Nicolás e

Laura Catena, que graças ao trabalho de identificação e desenvolvimento dos melhores microclimas da

região, ficou conhecido pela produção de seus excelentes Malbec, complexos e altamente estruturados

em seus aromas e sabores.
</p>
<p>

<strong>O Chile também tem ganhado espaço no mercado mundial</strong> graças aos seus tintos ricos e

equilibrados, produzidos principalmente a partir da uva Cabernet Sauvignon, cujo cultivo ocupa mais de

70% das vinhas da região. Produtores como O Fournier, que selecionou as áreas mais interessantes para

o desenvolvimento de vinhas como a região de Lo Abarca, onde a propriedade de 25 hectares está

localizada, produz vinhos de alta qualidade com as variedades Sauvignon Blanc, Cabernet Sauvignon,

Cabernet Franc, Syrah, Merlot e Carignan.
</p>
<p>

Na Oceania, a australiana Gemtree, localizada na região de McLaren, é uma vinícola familiar que possui

um portfólio de alta qualidade, com vinhas certificadamente orgânicas. Exportam para mais de 10

países, entre eles Brasil, Suécia, China e Nova Zelândia.
</p>
<p>

Já nos tradicionais mercados do Velho Mundo, a França e Itália mantêm seu posto como as mais

importantes produtoras do mundo, com seus vinhos grandiosos e consagrados, verdadeiros clássicos

oriundos das videiras de Malbec, Pinot Noire, Chardonnay, Riesling e das castas italianas Nebbiolo,

Sangiovese, Barbera, Aglianico e tantas outras.
</p>
<p>

Localizado no meio da área nobre de Deux-Mers, entre os Dordogne e Garonne, o Château Sainte-Marie

dispõe de uma ampla diversidade no solo onde as vinhas são cultivadas, resultando em frutos com

grande qualidade e constante melhora. A abundante variedade de terroirs prevê a possibilidade de

selecionar criteriosamente quais são verdadeiramente dignas dos grandes vinhos.
</p>
<p>

<strong>Em Piemonte está localizada a vinícola da família Bera</strong>, que produz e engarrafa vinhos desde os

anos 1970, mas possui secular tradição vinícola. Está espalhada por uma área de 30 hectares, dos quais

23 são vinhedos que se estendem também por cidades vizinhas. Mantém o máximo respeito à tradição

da região em todos os processos, o que possibilita a produção de vinhos premiados ao redor do mundo.

Aqui na Vinci você terá acesso a um completo catálogo de vinhos provenientes de respeitados e

premiados produtores nacionais e internacionais. Comercializando vinhos originários desde as

tradicionais e centenárias vinícolas até pequenos fabricantes, a Vinci é criteriosa na escolha de seus

rótulos, garantindo a alta qualidade do estoque disponibilizado.
</p>
        ';

        return $this->view('layouts.pages.list')
                    ->with([
                        'metaTitle' => 'Os maiores produtores de vinho da atualidade - Vinci',
                        'metaDescription' => $pageDescription,
                        'resources' => $producers,
                        'resourceType' => 'producer',
                        'pageTitle' => 'Vinhos por produtor',
                        'pageDescription' => $pageDescription,
                        'template' => 'template3',
                        'imageTitle' => 'bg-produtor.png'
                    ]);
    }

    protected function getProducer($slug)
    {
        $producer = $this->producerRepository->getOneBySlug($slug);

        $producer = $this->presenter->model($producer, ProducerPresenter::class);

        return $producer;
    }

}