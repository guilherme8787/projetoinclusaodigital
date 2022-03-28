<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dusterio\LinkPreview\Client;
use App\Models\Thumb;

class LinkPreview extends Controller
{

    public function fileGetByUrl($url){
        $arrContextOptions = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.109 Safari/537.36 OPR/84.0.4316.42"
            )
        ); 
        return file_get_contents($url, false, stream_context_create($arrContextOptions));
    }
    public function get(Request $request){ 

        if($request->filled('url')){

            $url_de_busca = null;
            $url_de_opcao = null;
            $url_explodido = explode('https://', $request->get('url'));
            foreach($url_explodido as $url){
                if(str_contains($url, 'play.google.com')){
                    $url_de_busca = 'https://'.$url;
                } else {
                    if(!empty($url)){
                        $url_de_opcao = 'https://'.$url;
                    }
                }
            }

            if($url_de_opcao == null && $url_de_busca != null){
                $url_request = $url_de_busca;
            } else if($url_de_busca == null && $url_de_opcao != null) {
                $url_request = $url_de_opcao;
            } else if($url_de_busca != null && $url_de_opcao != null) {
                $url_request = $url_de_busca;
            } else {
                $url_request = $request->get('url');
            }

            $url_request = str_replace('https://http://', 'http://', $url_request);

            if(str_contains($url, 'wikipedia')){
                $url_request = 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Wikipedia-logo-v2-pt.svg/892px-Wikipedia-logo-v2-pt.svg.png';
            }

            if(str_contains($url, 'youtube')){
                if(!str_contains($url, 'youtube.kids')){
                    $url_request = 'https://inclusaodigitalnasescolas.com.br/storage/img/youtube.png';
                }
            }

            if(str_contains($url, 'pixabay')){
                $url_request = 'https://cdn.pixabay.com/photo/2017/01/17/14/44/pixabay-1987090_1280.png';
            }


            $thumbArray = Thumb::where('url', $url_request)->get()->toArray();
            if($thumbArray == null){
                $previewClient = new Client($url_request);
                $previews = $previewClient->getPreviews();
                $preview = $previewClient->getPreview('general');
                $preview = $preview->toArray();
                if(empty($preview['cover'])){
                    if(is_array($preview['images'])){
                        if(isset($preview['images'][0])){
                            $contents = $this->fileGetByUrl($preview['images'][0]);
                        } else {
                            $contents = false;
                        }
                    } else {
                        if(isset($preview['images'])){
                            $contents = $this->fileGetByUrl($preview['images']);
                        } else {
                            $contents = false;
                        }
                    }
                } else {
                    if(isset($preview['cover'])){
                        $contents = $this->fileGetByUrl($preview['cover']);
                    } else {
                        $contents = false;
                    }
                }
                if($contents == false){
                    $contents = $this->fileGetByUrl('https://inclusaodigitalnasescolas.com.br/storage/img/nothuhmbpng.png');
                } else {
                    Thumb::insert([
                        'url' => $url_request,
                        'file_contents' => bin2hex($contents)
                    ]);
                }
                $expires = 14 * 60*60*24;
                header("Content-Type: image/jpeg");
                header("Content-Length: " . strlen($contents));
                header("Cache-Control: public", true);
                header("Pragma: public", true);
                header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);
                echo $contents;
                exit;
            } else {
                $contents = hex2bin($thumbArray[0]['file_contents']);
                $expires = 14 * 60*60*24;
                header("Content-Type: image/jpeg");
                header("Content-Length: " . strlen($contents));
                header("Cache-Control: public", true);
                header("Pragma: public", true);
                header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);
                echo $contents;
            }
        } else {
            return response()->json(['404']);
        }
    }
}

