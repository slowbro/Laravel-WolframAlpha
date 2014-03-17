Laravel Wolfram|Alpha
=====================

This is a very simple wrapper for Wolfram|Alpha to allow use of the Facade interface in Laravel. If using in Laravel, be sure to define the config key `app.wolframapikey` as your unique API key.

### Laravel

If you're using laravel, add this service provider:
```php
'ConnorVG\laravel-wolframalpha\WolframAlphaServiceProvider'
```

Also, this Facade:
```php
'WolframAlpha' => 'ConnorVG\laravel-wolframalpha\WolframAlphaFacade'
```

I recommend:
```php
'WA' => 'ConnorVG\laravel-wolframalpha\WolframAlphaFacade'
```
