<?php namespace ConnorVG\WolframAlpha;

class WolframAlpha
{

	public $apikey;

	/**
	 * Thereshold for automatically querying a 'didyoumean'. int or (bool)false
	 * 
	 * @var $scoreThreshold 
	 */
    public $scoreThreshold;

	/**
	 * WolframAlphaEngine instance
	 * 
	 * @var ConnorVG\WolframAlpha\WolframAlphaEngine
	 */
	public $wrapped;

	/**
	 * Create a new wolframalpha instance.
	 *
	 * @return void
	 */
	public function __construct($apikey, $scoreThreshold = 0.3)
	{
		$this->apikey = $apikey;
		$this->wrapped = new WolframAlphaEngine($apikey);
        $this->scoreThreshold = $scoreThreshold;
	}

	public function easyQuery($query, $params = [ 'format' => 'plaintext', 'scantimeout' => '.8' ])
	{
		$engine = $this->wrapped;
		$response = $engine->getResults($query, $params);

		if ($response->isError())
			return 'There was an error with WolframAlpha, try again?';


		if (count($response->getPods()) < 1) {
            if(count($response->getDidyoumeans())){
                $score = 0;
                foreach($response->getDidyoumeans() as $dym){
                    if($dym->attributes['score'] > $score){
                        $score = $dym->attributes['score'];
                        $d = $dym;
                    }
                }
                // if we are at or above the threhold, run the new query
                if($this->scoreThreshold !== false && $score >= $this->scoreThreshold){
                    return $this->easyQuery($d->text, $params);
                } else {
                    return 'No answers found - did you mean "'.$d->text.'"?';
                }
            } else {
    			return 'No answers found!';
            }
        }

		$answer = [];
		$count = 0;
		foreach ($response->getPods() as $pod)
		{
			$id = $pod->attributes['id'];

			if ($id != 'Input')
			{
				$title = $pod->attributes['title'];
				$data = [];

				$has = false;
				foreach ($pod->getSubpods() as $subpod)
				{
					$data[] = $subpod->plaintext;
					$has = $has ?: ($subpod->plaintext !== null && strlen($subpod->plaintext) > 0);
				}

				if ($has)
				{
					$data = implode(', ', $data);
					$answer[] = $title . ': ' . $data;

					if (++$count > 4)
						break;
				}
			}
		}

		if (count($answer) == 0)
			return 'No answers found!';

		$answer[] = 'View more at: http://www.wolframalpha.com/input/?i=' . urlencode($query);

		return $answer;
	}
}
