<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="utf-8">
    <meta name="ProgId" content="Word.Document">
    <meta name="Generator" content="Microsoft Word 15">
    <title>Hasil Diagnosa #{{ $d->id }}</title>
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
            <w:ValidateAgainstSchemas/>
            <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
            <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
            <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
            <w:Compatibility>
                <w:BreakWrappedTables/>
                <w:SnapToGridInCell/>
                <w:WrapTextWithPunct/>
                <w:UseAsianBreakRules/>
            </w:Compatibility>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        @page Section1 {
            size: 595.3pt 841.9pt;
            margin: 42.5pt 49.6pt 42.5pt 49.6pt;
        }
        div.Section1 { page: Section1; }
        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: Calibri, Arial, sans-serif;
            font-size: 11pt;
            color: #334155;
        }
        table { border-collapse: collapse; }
        p { margin: 0; }
        img { border: 0; }
    </style>
</head>
<body>
    <div class="Section1">
        @include('exports.partials.hasil-diagnosa-word-body')
    </div>
</body>
</html>
