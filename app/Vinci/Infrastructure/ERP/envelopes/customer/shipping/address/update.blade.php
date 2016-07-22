<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:atu="http://xmlns.oracle.com/orawsv/WSGW/ATUALIZAENDERENTREGACLIENTE">
    <soapenv:Header/>
    <soapenv:Body>
        <atu:ATUALIZAENDERENTREGACLIENTEInput>
            @foreach($data as $key => $value)
                <atu:{{ $key }}>{!! $value !!}</atu:{{ $key }}>
            @endforeach
        </atu:ATUALIZAENDERENTREGACLIENTEInput>
    </soapenv:Body>
</soapenv:Envelope>