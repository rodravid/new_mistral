<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cri="http://xmlns.oracle.com/orawsv/WSGW/CRIAPESSOA">
    <soapenv:Header/>
    <soapenv:Body>
        <cri:CRIAPESSOAInput>
            @foreach($data as $key => $value)
                <cri:{{ $key }}>{!! $value !!}</cri:{{ $key }}>
            @endforeach
        </cri:CRIAPESSOAInput>
    </soapenv:Body>
</soapenv:Envelope>