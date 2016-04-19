<?php

namespace Vinci\App\Core\Utils;

interface Mask
{
    const PHONE = '8 OU 9 DIGITOS';
    const DOCUMENT = 'CPF OU CNPJ';
    const CPF = '###.###.###-##';
    const CNPJ = '##.###.###/####-##';
    const POSTAL_CODE = '#####-###';
    const MAC = '##:##:##:##:##:##';
}