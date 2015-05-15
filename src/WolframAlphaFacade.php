<?php namespace ConnorVG\WolframAlpha;

class WolframAlphaFacade extends \Illuminate\Support\Facades\Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'wolframalpha'; }

}
