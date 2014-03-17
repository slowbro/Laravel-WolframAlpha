<?php namespace ConnorVG\WolframAlpha;

class WolframAlpha
{

	public $apikey;

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
	public function __construct($apikey)
	{
		$this->apikey = $apikey;
		$this->wrapped = new WolframAlphaEngine($apikey);
	}

	public function easyQuery($query, $params = [ 'format' => 'plaintext', 'scantimeout' => '.8' ])
	{
		$engine = $this->wrapped;
		$response = $engine->getResults($query, $params);

		if ($response->isError())
			return 'There was an error with WolframAlpha, try again?';


		if (count($response->getPods()) < 1)
			return 'No answers found!';

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