<?php 

namespace App\Context\Monetary;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Datetime;

/**
 * summary
 */
class Formatter
{
    /**
     * summary
     */
    public function __construct()
    {
        
    }

    public static function realmonetary( $value ) {
		
    	$value = new Money($value, new Currency('BRL'));
		$numformatter = new \NumberFormatter(
			'pt_BR', 
			\NumberFormatter::CURRENCY
		);
		$formatter = new IntlMoneyFormatter(
			$numformatter, 
			new ISOCurrencies()
		);

		return $formatter->format($value);
    }

    public static function stringToMoney( $value ) {
        //corrigindo vígula/ponto
        
        $valor = preg_replace('/\,/','', $value);
        $valor = preg_replace('/\./','', $valor);
        $valor = preg_replace('/R\$/','', $valor);
        $valor = preg_replace('/\s+/','', $valor);
        $valor = preg_replace('/\xc2\xa0/','', $valor);
        return intval($valor);
    }


    public static function dataformat( $value ) {
    	$data = new Datetime($value);
    	return $data->format('d/M/Y');
    }

    public static function dataFromView( $value) {
        $months = [
            'Jan', 'Feb', 'Mar',
            'Apr', 'May', 'July',
            'Aug', 'Sep', 'Oct',
            'Nov', 'Dec' 
        ];

        $data = explode ('/', $value);
        $string = $data[2] . '-' . $data[1] . '-' . $data[0];
        foreach ($data as $d) {
            if (in_array($d, $months)) {
                $nova_data = new Datetime($string);
                return $nova_data;
            }
        }


        return new Datetime($string);

    }


}


