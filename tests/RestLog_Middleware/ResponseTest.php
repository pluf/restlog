<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. http://dpq.co.ir
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
use PHPUnit\Framework\TestCase;
require_once 'Pluf.php';

/**
 * Response test class
 */
class MockTestHttpResponse extends Pluf_HTTP_Response
{

    function __construct($content = '', $mimetype = null)
    {
        parent::__construct($content, $mimetype);
    }

    public function etag()
    {
        return 'test';
    }
}

/**
 * Check middleware api
 *
 * @author pluf.ir<info@pluf.ir>
 *         @backupGlobals disabled
 *         @backupStaticAttributes disabled
 */
class RestLog_Middleware_ResponseTest extends TestCase
{

    /**
     * Creates DBMS
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        Pluf::start(__DIR__ . '/../conf/config.php');
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
        $m->install();
        $m->init();
    }

    /**
     * Remove all created DBMS
     *
     * @afterClass
     */
    public static function removeDatabses()
    {
        $m = new Pluf_Migration(Pluf::f('installed_apps'));
        $m->uninstall();
    }

    /**
     * Check processing a simple request
     *
     * @test
     */
    public function processSimpleRequest()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';

        $middleware = new RestLog_Middleware_Audit();
        $request = new Pluf_HTTP_Request($query);
        $request->user = new User_Account();
        $response = new Pluf_HTTP_Response('Hi!');

        // empty view
        $request->view = array(
            'ctrl' => array()
        );

        $response = $middleware->process_request($request);
        $this->assertFalse($response);

        $response = $middleware->process_response($request, $response);
        // TODO: maso, 2017: check a new audit creation
    }

    /**
     * Check processing a request with attached file
     *
     * @test
     */
    public function processRequestWithAttachedFile()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';
        $filePath = __DIR__ . '/../data/man.png';
        $fileSize = filesize($filePath);
        $_FILES['file'] = array(
            'name' => 'man.png',
            'tmp_name' => $filePath,
            'type' => 'image/png',
            'size' => $fileSize,
            'error' => 0
        );

        $middleware = new RestLog_Middleware_Audit();
        $request = new Pluf_HTTP_Request($query);
        $request->user = new User_Account();
        $response = new Pluf_HTTP_Response('Hi!');

        // empty view
        $request->view = array(
            'ctrl' => array()
        );

        $response = $middleware->process_request($request);
        $this->assertFalse($response);

        $response = $middleware->process_response($request, $response);
        // TODO: maso, 2017: check a new audit creation
    }

    /**
     * Check counter of requests
     *
     * @test
     */
    public function checkRequestCounts()
    {
        $query = '/example/resource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'http://localhost/example/resource';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $GLOBALS['_PX_uniqid'] = 'example';

        $middleware = new RestLog_Middleware_Audit();
        $request = new Pluf_HTTP_Request($query);
        $request->user = new User_Account();
        $response = new Pluf_HTTP_Response('Hi!');

        // empty view
        $request->view = array(
            'ctrl' => array()
        );

        $count = RestLog_Monitor::requestCount($request, array());

        $response = $middleware->process_request($request);
        $this->assertFalse($response);

        $response = $middleware->process_response($request, $response);

        $count2 = RestLog_Monitor::requestCount($request, array());

        $this->assertEquals($count2, $count + 1);
    }
}
