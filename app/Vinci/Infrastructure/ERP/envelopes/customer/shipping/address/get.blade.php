<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:get="http://xmlns.oracle.com/orawsv/WSGW/GETENDERENTREGACLIENTE">
    <soapenv:Header/>
    <soapenv:Body>
        <get:GETENDERENTREGACLIENTEInput>
            @foreach($data as $key => $value)
                <get:{{ $key }}>{!! $value !!}</get:{{ $key }}>
            @endforeach
        </get:GETENDERENTREGACLIENTEInput>
    </soapenv:Body>
</soapenv:Envelope>