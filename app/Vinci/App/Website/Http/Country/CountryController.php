<?php

namespace Vinci\App\Website\Http\Country;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
use Vinci\Domain\Country\CountryRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class CountryController extends BaseTaxonomyController
{

    private $countryRepository;

    public function __construct(
        EntityManagerInterface $em,
        CountryRepository $countryRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->countryRepository = $countryRepository;
    }

    public function show($slug, Request $request)
    {
        $country = $this->getCountry($slug);

        $filters = [
            'pais' => [$country->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['regiao', 'produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('country.index', compact('country', 'result'));
    }

    public function index(Request $request)
    {
        $countries = new TaxonomyCollection($this->countryRepository->getAll());

        $countries = $countries->filter(function ($country) {
            return ! in_array($country->getName(), ['Acessórios', 'Embalagens']);
        });

        $pageDescription = ' <p>    A Vinci seleciona sempre os melhores produtores de cada país, para que você encontre sempre os mais

conceituados e premiados vinhos do mundo em nosso catálogo. </p>

<p>

Faça uma verdadeira viagem pelo globo através de nossos vinhos e descubra as diferenças e

peculiaridades de cada país. Para nós, não importa <strong>qual é o país que mais produz vinhos no mundo</strong>, mas

<strong>quem produz os melhores vinhos do mundo</strong>. São mais de 1000 rótulos de vinhos de 15 países diferentes e

mais de 100 vinícolas exclusivas do mais alto nível que você só encontra aqui.
</p>
<p>
<strong>Tratamos com o máximo respeito e carinho nossos vinhos, pois sabemos que cada <i>terroir</i></strong>, cada região e

cada país tem uma história que faz seus vinhos serem o que são. O vinho é tão antigo quanto a

civilização ocidental e sua produção é milenar, muito anterior à escrita, por exemplo. Já nos primeiros

textos da humanidade o vinho já é citado em tábuas de argila escritas pelos sumérios, que contam uma

história semelhante à do dilúvio cristão. Nela, Gilgamesh, o Nóe sumério, teria pago os trabalhadores

que construíram sua arca com cerveja e vinho. Já o Noé da Bíblia, plantou uvas e produziu vinhos, para

comemorar seu sucesso depois do dilúvio. O vinho também tem uma importante participação na

mitologia grega e em lendas persas. Depois, como sabemos, Jesus fez seu primeiro milagre

transformando agua em vinho.

</p>

<p>
É provável que <strong>os fenícios, povo comerciante originário de onde hoje é o Líbano, tenham levado a bebida até

a Grécia, onde ganhou enorme importância</strong> – Dionísio, o deus grego do vinho era o próprio filho de Zeus.

Em Roma, o deus do vinho era Baco e o vinho era a bebida cotidiana destes dois povos, que espalharam

videiras pela região do Mediterrâneo, até a Espanha. No sul da Itália, chamado de Magna Grécia na

antiguidade, a produção de vinhos prosperou tanto que o nome Enótria (terra do vinho) foi também

usado para nomear a região.
</p>

<p>
<strong>Quando os romanos conquistaram a Magna Grécia</strong> e depois a Grécia e todos os países do Mediterrâneo,

levaram o vinho e plantaram videiras. <strong>Incentivaram também os povos bárbaros a plantar videiras e a

produzir vinhos, deixando de lado a vida nômade e adotando o estilo de vida romano</strong>. Foi na época do

Império Romano que começaram os estudos mais sérios sobre uvas, suas plantações e métodos de

produção dos vinhos que, junto da azeitona e seus derivados, formavam a base da alimentação das

civilizações da antiguidade ocidental.
</p>

<p>

A produção de vinhos ganhou força na Europa ao longo da Idade Média e alguns mosteiros começaram a

ser reconhecidos e valorizados como os melhores vinhedos, já que possuíam as melhores videiras e

terras do velho continente.</p>

<p>

<strong>Quando chegou ao Novo Mundo – Américas, Oceania e África do Sul</strong> – os vinhos foram ganhando identidade

própria e ganhou ainda mais força à medida que novas levas de imigrantes europeus chegavam aos

vinhedos, nos séculos XIX e XX. Já em meados do século XX, tais vinhos começaram a ser mais

respeitados internacionalmente, principalmente após a famosa Degustacao de Paris de 1976, quando os

vinhos californianos surpreenderam ao mundo. Logo em seguida, Uruguai, África do Sul, Austrália, Nova

Zelândia, Chile e Argentina, entre outros países, entraram de vez para a lista de melhores produtores do

mundo. Muitas regiões da Europa também surgiram ou se reestabeleceram como produtoras vinícolas,

voltando a entregar ótimos exemplares.</p>'


                            ;

        return $this->view('layouts.pages.list')
                    ->with([
                        'metaTitle' => 'Os melhores vinhos do mundo de cada país - Vinci',
                        'metaDescription' => $pageDescription,
                        'resources' => $countries,
                        'resourceType' => 'country',
                        'pageTitle' => 'Vinhos por país',
                        'pageDescription' => $pageDescription,
                        'template' => 'template1',
                        'imageTitle' => 'bg-pais.png'
                    ]);
    }

    protected function getCountry($slug)
    {
        $country = $this->countryRepository->getOneBySlug($slug);

        $country = $this->presenter->model($country, CountryPresenter::class);

        return $country;
    }

}