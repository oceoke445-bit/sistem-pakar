<?php

namespace App\Support;

use Illuminate\Http\Response;

class WordMhtmlExporter
{
    /**
     * @param  array<string, string>  $embeds  Content-ID (tanpa <>) => absolute path file gambar
     */
    public static function download(string $html, string $filename, array $embeds = []): Response
    {
        $boundary = '----=_NextPart_'.bin2hex(random_bytes(8));
        $parts = '';

        $parts .= '--'.$boundary."\r\n";
        $parts .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
        $parts .= "Content-Transfer-Encoding: 8bit\r\n";
        $parts .= "Content-Location: file:///C:/export/doc.htm\r\n\r\n";
        $parts .= $html."\r\n";

        foreach ($embeds as $cid => $path) {
            if (! is_file($path)) {
                continue;
            }
            $binary = (string) file_get_contents($path);
            if ($binary === '') {
                continue;
            }
            $parts .= '--'.$boundary."\r\n";
            $parts .= "Content-Type: image/png\r\n";
            $parts .= "Content-Transfer-Encoding: base64\r\n";
            $parts .= 'Content-ID: <'.$cid.">\r\n";
            $parts .= 'Content-Location: '.$cid."\r\n\r\n";
            $parts .= chunk_split(base64_encode($binary))."\r\n";
        }

        $parts .= '--'.$boundary."--\r\n";

        $body = "MIME-Version: 1.0\r\n";
        $body .= 'Content-Type: multipart/related; boundary="'.$boundary."\"\r\n\r\n";
        $body .= $parts;

        return response("\xEF\xBB\xBF".$body, 200, [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
