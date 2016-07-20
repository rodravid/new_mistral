<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cri="http://xmlns.oracle.com/orawsv/WSGW/CRIAPEDIDOITEM">
    <soapenv:Header/>
    <soapenv:Body>
        <cri:CRIAPEDIDOITEMInput>
            @foreach($data as $key => $value)
                <cri:{{ $key }}>{!! $value !!}</cri:{{ $key }}>
            @endforeach
        </cri:CRIAPEDIDOITEMInput>
    </soapenv:Body>
</soapenv:Envelope>