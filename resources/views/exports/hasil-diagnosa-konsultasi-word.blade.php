<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
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
            <w:DisplayHorizontalDrawingGridEvery>0</w:DisplayHorizontalDrawingGridEvery>
            <w:DisplayVerticalDrawingGridEvery>0</w:DisplayVerticalDrawingGridEvery>
        </w:WordDocument>
    </xml>
    <![endif]-->
    @include('exports.partials.word-mso-head')
    <style>
        @page Section1 { size: 595.3pt 841.9pt; margin: 42.5pt 49.6pt 42.5pt 49.6pt; }
        div.Section1 { page: Section1; }
        body { margin: 0; padding: 0; background: #ffffff; font-family: Calibri, Arial, sans-serif; font-size: 11pt; color: #334155; }
        table, td, th, tr {
            border: 0pt none windowtext !important;
            border-collapse: collapse;
            mso-border-alt: none !important;
        }
        img { border: 0 !important; }
        p { margin: 0; }
    </style>
</head>
<body>
    <div class="Section1" style="font-family:Calibri,Arial,sans-serif;font-size:11pt;color:#334155;">
        @include('exports.partials.konsultasi-hasil-word-body')
    </div>
</body>
</html>
