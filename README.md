# TSantos HTTP Annotation Bundle ![HTTP Annotation Bundle](https://github.com/tsantos84/http-annotation-bundle/workflows/HTTP%20Annotation%20Bundle/badge.svg)

This bundle allows you to easily inject request data to your controllers 
through annotations. Suppose you have a search url on your application 
like: `/search?term=php&&limit=10`

Currently, a common way to handle requests like this would be something like with:

```php
/**
 * @Route("/search")
 */
function searchAction(Request $request)
{
    $term = $request->query->get('term');
     
    if (null === $term || length($term) < 3) {
        throw new HttpException(400);
    }
    
    $limit = $request->query->getInt('limit', 10);
    
    // perform search with $term and $limit
}
```

With this bundle the same code above can be rewritten with:

```php
/**
 * @Route("/search")
 *
 * @QueryParam("term", constraints={@Assert\Length(min=3)})
 * @QueryParam("limit")
 */
function searchAction(string $term, int $limit = 10)
{
    // perform search with $term and $limit
}
```

As you can see, the query params was mapped to controller arguments and 
injected to it. If `$term` is not passed on query string or its size is less then 
3 characters, the bundle will raise a bad request exception automatically. If
you want to handle the violations by yourself, just add an argument type-hinted 
with `ConstraintViolationListInterface` to your controller.

```php
/**
 * @Route("/search")
 * @QueryParam("term", constraints={@Assert\Length(min=3)})
 * @QueryParam("limit")
 */
function searchAction(ConstraintViolationListInterface $requestViolations, string $term, int $limit = 10)
{
    if (count($requestViolations)) {
        // handle the violations by your self here
    }
    // perform search with $term and $limit
}
```

All the constraints violations will be passed to `$requestViolations` even more than one query param is invalid. 
Keep in mind that if you prefer to handle the violations, the invalid value will be injected to your controller.


## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require tsantos/http-annotation-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require tsantos/http-annotation-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    TSantos\HttpAnnotationBundle\HttpAnnotationBundle::class => ['all' => true],
];
```

## HTTP Annotation Bundle vs Symfony Param Converter

This is the first thought when can come in your mind and this is natural comparison. 
Both libraries are not excluding each other because the HTTP Annotation Bundle is 
focused only to resolve HTTP values while Symfony Param Converter can convert any 
kind of data (e.g DateTime, granted users, ORM and etc).

**It means that this bundle isn't a replacement to Param Converter**

## Annotations

* [@RequestBody](#requestbody)
* [@QueryParam](#queryparam)
* [@RequestHeader](#requestheader)
* [@PathParam](#pathparam)
* [@RequestCookie](#requestcookie)

## @RequestBody

* Pass the request content to `$content` variable as string.

```php
/**
 * @RequestBody("content") 
 */
public function show(string $content) {}
```

* A Bad Request exception will be thrown if the request content is empty. 
If the content is not required, you can make your argument to allow `null` 
and the exception will not be raised.

```php
/** 
 * @RequestBody("content") 
 */
public function show(?string $content) {}
```

* If the request is a JSON/XML content (e.g the headers has application/[json/xml]) 
the argument resolvers will decode the content and pass it to controller. 

```php
/**
 * @RequestBody("post")
 */
public function show(array $post) {}
```

* If the argument is type-hinted to some complex type, the argument resolvers will deserialize 
the content and inject the result automatically.

```php
/**
 * @RequestBody("post", serialization_groups={"registration"}) 
 */
public function show(Post $post) {}
```

## @QueryParam

* Inject a single query param when the route `/foo?foo=bar` is matched. If you don't 
provide the param name, it will use the argument name to fetch data from query parameter bag.

```php
/**
 * @QueryParam("foo", name="foo") 
 */
public function show(string $foo) { echo $foo; // will echo "bar"}
```

* You can omit the attribute `name` if the name of the param is equals to the controller 
argument.

```php
/**
 * @QueryParam("foo") 
 */
public function show(string $foo) { echo $foo; // will echo "bar"}
```

* Default value if the query param isn't passed.

```php
/**
 * @QueryParam("foo") 
 */
public function show(string $foo = 'bar') {}
```

* Inject multiple query params

```php
/**
 * @QueryParam("foo")
 * @QueryParam("bar") 
 */
 public function show(string $foo, string $bar) {}
```

* Inject all query params as `ParameterBag` instance

```php
/**
 * @QueryParam("query")
 */
 public function show(ParameterBag $query) {}
```

## @RequestHeader

* Inject a single header

```php
/**
 * @RequestHeader("contentType", name="Content-Type") 
 */
 public function show(string $contentType) { }
```

* Default value if the header isn't passed.

```php
/**
 * @RequestHeader("contentType") 
 */
 public function show(string $contentType = 'application/json') {}
```

* Inject multiple headers

```php
/**
 * @RequestHeader("userId", name="X-USER-ID")
 * @RequestHeader("userAgent", name="User-Agent") 
 */
 public function show(string $userId, string $userAgent) {}
```

* Inject all headers at once

```php
/**
 * @RequestHeader("headers")
 */
 public function show(HeaderBag $headers) {}
```

## @PathParam

Symfony automatically maps path params to controller arguments so this annotation could came
redundant and omit it is recommended. The only situation where make sense to use it is when
your path param name is different from the controller argument:

```php
/**
 * @Route("/show/{id}/comments/{cId}")
 * @PathParam("postId", name="id")
 * @PathParam("commentId", name="cId")
 */
 public function show(int $postId, int $commentId) {}
```

If you want to resolve the param `id` to the real entity (e.g Post entity), just keep your controller as described
in Symfony's documentation and omit the @PathParam annotation.

## @RequestCookie

* Inject a cookie value.

```php
/**
 * @RequestCookie("cookie", name="cookie.name") 
 */
public function show(string $cookie) {}
```

* You can omit the attribute `name` if the name of the cookie is equals to the controller 
argument.

```php
/**
 * @RequestCookie("cookie") 
 */
public function show(string $cookie) {}
```

* Default value if the cookie isn't provided.

```php
/**
 * @RequestCookie("cookie") 
 */
public function show(string $cookie = 'foo') {}
```

* Inject multiple cookies

```php
/**
 * @RequestCookie("cookie1")
 * @RequestCookie("cookie2") 
 */
 public function show(string $cookie1, string $cookie2) {}
```

* Inject all cookies at once

```php
/**
 * @RequestCookie("cookies")
 */
 public function show(ParameterBag $cookies) {}
```
