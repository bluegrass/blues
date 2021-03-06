<?php

namespace Bluegrass\Blues\Component\Widget\FilterableMenu\Model;

use Bluegrass\Blues\Component\Menu\MenuItemIteratorInterface;

class FilterableMenuItemIterator extends \RecursiveFilterIterator implements MenuItemIteratorInterface
{
    protected $filterPattern;

    public function getFilterPattern()
    {
        return trim( $this->filterPattern );
    }

    public function setFilterPattern($filterPattern)
    {
        $this->filterPattern = $filterPattern;
    }
    
    public function hasChildren()
    {
        // La estructura ya está aplanada, por lo tanto a cada resultado filtrado, no va a tener hijos
        return false;
    }
    
    public function accept() 
    {        
        // Aceptar el elemento actual si podemos utilizar la recursión en este
        // o este valor empieza con "test"
        
        if ( $this->getFilterPattern() == "" ){
            return true;
        }else{
            
            $normalize = function ($string) {
                $table = array(
                    'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
                    'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                    'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
                    'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
                    'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
                    'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
                    'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
                    'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
                );

                return strtr($string, $table);
            };        
            
            $accept = stripos( $normalize( $this->current()->getLabel() ), $normalize( $this->getFilterPattern() ) ) !== false;
            return $accept;            
        }
    }    
}

