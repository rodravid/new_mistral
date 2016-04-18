@extends('cms::layouts.master')

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="jumbotron">
                    <div class="container">

                        <div class="hero-unit">
                            <h2>Dicas de senha</h2>
                            <h5>Thiago Del Ré Cavallini, algumas dicas para criar senhas fortes</h5>
                            <span>
                                Uma senha é uma cadeia de caracteres usada para acessar informações ou um computador.
                                Frases de senha são geralmente mais longas que senhas, para segurança adicional,
                                e contêm várias palavras que criam uma frase. As senhas ajudam a impedir que pessoas
                                não autorizadas acessem arquivos, programas e outros recursos. Quando você cria uma
                                senha, ela deve ser forte, o que significa ser difícil de adivinhar ou desvendar.
                                É recomendável usar senhas fortes em todas as contas de usuário no computador. Se
                                você estiver usando uma rede do local de trabalho, o administrador da rede talvez
                                exija o uso de uma senha forte.</span><span>Uma senha é uma cadeia de caracteres
                                usada para acessar informações ou um computador. Frases de senha são geralmente
                                mais longas que senhas, para segurança adicional, e contêm várias palavras que
                                criam uma frase. As senhas ajudam a impedir que pessoas não autorizadas acessem
                                arquivos, programas e outros recursos. Quando você cria uma senha, ela deve ser
                                forte, o que significa ser difícil de adivinhar ou desvendar. É recomendável
                                usar senhas fortes em todas as contas de usuário no computador. Se você estiver
                                usando uma rede do local de trabalho, o administrador da rede talvez exija
                                o uso de uma senha forte.</span>

                            <h5>Observação</h5>
                            <span>Em redes sem fio, uma chave de segurança Wi-Fi Protected Access (WPA) oferece suporte ao uso de senha.
                                Essa senha é convertida em uma chave que é usada para criptografia, que não fica visível para você.
                                Para obter mais informações sobre chaves de segurança WPA, consulte Quais são os diferentes métodos
                                de segurança de rede sem fio?
                            </span>

                            <h5>O que torna uma senha forte?</h5>
                            <p></p>
                            <ul>
                                <li>Tem pelo menos oito caracteres.</li>
                                <li>Não contém seu nome de usuário, seu nome real ou o nome da empresa.</li>
                                <li>Não contém uma palavra completa.</li>
                                <li>É bastante diferente das senhas anteriores.</li>
                                <li>Tem de 20 a 30 caracteres.</li>
                                <li>Contém uma série de palavras que criam uma frase.</li>
                                <li>Não contém frases comuns encontradas na literatura ou em música.</li>
                                <li>Não contém palavras encontradas no dicionário.</li>
                                <li>Não contém seu nome de usuário, seu nome real ou o nome da empresa.</li>
                                <li>É bastante diferente das senhas anteriores.</li>
                            </ul>
                            <p></p>
                            <span>
                                Uma senha pode cumprir todos os critérios acima e ainda ser fraca. Por exemplo,
                                Hello2U! cumpre todos os critérios de uma senha forte listados acima, mas ainda é
                                fraca porque contém uma palavra completa. H3ll0 2 U! é uma alternativa melhor,
                                porque substitui algumas das letras da palavra completa por números e também
                                inclui espaços
                            </span>

                            <h5>Facilite a memorização da sua senha forte, seguindo estas etapas:</h5>
                            <p></p>
                            <ul>
                                <li>Crie uma sigla a partir de uma informação fácil de lembrar. Por exemplo, escolha uma
                                    frase significativa para você, como O aniversário do meu filho é 12 de dezembro de
                                    2004. Usando essa frase como guia, você pode usar Nmfe12/Dez,4 como senha.
                                </li>
                                <li>Substitua números, símbolos e ortografia incorreta por letras ou palavras em uma
                                    frase fácil de lembrar. Por exemplo, O aniversário do meu filho é 12 de dezembro de
                                    2004 pode se tornar AnivM&amp; F1lhOeh 12124, que é uma boa senha.
                                </li>
                                <li>Associe a senha a um hobby ou esporte predileto. Por exemplo, Eu amo jogar badminton
                                    pode ser 4mJo6arB@dm1nt()n.
                                </li>
                                <li>Se você achar que deve anotar a senha para lembrá-la, não a identifique como uma
                                    senha e guarde-a em um lugar seguro.
                                </li>
                            </ul>
                            <p></p>
                            <p><a class="btn btn-primary btn-sm" href="{{ route('cms.profile') }}" role="button">Editar meus dados &raquo;</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection