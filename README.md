Laravel Wolfram|Alpha
=====================

This is a very simple wrapper for Wolfram|Alpha to allow use of the Facade interface in Laravel. If using in Laravel, be sure to define the config key `app.wolframapikey` as your unique API key.

To access the WolframAlphaEngine, simply do `WolframAlpha::wrapped();`

There is a function that I added their for simple queries, it is very useful when you just want a limitted amount of plaintext responses. It will return up to 5 responses, in an array (E.G: `['one', 'two', 'three' ... ]`) and the last response will be a link to the Wolfram|Alpha query page with the query already executed.

Usage:
```php
$response = WA::easyQuery('5!');

dd($response);
```

### Laravel

If you're using laravel, add this service provider:
```php
'ConnorVG\WolframAlpha\WolframAlphaServiceProvider'
```

Also, this Facade:
```php
'WolframAlpha' => 'ConnorVG\WolframAlpha\WolframAlphaFacade'
```

I recommend:
```php
'WA' => 'ConnorVG\WolframAlpha\WolframAlphaFacade'
```
