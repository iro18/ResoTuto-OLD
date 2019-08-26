<?php 

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('iframetuto', [$this, 'IframedTuto']),
        ];
    }

    public function IframedTuto($url)
    {
        if(preg_match("#watch\?v=([^/. ]{11})#", $url ,$test)){
            $id=$test[1];
        }
        else{
            return "Erreur";
        }
        
        return '<iframe src="https://www.youtube.com/embed/'.$id.'" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
    }
}
?>