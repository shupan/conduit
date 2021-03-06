<?php

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;

class RouteCollectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routeCollection;

    public function setUp()
    {
        parent::setUp();

        $this->routeCollection = new RouteCollection();
    }

    public function testRouteCollectionCanBeConstructed()
    {
        $this->assertInstanceOf(RouteCollection::class, $this->routeCollection);
    }

    /**
     * 路由是有Uri + method + action pars组成
     */
    public function testRouteCollectionCanAddRoute()
    {
        $this->routeCollection->add(new Route('GET', 'foo', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]));

        $this->assertCount(1, $this->routeCollection);
    }

    public function testRouteCollectionAddReturnsTheRoute()
    {
        $outputRoute = $this->routeCollection->add($inputRoute = new Route('GET', 'foo', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]));
        $this->assertInstanceOf(Route::class, $outputRoute);
        $this->assertEquals($inputRoute, $outputRoute);
    }

    public function testRouteCollectionAddRouteChangesCount()
    {
        $this->routeCollection->add(new Route('GET', 'foo', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]));
        $this->assertCount(1, $this->routeCollection);
    }

    public function testRouteCollectionIsCountable()
    {
        $this->routeCollection->add(new Route('GET', 'foo', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]));
        $this->assertCount(1, $this->routeCollection);
    }

    public function testRouteCollectionCanRetrieveByName()
    {
        $this->routeCollection->add($routeIndex = new Route('GET', 'foo/index', [
            'uses' => 'FooController@index',
            'as' => 'route_name',
        ]));

        $this->assertSame('route_name', $routeIndex->getName());
        $this->assertSame('route_name', $this->routeCollection->getByName('route_name')->getName());
        $this->assertEquals($routeIndex, $this->routeCollection->getByName('route_name'));
    }

    public function testRouteCollectionCanRetrieveByAction()
    {
        $this->routeCollection->add($routeIndex = new Route('GET', 'foo/index', $action = [
            'uses' => 'FooController@index',
            'as' => 'route_name',
        ]));

        $this->assertSame($action, $routeIndex->getAction());
    }

    public function testRouteCollectionCanGetIterator()
    {
        $this->routeCollection->add(new Route('GET', 'foo/index', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]));
        $this->assertInstanceOf(ArrayIterator::class, $this->routeCollection->getIterator());
    }

    public function testRouteCollectionCanGetIteratorWhenEmpty()
    {
        $this->assertCount(0, $this->routeCollection);
        $this->assertInstanceOf(ArrayIterator::class, $this->routeCollection->getIterator());
    }

    public function testRouteCollectionCanGetIteratorWhenRouteAreAdded()
    {
        $this->routeCollection->add($routeIndex = new Route('GET', 'foo/index', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]));
        $this->assertCount(1, $this->routeCollection);

        $this->routeCollection->add($routeShow = new Route('GET', 'bar/show', [
            'uses' => 'BarController@show',
            'as' => 'bar_show',
        ]));
        $this->assertCount(2, $this->routeCollection);

        $this->assertInstanceOf(ArrayIterator::class, $this->routeCollection->getIterator());
    }

    public function testRouteCollectionCanHandleSameRoute()
    {
        $routeIndex = new Route('GET', 'foo/index', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]);

        $this->routeCollection->add($routeIndex);
        $this->assertCount(1, $this->routeCollection);

        // Add exactly the same route
        $this->routeCollection->add($routeIndex);
        $this->assertCount(1, $this->routeCollection);

        // Add a non-existing route
        $this->routeCollection->add(new Route('GET', 'bar/show', [
            'uses' => 'BarController@show',
            'as' => 'bar_show',
        ]));
        $this->assertCount(2, $this->routeCollection);
    }

    public function testRouteCollectionCanRefreshNameLookups()
    {
        $routeIndex = new Route('GET', 'foo/index', [
            'uses' => 'FooController@index',
        ]);

        // The name of the route is not yet set. It will be while adding if to the RouteCollection.
        $this->assertNull($routeIndex->getName());

        // The route name is set by calling \Illuminate\Routing\Route::name()
        $this->routeCollection->add($routeIndex)->name('route_name');

        // No route is found. This is normal, as no refresh as been done.
        $this->assertNull($this->routeCollection->getByName('route_name'));

        // After the refresh, the name will be properly set to the route.
        $this->routeCollection->refreshNameLookups();
        $this->assertEquals($routeIndex, $this->routeCollection->getByName('route_name'));
    }

    public function testRouteCollectionCanGetAllRoutes()
    {
        $this->routeCollection->add($routeIndex = new Route('GET', 'foo/index', [
            'uses' => 'FooController@index',
            'as' => 'foo_index',
        ]));

        $this->routeCollection->add($routeShow = new Route('GET', 'foo/show', [
            'uses' => 'FooController@show',
            'as' => 'foo_show',
        ]));

        $this->routeCollection->add($routeNew = new Route('POST', 'bar', [
            'uses' => 'BarController@create',
            'as' => 'bar_create',
        ]));

        $allRoutes = [
            $routeIndex,
            $routeShow,
            $routeNew,
        ];
        $this->assertEquals($allRoutes, $this->routeCollection->getRoutes());
    }
}
