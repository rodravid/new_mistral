<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cri="http://xmlns.oracle.com/orawsv/WSGW/CRIAPEDIDO">
    <soapenv:Header/>
    <soapenv:Body>
        <cri:CRIAPEDIDOInput>
            @foreach($data as $key => $value)
                <cri:{{ $key }}>{!! $value !!}</cri:{{ $key }}>
            @endforeach
        </cri:CRIAPEDIDOInput>
    </soapenv:Body>
</soapenv:Envelope>